# Changelog

Format ikut [Keep a Changelog](https://keepachangelog.com/id/1.1.0/). Versi tanpa tag rilis — anchor per tanggal + PR.

## [Unreleased]

_Belum ada perubahan._

## 2026-08-19

### Added
- **support**: mini-app baru `/support/` — donation hub (Saweria, Trakteer, Karyakarsa, Sociabuzz, Tako, Nih Buat Jajan) + slot ad banner + thanks card. Footer year via PHP. ([#8](https://github.com/Rebornian48/rebornian48.my.id/pull/8))
- **landing**: card `support` (tag "Dukungan") tambah di tools grid sebagai card ke-6. ([#9](https://github.com/Rebornian48/rebornian48.my.id/pull/9))

### Changed
- **waktukita**: swap nav ke pattern brand-nav choropleth-style — `rebornian48 / waktukita` + Live chip + theme toggle + Semua Tools. Hilangkan anchor Waktu/Cuaca/Adzan/Lokasi + CTA Perbarui. Padding horizontal pindah ke `.shell`. ([#6](https://github.com/Rebornian48/rebornian48.my.id/pull/6))
- **geocalc, basajawatools, codevault**: unify design ke waktukita/choropleth family — pakai `/assets/theme.css` tokens (pink `#ff3b6b` accent, cream `#f5f2ec` bg), font Plus Jakarta Sans + JetBrains Mono, cards + tabs pakai offset "pop" shadow style, buang palette lokal (Syne/orange, gold/cream, tailwind dark). Fungsi + IDs tidak berubah. ([#5](https://github.com/Rebornian48/rebornian48.my.id/pull/5))
- **choropleth**: align tema ke waktukita sebagai source of truth. ([#4](https://github.com/Rebornian48/rebornian48.my.id/pull/4))

### Fixed
- **waktukita**: cache-bust `styles.css?v=2` supaya browser/CDN fetch ulang selector brand-nav baru — sebelumnya render vertikal stacking karena CSS stale. ([#7](https://github.com/Rebornian48/rebornian48.my.id/pull/7))

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
