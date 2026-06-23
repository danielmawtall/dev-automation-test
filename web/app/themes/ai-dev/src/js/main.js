import SiteHeader from './modules/site-header';
import SiteFooter from './modules/site-footer';
import Preloader from './modules/preloader';

document.addEventListener('DOMContentLoaded', () => {
  new SiteHeader();
  new SiteFooter();
  new Preloader();
  document.documentElement.classList.remove('no-js');
});
