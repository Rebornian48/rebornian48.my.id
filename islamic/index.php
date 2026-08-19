<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Al-Quran Digital — EQuran.id</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="islamic" defer></script>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Amiri:wght@400;700&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<!-- jQuery CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          bg:       '#07111e',
          bg2:      '#0d1a2a',
          bg3:      '#132135',
          card:     '#0f1e30',
          gold:     '#c8993e',
          gold2:    '#e2b96a',
          gold3:    '#f5d9a0',
          emerald:  '#1b5e42',
          emerald2: '#237a57',
          muted:    '#8fa1b5',
          dim:      '#4d6075',
        },
        fontFamily: {
          cinzel: ['Cinzel', 'serif'],
          amiri:  ['Amiri', 'serif'],
          lora:   ['Lora', 'Georgia', 'serif'],
        },
      },
    },
  }
</script>

<style>
  body { background-color: #07111e; font-family: 'Lora', Georgia, serif; }

  /* Geometric tile background */
  body::before {
    content: '';
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='72' height='72'%3E%3Cg fill='none' stroke='rgba(200%2C153%2C62%2C0.045)' stroke-width='0.6'%3E%3Cpolygon points='36%2C4 66%2C20 66%2C52 36%2C68 6%2C52 6%2C20'/%3E%3Cpolygon points='36%2C16 56%2C27 56%2C49 36%2C60 16%2C49 16%2C27'/%3E%3C/g%3E%3C/svg%3E");
  }
  body::after {
    content: '';
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background: radial-gradient(ellipse 90% 40% at 50% 0%, rgba(200,153,62,0.07) 0%, transparent 65%);
  }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: #07111e; }
  ::-webkit-scrollbar-thumb { background: rgba(200,153,62,0.2); border-radius: 4px; }

  .arabic { direction: rtl; font-family: 'Amiri', serif; }

  .nav-tab::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 2px; background: #c8993e;
    transform: scaleX(0); transition: transform .3s;
  }
  .nav-tab.active::after { transform: scaleX(1); }

  @keyframes spin { to { transform: rotate(360deg); } }
  .spin { animation: spin 0.8s linear infinite; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up { animation: fadeUp .28s ease both; }

  .card-hover { transition: border-color .2s, box-shadow .2s, transform .2s; }
  .card-hover:hover {
    border-color: rgba(200,153,62,.4) !important;
    box-shadow: 0 6px 28px rgba(200,153,62,.09);
    transform: translateY(-2px);
  }

  .chevron { transition: transform .25s; }
  .open .chevron { transform: rotate(180deg); }

  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
  .playing { animation: pulse 1.4s ease infinite; color: #237a57 !important; border-color: rgba(35,122,87,.5) !important; }

  select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%238fa1b5' d='M6 8L0 0h12z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px !important; }
</style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body class="min-h-screen text-gray-100 relative">

<!-- HEADER -->
<header class="relative z-10 text-center py-12 px-5 border-b border-white/5">
  <div class="flex items-center justify-center gap-4 mb-3">
    <div class="h-px w-20" style="background:linear-gradient(90deg,transparent,rgba(200,153,62,.6))"></div>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="opacity-60">
      <polygon points="10,1 12,7.5 19,7.5 13.5,11.5 15.5,18 10,14 4.5,18 6.5,11.5 1,7.5 8,7.5" stroke="#c8993e" stroke-width="0.8"/>
    </svg>
    <div class="h-px w-20" style="background:linear-gradient(90deg,rgba(200,153,62,.6),transparent)"></div>
  </div>
  <h1 class="font-cinzel font-bold tracking-widest mb-2" style="font-size:clamp(1.8rem,5vw,3rem);background:linear-gradient(135deg,#f5d9a0,#c8993e,#8a6020);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
    Al-Quran Digital
  </h1>
  <p class="text-muted font-lora italic text-sm">
    بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ &nbsp;·&nbsp; EQuran.id
  </p>
</header>

<!-- NAVIGATION -->
<nav class="sticky top-0 z-50 flex justify-center border-b border-white/5" style="background:rgba(7,17,30,.95);backdrop-filter:blur(16px)">
  <button id="tab-btn-quran"  class="nav-tab active relative flex items-center gap-2 px-6 py-4 font-cinzel text-xs font-semibold tracking-widest uppercase text-gold2 transition-colors" onclick="switchTab('quran')">
    <span>📖</span><span class="hidden sm:inline">Al-Quran</span>
  </button>
  <button id="tab-btn-doa"    class="nav-tab relative flex items-center gap-2 px-6 py-4 font-cinzel text-xs font-semibold tracking-widest uppercase text-muted transition-colors hover:text-gray-300" onclick="switchTab('doa')">
    <span>🤲</span><span class="hidden sm:inline">Doa &amp; Dzikir</span>
  </button>
  <button id="tab-btn-shalat" class="nav-tab relative flex items-center gap-2 px-6 py-4 font-cinzel text-xs font-semibold tracking-widest uppercase text-muted transition-colors hover:text-gray-300" onclick="switchTab('shalat')">
    <span>🕌</span><span class="hidden sm:inline">Jadwal Shalat</span>
  </button>
  <a href="imsakiyah.php" class="nav-tab relative flex items-center gap-2 px-6 py-4 font-cinzel text-xs font-semibold tracking-widest uppercase text-muted no-underline transition-colors hover:text-gray-300">
    <span>🌙</span><span class="hidden sm:inline">Imsakiyah</span>
  </a>
  <a href="waktu-shalat.php" class="nav-tab relative flex items-center gap-2 px-6 py-4 font-cinzel text-xs font-semibold tracking-widest uppercase text-muted no-underline transition-colors hover:text-gray-300">
    <span>🌍</span><span class="hidden sm:inline">Cari Kota</span>
  </a>
</nav>

<!-- MAIN -->
<main class="relative z-10 max-w-5xl mx-auto px-4 py-10">

  <!-- ═══ AL-QURAN ═══ -->
  <section id="tab-quran" class="tab-section">
    <div id="quran-list">
      <p class="font-cinzel text-xl font-semibold text-gold2 mb-1">114 Surat Al-Quran</p>
      <p class="text-muted italic text-sm mb-6">Pilih surat untuk membaca ayat beserta audio tilawah</p>
      <div class="relative mb-6">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-dim text-sm select-none">🔍</span>
        <input id="surat-search" type="text" placeholder="Cari surat (nama, nomor, atau arti)..."
          class="w-full bg-card border border-white/8 rounded-xl pl-10 pr-4 py-3 text-gray-100 font-lora text-sm outline-none transition-colors placeholder-dim"
          style="border-color:rgba(255,255,255,.08)">
      </div>
      <div id="surat-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
    </div>
    <div id="quran-detail" class="hidden"></div>
  </section>

  <!-- ═══ DOA & DZIKIR ═══ -->
  <section id="tab-doa" class="tab-section hidden">
    <p class="font-cinzel text-xl font-semibold text-gold2 mb-1">Doa &amp; Dzikir Harian</p>
    <p class="text-muted italic text-sm mb-5">228 doa pilihan — teks Arab, transliterasi &amp; terjemahan Indonesia</p>

    <!-- Search + Dropdown Filter -->
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
      <!-- Search -->
      <div class="relative flex-1">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-dim text-sm select-none pointer-events-none">🔍</span>
        <input id="doa-search" type="text" placeholder="Cari judul, teks Arab, atau terjemahan..."
          class="w-full bg-card border rounded-xl pl-10 pr-4 py-3 text-gray-100 font-lora text-sm outline-none transition-colors placeholder-dim"
          style="border-color:rgba(255,255,255,.08)">
      </div>
      <!-- Kategori Dropdown -->
      <div class="relative sm:w-56">
        <select id="doa-grup-select"
          class="w-full bg-card border rounded-xl px-4 py-3 text-gray-100 font-lora text-sm outline-none cursor-pointer appearance-none transition-colors"
          style="border-color:rgba(255,255,255,.08)">
          <option value="">🗂 Semua Kategori</option>
        </select>
      </div>
    </div>

    <!-- Result count -->
    <p id="doa-count" class="text-dim text-xs italic mb-4"></p>

    <div id="doa-list" class="flex flex-col gap-3"></div>
  </section>

  <!-- ═══ JADWAL SHALAT ═══ -->
  <section id="tab-shalat" class="tab-section hidden">
    <p class="font-cinzel text-xl font-semibold text-gold2 mb-1">Jadwal Shalat Bulanan</p>
    <p class="text-muted italic text-sm mb-6">517 kabupaten/kota di 34 provinsi — tahun 2026</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
      <div class="flex flex-col gap-1.5">
        <label class="font-cinzel text-xs text-muted tracking-widest uppercase">Provinsi</label>
        <select id="sel-provinsi" class="bg-card border rounded-xl px-4 py-3 text-gray-100 font-lora text-sm outline-none cursor-pointer appearance-none" style="border-color:rgba(255,255,255,.08)">
          <option value="">— Pilih Provinsi —</option>
        </select>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-cinzel text-xs text-muted tracking-widest uppercase">Kabupaten / Kota</label>
        <select id="sel-kabkota" disabled class="bg-card border rounded-xl px-4 py-3 text-gray-100 font-lora text-sm outline-none cursor-pointer appearance-none opacity-50" style="border-color:rgba(255,255,255,.08)">
          <option value="">— Pilih Kab/Kota —</option>
        </select>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-cinzel text-xs text-muted tracking-widest uppercase">Bulan</label>
        <select id="sel-bulan" class="bg-card border rounded-xl px-4 py-3 text-gray-100 font-lora text-sm outline-none cursor-pointer appearance-none" style="border-color:rgba(255,255,255,.08)">
          <option value="1">Januari</option><option value="2">Februari</option>
          <option value="3">Maret</option><option value="4">April</option>
          <option value="5">Mei</option><option value="6">Juni</option>
          <option value="7">Juli</option><option value="8">Agustus</option>
          <option value="9">September</option><option value="10">Oktober</option>
          <option value="11">November</option><option value="12">Desember</option>
        </select>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-cinzel text-xs text-muted tracking-widest uppercase">Tahun</label>
        <select id="sel-tahun" class="bg-card border rounded-xl px-4 py-3 text-gray-100 font-lora text-sm outline-none cursor-pointer appearance-none" style="border-color:rgba(255,255,255,.08)">
          <option value="2026">2026</option>
        </select>
      </div>
      <button id="btn-fetch-shalat" class="sm:col-span-2 text-white font-cinzel text-sm font-semibold tracking-widest rounded-xl py-3.5 transition-all" style="background:linear-gradient(135deg,#1b5e42,#237a57)">
        🕌 &nbsp; Tampilkan Jadwal Shalat
      </button>
    </div>
    <div id="shalat-result"></div>
  </section>

</main>

<!-- Toast -->
<div id="toast" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 font-lora text-sm rounded-xl px-5 py-3 shadow-xl border" style="background:rgba(60,20,20,.95);color:#fca5a5;border-color:rgba(239,68,68,.3)"></div>

<!-- Footer -->
<footer class="relative z-10 text-center text-dim text-xs italic py-6 border-t border-white/5">
  Data dari <a href="https://equran.id" target="_blank" class="text-gold hover:text-gold2 transition-colors">EQuran.id</a>
  &nbsp;·&nbsp; Al-Quran v2 · Doa &amp; Dzikir · Jadwal Shalat 2026
</footer>

<script>
$(function() {

// ─────────────────────────────────────────
//  CONFIG & HELPERS
// ─────────────────────────────────────────
const API   = 'https://equran.id/api';
const TIMEOUT = 14000;

/**
 * jQuery $.ajax wrapper — returns Promise<data>
 * Handles: timeout, network error, HTTP errors, malformed JSON,
 *          EQuran's {code, data} envelope, and bare array responses.
 */
function apiFetch(path, opts) {
  opts = opts || {};
  return new Promise(function(resolve, reject) {
    $.ajax({
      url:         API + path,
      method:      opts.method || 'GET',
      contentType: opts.body ? 'application/json' : undefined,
      data:        opts.body ? JSON.stringify(opts.body) : undefined,
      // ✅ FIX 1: pakai 'text' bukan 'json'
      // jQuery dengan dataType:'json' akan GAGAL (error callback) jika server
      // mengirim Content-Type selain application/json (misal text/html),
      // meskipun body-nya tetap JSON valid. Dengan 'text' kita parse manual.
      dataType:    'text',
      timeout:     TIMEOUT,

      success: function(raw) {
        var res;
        // ✅ FIX 2: parse manual sehingga kita bisa beri pesan jelas jika gagal
        try {
          res = JSON.parse(raw);
        } catch(e) {
          console.error('[apiFetch] JSON parse error untuk', path, ':', e.message);
          console.error('[apiFetch] Raw response:', raw ? raw.substring(0, 300) : '(kosong)');
          reject('Response bukan JSON valid. Cek console untuk detail.');
          return;
        }

        // ✅ FIX 3: handle semua kemungkinan format response EQuran
        // Format A — plain array (beberapa endpoint Doa)
        if (Array.isArray(res)) {
          resolve(res);
          return;
        }
        // Format B — envelope { code, message, data } (v2 & shalat API)
        if (res && typeof res === 'object' && 'data' in res) {
          if (res.code && res.code !== 200) {
            reject('Server error ' + res.code + ': ' + (res.message || 'Unknown'));
          } else {
            resolve(res.data);
          }
          return;
        }
        // Format C — objek tanpa wrapper (fallback)
        if (res && typeof res === 'object') {
          resolve(res);
          return;
        }
        reject('Format response tidak dikenal dari endpoint: ' + path);
      },

      error: function(xhr, status, err) {
        // ✅ FIX 4: tangani semua status error jQuery termasuk 'parseerror'
        if (status === 'timeout') {
          reject('Request timeout (' + (TIMEOUT/1000) + 'dtk). Server tidak merespons.');
        } else if (status === 'parseerror') {
          // Dengan dataType:'text' ini seharusnya tidak terjadi, tapi sebagai safety net
          reject('Gagal mem-parse response dari server.');
        } else if (xhr.status === 0) {
          reject('Tidak dapat terhubung. Periksa koneksi internet atau CORS.');
        } else if (xhr.status === 404) {
          reject('Endpoint tidak ditemukan (404): ' + path);
        } else if (xhr.status >= 500) {
          reject('Server error ' + xhr.status + '. Coba beberapa saat lagi.');
        } else if (xhr.status > 0) {
          reject('Gagal memuat data (HTTP ' + xhr.status + ').');
        } else {
          reject('Gagal memuat data: ' + (err || status || 'unknown error'));
        }
      }
    });
  });
}

function esc(str) {
  return str == null ? '' : String(str)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function loaderHtml(msg) {
  return `<div class="flex flex-col items-center gap-3 py-16 text-muted">
    <div class="w-9 h-9 rounded-full border-2 spin" style="border-color:rgba(200,153,62,.2);border-top-color:#c8993e"></div>
    <span class="text-sm italic">${esc(msg || 'Memuat data...')}</span>
  </div>`;
}

function errHtml(msg, retryFn) {
  return `<div class="flex flex-col items-center gap-4 py-14 text-center">
    <div class="text-3xl">⚠️</div>
    <p class="text-red-400 text-sm italic max-w-xs leading-relaxed">${esc(msg)}</p>
    ${retryFn ? `<button onclick="${retryFn}()" class="font-cinzel text-xs tracking-widest uppercase text-gold border border-gold/30 rounded-full px-5 py-2 hover:bg-gold/10 transition-colors">↺ Coba Lagi</button>` : ''}
  </div>`;
}

let toastTimer;
function toast(msg) {
  clearTimeout(toastTimer);
  $('#toast').text(msg).removeClass('hidden');
  toastTimer = setTimeout(function(){ $('#toast').addClass('hidden'); }, 3500);
}

// ─────────────────────────────────────────
//  TAB NAVIGATION
// ─────────────────────────────────────────
window.switchTab = function(tab) {
  $('.tab-section').addClass('hidden');
  $('#tab-' + tab).removeClass('hidden');
  $('.nav-tab').removeClass('active text-gold2').addClass('text-muted');
  $('#tab-btn-' + tab).addClass('active text-gold2').removeClass('text-muted');
};

// ─────────────────────────────────────────
//  ① AL-QURAN
// ─────────────────────────────────────────
var allSurat    = [];
var currentAudio = null;

function loadSurat() {
  $('#surat-grid').html(loaderHtml('Memuat daftar surat...'));

  apiFetch('/v2/surat')
    .then(function(data) {
      if (!Array.isArray(data) || !data.length) throw new Error('Data surat tidak tersedia.');
      allSurat = data;
      renderSuratGrid(allSurat);
    })
    .catch(function(err) {
      $('#surat-grid').html(errHtml(err, 'loadSurat'));
    });
}

function renderSuratGrid(list) {
  if (!list.length) {
    $('#surat-grid').html('<p class="col-span-full text-center text-muted italic py-12">Tidak ada hasil yang cocok.</p>');
    return;
  }
  var html = list.map(function(s, i) {
    return `<div class="card-hover bg-card border rounded-xl p-4 flex items-center gap-3 cursor-pointer fade-up"
                 style="border-color:rgba(255,255,255,.07);animation-delay:${Math.min(i*.025,.45)}s"
                 onclick="loadSuratDetail(${s.nomor})">
      <div class="flex-shrink-0 w-10 h-10 rounded-full border flex items-center justify-center" style="border-color:rgba(200,153,62,.2);background:rgba(200,153,62,.07)">
        <span class="font-cinzel text-xs font-bold text-gold">${s.nomor}</span>
      </div>
      <div class="flex-1 min-w-0">
        <p class="font-cinzel text-sm font-semibold text-gray-100 truncate">${esc(s.namaLatin)}</p>
        <p class="text-xs text-muted truncate mt-0.5">${esc(s.arti)} &middot; ${s.jumlahAyat} Ayat &middot; ${esc(s.tempatTurun)}</p>
      </div>
      <div class="arabic text-xl text-gold2 opacity-70 flex-shrink-0">${esc(s.nama)}</div>
    </div>`;
  }).join('');
  $('#surat-grid').html(html);
}

$('#surat-search').on('input', function() {
  var q = $(this).val().toLowerCase();
  if (!q) { renderSuratGrid(allSurat); return; }
  renderSuratGrid(allSurat.filter(function(s) {
    return s.namaLatin.toLowerCase().includes(q)
        || s.arti.toLowerCase().includes(q)
        || String(s.nomor).includes(q)
        || (s.nama || '').includes(q);
  }));
});

window.loadSuratDetail = function(nomor) {
  stopAudio();
  $('#quran-list').hide();
  var $detail = $('#quran-detail').removeClass('hidden').html(loaderHtml('Memuat surat...'));

  apiFetch('/v2/surat/' + nomor)
    .then(function(s) {
      if (!s || !s.ayat) throw new Error('Data ayat tidak ditemukan.');
      renderDetail(s, $detail);
    })
    .catch(function(err) {
      $detail.html('<button onclick="backToList()" class="mb-4 text-sm text-muted border border-white/10 rounded-full px-4 py-1.5 hover:border-gold/40 hover:text-gold transition-colors">← Kembali</button>' + errHtml(err, null));
    });
};

function renderDetail(s, $el) {
  var showBism = s.nomor !== 1 && s.nomor !== 9;

  var header = `
    <div class="text-center py-8 mb-6 border-b border-white/6">
      <button onclick="backToList()" class="inline-flex items-center gap-2 text-sm text-muted border border-white/10 rounded-full px-4 py-1.5 mb-6 hover:border-gold/40 hover:text-gold transition-colors">← Kembali ke Daftar</button>
      <div class="arabic text-5xl text-gold mb-2">${esc(s.nama)}</div>
      <h2 class="font-cinzel text-2xl font-bold text-gold2 mb-3">${esc(s.namaLatin)}</h2>
      <div class="flex flex-wrap justify-center gap-2">
        <span class="font-cinzel text-xs text-muted border border-white/10 rounded-full px-3 py-1">${esc(s.arti)}</span>
        <span class="font-cinzel text-xs text-muted border border-white/10 rounded-full px-3 py-1">${s.jumlahAyat} Ayat</span>
        <span class="font-cinzel text-xs text-muted border border-white/10 rounded-full px-3 py-1">${esc(s.tempatTurun)}</span>
      </div>
      ${s.deskripsi ? `<p class="text-muted text-sm italic max-w-2xl mx-auto leading-relaxed mt-4">${esc(s.deskripsi).substring(0,280)}${s.deskripsi.length>280?'...':''}</p>` : ''}
    </div>
    ${showBism ? '<div class="text-center arabic text-3xl text-gold2 py-5 mb-4 border-b border-white/6">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</div>' : ''}`;

  var ayatHtml = s.ayat.map(function(a, i) {
    var audioKeys = a.audio ? Object.keys(a.audio) : [];
    // Prefer key '05' (Misyari), fallback to first available
    var audioUrl  = a.audio ? (a.audio['05'] || a.audio[audioKeys[0]] || '') : '';

    return `<div class="bg-card border rounded-xl p-6 mb-4 fade-up" style="border-color:rgba(255,255,255,.07);animation-delay:${Math.min(i*.03,.5)}s">
      <div class="flex items-center mb-4">
        <span class="w-8 h-8 rounded-full border flex items-center justify-center font-cinzel text-xs text-gold font-bold" style="border-color:rgba(200,153,62,.2);background:rgba(200,153,62,.07)">${a.nomorAyat}</span>
        ${audioUrl ? `<button class="audio-btn ml-auto font-lora text-xs text-muted border border-white/15 rounded-full px-3 py-1.5 hover:border-gold/40 hover:text-gold transition-colors"
          data-url="${esc(audioUrl)}" data-id="${a.nomorAyat}" onclick="handleAudio(this)">▶ Tilawah</button>` : ''}
      </div>
      <p class="arabic text-2xl leading-loose text-gray-100 mb-4">${esc(a.teksArab)}</p>
      ${a.teksLatin ? `<p class="text-muted italic text-sm leading-relaxed mb-3">${esc(a.teksLatin)}</p>` : ''}
      ${a.teksIndonesia ? `<p class="text-gray-200 text-sm leading-relaxed border-t border-white/6 pt-3">${esc(a.teksIndonesia)}</p>` : ''}
    </div>`;
  }).join('');

  $el.html(header + '<div>' + ayatHtml + '</div>');
}

window.backToList = function() {
  stopAudio();
  $('#quran-detail').addClass('hidden');
  $('#quran-list').show();
};

window.handleAudio = function(btn) {
  var url = $(btn).data('url');
  var id  = String($(btn).data('id'));

  if (currentAudio && !currentAudio.paused && currentAudio._id === id) {
    stopAudio(); return;
  }
  stopAudio();

  currentAudio = new Audio(url);
  currentAudio._id  = id;
  currentAudio._btn = btn;

  $(btn).text('⏸ Berhenti').addClass('playing');

  currentAudio.play().catch(function(e) {
    resetBtn(btn); currentAudio = null;
    toast('Gagal memutar audio: ' + e.message);
  });
  currentAudio.onended = function() { resetBtn(btn); currentAudio = null; };
  currentAudio.onerror = function() { resetBtn(btn); currentAudio = null; toast('Audio tidak tersedia.'); };
};

function stopAudio() {
  if (currentAudio) {
    currentAudio.pause();
    if (currentAudio._btn) resetBtn(currentAudio._btn);
    currentAudio = null;
  }
}
function resetBtn(btn) {
  $(btn).text('▶ Tilawah').removeClass('playing');
}

// ─────────────────────────────────────────
//  ② DOA & DZIKIR
// ─────────────────────────────────────────
var allDoa    = [];
var activeGrup = '';

function loadDoa() {
  $('#doa-list').html(loaderHtml('Memuat doa & dzikir...'));

  apiFetch('/doa')
    .then(function(data) {
      console.log('[loadDoa] type:', typeof data, Array.isArray(data) ? 'array len='+data.length : JSON.stringify(data).substring(0,120));

      // apiFetch sudah unwrap envelope — 'data' bisa: array, object {data:[...]}, atau object lain
      var list;
      if (Array.isArray(data)) {
        list = data;
      } else if (data && Array.isArray(data.data)) {
        list = data.data;
      } else if (data && typeof data === 'object') {
        // Cari value pertama yang berupa array
        var keys = Object.keys(data);
        list = [];
        for (var i = 0; i < keys.length; i++) {
          if (Array.isArray(data[keys[i]])) { list = data[keys[i]]; break; }
        }
      } else {
        list = [];
      }

      console.log('[loadDoa] list.length:', list.length, list.length ? 'keys:'+Object.keys(list[0]) : '');
      if (!list.length) throw new Error('Data doa kosong atau format tidak dikenali.');
      allDoa = list;
      buildFilters();
      filterDoa(); // juga update count
    })
    .catch(function(err) {
      console.error('[loadDoa] catch:', err);
      $('#doa-list').html(errHtml(String(err), 'loadDoa'));
    });
}

function buildFilters() {
  var groups = [];
  allDoa.forEach(function(d) {
    var g = d.grup || d.group || '';
    if (g && !groups.includes(g)) groups.push(g);
  });
  groups.sort();

  var $sel = $('#doa-grup-select');
  $sel.html('<option value="">🗂 Semua Kategori</option>');
  groups.forEach(function(g) {
    $sel.append($('<option>').val(g).text(g));
  });

  // bind change event (bisa dipanggil ulang setelah rebuild)
  $sel.off('change').on('change', function() {
    activeGrup = $(this).val();
    filterDoa();
  });
}

window.setGrup = function(grup) {
  activeGrup = grup;
  $('#doa-grup-select').val(grup);
  filterDoa();
};

$('#doa-search').on('input', filterDoa);

function filterDoa() {
  var q    = ($('#doa-search').val() || '').toLowerCase();
  var list = allDoa;
  if (activeGrup) list = list.filter(function(d){
    return (d.grup || '') === activeGrup;
  });
  if (q) list = list.filter(function(d){
    var judul  = (d.nama   || d.judul  || '').toLowerCase();
    var arab   = (d.ar     || d.arab   || '');
    var indo   = (d.idn    || d.indo   || '').toLowerCase();
    var latin  = (d.tr     || d.latin  || '').toLowerCase();
    var tentang = (d.tentang || '').toLowerCase();
    return judul.includes(q) || arab.includes(q) || indo.includes(q) || latin.includes(q) || tentang.includes(q);
  });
  // Update result count
  var total = allDoa.length;
  var shown = list.length;
  $('#doa-count').text(shown < total ? ('Menampilkan ' + shown + ' dari ' + total + ' doa') : (total + ' doa tersedia'));
  renderDoa(list);
}

function renderDoa(list) {
  if (!list.length) {
    $('#doa-list').html('<p class="text-center text-muted italic py-16">Tidak ada doa yang cocok.</p>');
    return;
  }
  var html = list.map(function(d, idx) {
    // Field names sesuai API EQuran: id, nama, ar, tr, idn, tentang, grup, tag
    var uid    = d.id || d.nomor || (idx + 1);
    var cardId = 'doa-' + uid;
    var judul  = d.nama  || d.judul  || d.title || ('Doa #' + uid);
    var arab   = d.ar    || d.arab   || '';
    var latin  = d.tr    || d.latin  || '';
    var indo   = d.idn   || d.indo   || '';
    var tentang = d.tentang || d.info || d.keterangan || '';
    var grup   = d.grup  || d.group  || d.kategori || '';
    var tags   = Array.isArray(d.tag) ? d.tag : (d.tag ? String(d.tag).split(',').map(function(t){return t.trim();}) : []);

    // Badge grup
    var grupBadge = grup
      ? `<span class="font-cinzel text-xs px-2 py-0.5 rounded-full" style="background:rgba(200,153,62,.12);color:#e2b96a;border:1px solid rgba(200,153,62,.25)">${esc(grup)}</span>`
      : '';

    // Tags badges
    var tagBadges = tags.length
      ? tags.map(function(t){ return `<span class="font-cinzel text-xs px-2 py-0.5 rounded-full" style="background:rgba(255,255,255,.05);color:#8fa1b5;border:1px solid rgba(255,255,255,.08)">${esc(t)}</span>`; }).join('')
      : '';

    return `<div class="doa-card border rounded-xl overflow-hidden fade-up" style="background:#0f1e30;border-color:rgba(255,255,255,.08);transition:border-color .2s" id="${cardId}"
            onmouseenter="this.style.borderColor='rgba(200,153,62,.3)'" onmouseleave="this.style.borderColor='rgba(255,255,255,.08)'">

      <!-- HEADER ROW -->
      <div class="doa-head flex items-center justify-between px-5 py-4 cursor-pointer select-none" onclick="toggleDoa('${cardId}')">
        <div class="flex items-center gap-3 min-w-0 flex-1">
          <!-- number badge -->
          <span class="flex-shrink-0 w-8 h-8 rounded-full border flex items-center justify-center font-cinzel text-xs font-bold text-gold"
                style="border-color:rgba(200,153,62,.25);background:rgba(200,153,62,.08)">${String(uid).padStart(3,'0')}</span>
          <div class="min-w-0 flex-1">
            <p class="font-cinzel text-sm font-semibold text-gray-100 truncate">${esc(judul)}</p>
            ${(grupBadge || tagBadges) ? `<div class="flex flex-wrap gap-1.5 mt-1.5">${grupBadge}${tagBadges}</div>` : ''}
          </div>
        </div>
        <svg class="chevron flex-shrink-0 ml-3 text-dim" width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M2 5l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <!-- BODY (collapsed) -->
      <div class="doa-body hidden border-t" style="border-color:rgba(255,255,255,.07)">

        <!-- Arab -->
        ${arab ? `
        <div class="px-6 pt-6 pb-4">
          <p class="arabic text-right leading-loose text-gray-100" style="font-size:1.65rem;line-height:2.4">${esc(arab)}</p>
        </div>
        <div style="height:1px;background:rgba(255,255,255,.06);margin:0 24px"></div>` : ''}

        <!-- Transliterasi -->
        ${latin ? `
        <div class="px-6 py-4">
          <p class="font-cinzel text-xs tracking-widest uppercase mb-2" style="color:rgba(200,153,62,.7)">Transliterasi</p>
          <p class="font-lora italic leading-relaxed" style="color:#c4d0de;font-size:.9rem">${esc(latin)}</p>
        </div>
        <div style="height:1px;background:rgba(255,255,255,.06);margin:0 24px"></div>` : ''}

        <!-- Terjemahan -->
        ${indo ? `
        <div class="px-6 py-4">
          <p class="font-cinzel text-xs tracking-widest uppercase mb-2" style="color:rgba(200,153,62,.7)">Terjemahan</p>
          <p class="font-lora leading-relaxed text-gray-200" style="font-size:.92rem">${esc(indo)}</p>
        </div>` : ''}

        <!-- Tentang / Keterangan Doa -->
        ${tentang ? `
        <div class="px-6 py-4" style="border-top:1px solid rgba(255,255,255,.06)">
          <p class="font-cinzel text-xs tracking-widest uppercase mb-2" style="color:rgba(200,153,62,.7)">Tentang Doa Ini</p>
          <p class="font-lora leading-relaxed whitespace-pre-line" style="color:#8fa1b5;font-size:.85rem">${esc(tentang)}</p>
        </div>` : ''}

        <!-- Info footer: grup + tags -->
        ${(grup || tags.length) ? `
        <div class="px-6 py-3 flex flex-wrap items-center gap-x-4 gap-y-2" style="border-top:1px solid rgba(255,255,255,.06);background:rgba(0,0,0,.12)">
          ${grup ? `<span class="flex items-center gap-1.5 font-cinzel text-xs" style="color:#8fa1b5">
            <svg width="11" height="11" viewBox="0 0 16 16" fill="none"><path d="M2 4h3l2 2h7v8H2V4z" stroke="currentColor" stroke-width="1.2"/></svg>
            ${esc(grup)}</span>` : ''}
          ${tags.length ? `<div class="flex flex-wrap gap-1">${tags.map(function(t){return `<span class="font-cinzel text-xs px-2 py-0.5 rounded-full" style="background:rgba(255,255,255,.04);color:#4d6075;border:1px solid rgba(255,255,255,.07)">#${esc(t)}</span>`;}).join('')}</div>` : ''}
        </div>` : ''}
      </div>
    </div>`;
  }).join('');
  $('#doa-list').html(html);
}

window.toggleDoa = function(id) {
  var $card = $('#' + id);
  var wasOpen = $card.hasClass('open');
  $('.doa-card.open').removeClass('open').find('.doa-body').addClass('hidden');
  if (!wasOpen) { $card.addClass('open').find('.doa-body').removeClass('hidden'); }
};

// ─────────────────────────────────────────
//  ③ JADWAL SHALAT
// ─────────────────────────────────────────
function loadProvinsi() {
  apiFetch('/v2/shalat/provinsi')
    .then(function(data) {
      var list = Array.isArray(data) ? data : [];
      if (!list.length) throw new Error('Data provinsi kosong.');
      var $sel = $('#sel-provinsi');
      list.forEach(function(p) { $sel.append($('<option>').val(p).text(p)); });
      // Auto-set current month
      $('#sel-bulan').val(new Date().getMonth() + 1);
    })
    .catch(function(err) {
      $('#sel-provinsi').closest('.flex').append(`<p class="text-red-400 text-xs italic mt-1">⚠ ${esc(err)}</p>`);
    });
}

$('#sel-provinsi').on('change', function() {
  var prov = $(this).val();
  var $kab = $('#sel-kabkota');
  $kab.prop('disabled', true).css('opacity','0.5').html('<option value="">Memuat...</option>');
  if (!prov) { $kab.html('<option value="">— Pilih Kab/Kota —</option>'); return; }

  apiFetch('/v2/shalat/kabkota', { method:'POST', body:{ provinsi: prov } })
    .then(function(data) {
      var list = Array.isArray(data) ? data : [];
      $kab.html('<option value="">— Pilih Kab/Kota —</option>');
      list.forEach(function(k) { $kab.append($('<option>').val(k).text(k)); });
      $kab.prop('disabled', false).css('opacity','1');
    })
    .catch(function(err) {
      $kab.html('<option value="">⚠ Gagal memuat</option>').prop('disabled', false).css('opacity','1');
      toast(err);
    });
});

$('#btn-fetch-shalat').on('click', function() {
  var prov  = $('#sel-provinsi').val();
  var kab   = $('#sel-kabkota').val();
  var bulan = parseInt($('#sel-bulan').val());
  var tahun = parseInt($('#sel-tahun').val());

  if (!prov) { toast('Pilih provinsi terlebih dahulu.'); return; }
  if (!kab)  { toast('Pilih kabupaten/kota terlebih dahulu.'); return; }

  var $btn = $(this);
  $btn.prop('disabled', true).text('⏳ Memuat jadwal...');
  $('#shalat-result').html(loaderHtml('Mengambil jadwal shalat...'));

  apiFetch('/v2/shalat', { method:'POST', body:{ provinsi:prov, kabkota:kab, bulan:bulan, tahun:tahun } })
    .then(function(data) {
      if (!data || !data.jadwal || !data.jadwal.length) throw new Error('Jadwal shalat kosong untuk lokasi ini.');
      renderJadwal(data, bulan, tahun);
    })
    .catch(function(err) {
      $('#shalat-result').html(errHtml(err, null));
    })
    .always(function() {
      $btn.prop('disabled', false).html('🕌 &nbsp; Tampilkan Jadwal Shalat');
    });
});

function renderJadwal(data, bulan, tahun) {
  var jadwal     = data.jadwal;
  var bulan_nama = data.bulan_nama;
  var kabkota    = data.kabkota;
  var provinsi   = data.provinsi;
  var WAKTU = ['imsak','subuh','terbit','dhuha','dzuhur','ashar','maghrib','isya'];
  var LABEL = { imsak:'Imsak',subuh:'Subuh',terbit:'Terbit',dhuha:'Dhuha',dzuhur:'Dzuhur',ashar:'Ashar',maghrib:'Maghrib',isya:'Isya' };

  var today     = new Date();
  var todayDate = today.getDate();
  var isCur     = (bulan === today.getMonth() + 1 && tahun === today.getFullYear());
  var todayRow  = isCur ? jadwal.find(function(j){ return j.tanggal === todayDate; }) : null;

  // Today card
  var todayCard = '';
  if (todayRow) {
    var nowMins = today.getHours() * 60 + today.getMinutes();
    var mins    = WAKTU.map(function(w) {
      var t = (todayRow[w] || '00:00').split(':').map(Number);
      return t[0] * 60 + (t[1] || 0);
    });
    var nextIdx = mins.findIndex(function(m){ return m > nowMins; });
    if (nextIdx < 0) nextIdx = 0;

    todayCard = `<div class="border rounded-xl p-5 mb-6" style="background:linear-gradient(135deg,#132135,#0f1e30);border-color:rgba(200,153,62,.4)">
      <p class="font-cinzel text-xs text-gold tracking-widest uppercase mb-4">⏰ Jadwal Hari Ini — ${esc(todayRow.hari)}, ${todayRow.tanggal} ${esc(bulan_nama)} ${tahun}</p>
      <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
        ${WAKTU.map(function(w, i) {
          var isNext = i === nextIdx;
          return `<div class="text-center">
            <p class="font-cinzel text-xs text-muted tracking-wider mb-1">${LABEL[w]}</p>
            <p class="text-lg font-semibold ${isNext ? 'text-gold2' : 'text-gray-100'}">${todayRow[w] || '-'}</p>
            ${isNext ? '<p class="font-cinzel text-xs" style="color:rgba(200,153,62,.6)">Selanjutnya</p>' : ''}
          </div>`;
        }).join('')}
      </div>
    </div>`;
  }

  // Table rows
  var rows = jadwal.map(function(j) {
    var isToday = isCur && j.tanggal === todayDate;
    var rowBg   = isToday ? 'rgba(200,153,62,.05)' : '';
    var tdCls   = isToday ? 'color:#e2b96a;font-weight:600' : 'color:#8fa1b5';
    return `<tr style="${rowBg ? 'background:'+rowBg : ''}">
      <td class="px-4 py-2.5 whitespace-nowrap text-sm" style="color:#e2e8f0;font-weight:500">${esc(j.hari)}, ${j.tanggal}</td>
      ${WAKTU.map(function(w){ return `<td class="px-3 py-2.5 text-center text-sm whitespace-nowrap" style="${isToday?'color:#e2b96a;font-weight:600':'color:#8fa1b5'}">${j[w]||'-'}</td>`; }).join('')}
    </tr>`;
  }).join('');

  $('#shalat-result').html(`
    <div class="text-center mb-5">
      <h3 class="font-cinzel text-lg font-semibold text-gold2">${esc(kabkota)}, ${esc(provinsi)}</h3>
      <p class="text-muted italic text-sm">${esc(bulan_nama)} ${tahun} &mdash; ${jadwal.length} hari</p>
    </div>
    ${todayCard}
    <div class="overflow-x-auto rounded-xl border border-white/7">
      <table class="w-full text-sm">
        <thead style="background:#132135">
          <tr>
            <th class="px-4 py-3 text-left font-cinzel text-xs text-gold tracking-widest uppercase">Tanggal</th>
            ${WAKTU.map(function(w){ return `<th class="px-3 py-3 font-cinzel text-xs text-gold tracking-widest uppercase text-center">${LABEL[w]}</th>`; }).join('')}
          </tr>
        </thead>
        <tbody class="divide-y" style="border-color:rgba(255,255,255,.05)">${rows}</tbody>
      </table>
    </div>`);
}

// ─────────────────────────────────────────
//  INIT
// ─────────────────────────────────────────
window.loadSurat = loadSurat;
window.loadDoa   = loadDoa;

loadSurat();
loadDoa();
loadProvinsi();

}); // end $(function)
</script>
</body>
</html>