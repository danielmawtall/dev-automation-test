export default class SiteHeader {
  constructor() {
    this.header = document.getElementById('site-header');
    if (!this.header) return;

    this.mobileToggle = this.header.querySelector('[data-mobile-menu-toggle]');
    this.mobilePanel = this.header.querySelector('[data-mobile-menu]');
    this.menuLabel = this.header.querySelector('[data-menu-label]');
    this.contactTriggers = document.querySelectorAll('[data-contact-trigger]');
    this.contactOverlay = document.querySelector('[data-contact-overlay]');
    this.contactCloses = document.querySelectorAll('[data-contact-close]');

    this.bindEvents();
  }

  bindEvents() {
    if (this.mobileToggle && this.mobilePanel) {
      this.mobileToggle.addEventListener('click', () => this.toggleMobileMenu());
    }

    this.contactTriggers.forEach((trigger) => {
      trigger.addEventListener('click', () => this.openContact());
    });

    this.contactCloses.forEach((close) => {
      close.addEventListener('click', () => this.closeContact());
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeContact();
        this.closeMobileMenu();
      }
    });
  }

  toggleMobileMenu() {
    const isOpen = this.mobilePanel.hasAttribute('data-open');
    if (isOpen) {
      this.closeMobileMenu();
    } else {
      this.mobilePanel.removeAttribute('hidden');
      this.mobilePanel.setAttribute('data-open', '');
      this.mobileToggle.setAttribute('aria-expanded', 'true');
      if (this.menuLabel) this.menuLabel.textContent = 'Close';
    }
  }

  closeMobileMenu() {
    if (!this.mobilePanel) return;
    this.mobilePanel.removeAttribute('data-open');
    this.mobilePanel.setAttribute('hidden', '');
    if (this.mobileToggle) this.mobileToggle.setAttribute('aria-expanded', 'false');
    if (this.menuLabel) this.menuLabel.textContent = this.menuLabel.dataset.default || 'Menu';
  }

  openContact() {
    if (!this.contactOverlay) return;
    this.contactOverlay.removeAttribute('hidden');
    this.contactOverlay.setAttribute('data-open', '');
    document.body.style.overflow = 'hidden';
    this.closeMobileMenu();
  }

  closeContact() {
    if (!this.contactOverlay) return;
    this.contactOverlay.removeAttribute('data-open');
    this.contactOverlay.setAttribute('hidden', '');
    document.body.style.overflow = '';
  }
}
