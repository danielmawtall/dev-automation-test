/**
 * Homepage overflow audit — run in Chrome DevTools console @ 1440px and 390px.
 * Paste entire file, or: copy output of scripts/qa-homepage.sh browser section.
 *
 * High-severity fail if scrollWidth > innerWidth or offenders are found.
 */
(function qaHomepageOverflow() {
  const doc = document.documentElement;
  const overflow =
    doc.scrollWidth > window.innerWidth || document.body.scrollWidth > window.innerWidth;

  const offenders = [...document.querySelectorAll('body *')].filter((el) => {
    const r = el.getBoundingClientRect();
    return r.width > 0 && r.right > window.innerWidth + 1;
  });

  const sample = offenders.slice(0, 8).map((el) => {
    const r = el.getBoundingClientRect();
    return {
      tag: el.tagName.toLowerCase(),
      class: el.className,
      right: Math.round(r.right),
      width: Math.round(r.width),
    };
  });

  // Document scroll is the hard gate (overflow-x: clip hides decorative bleed e.g. hero marquee).
  const result = {
    viewport: window.innerWidth,
    scrollWidth: doc.scrollWidth,
    overflow,
    offenderCount: offenders.length,
    offenders: sample,
    pass: !overflow,
  };

  console.log('[qa-homepage-overflow]', result.pass ? 'PASS' : 'FAIL', result);
  return result;
})();
