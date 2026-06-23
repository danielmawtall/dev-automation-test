# AI Dev theme

Tall Website 2025 theme for **Tall AI Dev Test**. ACF blocks, webpack, SCSS + BEM.

## Commands

```bash
npm install
npm run start   # watch
npm run build   # production
```

## Blocks (in scope)

- Homepage Header, Skewed Reveal, Case Study Grid, Scrolling Logos, Featured Grid
- Media Header, Text Block, Centered List, Scrolling Text, Work Grid
- Full Width / Container Media, CTA Banner, Spacer, Form Block, Content Block

## Structure

- `includes/acf/field-groups/` — PHP ACF registration (no JSON sync)
- `template-parts/blocks/` — block templates + `block.json`
- `template-parts/components/` — shared partials
- `src/scss/` — design tokens and block styles
- `src/js/modules/` — global UI (header, footer, preloader)

## Manual plugins

ACF Pro and Gravity Forms must be installed separately.
