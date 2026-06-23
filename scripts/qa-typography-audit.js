/**
 * Live typography audit — paste in Chrome DevTools @ 1440px.
 * Compares computed styles to docs/build/DESIGN_SPEC.md tokens.
 */
(function qaTypographyAudit() {
  const px = (v) => Math.round(parseFloat(v) || 0);
  const fam = (v) => (v || '').split(',')[0].replace(/['"]/g, '').trim();

  const checks = [
    { name: 'body', el: document.body, font: 'Uncut Sans', size: 24, weight: 400 },
    { name: 'nav-menu', el: document.querySelector('.site-header__menu'), font: 'Uncut Sans', size: 24, weight: 400 },
    { name: 'marquee', el: document.querySelector('.homepage-header__marquee-text'), font: 'Anton', size: 300, weight: 400, tol: 12 },
    { name: 'intro-heading', el: document.querySelector('.text-block--intro .text-block__heading'), font: 'Uncut Sans', size: 40, weight: 400 },
    { name: 'intro-body', el: document.querySelector('.text-block--intro .text-block__body'), font: 'Uncut Sans', size: 24, weight: 400 },
    { name: 'caption', el: document.querySelector('.caption'), font: 'IBM Plex Mono', size: 12, weight: 400 },
    { name: 'skewed-word', el: document.querySelector('.skewed-reveal__word'), font: 'Anton', size: 240, weight: 400, tol: 4 },
    { name: 'featured-heading', el: document.querySelector('.featured-grid__heading'), font: 'Anton', size: 160, weight: 400, tol: 4 },
    { name: 'featured-title', el: document.querySelector('.featured-card__title'), font: 'Uncut Sans', size: 24, weight: 400 },
    { name: 'card-title', el: document.querySelector('.case-study-card__title'), font: 'Uncut Sans', size: 24, weight: 400 },
    { name: 'footer-top', el: document.querySelector('.site-footer__top-menu'), font: 'Uncut Sans', size: 16, weight: 400 },
    { name: 'cta-button', el: document.querySelector('.button'), font: 'Uncut Sans', size: 24, weight: 400 },
  ];

  const rows = checks.filter((c) => c.el).map((c) => {
    const s = getComputedStyle(c.el);
    const tol = c.tol || 2;
    const sizeOk = Math.abs(px(s.fontSize) - c.size) <= tol;
    const weightOk = px(s.fontWeight) === c.weight;
    const family = fam(s.fontFamily);
    const fontOk = c.font === 'Uncut Sans'
      ? /Inter|Uncut Sans/i.test(family)
      : family === c.font;
    return {
      name: c.name,
      family,
      expectedFamily: c.font,
      fontSize: px(s.fontSize),
      expectedSize: c.size,
      fontWeight: px(s.fontWeight),
      pass: sizeOk && weightOk && fontOk,
    };
  });

  const pass = rows.every((r) => r.pass);
  console.log('[qa-typography-audit]', pass ? 'PASS' : 'FAIL', rows);
  return { pass, rows, viewport: window.innerWidth };
})();
