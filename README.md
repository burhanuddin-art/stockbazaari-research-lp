# Stockbazaari – Research Calls Landing Page

Single-file landing page (`index.html`) for Stockbazaari Google Ads Demand Gen campaigns.
Intended domain: **research.stockbazaari.com**

## URL parameters
| Param | Values | Effect |
|---|---|---|
| `angle` | calls · exit · tips · plan · revenge · expiry · time · guesswork | Swaps hero headline to match the ad |
| any `utm_*` containing `hindi`, or `lang=hi` | — | Shows the page in Hindi |
| `utm_source/medium/campaign/content/term`, `gclid` | — | Captured with every lead |

Example: `https://research.stockbazaari.com/?angle=calls&utm_source=google&utm_medium=demandgen&utm_campaign=DG_Hindi_Options&utm_content=direct`

## Before going live – fill `SB_CONFIG` in index.html
- `SUBMIT_URL` – endpoint that receives leads (CRM webhook / Google Apps Script / form backend). **Empty = leads are not saved.**
- `GADS_SEND_TO` – Google Ads conversion `AW-XXXXXXXXX/label` (fires after step 1).
- Latest YouTube videos (auto-update daily) – either `YT_FEED_URL: "/yt-feed.php"` if the host runs PHP, **or** a `YT_API_KEY` (YouTube Data API v3, restricted to this domain) for static hosts like GitHub Pages / Vercel. With neither set, the built-in video list is shown.

## Files
- `index.html` – the landing page (fonts from Google Fonts, everything else inline)
- `yt-feed.php` – optional: latest channel videos as JSON (needs PHP hosting, cached 1h)

## Compliance
SEBI RA Reg. No. INH000018665. Disclaimer block and risk box are part of the page — do not remove.
