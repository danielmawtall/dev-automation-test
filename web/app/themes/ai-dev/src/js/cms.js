import SiteHeader from './modules/site-header';

document.addEventListener('DOMContentLoaded', () => {
  new SiteHeader();
});

if (window.acf) {
  window.acf.addAction('render_block_preview', () => {
    new SiteHeader();
  });
}
