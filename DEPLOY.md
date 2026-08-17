# Deploy ke Hostinger Shared Hosting (rebornian48.my.id)

Repo ini adalah **monorepo statis** — root = landing site, tiap subfolder = mini-app terpisah, otomatis jadi sub-path di domain.

```
rebornian48/
├── index.html                 → https://rebornian48.my.id/
├── waktukita/
│   ├── index.html             → https://rebornian48.my.id/waktukita/
│   ├── styles.css
│   └── dashboard.js
└── (mini-app baru)/           → https://rebornian48.my.id/nama-app/
```

Nambah app baru: bikin folder di root, isi HTML/CSS/JS, commit, push. Otomatis live di `/nama-app/`.

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

- **Semua path relatif** di HTML — `styles.css`, `dashboard.js`. Aman dipindah subfolder.
- **CDN eksternal** (Leaflet, Google Fonts, API cuaca/adzan) pakai HTTPS absolut — aman.
- **HTTPS**: Hostinger kasih SSL gratis (Let's Encrypt) via hPanel → SSL. Auto-renew.
- **`.gitignore`** exclude `.claude/`, `docs/`, `tailadmin-template/` biar gak ke-push (bukan kode produksi).
- **Trailing slash**: Apache Hostinger otomatis serve `waktukita/index.html` saat URL `/waktukita/`. Kalau redirect gak jalan, tambah `.htaccess` di root:
  ```apache
  DirectoryIndex index.html
  ```

---

## 5. Kalau butuh cabang staging

Buat cabang `staging`, di hPanel bisa buat repo Git kedua yang track branch `staging` ke subdomain (misal `staging.rebornian48.my.id` → `public_html/staging/`). Butuh setup subdomain dulu di hPanel → Subdomains.
