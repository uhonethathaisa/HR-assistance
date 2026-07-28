<?php
// app/Http/Livewire/WorkHistory.php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WorkHistory as WorkHistoryModel;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Log;

class WorkHistory extends Component
{
    use WithFileUploads;

    // Form properties
    public $showForm = false;
    public $showImportForm = false;
    public $editingId = null;
    public $company_name;
    public $job_title;
    public $location;
    public $start_date;
    public $end_date;
    public $is_current = false;
    public $description;

    // Upload properties
    public $file;
    public $isUploading = false;
    public $uploadProgress = 0;
    public $extractedData = [];
    public $showPreview = false;
    public $processingStatus = '';
    public $extractedEducations = [];
    public $extractedSkills = [];
    public $extractedQualifications = [];

    protected $listeners = ['importCompleted' => 'populateFromImport'];

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'job_title' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after:start_date',
        'is_current' => 'boolean',
        'description' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->company_name = '';
        $this->job_title = '';
        $this->location = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->is_current = false;
        $this->description = '';
        $this->editingId = null;
        $this->showForm = false;
        $this->showImportForm = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->showImportForm = false;
        $this->showPreview = false;
    }

    public function showImport()
    {
        $this->resetForm();
        $this->showImportForm = true;
        $this->showForm = false;
        $this->showPreview = false;
    }

    public function edit($id)
    {
        $work = WorkHistoryModel::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId = $id;
        $this->company_name = $work->company_name;
        $this->job_title = $work->job_title;
        $this->location = $work->location;
        $this->start_date = $work->start_date->format('Y-m-d');
        $this->end_date = $work->end_date ? $work->end_date->format('Y-m-d') : null;
        $this->is_current = $work->is_current;
        $this->description = $work->description;
        $this->showForm = true;
        $this->showImportForm = false;
        $this->showPreview = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->is_current) {
            $this->end_date = null;
        }

        $data = [
            'user_id' => auth()->id(),
            'job_title' => $this->job_title,
            'company_name' => $this->company_name,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_current' => $this->is_current,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            $work = WorkHistoryModel::where('user_id', auth()->id())->findOrFail($this->editingId);
            $work->update($data);
            $message = 'Work history updated successfully!';
        } else {
            WorkHistoryModel::create($data);
            $message = 'Work history added successfully!';
        }

        $this->resetForm();
        $this->showForm = false;
        $this->showImportForm = false;
        $this->showPreview = false;

        $this->dispatch('notify', [
            'message' => $message,
            'type' => 'success'
        ]);
    }

    public function delete($id)
    {
        $work = WorkHistoryModel::where('user_id', auth()->id())->findOrFail($id);
        $work->delete();

        $this->dispatch('notify', [
            'message' => 'Work history deleted successfully!',
            'type' => 'success'
        ]);
    }

    /**
     * Upload and parse CV using AI
     */
    public function uploadAndParse()
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $this->isUploading = true;
        $this->uploadProgress = 0;
        $this->processingStatus = 'Uploading file...';

        try {
            $uploadedFile = $this->file;
            $filePath = $uploadedFile->getRealPath();

            if (!$filePath || !file_exists($filePath)) {
                throw new \Exception('Temporary file not found. Please try uploading again.');
            }

            $this->uploadProgress = 30;
            $this->processingStatus = 'Extracting text from document...';

            // Extract text from file
            $deepSeek = new DeepSeekService();
            $text = $deepSeek->extractTextFromFile($filePath);

            if (empty(trim($text))) {
                throw new \Exception('Could not extract text from the document. Please try a different file.');
            }

            $this->uploadProgress = 60;
            $this->processingStatus = 'Parsing with AI...';

            // Parse the text using DeepSeek
            $result = $deepSeek->parseCvToStructuredJson($text);

            $this->uploadProgress = 90;
            $this->processingStatus = 'Preparing extracted data...';

            // Store all extracted data
            $this->extractedData = $result['experiences'] ?? [];
            $this->extractedEducations = $result['educations'] ?? [];
            $this->extractedSkills = $result['skills'] ?? [];
            $this->extractedQualifications = $result['qualifications'] ?? [];

            if (count($this->extractedData) > 0) {
                $this->showPreview = true;
                $this->showImportForm = false;
                $this->showForm = false;
                $this->processingStatus = 'Ready to review!';

                $this->dispatch('notify', [
                    'message' => count($this->extractedData) . ' work history entr' . (count($this->extractedData) === 1 ? 'y' : 'ies') . ' extracted successfully!',
                    'type' => 'success'
                ]);
            } else {
                throw new \Exception('No work history entries found in the document.');
            }

            $this->uploadProgress = 100;

        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());

            $this->dispatch('notify', [
                'message' => 'Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        } finally {
            $this->isUploading = false;

            // Clean up
            if (isset($this->file) && method_exists($this->file, 'delete')) {
                try {
                    $this->file->delete();
                } catch (\Exception $e) {
                    // Silently fail on cleanup
                }
            }
        }
    }

    public function saveExtractedEntry($index)
    {
        if (!isset($this->extractedData[$index])) {
            return;
        }

        $entry = $this->extractedData[$index];

        // Validate and save
        $this->company_name = $entry['company_name'] ?? '';
        $this->job_title = $entry['job_title'] ?? '';
        $this->location = $entry['location'] ?? '';
        $this->start_date = $entry['start_date'] ?? '';
        $this->end_date = $entry['end_date'] ?? null;
        $this->is_current = $entry['is_current'] ?? false;
        $this->description = $entry['description'] ?? '';

        $this->validate();

        WorkHistoryModel::create([
            'user_id' => auth()->id(),
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->is_current ? null : $this->end_date,
            'is_current' => $this->is_current,
            'description' => $this->description,
        ]);

        // Remove from extracted data
        unset($this->extractedData[$index]);
        $this->extractedData = array_values($this->extractedData);

        if (count($this->extractedData) === 0) {
            $this->showPreview = false;
        }

        $this->dispatch('notify', [
            'message' => 'Entry saved successfully!',
            'type' => 'success'
        ]);
    }

    public function saveAllExtracted()
    {
        foreach ($this->extractedData as $entry) {
            WorkHistoryModel::create([
                'user_id' => auth()->id(),
                'company_name' => $entry['company_name'] ?? '',
                'job_title' => $entry['job_title'] ?? '',
                'location' => $entry['location'] ?? '',
                'start_date' => $entry['start_date'] ?? null,
                'end_date' => ($entry['is_current'] ?? false) ? null : ($entry['end_date'] ?? null),
                'is_current' => $entry['is_current'] ?? false,
                'description' => $entry['description'] ?? '',
            ]);
        }

        $count = count($this->extractedData);
        $this->extractedData = [];
        $this->showPreview = false;

        $this->dispatch('notify', [
            'message' => $count . ' entr' . ($count === 1 ? 'y' : 'ies') . ' saved successfully!',
            'type' => 'success'
        ]);
    }

    public function cancelExtracted()
    {
        $this->extractedData = [];
        $this->extractedEducations = [];
        $this->extractedSkills = [];
        $this->extractedQualifications = [];
        $this->showPreview = false;
        $this->showImportForm = true;
        $this->file = null;
        $this->uploadProgress = 0;
    }

    /**
     * Listen for the importCompleted event dispatched from JavaScript
     * after the AJAX upload to /import-cv returns successfully.
     */
    public function populateFromImport($data)
    {
        if (empty($data)) {
            $this->dispatch('notify', [
                'message' => 'No data received from the import.',
                'type' => 'error'
            ]);
            return;
        }

        $this->extractedData = $data['experiences'] ?? [];
        $this->extractedEducations = $data['educations'] ?? [];
        $this->extractedSkills = $data['skills'] ?? [];
        $this->extractedQualifications = $data['qualifications'] ?? [];

        if (count($this->extractedData) > 0) {
            $this->showPreview = true;
            $this->showImportForm = false;
            $this->showForm = false;

            $this->dispatch('notify', [
                'message' => count($this->extractedData) . ' work history entr' . (count($this->extractedData) === 1 ? 'y' : 'ies') . ' extracted successfully!',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('notify', [
                'message' => 'No work history entries found in the parsed data.',
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        $workHistory = WorkHistoryModel::where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

        return view('livewire.work-history', [
            'workHistory' => $workHistory,
        ])->layout('layouts.dashboard', [
            'pageTitle' => 'Work History'
        ]);
    }
}
