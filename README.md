# rebornian48

Monorepo static site untuk `rebornian48.my.id` di Hostinger shared hosting.

```
├── index.html          # landing rebornian48.my.id/
├── waktukita/          # rebornian48.my.id/waktukita/
│   ├── index.html      # Dashboard jam · cuaca · adzan · lokasi
│   ├── styles.css
│   └── dashboard.js
├── DEPLOY.md           # panduan deploy Hostinger
└── .gitignore
```

## Dev lokal

Serve root pakai server statis apa aja:

```bash
python -m http.server 8765
```

Buka `http://localhost:8765/` (landing) atau `http://localhost:8765/waktukita/`.

## Deploy

Lihat [DEPLOY.md](DEPLOY.md).

## Nambah mini-app

1. Bikin folder baru di root: `nama-app/`
2. Isi `index.html` (+ asset)
3. Update tile di landing `index.html`
4. Commit + push → auto live di `rebornian48.my.id/nama-app/`
