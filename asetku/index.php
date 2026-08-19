<!-- AsetKu - Personal Finance Tracker by Claude -->
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AsetKu — Personal Finance Tracker</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="asetku" defer></script>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts: Syne (display) + DM Sans (body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- jQuery 3.7 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Chart.js via cdnjs (primary) with jsdelivr fallback -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
  <script>
    if (typeof Chart === 'undefined') {
      document.write('<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"><\/script>');
    }
  </script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            display: ['Syne', 'sans-serif'],
            body: ['DM Sans', 'sans-serif'],
          },
          colors: {
            brand: {
              50:  '#ecfdf5',
              100: '#d1fae5',
              200: '#a7f3d0',
              300: '#6ee7b7',
              400: '#34d399',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
              800: '#065f46',
              900: '#064e3b',
            },
            gold: {
              300: '#fcd34d',
              400: '#fbbf24',
              500: '#f59e0b',
            },
            surface: {
              900: '#0a0f0d',
              800: '#111812',
              700: '#182119',
              600: '#1e2b20',
              500: '#253328',
            }
          }
        }
      }
    }
  </script>

  <style>
    * { box-sizing: border-box; }

    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #0a0f0d;
      color: #e2f0eb;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #111812; }
    ::-webkit-scrollbar-thumb { background: #253328; border-radius: 3px; }

    /* ── Glass card ── */
    .glass {
      background: rgba(17,24,18,0.85);
      border: 1px solid rgba(52,211,153,0.12);
      backdrop-filter: blur(12px);
    }

    /* ── Glow accent ── */
    .glow-emerald { box-shadow: 0 0 32px rgba(16,185,129,0.15); }
    .glow-gold    { box-shadow: 0 0 32px rgba(251,191,36,0.12); }

    /* ── Stat card hover ── */
    .stat-card { transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(16,185,129,0.18); }

    /* ── Input focus ring ── */
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: #10b981 !important;
      box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
    }

    /* ── Custom checkbox / select ── */
    select option { background: #111812; color: #e2f0eb; }

    /* ── Table row hover ── */
    .asset-row { transition: background 0.15s; }
    .asset-row:hover { background: rgba(16,185,129,0.06) !important; }

    /* ── Badge ── */
    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 10px; border-radius: 999px;
      font-size: 11px; font-weight: 600; letter-spacing: 0.04em;
    }

    /* ── Tab active ── */
    .tab-btn.active {
      background: #10b981;
      color: #0a0f0d;
    }

    /* ── Fade animation ── */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(12px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation: fadeUp 0.4s ease both; }

    /* ── Progress bar ── */
    .progress-bar { height: 6px; border-radius: 999px; background: #182119; overflow: hidden; }
    .progress-fill { height:100%; border-radius:999px; transition: width 0.6s ease; }

    /* ── Tooltip (simple) ── */
    [data-tip] { position:relative; cursor:help; }
    [data-tip]:hover::after {
      content: attr(data-tip);
      position:absolute; bottom:calc(100% + 6px); left:50%; transform:translateX(-50%);
      background:#182119; color:#a7f3d0; padding:4px 10px; border-radius:6px;
      font-size:11px; white-space:nowrap; pointer-events:none; z-index:50;
      border: 1px solid rgba(52,211,153,0.2);
    }

    /* Modal backdrop */
    #modal-overlay {
      display:none; position:fixed; inset:0;
      background:rgba(0,0,0,0.7); backdrop-filter:blur(4px);
      z-index:100; align-items:center; justify-content:center;
    }
    #modal-overlay.open { display:flex; }

    /* Noise texture overlay */
    body::before {
      content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      opacity: 0.4;
    }
  </style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>

<body class="min-h-screen relative">

<!-- ════════════════════════════════════════
     NAVBAR
