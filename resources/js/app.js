/**
 * Fix 1: Increase max listeners to suppress MaxListenersExceededWarning
 * (Caused by browser extensions like MetaMask, Vue DevTools, etc.)
 */
if (typeof process !== 'undefined' && process.env) {
    try {
        require('events').EventEmitter.defaultMaxListeners = 20;
    } catch (e) {
        // Silently fail if events module not available
    }
}

/**
 * Fix 2: Suppress harmless ObjectMultiplex warnings from browser extensions
 * These are non-actionable warnings from MetaMask and similar extensions
 */
const originalConsoleWarn = console.warn;
console.warn = function(...args) {
    if (args[0] && typeof args[0] === 'string') {
        if (args[0].includes('orphaned data for stream') ||
            args[0].includes('MaxListenersExceededWarning') ||
            args[0].includes('background-liveness') ||
            args[0].includes('app-init-liveness')) {
            return;
        }
    }
    originalConsoleWarn.apply(console, args);
};

/**
 * Fix 3: Do NOT import Alpine.js separately here.
 * Livewire already bundles and initializes Alpine.js.
 * Importing it again causes "Detected multiple instances of Alpine running" warning.
 *
 * If you need custom Alpine code, use Alpine.data() or Alpine.store()
 * via the window.Alpine reference that Livewire provides.
 */

// Custom Alpine data can be added via Livewire's JavaScript hooks
document.addEventListener('livewire:init', () => {
    // Alpine is already available via Livewire
    // Add any custom Alpine code here if needed
});
