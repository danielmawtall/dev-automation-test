export default class Preloader {
  constructor() {
    this.el = document.querySelector('[data-preloader]');
    if (!this.el) return;

    window.addEventListener('load', () => {
      this.el.setAttribute('data-done', '');
    });

    setTimeout(() => {
      this.el.setAttribute('data-done', '');
    }, 2500);
  }
}