════════════════════════════════════════ -->
<nav class="sticky top-0 z-50 glass border-b border-emerald-900/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#0a0f0d" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <span class="font-display text-xl text-white tracking-tight">Aset<span class="text-brand-400">Ku</span></span>
    </div>

    <!-- Nav actions -->
    <div class="flex items-center gap-2">
      <!-- Import -->
      <label title="Import JSON" class="cursor-pointer flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-brand-300 border border-brand-800 hover:bg-brand-900/40 transition-colors">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        <span class="hidden sm:inline">Import</span>
        <input type="file" id="import-input" accept=".json" class="hidden" />
      </label>

      <!-- Export -->
      <button id="btn-export" title="Export JSON" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-brand-300 border border-brand-800 hover:bg-brand-900/40 transition-colors">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        <span class="hidden sm:inline">Export</span>
      </button>

      <!-- Reset -->
      <button id="btn-reset" title="Reset semua data" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-400 border border-red-900/50 hover:bg-red-900/20 transition-colors">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        <span class="hidden sm:inline">Reset</span>
      </button>

      <!-- Add Asset -->
      <button id="btn-open-modal" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-brand-500 text-surface-900 hover:bg-brand-400 transition-colors shadow-lg shadow-brand-900/40">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Aset</span>
      </button>
    </div>
  </div>
</nav>

<!-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ -->
<main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

  <!-- ── HERO NET WORTH ── -->
  <section class="fade-up glass rounded-2xl p-6 sm:p-8 glow-emerald">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
      <div>
        <p class="text-xs font-semibold uppercase tracking-widest text-brand-600 mb-1">Total Net Worth</p>
        <h1 id="total-net-worth" class="font-display text-4xl sm:text-5xl text-white">Rp 0</h1>
        <p class="text-sm text-brand-700 mt-2" id="asset-count-label">0 aset tercatat</p>
      </div>
      <div class="text-right hidden sm:block">
        <p class="text-xs text-brand-700">Terakhir diperbarui</p>
        <p id="last-updated" class="text-sm text-brand-400 font-medium">—</p>
      </div>
    </div>
  </section>

  <!-- ── STATS CARDS ── -->
  <section class="grid grid-cols-2 lg:grid-cols-5 gap-3 fade-up">
    <!-- filled dynamically -->
    <div id="stat-cards" class="contents"></div>
  </section>

  <!-- ── TABS ── -->
  <div class="fade-up flex gap-2 p-1 glass rounded-xl w-fit">
    <button class="tab-btn active text-sm font-semibold px-5 py-2 rounded-lg transition-all" data-tab="dashboard">Dashboard</button>
    <button class="tab-btn text-sm font-semibold px-5 py-2 rounded-lg text-brand-600 hover:text-brand-400 transition-all" data-tab="assets">Semua Aset</button>
  </div>

  <!-- ════════ TAB: DASHBOARD ════════ -->
  <div id="tab-dashboard" class="tab-content space-y-6 fade-up">

    <!-- Charts row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- Pie Chart -->
      <div class="glass rounded-2xl p-6">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 mb-4">Distribusi Aset</h2>
        <div class="relative h-64 flex items-center justify-center">
          <canvas id="pie-chart"></canvas>
          <div id="pie-empty" class="absolute text-center text-brand-700 text-sm hidden">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            Belum ada data aset
          </div>
        </div>
      </div>

      <!-- Bar Chart -->
      <div class="glass rounded-2xl p-6">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 mb-4">Nilai per Kategori</h2>
        <div class="relative h-64">
          <canvas id="bar-chart"></canvas>
          <div id="bar-empty" class="absolute inset-0 flex items-center justify-center text-brand-700 text-sm hidden">
            <div class="text-center">
              <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
              Belum ada data aset
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Summary Table -->
    <div class="glass rounded-2xl overflow-hidden">
      <div class="px-6 py-4 border-b border-brand-900/40">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600">Ringkasan Kategori</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-brand-900/30">
              <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Kategori</th>
              <th class="text-right px-6 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Jumlah Aset</th>
              <th class="text-right px-6 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Total Nilai</th>
              <th class="text-right px-6 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">% Portofolio</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody id="category-summary-body">
            <tr>
              <td colspan="5" class="px-6 py-8 text-center text-brand-700 text-sm">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                Tambahkan aset pertama Anda
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ════════ TAB: ALL ASSETS ════════ -->
  <div id="tab-assets" class="tab-content space-y-4 fade-up hidden">

    <!-- Filter bar -->
    <div class="glass rounded-xl p-4 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
      <div class="flex items-center gap-2 flex-1">
        <svg width="16" height="16" class="text-brand-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        <span class="text-xs font-semibold text-brand-600 uppercase tracking-wider">Filter:</span>
      </div>
      <div class="flex flex-wrap gap-2" id="filter-btns">
        <button class="filter-btn active text-xs font-semibold px-3 py-1.5 rounded-lg bg-brand-500 text-surface-900 transition-all" data-filter="all">Semua</button>
      </div>
    </div>

    <!-- Assets table -->
    <div class="glass rounded-2xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-brand-900/30">
              <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Nama Aset</th>
              <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Kategori</th>
              <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Nilai</th>
              <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Tanggal</th>
              <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Catatan</th>
              <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-700">Aksi</th>
            </tr>
          </thead>
          <tbody id="assets-table-body">
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-brand-700 text-sm">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Belum ada aset. Klik "Tambah Aset" untuk memulai.
              </td>
            </tr>
          </tbody>
          <tfoot id="assets-table-footer" class="border-t border-brand-900/30 hidden">
            <tr>
              <td colspan="2" class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-brand-500">Total Terfilter</td>
              <td id="footer-total" class="text-right px-4 py-3 text-sm font-bold text-brand-300"></td>
              <td colspan="3"></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

