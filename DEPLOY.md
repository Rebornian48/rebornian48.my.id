# Deploy ke Hostinger Shared Hosting (rebornian48.my.id)

Repo ini adalah **monorepo statis** — root = landing site, tiap subfolder = mini-app terpisah, otomatis jadi sub-path di domain.

```
rebornian48/
├── index.html                 → https://rebornian48.my.id/
├── assets/
│   ├── theme.css              # tokens shared (light + dark)
│   ├── brand.css, brand.js    # brand-nav auto-inject + theme sync
│   ├── miniapp-restyle.css    # shim untuk 11 miniapps PHP
│   ├── waktukita.css, waktukita.js
│   └── choropleth.js
├── waktukita/, choropleth/, geocalc/, basajawatools/, codevault/  # HTML apps
├── support/, devkit/, calc/, asetku/, notepad/, paint/            # PHP apps
├── music-instruments/, randomizer/, tuang-sadayana/               # PHP apps
├── islamic/{index,imsakiyah,waktu-shalat}.php    # multi-page app
└── calendar/{index,agecalc}.php                  # multi-page app
```

Nambah app baru: bikin folder di root, isi HTML/CSS/JS/PHP, commit, push. Otomatis live di `/nama-app/`.

**PHP support**: Hostinger shared hosting sudah include PHP 8. File `.php` di-execute otomatis. **Fatal error di include/require = page blank** — pastikan semua path exist sebelum push (lihat gotcha section di [README](README.md#php-miniapps--gotchas)).

---

## 1. Push repo ke GitHub / GitLab

```bash
git init
git add .
git commit -m "init: monorepo rebornian48 + waktukita"
git branch -M main
git remote add origin https://github.com/USERNAME/rebornian48.git
git push -u origin main
```

Repo boleh **private**. Hostinger dukung private via personal access token atau SSH deploy key.

---

## 2. Hubungkan ke Hostinger (hPanel Git)

1. Login hPanel → **Websites** → pilih `rebornian48.my.id` → **Advanced** → **Git**
2. **Create Repository**:
   - **Repository URL**:
     - Public: `https://github.com/USERNAME/rebornian48.git`
     - Private HTTPS: `https://TOKEN@github.com/USERNAME/rebornian48.git` (PAT scope `repo`)
     - Private SSH: `git@github.com:USERNAME/rebornian48.git` (tambah deploy key Hostinger ke repo GitHub Settings → Deploy keys)
   - **Branch**: `main`
   - **Install Path**: `public_html`
3. Klik **Create**. Hostinger clone repo langsung ke `public_html/`.

Cek: buka `https://rebornian48.my.id/` → landing muncul. `https://rebornian48.my.id/waktukita/` → dashboard muncul.

---

## 3. Auto-deploy tiap push (webhook)

Di hPanel Git panel, ada tombol **Copy webhook URL** → salin.

**GitHub**: repo Settings → Webhooks → Add webhook
- Payload URL: paste dari Hostinger
- Content type: `application/json`
- Events: **Just the push event**
- Aktif

Tiap `git push origin main` → Hostinger auto `git pull` di `public_html/`.

Manual deploy kalau webhook gagal: hPanel Git panel → **Manage** → **Deploy latest**.

---

## 4. Catatan penting

- **Shared assets** pakai absolute path `/assets/…` (theme.css, brand.js, waktukita.css, dll). Per-app HTML tinggal load via `<link href="/assets/nama.css">`.
- **CDN eksternal** (Leaflet, Google Fonts, API cuaca/adzan) pakai HTTPS absolut — aman.
- **HTTPS**: Hostinger kasih SSL gratis (Let's Encrypt) via hPanel → SSL. Auto-renew.
- **`.gitignore`** exclude `.claude/`, `docs/`, `tailadmin-template/` biar gak ke-push (bukan kode produksi).
- **Trailing slash**: Apache Hostinger otomatis serve `waktukita/index.html` saat URL `/waktukita/`. Untuk folder yang cuma punya `index.php` (support, devkit, calc, dll), pastikan DirectoryIndex include `index.php`:
  ```apache
  DirectoryIndex index.html index.php
  ```
- **Common PHP gotcha**: kalau app blank di production tapi normal di localhost, biasanya `require_once` atau `include` reference file yang ga ada di repo (misal `assets/theme.php`). Cek error log via hPanel → Errors atau tambah `error_reporting(E_ALL); ini_set('display_errors', 1);` sementara.
- **Cache-bust**: browser sering cache `.css`/`.js` agresif. Setelah update styling, bump query string di HTML: `<link href="styles.css?v=3">` supaya fetch ulang.

---

## 5. Kalau butuh cabang staging

Buat cabang `staging`, di hPanel bisa buat repo Git kedua yang track branch `staging` ke subdomain (misal `staging.rebornian48.my.id` → `public_html/staging/`). Butuh setup subdomain dulu di hPanel → Subdomains.
