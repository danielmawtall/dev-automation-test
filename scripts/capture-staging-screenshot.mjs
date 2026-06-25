import { chromium } from 'playwright';

const [url, username, password, outputPath, selector] = process.argv.slice(2);

if (!url || !username || !password || !outputPath) {
  console.error('Usage: node capture-staging-screenshot.mjs <url> <user> <pass> <output.png>');
  process.exit(1);
}

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1708, height: 943 } });

await page.setExtraHTTPHeaders({
  Authorization: 'Basic ' + Buffer.from(`${username}:${password}`).toString('base64'),
});

await page.goto(url, { waitUntil: 'networkidle', timeout: 120000 });
await page.waitForTimeout(3000);

if (selector) {
  const target = page.locator(selector);
  if (await target.count()) {
    await target.first().scrollIntoViewIfNeeded();
    await page.waitForTimeout(1000);
  }
}

await page.screenshot({ path: outputPath, fullPage: false });
await browser.close();
console.log(`Saved ${outputPath}`);