</main>

<!-- ════════════════════════════════════════
     MODAL: ADD / EDIT ASSET
════════════════════════════════════════ -->
<div id="modal-overlay">
  <div class="glass rounded-2xl w-full max-w-md mx-4 p-6 sm:p-8 border border-brand-800/50 shadow-2xl shadow-black/50 fade-up" style="animation-duration:0.3s">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-display text-xl text-white" id="modal-title">Tambah Aset</h2>
      <button id="btn-close-modal" class="text-brand-700 hover:text-brand-300 transition-colors">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- Form -->
    <div class="space-y-4">
      <input type="hidden" id="form-id" />

      <!-- Nama -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-brand-600 mb-1.5">Nama Aset <span class="text-red-500">*</span></label>
        <input type="text" id="form-name" placeholder="contoh: Tabungan BCA, Bitcoin..."
          class="w-full bg-surface-700 border border-brand-900/60 rounded-xl px-4 py-2.5 text-sm text-white placeholder-brand-800 transition-colors" />
      </div>

      <!-- Kategori -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-brand-600 mb-1.5">Kategori <span class="text-red-500">*</span></label>
        <select id="form-category" class="w-full bg-surface-700 border border-brand-900/60 rounded-xl px-4 py-2.5 text-sm text-white transition-colors appearance-none">
          <option value="">— Pilih Kategori —</option>
          <option value="Uang Tunai">💵 Uang Tunai</option>
          <option value="Rekening Bank">🏦 Rekening Bank</option>
          <option value="Dompet Digital">📱 Dompet Digital</option>
          <option value="Saham">📈 Saham</option>
          <option value="Crypto">🪙 Crypto</option>
        </select>
      </div>

      <!-- Nilai -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-brand-600 mb-1.5">Nilai (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-600 text-sm font-semibold">Rp</span>
          <input type="number" id="form-value" placeholder="0" min="0" step="1000"
            class="w-full bg-surface-700 border border-brand-900/60 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-brand-800 transition-colors" />
        </div>
      </div>

      <!-- Tanggal -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-brand-600 mb-1.5">Tanggal</label>
        <input type="date" id="form-date"
          class="w-full bg-surface-700 border border-brand-900/60 rounded-xl px-4 py-2.5 text-sm text-white transition-colors" />
      </div>

      <!-- Catatan -->
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-brand-600 mb-1.5">Catatan <span class="text-brand-800 font-normal normal-case">(opsional)</span></label>
        <textarea id="form-notes" rows="2" placeholder="Catatan tambahan..."
          class="w-full bg-surface-700 border border-brand-900/60 rounded-xl px-4 py-2.5 text-sm text-white placeholder-brand-800 transition-colors resize-none"></textarea>
      </div>

      <!-- Error -->
      <p id="form-error" class="text-xs text-red-400 hidden"></p>

      <!-- Submit -->
      <button id="btn-save-asset" class="w-full py-3 rounded-xl bg-brand-500 hover:bg-brand-400 text-surface-900 font-bold text-sm transition-colors shadow-lg shadow-brand-900/40 mt-2">
        Simpan Aset
      </button>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     MODAL: CONFIRM RESET
