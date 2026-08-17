# rebornian48

Monorepo static site untuk `rebornian48.my.id` di Hostinger shared hosting.

```
├── index.html          # landing rebornian48.my.id/
├── assets/
│   ├── theme.css       # DESIGN TOKENS SHARED (light + dark + view transition)
│   └── json/           # geojson besar (exclude dari git, upload manual ke server)
├── waktukita/          # rebornian48.my.id/waktukita/
│   ├── index.html      # Jam · cuaca · adzan · peta lokasi
│   ├── styles.css
│   └── dashboard.js
├── choropleth/         # rebornian48.my.id/choropleth/
│   ├── index.html      # Peta 38 provinsi + upload CSV/Excel
│   └── choropleth.js
├── DEPLOY.md           # panduan deploy Hostinger
└── .gitignore
```

## Standar tampilan (design system)

**waktukita = referensi.** Tiap mini-app baru wajib ikut token yang sama biar konsisten lintas app.

**Sumber token:** `assets/theme.css` — import di `<head>`:

```html
<link rel="stylesheet" href="/assets/theme.css">
```

Isi: variabel CSS `--bg`, `--surface`, `--text`, `--accent`, `--border-strong`, `--pop`, dsb — otomatis swap saat `data-theme="dark"` di `<html>`.

**Font:**
- Body/heading: **Plus Jakarta Sans** (400, 500, 600, 700, 800)
- Angka/mono: **JetBrains Mono** (400, 500, 600)

```html
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
```

**Palet aksen:** cuma `--accent` (pink-red `#ff3b6b`). Jangan hardcode warna baru — pakai token.

**Radius:** 20px card, 12–14px input, 999px pill.

**Shadow neo-brutalist:** `box-shadow: 3px 3px 0 var(--border-strong)` buat tombol/chip yang mau nonjol.

**Theme toggle:** wajib ada sun/moon button di nav — key localStorage `rebornian.theme` (lintas app, sekali toggle apply ke semua).

Init script minimum di `<head>` sebelum render:
```html
<script>
(function(){
  const s = localStorage.getItem('rebornian.theme');
  const dark = matchMedia('(prefers-color-scheme: dark)').matches;
  document.documentElement.setAttribute('data-theme', s || (dark ? 'dark' : 'light'));
})();
</script>
```

**View transition circle-wipe** saat toggle — pola di `waktukita/dashboard.js` `switchTheme()`.

## Dev lokal

```bash
python -m http.server 8765
```

Buka:
- `http://localhost:8765/` — landing
- `http://localhost:8765/waktukita/`
- `http://localhost:8765/choropleth/`

## Deploy

Lihat [DEPLOY.md](DEPLOY.md).

## Nambah mini-app baru

1. Copy struktur `waktukita/` sebagai template
2. Bikin folder di root: `nama-app/`
3. Import `/assets/theme.css` + font Google
4. Reuse pola nav pill + theme toggle (contoh: `choropleth/index.html`)
5. Tambah tile di landing `index.html`
6. Commit + push → auto live di `rebornian48.my.id/nama-app/`

## Aset berat (opsional)

Aset >5 MB (geojson, video, dataset) jangan di-git. Upload direct ke Hostinger via File Manager ke `public_html/assets/`, akses via URL `/assets/...`. Ini kenapa `.gitignore` exclude `assets/json/`.
