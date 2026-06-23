export default class SiteFooter {
  constructor() {
    this.footer = document.getElementById('site-footer');
    this.backToTop = document.querySelector('[data-back-to-top]');
    if (this.backToTop) {
      this.backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }
  }
}