════════════════════════════════════════ -->
<div id="confirm-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); z-index:200; align-items:center; justify-content:center;">
  <div class="glass rounded-2xl w-full max-w-sm mx-4 p-6 border border-red-900/30 fade-up" style="animation-duration:0.25s">
    <div class="flex items-center gap-3 mb-4">
      <div class="w-10 h-10 rounded-xl bg-red-900/30 border border-red-800/40 flex items-center justify-center text-red-400">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
      </div>
      <h3 class="font-display text-lg text-white">Reset Semua Data?</h3>
    </div>
    <p class="text-sm text-brand-600 mb-6">Semua aset yang tersimpan akan <strong class="text-red-400">dihapus permanen</strong>. Aksi ini tidak bisa dibatalkan.</p>
    <div class="flex gap-3">
      <button id="btn-cancel-reset" class="flex-1 py-2.5 rounded-xl border border-brand-800 text-sm font-semibold text-brand-400 hover:bg-brand-900/20 transition-colors">Batal</button>
      <button id="btn-confirm-reset" class="flex-1 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-sm transition-colors">Hapus Semua</button>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     TOAST NOTIFICATION
════════════════════════════════════════ -->
<div id="toast" class="fixed bottom-6 right-6 z-[999] hidden">
  <div class="glass rounded-xl px-5 py-3 flex items-center gap-3 border border-brand-700/50 shadow-xl shadow-black/30 text-sm font-medium text-white">
    <span id="toast-icon">✓</span>
    <span id="toast-msg">Berhasil!</span>
  </div>
</div>

