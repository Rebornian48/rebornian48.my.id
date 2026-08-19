# Changelog

Format ikut [Keep a Changelog](https://keepachangelog.com/id/1.1.0/). Versi tanpa tag rilis — anchor per tanggal + PR.

## [Unreleased]

_Belum ada perubahan._

## 2026-08-19

### Added
- **11 mini-app baru** dari `miniapps.zip` diintegrasikan dengan brand-bar shared (`/assets/brand.js`) supaya cross-app theme toggle sync ke `rebornian.theme`. ([#12](https://github.com/Rebornian48/rebornian48.my.id/pull/12))
  - `devkit` — hub tools ID (Cek NIK + GenderSense sudah include, sekaligus menggantikan `cek_nik` + `cek_gender` yang di-skip dari zip)
  - `islamic` — Al-Quran (EQuran.id) + Doa & Dzikir + Jadwal Shalat, plus sub-routes `islamic/imsakiyah.php` (dari `ismakiyah`) dan `islamic/waktu-shalat.php` (dari `clock2` — multi-metode kiblat MWL/Gulf/Egyptian + cari 500+ kota worldwide)
  - `calendar` — Kalender Nusantara (Masehi × Hijriah × Cina × Jawa, pancawara, neptu, pranata mangsa)
  - `calc` — Kalkulator programmer (DEC/BIN/HEX/OCT) + scientific
  - `asetku` — Personal finance tracker (net worth, distribusi, import/export)
  - `notepad` — LocalStorage editor (undo/redo, find/replace, autosave, export .TXT/.MD/.HTML)
  - `paint` — Pixel Studio (brush, layer, zoom, palette)
  - `music-instruments` — 5 virtual instrument (piano, guitar, drum, violin, trumpet)
  - `randomizer` — 10-in-1 game/tools suite (Coin Flip, Dice, Random Number, Password, Cards, Seat Picker, dll)
  - `tuang-sadayana` — Widget rehat sejenak (cangkir teh + quote)
- **landing**: 11 tile baru di tools grid (16 total setelah agecalc di-merge ke calendar).
- **support**: mini-app baru `/support/` — donation hub (Saweria, Trakteer, Karyakarsa, Sociabuzz, Tako, Nih Buat Jajan) + slot ad banner + thanks card. Footer year via PHP. ([#8](https://github.com/Rebornian48/rebornian48.my.id/pull/8))
- **landing**: card `support` (tag "Dukungan") tambah di tools grid. ([#9](https://github.com/Rebornian48/rebornian48.my.id/pull/9))

### Changed
- **waktukita**: swap nav ke pattern brand-nav choropleth-style — `rebornian48 / waktukita` + Live chip + theme toggle + Semua Tools. Hilangkan anchor Waktu/Cuaca/Adzan/Lokasi + CTA Perbarui. Padding horizontal pindah ke `.shell`. ([#6](https://github.com/Rebornian48/rebornian48.my.id/pull/6))
- **geocalc, basajawatools, codevault**: unify design ke waktukita/choropleth family — pakai `/assets/theme.css` tokens (pink `#ff3b6b` accent, cream `#f5f2ec` bg), font Plus Jakarta Sans + JetBrains Mono, cards + tabs pakai offset "pop" shadow style, buang palette lokal (Syne/orange, gold/cream, tailwind dark). Fungsi + IDs tidak berubah. ([#5](https://github.com/Rebornian48/rebornian48.my.id/pull/5))
- **choropleth**: align tema ke waktukita sebagai source of truth. ([#4](https://github.com/Rebornian48/rebornian48.my.id/pull/4))
- **11 miniapps**: pulled toward waktukita palette via shared shim `/assets/miniapp-restyle.css` (v2 non-aggressive — cuma unify font + alias legacy tokens; body paint per app tidak diganggu). ([#13](https://github.com/Rebornian48/rebornian48.my.id/pull/13), softened di [#14](https://github.com/Rebornian48/rebornian48.my.id/pull/14))
- **agecalc + calendar merged**: `agecalc/index.php` → `calendar/agecalc.php` dengan pill nav switcher (Kalender ↔ Kalkulator Usia). Folder `/agecalc/` dihapus, tile landing dikonsolidasi. ([#14](https://github.com/Rebornian48/rebornian48.my.id/pull/14))
- **refactor**: pindahkan per-app CSS/JS ke `/assets/` — `waktukita/styles.css` → `assets/waktukita.css`, `waktukita/dashboard.js` → `assets/waktukita.js`, `choropleth/choropleth.js` → `assets/choropleth.js`. ([#11](https://github.com/Rebornian48/rebornian48.my.id/pull/11))

### Fixed
- **waktukita**: cache-bust `styles.css?v=2` supaya browser/CDN fetch ulang selector brand-nav baru — sebelumnya render vertikal stacking karena CSS stale. ([#7](https://github.com/Rebornian48/rebornian48.my.id/pull/7))
- **rehat + agecalc blank di production**: PHP `require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/theme.php'` fatal error karena file tidak ada di repo → output halted setelah brand-bar. Removed the two require_once lines.
- **brand-bar shrink di flex parent**: `.r48-bar` sebelumnya shrink jadi pill kecil di app yang pakai `body{display:flex;align-items:center}` (rehat, agecalc). Tambah `width:100% + align-self:stretch + flex-shrink:0`. ([#15](https://github.com/Rebornian48/rebornian48.my.id/pull/15))
- **shim v1 broke dark-native apps**: awal shim force `body{background;color !important}` bikin randomizer + devkit invisible (cards dark + text light dipaksa ke cream bg). v2 drop body override, cuma unify font + token aliases. ([#14](https://github.com/Rebornian48/rebornian48.my.id/pull/14))

### Skipped (redundan)
- `clock` (jam analog+digital) — sudah tercakup di `waktukita` (jam lokal) dan `islamic/waktu-shalat` (jam analog + shalat)
- `year_progress` — sudah ada di `waktukita` (section Year Progress penuh) dan `islamic/waktu-shalat`
- `cek_gender` (GenderSense standalone) — sudah include di `devkit`
- `cek_nik` (Cek NIK standalone) — sudah include di `devkit`
- `ismakiyah` (standalone) & `clock2` (standalone) — di-merge sebagai sub-route di `/islamic/` supaya semua urusan Islami satu pintu

## 2026-08-18

### Added
- **basajawatools**: mini-app baru — Walikan Ngalam, Dagadu Jogja, transliterasi Aksara Jawa. ([#2](https://github.com/Rebornian48/rebornian48.my.id/pull/2))
- **codevault**: mini-app baru — snippet manager dengan PHP API backend. ([#2](https://github.com/Rebornian48/rebornian48.my.id/pull/2))
- **geocalc**: mini-app baru — kalkulator geometri 2D & 3D dengan preview SVG. ([#2](https://github.com/Rebornian48/rebornian48.my.id/pull/2))
- **assets**: `brand.css` + `brand.js` shared brand bar (auto-inject r48 bar lintas app). ([#2](https://github.com/Rebornian48/rebornian48.my.id/pull/2))

## 2026-08-17

### Added
- **waktukita**: initial mini-app — jam lokal, cuaca real-time (Open-Meteo), jadwal adzan (Kemenag RI via Aladhan), peta lokasi Leaflet.
- **choropleth**: initial mini-app — peta 38 provinsi Indonesia + upload CSV/Excel + neraca produksi + export SVG/PNG.
- **landing**: `index.html` root sebagai gallery mini-apps.
- **assets/theme.css**: shared design tokens (light + dark + view transition).
- **DEPLOY.md**: panduan Hostinger shared hosting.

### Changed
- **all**: unify design system across apps — waktukita jadi standard. ([#1](https://github.com/Rebornian48/rebornian48.my.id/pull/1))

### Removed
- **git**: exclude `assets/json/` dari git (geojson besar upload manual ke Hostinger).

[Unreleased]: https://github.com/Rebornian48/rebornian48.my.id/compare/main...HEAD
