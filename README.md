# rebornian48

Monorepo static site untuk `rebornian48.my.id` di Hostinger shared hosting.

```
├── index.html          # landing rebornian48.my.id/
├── assets/
│   ├── theme.css       # DESIGN TOKENS SHARED (light + dark + view transition)
│   ├── brand.css       # brand-nav (rebornian48 / app · Live · toggle · Semua Tools)
│   ├── brand.js        # auto-inject brand-nav + sync theme lintas app
│   ├── waktukita.css   # style app-specific waktukita
│   ├── waktukita.js    # logic app-specific waktukita (jam, cuaca, adzan, peta)
│   ├── choropleth.js   # logic app-specific choropleth (peta + parsing data)
│   └── json/           # geojson besar (exclude dari git, upload manual ke server)
├── waktukita/          # rebornian48.my.id/waktukita/
│   └── index.html      # Jam · cuaca · adzan · peta lokasi
├── choropleth/         # rebornian48.my.id/choropleth/
│   ├── index.html      # Peta 38 provinsi + upload CSV/Excel
│   └── styles.css      # style app-specific choropleth
├── geocalc/            # rebornian48.my.id/geocalc/
│   └── index.html      # Kalkulator geometri 2D & 3D
├── basajawatools/      # rebornian48.my.id/basajawatools/
│   └── index.html      # Ngalam · Dagadu · Aksara Jawa
├── codevault/          # rebornian48.my.id/codevault/
│   ├── index.html      # Snippet manager
│   ├── api.php         # REST endpoint (Hostinger PHP)
│   └── snippets_data.json
├── support/            # rebornian48.my.id/support/
│   └── index.php       # Donation hub — Saweria · Trakteer · dll
├── DEPLOY.md           # panduan deploy Hostinger
├── CHANGELOG.md        # riwayat rilis
└── .gitignore
```

## Standar tampilan (design system)

**waktukita = referensi.** Tiap mini-app baru wajib ikut token yang sama biar konsisten lintas app.

**Sumber token:** `assets/theme.css` — import di `<head>`:

```html
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="nama-app" defer></script>
```

Isi `theme.css`: variabel CSS `--bg`, `--bg-2`, `--surface`, `--surface-2`, `--text`, `--text-soft`, `--muted`, `--accent`, `--border`, `--border-strong`, `--highlight`, `--pop`, `--shadow`, dsb — otomatis swap saat `data-theme="dark"` di `<html>`.

**Font:**
- Body/heading: **Plus Jakarta Sans** (400, 500, 600, 700, 800)
- Angka/mono: **JetBrains Mono** (400, 500, 600)

```html
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
```

**Palet aksen:** cuma `--accent` (pink-red `#ff3b6b` di light, `#ff5c85` di dark). Jangan hardcode warna baru — pakai token.

**Radius:** 20px card, 12–14px input, 999px pill.

**Shadow neo-brutalist:** `box-shadow: 3px 3px 0 var(--border-strong)` buat tombol/chip yang mau nonjol; `6px 6px 0` (`--pop`) buat card hero.

**Brand nav:** pattern grid 3-col — `rebornian48 / <app>` (kiri) · Live chip (tengah) · theme toggle + Semua Tools (kanan). Auto-inject via `brand.js`, atau markup manual (lihat `choropleth/`, `waktukita/`).

**Theme toggle:** wajib ada sun/moon button — key localStorage `rebornian.theme` (lintas app, sekali toggle apply ke semua). Init script minimum di `<head>` sebelum render:

```html
<script>
(function(){
  const s = localStorage.getItem('rebornian.theme');
  const dark = matchMedia('(prefers-color-scheme: dark)').matches;
  document.documentElement.setAttribute('data-theme', s || (dark ? 'dark' : 'light'));
})();
</script>
```

**View transition circle-wipe** saat toggle — pola di `assets/waktukita.js` `switchTheme()` / `choropleth/index.html` bagian bawah.

## Mini-apps

| App | Path | Tag | Fungsi |
|---|---|---|---|
| waktukita | `/waktukita/` | Utility | Jam lokal · cuaca real-time · jadwal adzan Kemenag RI · peta Leaflet |
| choropleth | `/choropleth/` | Data Viz | Peta 38 provinsi Indonesia · upload CSV/Excel · neraca produksi · export SVG/PNG |
| basajawatools | `/basajawatools/` | Bahasa | Walikan Ngalam · Dagadu Jogja · transliterasi Aksara Jawa |
| codevault | `/codevault/` | Dev | Snippet manager — filter per bahasa/tag, backend PHP API |
| geocalc | `/geocalc/` | Kalkulator | Kalkulator geometri 2D & 3D — luas, keliling, volume + preview SVG |
| support | `/support/` | Dukungan | Donation hub — Saweria, Trakteer, Karyakarsa, Sociabuzz, Tako, Nih Buat Jajan |

## Dev lokal

```bash
npx http-server . -p 8765 -c-1
```

Atau via `preview_start` (config di `.claude/launch.json`).

Buka:
- `http://localhost:8765/` — landing
- `http://localhost:8765/waktukita/`
- `http://localhost:8765/choropleth/`
- `http://localhost:8765/geocalc/`
- `http://localhost:8765/basajawatools/`
- `http://localhost:8765/codevault/` — butuh PHP backend (api.php) untuk load data
- `http://localhost:8765/support/` — butuh PHP untuk render `<?php date('Y') ?>`, layout static tetap render

## Deploy

Lihat [DEPLOY.md](DEPLOY.md). Push ke `main` → Hostinger auto-pull.

## Nambah mini-app baru

1. Copy struktur `waktukita/` sebagai template
2. Bikin folder di root: `nama-app/`
3. Import `/assets/theme.css` + `/assets/brand.css` + font Google
4. Load `<script src="/assets/brand.js" data-app="nama-app" defer></script>` supaya brand-nav auto-inject
5. Cache-bust local `styles.css?v=N` saat swap CSS besar
6. Tambah tile di landing `index.html`
7. Update [CHANGELOG.md](CHANGELOG.md) — Unreleased → Added
8. Buat PR, merge → auto live di `rebornian48.my.id/nama-app/`

## Riwayat perubahan

Lihat [CHANGELOG.md](CHANGELOG.md).

## Aset berat (opsional)

Aset >5 MB (geojson, video, dataset) jangan di-git. Upload direct ke Hostinger via File Manager ke `public_html/assets/`, akses via URL `/assets/...`. Ini kenapa `.gitignore` exclude `assets/json/`.