<!-- ════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
$(function () {

  // ──────────────────────────────────────
  // CONSTANTS & STATE
  // ──────────────────────────────────────
  const STORAGE_KEY = 'asetku_v1';

  const CATEGORY_META = {
    'Uang Tunai':     { icon: '💵', color: '#34d399', bg: 'rgba(52,211,153,0.15)'  },
    'Rekening Bank':  { icon: '🏦', color: '#60a5fa', bg: 'rgba(96,165,250,0.15)'  },
    'Dompet Digital': { icon: '📱', color: '#a78bfa', bg: 'rgba(167,139,250,0.15)' },
    'Saham':          { icon: '📈', color: '#fbbf24', bg: 'rgba(251,191,36,0.15)'  },
    'Crypto':         { icon: '🪙', color: '#fb923c', bg: 'rgba(251,146,60,0.15)'  },
  };

  let assets = loadAssets();
  let activeFilter = 'all';
  let editingId = null;
  let pieChart = null;
  let barChart = null;

  // ──────────────────────────────────────
  // STORAGE HELPERS
  // ──────────────────────────────────────
  function loadAssets() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      return raw ? JSON.parse(raw) : [];
    } catch(e) { return []; }
  }

  function saveAssets() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(assets));
  }

  function genId() {
    return Date.now().toString(36) + Math.random().toString(36).slice(2, 7);
  }

  // ──────────────────────────────────────
  // CURRENCY FORMAT
  // ──────────────────────────────────────
  function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
  }

  function shortRp(n) {
    if (n >= 1e9)  return 'Rp ' + (n/1e9).toFixed(1).replace('.',',') + ' M';
    if (n >= 1e6)  return 'Rp ' + (n/1e6).toFixed(1).replace('.',',') + ' jt';
    if (n >= 1e3)  return 'Rp ' + (n/1e3).toFixed(0) + ' rb';
    return formatRp(n);
  }

  // ──────────────────────────────────────
  // CATEGORY AGGREGATION
  // ──────────────────────────────────────
  function categoryTotals() {
    const totals = {};
    assets.forEach(a => {
      if (!totals[a.category]) totals[a.category] = { count: 0, total: 0 };
      totals[a.category].count++;
      totals[a.category].total += Number(a.value);
    });
    return totals;
  }

  function grandTotal() {
    return assets.reduce((s, a) => s + Number(a.value), 0);
  }

  // ──────────────────────────────────────
  // RENDER: HERO + STATS
  // ──────────────────────────────────────
  function renderHero() {
    const total = grandTotal();
    $('#total-net-worth').text(formatRp(total));
    $('#asset-count-label').text(assets.length + ' aset tercatat');
    const now = new Date();
    $('#last-updated').text(now.toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' }));
  }

  function renderStatCards() {
    const totals = categoryTotals();
    const grand  = grandTotal();
    let html = '';

    Object.keys(CATEGORY_META).forEach(cat => {
      const meta = CATEGORY_META[cat];
      const data = totals[cat] || { count: 0, total: 0 };
      const pct  = grand > 0 ? ((data.total / grand) * 100).toFixed(1) : '0.0';
      html += `
        <div class="stat-card glass rounded-xl p-4 flex flex-col gap-2">
          <div class="flex items-center justify-between">
            <span class="text-lg">${meta.icon}</span>
            <span class="badge" style="background:${meta.bg}; color:${meta.color}">${pct}%</span>
          </div>
          <p class="text-xs font-semibold text-brand-600 leading-tight">${cat}</p>
          <p class="text-base font-bold text-white">${shortRp(data.total)}</p>
          <p class="text-xs text-brand-700">${data.count} aset</p>
        </div>`;
    });

    $('#stat-cards').html(html);
  }

  // ──────────────────────────────────────
  // RENDER: CATEGORY SUMMARY TABLE
  // ──────────────────────────────────────
  function renderCategorySummary() {
    const totals = categoryTotals();
    const grand  = grandTotal();
    let html = '';

    if (assets.length === 0) {
      html = `<tr><td colspan="5" class="px-6 py-8 text-center text-brand-700 text-sm">
        <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        Tambahkan aset pertama Anda
      </td></tr>`;
    } else {
      const sorted = Object.entries(totals).sort((a,b) => b[1].total - a[1].total);
      sorted.forEach(([cat, data]) => {
        const meta = CATEGORY_META[cat] || { icon:'📦', color:'#a0aec0', bg:'rgba(160,174,192,0.1)' };
        const pct  = grand > 0 ? ((data.total / grand) * 100).toFixed(1) : '0.0';
        html += `
          <tr class="asset-row border-b border-brand-900/20">
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <span class="text-lg">${meta.icon}</span>
                <span class="font-medium text-white">${cat}</span>
              </div>
            </td>
            <td class="text-right px-6 py-4 text-brand-500">${data.count}</td>
            <td class="text-right px-6 py-4 font-semibold text-white">${formatRp(data.total)}</td>
            <td class="text-right px-6 py-4">
              <span class="badge" style="background:${meta.bg}; color:${meta.color}">${pct}%</span>
            </td>
            <td class="px-6 py-4 w-40">
              <div class="progress-bar"><div class="progress-fill" style="width:${pct}%; background:${meta.color}"></div></div>
            </td>
          </tr>`;
      });
    }
    $('#category-summary-body').html(html);
  }

  // ──────────────────────────────────────
  // RENDER: FILTER BUTTONS
  // ──────────────────────────────────────
  function renderFilterBtns() {
    const cats = [...new Set(assets.map(a => a.category))];
    let html = `<button class="filter-btn${activeFilter==='all'?' active':''} text-xs font-semibold px-3 py-1.5 rounded-lg transition-all" data-filter="all">Semua</button>`;
    cats.forEach(cat => {
      const meta = CATEGORY_META[cat] || { icon:'📦' };
      html += `<button class="filter-btn${activeFilter===cat?' active':''} text-xs font-semibold px-3 py-1.5 rounded-lg border border-brand-800/60 text-brand-500 hover:text-brand-300 hover:border-brand-600 transition-all" data-filter="${cat}">${meta.icon} ${cat}</button>`;
    });
    $('#filter-btns').html(html);
  }

  // ──────────────────────────────────────
  // RENDER: ASSETS TABLE
  // ──────────────────────────────────────
  function renderAssetsTable() {
    const filtered = activeFilter === 'all'
      ? assets
      : assets.filter(a => a.category === activeFilter);

    if (filtered.length === 0) {
      const msg = assets.length === 0
        ? 'Belum ada aset. Klik "Tambah Aset" untuk memulai.'
        : 'Tidak ada aset di kategori ini.';
      $('#assets-table-body').html(`<tr><td colspan="6" class="px-6 py-8 text-center text-brand-700 text-sm">${msg}</td></tr>`);
      $('#assets-table-footer').addClass('hidden');
      return;
    }

    let html = '';
    filtered.forEach(a => {
      const meta = CATEGORY_META[a.category] || { icon:'📦', color:'#a0aec0', bg:'rgba(160,174,192,0.1)' };
      const dateStr = a.date ? new Date(a.date).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' }) : '—';
      html += `
        <tr class="asset-row border-b border-brand-900/20" data-id="${a.id}">
          <td class="px-4 py-3 font-medium text-white">${escHtml(a.name)}</td>
          <td class="px-4 py-3">
            <span class="badge" style="background:${meta.bg}; color:${meta.color}">${meta.icon} ${a.category}</span>
          </td>
          <td class="text-right px-4 py-3 font-semibold text-brand-300">${formatRp(a.value)}</td>
          <td class="text-center px-4 py-3 text-brand-600 text-xs">${dateStr}</td>
          <td class="px-4 py-3 text-brand-600 text-xs max-w-[140px] truncate" title="${escHtml(a.notes || '')}">${escHtml(a.notes || '—')}</td>
          <td class="px-4 py-3">
            <div class="flex items-center justify-center gap-2">
              <button class="btn-edit text-brand-600 hover:text-brand-300 transition-colors" data-id="${a.id}" title="Edit">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </button>
              <button class="btn-delete text-red-700 hover:text-red-400 transition-colors" data-id="${a.id}" title="Hapus">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
          </td>
        </tr>`;
    });

    const filtTotal = filtered.reduce((s, a) => s + Number(a.value), 0);
    $('#assets-table-body').html(html);
    $('#footer-total').text(formatRp(filtTotal));
    $('#assets-table-footer').removeClass('hidden');
  }

  // ──────────────────────────────────────
  // CANVAS RESET HELPER
  // ──────────────────────────────────────
  function resetCanvas(id) {
    // Destroy existing Chart instance if registered
    const existing = Chart.getChart(id);
    if (existing) existing.destroy();
    // Replace canvas node to fully wipe internal state
    const oldEl = document.getElementById(id);
    if (!oldEl) return null;
    const newEl = document.createElement('canvas');
    newEl.id = id;
    newEl.style.display = 'block';
    oldEl.parentNode.replaceChild(newEl, oldEl);
    return newEl;
  }

  // ──────────────────────────────────────
  // RENDER: CHARTS
  // ──────────────────────────────────────
  function renderCharts() {
    // Guard: Chart.js must be loaded
    if (typeof Chart === 'undefined') {
      $('#pie-chart').hide();
      $('#bar-chart').hide();
      $('#pie-empty').removeClass('hidden').html(
        '<p class="text-xs text-red-400 mt-2">Chart.js gagal dimuat.<br>Pastikan Anda terhubung ke internet.</p>'
      );
      $('#bar-empty').removeClass('hidden').html(
        '<p class="text-xs text-red-400 mt-2">Chart.js gagal dimuat.<br>Pastikan Anda terhubung ke internet.</p>'
      );
      return;
    }

    const totals = categoryTotals();
    const cats   = Object.keys(totals);
    const vals   = cats.map(c => totals[c].total);
    const colors = cats.map(c => (CATEGORY_META[c] || {color:'#6b7280'}).color);

    // ── PIE ──
    if (cats.length === 0) {
      const oldPie = document.getElementById('pie-chart');
      if (oldPie) oldPie.style.display = 'none';
      $('#pie-empty').removeClass('hidden');
    } else {
      $('#pie-empty').addClass('hidden');
      const pieCanvas = resetCanvas('pie-chart');
      if (pieCanvas) {
        pieChart = new Chart(pieCanvas.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: cats,
            datasets: [{
              data: vals,
              backgroundColor: colors.map(c => c + 'cc'),
              borderColor: colors,
              borderWidth: 2,
              hoverOffset: 8,
            }]
          },
          options: {
            cutout: '62%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  color: '#6ee7b7',
                  font: { family: 'DM Sans', size: 11 },
                  padding: 12,
                  usePointStyle: true,
                }
              },
              tooltip: {
                callbacks: {
                  label: ctx => {
                    const val = ctx.parsed;
                    const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                    const pct = total > 0 ? ((val/total)*100).toFixed(1) : 0;
                    return ` ${formatRp(val)} (${pct}%)`;
                  }
                }
              }
            }
          }
        });
      }
    }

    // ── BAR ──
    if (cats.length === 0) {
      const oldBar = document.getElementById('bar-chart');
      if (oldBar) oldBar.style.display = 'none';
      $('#bar-empty').removeClass('hidden');
    } else {
      $('#bar-empty').addClass('hidden');
      const barCanvas = resetCanvas('bar-chart');
      if (barCanvas) {
        barChart = new Chart(barCanvas.getContext('2d'), {
          type: 'bar',
          data: {
            labels: cats,
            datasets: [{
              label: 'Nilai Aset',
              data: vals,
              backgroundColor: colors.map(c => c + '55'),
              borderColor: colors,
              borderWidth: 2,
              borderRadius: 6,
              borderSkipped: false,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: ctx => ' ' + formatRp(ctx.parsed.y)
                }
              }
            },
            scales: {
              x: {
                grid: { color: 'rgba(52,211,153,0.05)' },
                ticks: { color: '#6ee7b7', font: { family:'DM Sans', size:11 } }
              },
              y: {
                grid: { color: 'rgba(52,211,153,0.05)' },
                ticks: {
                  color: '#6ee7b7',
                  font: { family:'DM Sans', size:10 },
                  callback: v => shortRp(v)
                }
              }
            }
          }
        });
      }
    }
  }

  // ──────────────────────────────────────
  // FULL RENDER
  // ──────────────────────────────────────
  function renderAll() {
    renderHero();
    renderStatCards();
    renderCategorySummary();
    renderCharts();
    renderFilterBtns();
    renderAssetsTable();
  }

  // ──────────────────────────────────────
  // MODAL HELPERS
  // ──────────────────────────────────────
  function openModal(asset) {
    if (asset) {
      editingId = asset.id;
      $('#modal-title').text('Edit Aset');
      $('#form-id').val(asset.id);
      $('#form-name').val(asset.name);
      $('#form-category').val(asset.category);
      $('#form-value').val(asset.value);
      $('#form-date').val(asset.date || '');
      $('#form-notes').val(asset.notes || '');
    } else {
      editingId = null;
      $('#modal-title').text('Tambah Aset');
      $('#form-id').val('');
      $('#form-name').val('');
      $('#form-category').val('');
      $('#form-value').val('');
      $('#form-date').val(new Date().toISOString().split('T')[0]);
      $('#form-notes').val('');
    }
    $('#form-error').addClass('hidden').text('');
    $('#modal-overlay').addClass('open');
  }

  function closeModal() {
    $('#modal-overlay').removeClass('open');
    editingId = null;
  }

  // ──────────────────────────────────────
  // TOAST
  // ──────────────────────────────────────
  let toastTimer = null;
  function showToast(msg, type) {
    clearTimeout(toastTimer);
    const icons = { success:'✓', error:'✕', info:'ℹ' };
    $('#toast-icon').text(icons[type] || '✓');
    $('#toast-msg').text(msg);
    $('#toast').show();
    toastTimer = setTimeout(() => $('#toast').fadeOut(300), 3000);
  }

  // ──────────────────────────────────────
  // ESCAPE HTML
  // ──────────────────────────────────────
  function escHtml(str) {
    return String(str)
      .replace(/&/g,'&amp;')
      .replace(/</g,'&lt;')
      .replace(/>/g,'&gt;')
      .replace(/"/g,'&quot;');
  }

  // ──────────────────────────────────────
  // SAVE ASSET (add or edit)
  // ──────────────────────────────────────
  function saveAsset() {
    const name     = $.trim($('#form-name').val());
    const category = $('#form-category').val();
    const value    = parseFloat($('#form-value').val());
    const date     = $('#form-date').val();
    const notes    = $.trim($('#form-notes').val());

    if (!name)            { showFormError('Nama aset tidak boleh kosong.'); return; }
    if (!category)        { showFormError('Pilih kategori aset.'); return; }
    if (isNaN(value) || value < 0) { showFormError('Nilai harus berupa angka positif.'); return; }

    if (editingId) {
      const idx = assets.findIndex(a => a.id === editingId);
      if (idx !== -1) {
        assets[idx] = { ...assets[idx], name, category, value, date, notes };
        showToast('Aset berhasil diperbarui.', 'success');
      }
    } else {
      assets.push({ id: genId(), name, category, value, date, notes, createdAt: Date.now() });
      showToast('Aset berhasil ditambahkan!', 'success');
    }

    saveAssets();
    renderAll();
    closeModal();
  }

  function showFormError(msg) {
    $('#form-error').text(msg).removeClass('hidden');
  }

  // ──────────────────────────────────────
  // DELETE ASSET
  // ──────────────────────────────────────
  function deleteAsset(id) {
    assets = assets.filter(a => a.id !== id);
    saveAssets();
    renderAll();
    showToast('Aset dihapus.', 'info');
  }

  // ──────────────────────────────────────
  // EXPORT JSON
  // ──────────────────────────────────────
  function exportJson() {
    const data = JSON.stringify({ version: 1, exportedAt: new Date().toISOString(), assets }, null, 2);
    const blob = new Blob([data], { type: 'application/json' });
    const url  = URL.createObjectURL(blob);
    const ts   = new Date().toISOString().replace(/[:.]/g,'-').slice(0,19);
    const a    = document.createElement('a');
    a.href = url; a.download = `asetku-${ts}.json`; a.click();
    URL.revokeObjectURL(url);
    showToast('Data berhasil diekspor!', 'success');
  }

  // ──────────────────────────────────────
  // IMPORT JSON
  // ──────────────────────────────────────
  function importJson(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      try {
        const parsed = JSON.parse(e.target.result);
        const data = parsed.assets || parsed;
        if (!Array.isArray(data)) throw new Error('Format tidak valid.');
        assets = data;
        saveAssets();
        renderAll();
        showToast(`${assets.length} aset berhasil diimpor!`, 'success');
      } catch(err) {
        showToast('Gagal impor: ' + err.message, 'error');
      }
    };
    reader.readAsText(file);
  }

  // ──────────────────────────────────────
  // EVENT BINDINGS
  // ──────────────────────────────────────

  // Open/close modal
  $('#btn-open-modal').on('click', () => openModal(null));
  $('#btn-close-modal').on('click', closeModal);
  $('#modal-overlay').on('click', function(e) {
    if ($(e.target).is('#modal-overlay')) closeModal();
  });

  // Save asset
  $('#btn-save-asset').on('click', saveAsset);

  // Enter key in form
  $('#form-name, #form-value').on('keydown', function(e) {
    if (e.key === 'Enter') saveAsset();
  });

  // Export
  $('#btn-export').on('click', exportJson);

  // Import
  $('#import-input').on('change', function() {
    if (this.files && this.files[0]) { importJson(this.files[0]); this.value = ''; }
  });

  // Reset
  $('#btn-reset').on('click', () => {
    $('#confirm-overlay').css('display','flex');
  });
  $('#btn-cancel-reset').on('click', () => { $('#confirm-overlay').hide(); });
  $('#btn-confirm-reset').on('click', () => {
    assets = [];
    saveAssets();
    renderAll();
    $('#confirm-overlay').hide();
    showToast('Semua data telah direset.', 'info');
  });

  // Tabs
  $(document).on('click', '.tab-btn', function() {
    const tab = $(this).data('tab');
    $('.tab-btn').removeClass('active').addClass('text-brand-600').removeClass('text-surface-900');
    $(this).addClass('active').removeClass('text-brand-600');
    $('.tab-content').addClass('hidden');
    $(`#tab-${tab}`).removeClass('hidden');
  });

  // Filter buttons
  $(document).on('click', '.filter-btn', function() {
    activeFilter = $(this).data('filter');
    renderFilterBtns();
    renderAssetsTable();
  });

  // Edit button
  $(document).on('click', '.btn-edit', function() {
    const id = $(this).data('id');
    const asset = assets.find(a => a.id === id);
    if (asset) openModal(asset);
  });

  // Delete button
  $(document).on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    if (confirm('Hapus aset ini?')) deleteAsset(id);
  });

  // ──────────────────────────────────────
  // INIT
  // ──────────────────────────────────────
  renderAll();

  // Demo data if empty
  if (assets.length === 0) {
    const demo = [
      { id: genId(), name: 'Dompet',        category: 'Uang Tunai',     value: 350000,    date: new Date().toISOString().split('T')[0], notes: 'Uang harian', createdAt: Date.now() },
      { id: genId(), name: 'Tabungan BCA',  category: 'Rekening Bank',  value: 15000000,  date: new Date().toISOString().split('T')[0], notes: 'Rekening utama', createdAt: Date.now() },
      { id: genId(), name: 'GoPay',         category: 'Dompet Digital', value: 250000,    date: new Date().toISOString().split('T')[0], notes: '', createdAt: Date.now() },
      { id: genId(), name: 'OVO',           category: 'Dompet Digital', value: 180000,    date: new Date().toISOString().split('T')[0], notes: '', createdAt: Date.now() },
      { id: genId(), name: 'Saham BBCA',    category: 'Saham',          value: 5000000,   date: new Date().toISOString().split('T')[0], notes: '50 lot @ 8.900', createdAt: Date.now() },
      { id: genId(), name: 'Bitcoin',       category: 'Crypto',         value: 3500000,   date: new Date().toISOString().split('T')[0], notes: '0.005 BTC', createdAt: Date.now() },
    ];
    assets = demo;
    saveAssets();
    renderAll();
    showToast('Data contoh dimuat. Silakan edit sesuai kebutuhan!', 'info');
  }

});
</script>
</body>
</html>