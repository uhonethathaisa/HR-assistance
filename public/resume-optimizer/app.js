// ============================================================================
// Resume Optimization Platform - Frontend Application
// ============================================================================
// This app now uses Laravel Breeze for authentication.
// All auth is handled server-side via Blade templates.
// The resume-optimizer frontend is a landing page that links to Laravel auth.
// ============================================================================

// ============================================================================
// FILE PROTOCOL DETECTION
// ============================================================================
(function detectFileProtocol() {
  if (window.location.protocol === 'file:') {
    const msg = [
      '╔══════════════════════════════════════════════════════════════════╗',
      '║  ⚠️  FILE PROTOCOL DETECTED                                     ║',
      '╠══════════════════════════════════════════════════════════════════╣',
      '║  Serve via Laravel:  php artisan serve                          ║',
      '║  Open:  http://localhost:8000/resume-optimizer                  ║',
      '╚══════════════════════════════════════════════════════════════════╝',
    ].join('\n');
    console.warn('%c' + msg, 'color: #f59e0b; font-weight: bold;');
  }
})();

// ============================================================================
// LARAVEL AUTH REDIRECTS
// ============================================================================
// All authentication is handled by Laravel Breeze at:
//   /login    - Sign in
//   /register - Create account
//   /dashboard - User dashboard
// ============================================================================

function redirectToLogin() {
  window.location.href = '/login';
}

function redirectToRegister() {
  window.location.href = '/register';
}

function redirectToDashboard() {
  window.location.href = '/dashboard';
}

// ============================================================================
// DOM References
// ============================================================================
const $ = (id) => document.getElementById(id);

const dom = {
  authBtn: $('authBtn'),
  getStartedBtn: $('getStartedBtn'),
  signOutBtn: $('signOutBtn'),
  mobileMenuBtn: $('mobileMenuBtn'),
  navLinks: $('navLinks'),
};

// ============================================================================
// Event Bindings
// ============================================================================

// Sign In button → Laravel login page
dom.authBtn.addEventListener('click', (e) => {
  e.preventDefault();
  redirectToLogin();
});

// Get Started → Laravel register page
dom.getStartedBtn.addEventListener('click', (e) => {
  e.preventDefault();
  redirectToRegister();
});

// Sign Out → Laravel logout (POST via form)
if (dom.signOutBtn) {
  dom.signOutBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/logout';
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
  });
}

// Mobile menu toggle
dom.mobileMenuBtn.addEventListener('click', () => {
  dom.navLinks.classList.toggle('open');
});

dom.navLinks.querySelectorAll('a').forEach((link) => {
  link.addEventListener('click', () => {
    dom.navLinks.classList.remove('open');
  });
});

// ============================================================================
// Smooth scroll for anchor links
// ============================================================================
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});
