<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>This Is Your Life — Kalkulator Usia</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="agecalc" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/theme.php'; ?>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Mono:wght@300;400;500&family=Noto+Serif:ital@0;1&display=swap" rel="stylesheet" />

  <style>
    :root {
      --ink: #0d0d0d;
      --paper: #f5f0e8;
      --cream: #ede8dc;
      --gold: #c8973a;
      --gold-light: #e8b95a;
      --rust: #9b3d2b;
      --olive: #4a5c3a;
      --muted: #7a6f60;
    }
    * { box-sizing: border-box; }
    body {
      background-color: var(--paper);
      color: var(--ink);
      font-family: 'DM Mono', monospace;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 0; opacity: 0.4;
    }
    .page-border { position: fixed; background: var(--gold); z-index: 1; opacity: 0.3; }
    .page-border.top    { top:12px;left:12px;right:12px;height:1px; }
    .page-border.bottom { bottom:12px;left:12px;right:12px;height:1px; }
    .page-border.left   { top:12px;bottom:12px;left:12px;width:1px; }
    .page-border.right  { top:12px;bottom:12px;right:12px;width:1px; }

    .main-wrap {
      position: relative; z-index: 2;
      max-width: 740px; margin: 0 auto; padding: 60px 24px 80px;
    }

    /* ── HEADER ── */
    .site-header { text-align: center; margin-bottom: 48px; }
    .eyebrow {
      font-size: 10px; font-weight: 500; letter-spacing: 0.25em;
      text-transform: uppercase; color: var(--gold); margin-bottom: 12px;
    }
    h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem,6vw,3.2rem); font-weight: 700; line-height: 1.1;
      color: var(--ink); margin: 0 0 10px;
    }
    h1 em { font-style: italic; color: var(--rust); }
    .tagline { font-size: 12px; letter-spacing: 0.1em; color: var(--muted); }

    /* ── ORNAMENT ── */
    .ornament { display:flex;align-items:center;gap:12px;margin:28px 0; }
    .ornament::before,.ornament::after {
      content:'';flex:1;height:1px;background:linear-gradient(to right,transparent,var(--gold));
    }
    .ornament::after { background:linear-gradient(to left,transparent,var(--gold)); }
    .ornament-icon { color:var(--gold);font-size:14px;flex-shrink:0; }

    /* ── INPUT CARD ── */
    .input-card {
      background:var(--cream);border:1px solid rgba(200,151,58,.3);
      border-radius:2px;padding:32px 36px;position:relative;margin-bottom:32px;
    }
    .input-card::before {
      content:'';position:absolute;top:4px;left:4px;right:4px;bottom:4px;
      border:1px solid rgba(200,151,58,.1);pointer-events:none;border-radius:2px;
    }
    label {
      display:block;font-size:10px;letter-spacing:.2em;text-transform:uppercase;
      color:var(--muted);margin-bottom:10px;
    }
    input[type="date"] {
      width:100%;background:var(--paper);border:1px solid rgba(200,151,58,.4);
      border-radius:2px;padding:14px 16px;font-family:'DM Mono',monospace;
      font-size:15px;color:var(--ink);outline:none;
      transition:border-color .2s,box-shadow .2s;-webkit-appearance:none;cursor:pointer;
    }
    input[type="date"]:focus { border-color:var(--gold);box-shadow:0 0 0 3px rgba(200,151,58,.12); }
    .today-note { font-size:10px;color:var(--muted);margin-top:8px;letter-spacing:.05em; }
    .today-note span { color:var(--gold); }
    .calc-btn {
      width:100%;margin-top:20px;background:var(--ink);color:var(--paper);
      border:none;border-radius:2px;padding:16px;font-family:'DM Mono',monospace;
      font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;
      cursor:pointer;position:relative;overflow:hidden;transition:background .2s;
    }
    .calc-btn::after {
      content:'';position:absolute;inset:0;background:var(--gold);
      transform:scaleX(0);transform-origin:left;transition:transform .3s ease;
    }
    .calc-btn:hover::after { transform:scaleX(1); }
    .calc-btn span { position:relative;z-index:1; }

    /* ── RESULT SECTION ── */
    #result-section { display:none; }
    @keyframes fadeUp {
      from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}
    }

    /* ── THIS IS YOUR LIFE BANNER ── */
    .life-banner {
      text-align:center;border:1px solid rgba(200,151,58,.5);
      border-radius:2px;padding:28px 32px;background:var(--cream);
      position:relative;margin-bottom:20px;
      animation:fadeUp .5s ease both;
    }
    .life-banner::before {
      content:'';position:absolute;top:5px;left:5px;right:5px;bottom:5px;
      border:1px solid rgba(200,151,58,.2);pointer-events:none;border-radius:2px;
    }
    .life-banner-title {
      font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;
      color:var(--ink);margin-bottom:16px;letter-spacing:.05em;
    }
    .life-banner-title span { color:var(--gold); }
    .life-dob {
      font-size:11px;letter-spacing:.2em;text-transform:uppercase;
      color:var(--muted);margin-bottom:18px;
    }
    .life-dob strong { color:var(--gold);font-weight:500; }

    .info-lines { text-align:left;max-width:520px;margin:0 auto; }
    .info-line {
      display:flex;gap:8px;font-size:12px;line-height:1.7;
      color:var(--ink);padding:3px 0;border-bottom:1px dashed rgba(200,151,58,.15);
    }
    .info-line:last-child { border-bottom:none; }
    .info-label { color:var(--muted);min-width:24px;flex-shrink:0;font-size:11px; }
    .info-value { color:var(--ink); }
    .info-value b { color:var(--rust);font-weight:500; }
    .info-value .hl { color:var(--gold); }

    /* ── SECTION TITLE ── */
    .section-title {
      font-family:'Playfair Display',serif;font-size:1rem;font-style:italic;
      color:var(--muted);text-align:center;margin-bottom:16px;font-weight:400;
    }

    /* ── STAT CARDS ── */
    .cards-grid {
      display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:12px;
    }
    .stat-card {
      background:var(--cream);border:1px solid rgba(200,151,58,.25);border-radius:2px;
      padding:18px 16px;position:relative;overflow:hidden;
      transition:transform .2s,box-shadow .2s;animation:fadeUp .6s ease both;
    }
    .stat-card:hover { transform:translateY(-2px);box-shadow:0 6px 24px rgba(0,0,0,.08); }
    .stat-card::before {
      content:'';position:absolute;top:0;left:0;width:24px;height:24px;
      border-top:2px solid var(--gold);border-left:2px solid var(--gold);opacity:.4;
    }
    .stat-card:nth-child(1){animation-delay:.05s}.stat-card:nth-child(2){animation-delay:.10s}
    .stat-card:nth-child(3){animation-delay:.15s}.stat-card:nth-child(4){animation-delay:.20s}
    .stat-card:nth-child(5){animation-delay:.25s}.stat-card:nth-child(6){animation-delay:.30s}

    .stat-unit { font-size:9px;letter-spacing:.25em;text-transform:uppercase;color:var(--muted);margin-bottom:4px; }
    .stat-value { font-family:'Playfair Display',serif;font-size:clamp(1.6rem,4vw,2.4rem);font-weight:700;color:var(--ink);line-height:1;margin-bottom:4px; }
    .stat-desc { font-size:10px;color:var(--muted);line-height:1.4; }

    .card-abad   .stat-value{color:var(--rust)}
    .card-dekade .stat-value{color:var(--olive)}
    .card-windu  .stat-value{color:#5a3e7a}
    .card-tahun  .stat-value{color:var(--gold)}
    .card-bulan  .stat-value{color:var(--rust)}
    .card-hari   .stat-value{color:var(--ink)}

    /* ── TOTAL BAR ── */
    .total-days-bar {
      background:var(--ink);color:var(--paper);border-radius:2px;padding:20px 24px;
      display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;
      animation:fadeUp .6s .35s ease both;
    }
    .total-days-bar .label { font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:rgba(245,240,232,.5); }
    .total-days-bar .value { font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--gold-light); }

    /* ── FUN ROW ── */
    .fun-row {
      display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:4px;
      animation:fadeUp .6s .4s ease both;
    }
    .fun-card {
      background:var(--cream);border:1px solid rgba(200,151,58,.2);border-radius:2px;
      padding:14px 16px;text-align:center;
    }
    .fun-card .fun-label { font-size:9px;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);margin-bottom:6px; }
    .fun-card .fun-value { font-family:'Playfair Display',serif;font-size:1rem;font-style:italic;color:var(--ink); }

    /* Thai color swatch */
    .color-dot {
      display:inline-block;width:10px;height:10px;border-radius:50%;
      margin-right:4px;vertical-align:middle;border:1px solid rgba(0,0,0,.1);
    }

    /* ── CALENDAR TABLE ── */
    .cal-wrap {
      animation:fadeUp .6s .45s ease both;
      border:1px solid rgba(200,151,58,.3);border-radius:2px;overflow:hidden;
    }
    .cal-table { width:100%;border-collapse:collapse;font-size:12px; }
    .cal-table th {
      background:var(--ink);color:var(--paper);padding:10px 16px;
      text-align:left;font-size:9px;letter-spacing:.2em;text-transform:uppercase;font-weight:500;
    }
    .cal-table th:last-child { text-align:right; }
    .cal-table .group-row td {
      background:rgba(200,151,58,.12);color:var(--gold);
      font-size:9px;letter-spacing:.18em;text-transform:uppercase;
      padding:6px 16px;font-weight:500;
    }
    .cal-table tr.data-row td {
      padding:9px 16px;border-bottom:1px solid rgba(200,151,58,.1);
      vertical-align:top;
    }
    .cal-table tr.data-row:nth-child(even) td { background:rgba(237,232,220,.5); }
    .cal-table tr.data-row:hover td { background:rgba(200,151,58,.07); }
    .cal-table .cal-name { color:var(--muted);min-width:180px; }
    .cal-table .cal-date { color:var(--ink);text-align:right;font-weight:400; }
    .cal-table .cal-date .em { color:var(--rust);font-style:italic; }

    /* ── FOOTER ── */
    .site-footer { text-align:center;margin-top:60px;font-size:10px;letter-spacing:.1em;color:var(--muted); }
    .site-footer a { color:var(--gold);text-decoration:none; }

    @media(max-width:520px){
      .cards-grid{grid-template-columns:1fr 1fr}
      .input-card{padding:24px 20px}
      .total-days-bar{flex-direction:column;gap:8px;text-align:center}
      .life-banner{padding:20px 16px}
      .info-line{flex-direction:column;gap:2px}
      .cal-table{font-size:11px}
      .cal-table .cal-name{min-width:120px}
    }

    /* ── DARK MODE (override CSS var) ── */
    html.dark {
      --paper: #14120e;
      --cream: #1e1b15;
      --ink:   #ece5d8;
      --muted: #a2977f;
    }
    html.dark body { background-color: var(--paper); }
    html.dark body::before { opacity: 0.22; }
  </style>
</head>
<body>

  <div class="page-border top"></div>
  <div class="page-border bottom"></div>
  <div class="page-border left"></div>
  <div class="page-border right"></div>

  <div class="main-wrap">

    <header class="site-header">
      <p class="eyebrow">⟡ Perhitungan Usia ⟡</p>
      <h1>This Is<br/><em>Your Life</em></h1>
      <p class="tagline">Abad · Dekade · Windu · Tahun · Bulan · Hari · Shio · Kalender Dunia</p>
    </header>

    <div class="ornament"><span class="ornament-icon">✦</span></div>

    <!-- INPUT CARD -->
    <div class="input-card">
      <label for="birthdate">Masukkan Tanggal Lahir</label>
      <input type="date" id="birthdate" max="" />
      <p class="today-note">Hari ini: <span id="today-display"></span></p>
      <button class="calc-btn" id="calcBtn"><span>Hitung Sekarang</span></button>
    </div>

    <!-- RESULT SECTION -->
    <div id="result-section">

      <!-- THIS IS YOUR LIFE BANNER -->
      <div class="life-banner">
        <p class="life-banner-title"><span>★</span> This is Your Life <span>★</span></p>
        <p class="life-dob">Tanggal lahir = <strong id="tiyldob">—</strong></p>
        <div class="info-lines">
          <div class="info-line"><span class="info-label">☉</span><span class="info-value" id="li-hari">—</span></div>
          <div class="info-line"><span class="info-label">🎨</span><span class="info-value" id="li-warna">—</span></div>
          <div class="info-line"><span class="info-label">⏳</span><span class="info-value" id="li-hidup">—</span></div>
          <div class="info-line"><span class="info-label">📅</span><span class="info-value" id="li-hari-total">—</span></div>
          <div class="info-line"><span class="info-label">🔖</span><span class="info-value" id="li-milestone">—</span></div>
          <div class="info-line"><span class="info-label">🎂</span><span class="info-value" id="li-ultah">—</span></div>
          <div class="info-line"><span class="info-label">🐾</span><span class="info-value" id="li-shio">—</span></div>
          <div class="info-line"><span class="info-label">🌟</span><span class="info-value" id="li-zodiak">—</span></div>
          <div class="info-line"><span class="info-label">🀄</span><span class="info-value" id="li-china">—</span></div>
        </div>
      </div>

      <div class="ornament"><span class="ornament-icon">◆</span></div>
      <p class="section-title">Perhitungan Usia dalam Berbagai Satuan Waktu</p>

      <!-- STAT CARDS -->
      <div class="cards-grid">
        <div class="stat-card card-abad">
          <p class="stat-unit">Abad</p>
          <p class="stat-value" id="val-abad">0</p>
          <p class="stat-desc">desimal · 1 abad = 100 thn<br/><span id="sisa-abad-txt"></span></p>
        </div>
        <div class="stat-card card-dekade">
          <p class="stat-unit">Dekade</p>
          <p class="stat-value" id="val-dekade">0</p>
          <p class="stat-desc">desimal · 1 dekade = 10 thn<br/><span id="sisa-dekade-txt"></span></p>
        </div>
        <div class="stat-card card-windu">
          <p class="stat-unit">Windu</p>
          <p class="stat-value" id="val-windu">0</p>
          <p class="stat-desc">desimal · 1 windu = 8 thn<br/><span id="sisa-windu-txt"></span></p>
        </div>
        <div class="stat-card card-tahun">
          <p class="stat-unit">Tahun</p>
          <p class="stat-value" id="val-tahun">0</p>
          <p class="stat-desc">desimal sejak lahir<br/><span id="sisa-tahun-txt"></span></p>
        </div>
        <div class="stat-card card-bulan">
          <p class="stat-unit">Total Bulan</p>
          <p class="stat-value" id="val-bulan">0</p>
          <p class="stat-desc">sejak tanggal lahir<br/>&nbsp;</p>
        </div>
        <div class="stat-card card-hari">
          <p class="stat-unit">Total Hari</p>
          <p class="stat-value" id="val-hari">0</p>
          <p class="stat-desc">sejak tanggal lahir<br/>&nbsp;</p>
        </div>
      </div>

      <div class="total-days-bar">
        <div>
          <p class="label">Tepat hingga hari ini</p>
          <p style="font-size:11px;color:rgba(245,240,232,.4);margin-top:2px;letter-spacing:.05em" id="exact-age-text"></p>
        </div>
        <div class="value" id="val-total-hari">0</div>
      </div>

      <div class="fun-row">
        <div class="fun-card">
          <p class="fun-label">Zodiak Barat</p>
          <p class="fun-value" id="val-zodiak">—</p>
        </div>
        <div class="fun-card">
          <p class="fun-label">Shio</p>
          <p class="fun-value" id="val-shio">—</p>
        </div>
        <div class="fun-card">
          <p class="fun-label">Lahir Hari</p>
          <p class="fun-value" id="val-hari-lahir">—</p>
        </div>
      </div>

      <div class="ornament"><span class="ornament-icon">◆</span></div>
      <p class="section-title">Tabel Penanggalan Dunia</p>

      <!-- CALENDAR TABLE -->
      <div class="cal-wrap">
        <table class="cal-table">
          <thead>
            <tr>
              <th>Kalender</th>
              <th>Tanggal Lahir</th>
            </tr>
          </thead>
          <tbody>
            <!-- BARAT & ASIA TENGGARA -->
            <tr class="group-row"><td colspan="2">⊞ Barat &amp; Asia Tenggara</td></tr>
            <tr class="data-row"><td class="cal-name">Gregorian (Masehi)</td><td class="cal-date" id="c-gregorian">—</td></tr>
            <tr class="data-row"><td class="cal-name">Julian (Romawi)</td><td class="cal-date" id="c-julian">—</td></tr>
            <tr class="data-row"><td class="cal-name">ISO (Minggu)</td><td class="cal-date" id="c-iso">—</td></tr>
            <tr class="data-row"><td class="cal-name">Thai Solar (Suriyakati)</td><td class="cal-date" id="c-thai">—</td></tr>

            <!-- TIMUR TENGAH -->
            <tr class="group-row"><td colspan="2">☽ Timur Tengah &amp; Islam</td></tr>
            <tr class="data-row"><td class="cal-name">Hijriah (Aritmatika)</td><td class="cal-date" id="c-hijri">—</td></tr>

            <!-- JAWA & BALI -->
            <tr class="group-row"><td colspan="2">⬡ Jawa</td></tr>
            <tr class="data-row"><td class="cal-name">Kalender Jawa (AJ)</td><td class="cal-date" id="c-jawa">—</td></tr>
            <tr class="data-row"><td class="cal-name">Pawukon (Wuku)</td><td class="cal-date" id="c-wuku">—</td></tr>
            <tr class="data-row"><td class="cal-name">Pasaran (Pancawara)</td><td class="cal-date" id="c-pasaran">—</td></tr>

            <!-- TIONGHOA -->
            <tr class="group-row"><td colspan="2">☯ Tionghoa</td></tr>
            <tr class="data-row"><td class="cal-name">Tionghoa (Siklus Sexagenary)</td><td class="cal-date" id="c-china">—</td></tr>
            <tr class="data-row"><td class="cal-name">Shio</td><td class="cal-date" id="c-shio">—</td></tr>
            <tr class="data-row"><td class="cal-name">Usia Tionghoa</td><td class="cal-date" id="c-china-age">—</td></tr>

            <!-- BENGALI -->
            <tr class="group-row"><td colspan="2">◈ Asia Selatan</td></tr>
            <tr class="data-row"><td class="cal-name">Bengali (Bongabdo)</td><td class="cal-date" id="c-bengali">—</td></tr>

            <!-- MAYA -->
            <tr class="group-row"><td colspan="2">⊕ Maya (Mesoamerika)</td></tr>
            <tr class="data-row"><td class="cal-name">Maya Long Count</td><td class="cal-date" id="c-mayan-lc">—</td></tr>
            <tr class="data-row"><td class="cal-name">Maya Tzolkin (Keagamaan)</td><td class="cal-date" id="c-mayan-tz">—</td></tr>
            <tr class="data-row"><td class="cal-name">Maya Haab (Sipil)</td><td class="cal-date" id="c-mayan-hb">—</td></tr>

            <!-- TIMUR LAUT AFRIKA -->
            <tr class="group-row"><td colspan="2">☥ Afrika Timur Laut</td></tr>
            <tr class="data-row"><td class="cal-name">Koptik (Anno Martyrum)</td><td class="cal-date" id="c-coptic">—</td></tr>
            <tr class="data-row"><td class="cal-name">Etiopia (Amete Alem)</td><td class="cal-date" id="c-ethiopia">—</td></tr>
          </tbody>
        </table>
      </div>

    </div><!-- /result-section -->

    <footer class="site-footer">
      <p>Dibuat dengan ♥ oleh <a href="https://rebornian48.my.id" target="_blank">Rebornian48</a></p>
    </footer>

  </div><!-- /main-wrap -->

  <script>
  $(function () {

    // ======== UTILITY ========
    const MONTH_ID  = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const MONTH_EN  = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const HARI_ID   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const pad       = n => String(n).padStart(2,'0');

    function formatDateID(date) {
      return `${date.getDate()} ${MONTH_ID[date.getMonth()]} ${date.getFullYear()}`;
    }
    function formatDateEN(d,m,y) {
      return `${d} ${MONTH_EN[m-1]} ${y}`;
    }
    function numFmt(n) { return n.toLocaleString('id-ID'); }

    // ======== JULIAN DAY NUMBER (from Gregorian) ========
    function toJDN(y, m, d) {
      const a = Math.floor((14 - m) / 12);
      const yr = y + 4800 - a;
      const mo = m + 12 * a - 3;
      return d + Math.floor((153 * mo + 2) / 5) + 365 * yr +
             Math.floor(yr / 4) - Math.floor(yr / 100) + Math.floor(yr / 400) - 32045;
    }

    // ======== JULIAN CALENDAR from JDN ========
    function jdnToJulianCal(jdn) {
      const a = jdn + 32082;
      const d4 = Math.floor((4 * a + 3) / 1461);
      const b  = a - Math.floor(1461 * d4 / 4);
      const m  = Math.floor((5 * b + 2) / 153);
      return {
        day:   b - Math.floor((153 * m + 2) / 5) + 1,
        month: m + 3 - 12 * Math.floor(m / 10),
        year:  d4 - 4800 + Math.floor(m / 10)
      };
    }

    // ======== ISLAMIC (Arithmetical) from JDN ========
    // Epoch: JDN 1948440 = 1 Muharram 1 AH (verified)
    function jdnToIslamic(jdn) {
      const EPOCH = 1948440;
      const N = jdn - EPOCH;
      const year = Math.floor((30 * N + 10646) / 10631);
      const yearStart = 354 * (year - 1) + Math.floor((11 * (year - 1) + 3) / 30);
      const doy = N - yearStart;
      const isLeap = ((11 * year + 14) % 30) < 11;
      const mLen = [30,29,30,29,30,29,30,29,30,29,30, isLeap ? 30 : 29];
      let mo = 0, d = doy;
      while (mo < 11 && d >= mLen[mo]) { d -= mLen[mo]; mo++; }
      return { year, month: mo + 1, day: d + 1 };
    }

    const HIJRI_MONTHS = ['Muharram','Safar',"Rabi' al-Awwal","Rabi' al-Akhir",
                          'Jumada al-Awwal','Jumada al-Akhir','Rajab',"Sha'ban",
                          'Ramadan','Shawwal',"Dhu al-Qi'dah",'Dhu al-Hijjah'];
    const JAWA_MONTHS  = ['Sura','Sapar','Mulud','Bakdamulud','Jumadilawal',
                          'Jumadilakir','Rejeb','Ruwah','Pasa','Sawal','Dulkaidah','Besar'];

    // ======== WUKU & PASARAN (verified Sep 27, 1994) ========
    const WUKU_NAMES = ['Sinta','Landep','Wukir','Kurantil','Tolu','Gumbreg',
                        'Warigalit','Warigagung','Julungwangi','Sungsang',
                        'Galungan','Kuningan','Langkir','Mandasiya','Julungpujut',
                        'Pahang','Kuruwelut','Marakeh','Tambir','Medangkungan',
                        'Maktal','Wuye','Manail','Prangbakat','Bala',
                        'Wugu','Wayang','Kelawu','Dukut','Watugunung'];
    const PASARAN    = ['Legi','Pahing','Pon','Wage','Kliwon'];

    function getWukuPasaran(jdn) {
      const pos  = ((jdn + 64) % 210 + 210) % 210;
      const pasIdx = ((jdn % 5) + 5) % 5;
      return { wuku: WUKU_NAMES[Math.floor(pos / 7)], pasaran: PASARAN[pasIdx] };
    }

    // ======== COPTIC from JDN (verified Sep 27,1994 = 17 Thout 1711 AM) ========
    function jdnToCoptic(jdn) {
      const EPOCH = 1825030; // JDN of 1 Thout 1 AM
      const n = jdn - EPOCH;
      const y4   = Math.floor(n / 1461);
      const rem  = n % 1461;
      const yInC = Math.min(Math.floor(rem / 365), 3);
      const year = 4 * y4 + yInC + 1;
      const yStart = 365 * (year - 1) + Math.floor((year - 1) / 4);
      const doy  = n - yStart;
      const MONTHS = ['Thout','Paopi','Hathor','Koiak','Tobi','Mekhir',
                      'Paremhat','Paremoude','Pakhon','Paoni','Epip','Mesori','Nasie'];
      const mo = Math.min(12, Math.floor(doy / 30));
      return { year, monthName: MONTHS[mo], day: doy - mo * 30 + 1 };
    }

    // ======== ETHIOPIAN from JDN (Coptic + 276 years) ========
    function jdnToEthiopian(jdn) {
      const cop = jdnToCoptic(jdn);
      const ETH_MONTHS = ['Maskaram','Tikimt','Hidar','Tahsas','Tir','Yekatit',
                          'Megabit','Miyaziya','Ginbot','Sene','Hamle','Nehase','Pagume'];
      const copIdx = ['Thout','Paopi','Hathor','Koiak','Tobi','Mekhir',
                      'Paremhat','Paremoude','Pakhon','Paoni','Epip','Mesori','Nasie'].indexOf(cop.monthName);
      return { year: cop.year + 276, monthName: ETH_MONTHS[copIdx] || 'Pagume', day: cop.day };
    }

    // ======== MAYAN (GMT correlation 584283) ========
    function jdnToMayanLC(jdn) {
      const d = jdn - 584283;
      return {
        baktun: Math.floor(d / 144000),
        katun:  Math.floor((d % 144000) / 7200),
        tun:    Math.floor((d % 7200) / 360),
        uinal:  Math.floor((d % 360) / 20),
        kin:    d % 20
      };
    }
    function jdnToTzolkin(jdn) {
      const diff = jdn - 584283;
      const TZ = ['Imix','Ik','Akbal','Kan','Chicchan','Cimi','Manik','Lamat',
                  'Muluk','Ok','Chuen','Eb','Ben','Ix','Men','Kib','Kaban',
                  'Etznab','Kawak','Ahau'];
      const num = ((diff + 3) % 13 + 13) % 13 + 1;
      const idx = ((diff + 19) % 20 + 20) % 20;
      return `${num} ${TZ[idx]}`;
    }
    function jdnToHaab(jdn) {
      const diff = jdn - 584283;
      const HM = ['Pop','Uo','Zip','Zotz','Tzec','Xul','Yaxkin','Mol','Chen',
                  'Yax','Zac','Ceh','Mac','Kankin','Muan','Pax','Kayab','Cumku','Uayeb'];
      const REF = 17 * 20 + 8;
      const pos = ((REF + diff) % 365 + 365) % 365;
      const mi  = Math.floor(pos / 20);
      return `${pos % 20} ${HM[Math.min(mi, 18)]}`;
    }

    // ======== BENGALI (verified: Sep 27, 1994 = Ashwin 12, 1401 BS) ========
    function toBengali(jdn, gy, gm) {
      const BENG_M = ['Boishakh','Jaistha','Ashar','Srabon','Bhadro','Ashwin',
                       'Kartik','Ogrohayon','Poush','Magh','Falgun','Chaitra'];
      // Bengali year starts ~Apr 14
      const refYear = (gm > 4 || (gm === 4)) ? gy : gy - 1;
      const boiJDN  = toJDN(refYear, 4, 14);
      let diff = jdn - boiJDN;
      let bengYear;
      if (diff < 0) {
        bengYear = refYear - 1 - 593;
        diff += 365;
      } else {
        bengYear = refYear - 593;
      }
      const mLen = [31,31,31,31,31,30,30,30,30,30,30,30];
      let mo = 0, d = diff;
      while (mo < 11 && d >= mLen[mo]) { d -= mLen[mo]; mo++; }
      return { year: bengYear, monthName: BENG_M[mo], day: d + 1 };
    }

    // ======== CHINESE YEAR ========
    function getChineseYear(year) {
      const STEMS   = ['Jiǎ','Yǐ','Bǐng','Dīng','Wù','Jǐ','Gēng','Xīn','Rén','Guǐ'];
      const BRANCH  = ['Zǐ','Chǒu','Yín','Mǎo','Chén','Sì','Wǔ','Wèi','Shēn','Yǒu','Xū','Hài'];
      const sIdx    = (year + 2636) % 10;
      const bIdx    = (year + 2636) % 12;
      const yInCyc  = (year + 2636) % 60 + 1;
      const cycle   = Math.ceil((year + 2637) / 60);
      return { stem: STEMS[sIdx], branch: BRANCH[bIdx], yearInCycle: yInCyc, cycle };
    }

    // ======== ISO WEEK ========
    function getISOWeek(date) {
      const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
      const day = d.getUTCDay() || 7;
      d.setUTCDate(d.getUTCDate() + 4 - day);
      const y1 = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
      return {
        week: Math.ceil((((d - y1) / 86400000) + 1) / 7),
        year: d.getUTCFullYear()
      };
    }

    // ======== ZODIAK ========
    function getZodiak(d, m) {
      if((m===3&&d>=21)||(m===4&&d<=19)) return 'Aries ♈';
      if((m===4&&d>=20)||(m===5&&d<=20)) return 'Taurus ♉';
      if((m===5&&d>=21)||(m===6&&d<=20)) return 'Gemini ♊';
      if((m===6&&d>=21)||(m===7&&d<=22)) return 'Cancer ♋';
      if((m===7&&d>=23)||(m===8&&d<=22)) return 'Leo ♌';
      if((m===8&&d>=23)||(m===9&&d<=22)) return 'Virgo ♍';
      if((m===9&&d>=23)||(m===10&&d<=22)) return 'Libra ♎';
      if((m===10&&d>=23)||(m===11&&d<=21)) return 'Scorpio ♏';
      if((m===11&&d>=22)||(m===12&&d<=21)) return 'Sagitarius ♐';
      if((m===12&&d>=22)||(m===1&&d<=19)) return 'Capricorn ♑';
      if((m===1&&d>=20)||(m===2&&d<=18)) return 'Aquarius ♒';
      return 'Pisces ♓';
    }

    // ======== SHIO ========
    function getShio(year) {
      const LIST = ['🐀 Tikus','🐂 Kerbau','🐯 Macan','🐇 Kelinci',
                    '🐉 Naga','🐍 Ular','🐴 Kuda','🐑 Kambing',
                    '🐒 Monyet','🐓 Ayam','🐕 Anjing','🐖 Babi'];
      return LIST[((year - 1900) % 12 + 12) % 12];
    }

    // ======== THAI BIRTHDAY COLOR ========
    function getThaiColor(dow) {
      const COLORS = [
        { name:'Merah',        hex:'#e03030' },
        { name:'Kuning',       hex:'#f0c020' },
        { name:'Merah Muda',   hex:'#e87090' },
        { name:'Hijau',        hex:'#2e8b57' },
        { name:'Oranye',       hex:'#e07820' },
        { name:'Biru Muda',    hex:'#4080c8' },
        { name:'Ungu',         hex:'#7040a0' },
      ];
      return COLORS[dow];
    }

    // ======== FORMAT JDN DAY OF WEEK ========
    function jdnDayName(jdn) {
      return HARI_ID[(jdn + 1) % 7];
    }

    // ==========================================
    //  INIT
    // ==========================================
    const today = new Date();
    const todayStr = `${today.getFullYear()}-${pad(today.getMonth()+1)}-${pad(today.getDate())}`;
    $('#birthdate').attr('max', todayStr);
    $('#today-display').text(formatDateID(today));

    $('#calcBtn').on('click', calculate);
    $('#birthdate').on('keydown', e => { if(e.key==='Enter') calculate(); });

    function addDays(date, days) {
      const d = new Date(date.getTime());
      d.setDate(d.getDate() + days);
      return d;
    }

    function calculate() {
      const val = $('#birthdate').val();
      if (!val) {
        $('#birthdate').css('border-color','var(--rust)');
        setTimeout(() => $('#birthdate').css('border-color',''), 800);
        return;
      }

      const birth = new Date(val + 'T00:00:00');
      const now = new Date();
      now.setHours(0,0,0,0);

      if (birth > now) { alert('Tanggal lahir tidak boleh di masa depan!'); return; }

      // ── Basic diff ──
      let yrs = now.getFullYear() - birth.getFullYear();
      let mos = now.getMonth() - birth.getMonth();
      let dys = now.getDate() - birth.getDate();
      if (dys < 0) { mos--; const pm = new Date(now.getFullYear(), now.getMonth(), 0); dys += pm.getDate(); }
      if (mos < 0) { yrs--; mos += 12; }

      const totalDays   = Math.floor((now - birth) / 86400000);
      const totalMonths = yrs * 12 + mos;

      // ── Decimals ──
      const DPY = 365.25;
      const decYears  = totalDays / DPY;
      const decAbad   = totalDays / (100 * DPY);
      const decDekade = totalDays / (10  * DPY);
      const decWindu  = totalDays / (8   * DPY);

      const abadInt   = Math.floor(decAbad);
      const dekadeInt = Math.floor(decDekade);
      const winduInt  = Math.floor(decWindu);

      // ── Birth info ──
      const bd = birth.getDate(), bm = birth.getMonth()+1, by = birth.getFullYear();
      const birthJDN  = toJDN(by, bm, bd);
      const birthDOW  = birth.getDay();   // 0=Sun
      const zodiak    = getZodiak(bd, bm);
      const shio      = getShio(by);
      const thaiColor = getThaiColor(birthDOW);
      const hariLahir = HARI_ID[birthDOW];

      // ── Next birthday ──
      let nextBday = new Date(now.getFullYear(), birth.getMonth(), birth.getDate());
      if (nextBday <= now) nextBday = new Date(now.getFullYear()+1, birth.getMonth(), birth.getDate());
      const nextAge     = nextBday.getFullYear() - by;
      const nextBdayDay = HARI_ID[nextBday.getDay()];

      // ── Next 5000-day milestone ──
      const nextMile = Math.ceil(totalDays / 5000) * 5000;
      const mileDate = addDays(now, nextMile - totalDays);

      // ── Chinese year ──
      const chinese = getChineseYear(by);
      const chineseAge = now.getFullYear() - by + 1;

      // ── ISO Week ──
      const iso = getISOWeek(birth);

      // ── Calendar conversions ──
      const hijri = jdnToIslamic(birthJDN);
      const jawa  = { year: hijri.year + 512, month: hijri.month, day: hijri.day };
      const wp    = getWukuPasaran(birthJDN);
      const julianCal = jdnToJulianCal(birthJDN);
      const coptic  = jdnToCoptic(birthJDN);
      const ethiop  = jdnToEthiopian(birthJDN);
      const mayanLC = jdnToMayanLC(birthJDN);
      const mayanTz = jdnToTzolkin(birthJDN);
      const mayanHb = jdnToHaab(birthJDN);
      const bengali = toBengali(birthJDN, by, bm);

      // ==================== RENDER ====================

      // This Is Your Life block
      $('#tiyldob').text(formatDateID(birth));
      $('#li-hari').html(`Kamu lahir pada hari <b>${hariLahir}</b>.`);
      $('#li-warna').html(`Warna hari ulang tahun Thai kamu adalah <b><span class="color-dot" style="background:${thaiColor.hex}"></span>${thaiColor.name}</b>.`);
      $('#li-hidup').html(`Kamu telah hidup selama <b>${yrs} tahun ${mos} bulan ${dys} hari</b>.`);
      $('#li-hari-total').html(`Kamu telah hidup selama <b>${numFmt(totalDays)} hari</b>.`);
      $('#li-milestone').html(`Kamu akan mencapai <b class="hl">${numFmt(nextMile)} hari</b> pada <b>${formatDateID(mileDate)}</b>.`);
      $('#li-ultah').html(`Ulang tahunmu berikutnya jatuh pada hari <b>${nextBdayDay}</b>. Kamu akan berusia <b>${nextAge} tahun</b>.`);
      $('#li-shio').html(`Kamu lahir pada <b>${shio}</b> dalam penanggalan Tionghoa.`);
      $('#li-zodiak').html(`Kamu lahir di bawah tanda Zodiak <b>${zodiak}</b>.`);
      $('#li-china').html(`Tahun Tionghoa: <b>${chinese.stem}-${chinese.branch}</b> (tahun ke-${chinese.yearInCycle}, siklus ke-${chinese.cycle}). Usia Tionghoa: <b>${chineseAge}</b>.`);

      // Stat cards
      $('#val-abad').text(decAbad.toFixed(4));
      $('#sisa-abad-txt').text(`${abadInt} abad + ${yrs - abadInt*100} thn`);
      $('#val-dekade').text(decDekade.toFixed(3));
      $('#sisa-dekade-txt').text(`${dekadeInt} dekade + ${yrs - dekadeInt*10} thn`);
      $('#val-windu').text(decWindu.toFixed(3));
      $('#sisa-windu-txt').text(`${winduInt} windu + ${yrs - winduInt*8} thn`);
      $('#val-tahun').text(decYears.toFixed(2));
      $('#sisa-tahun-txt').text(`${yrs} thn ${mos} bln ${dys} hr`);
      $('#val-bulan').text(numFmt(totalMonths));
      $('#val-hari').text(numFmt(totalDays));
      $('#val-total-hari').text(numFmt(totalDays) + ' hari');
      $('#exact-age-text').text(`${yrs} tahun, ${mos} bulan, ${dys} hari`);

      // Fun row
      $('#val-zodiak').text(zodiak);
      $('#val-shio').text(shio);
      $('#val-hari-lahir').text(hariLahir);

      // ── CALENDAR TABLE ──
      const julDow = jdnDayName(birthJDN);
      $('#c-gregorian').html(`${hariLahir}, ${formatDateEN(bd,bm,by)}`);
      $('#c-julian').html(`${julDow}, ${formatDateEN(julianCal.day, julianCal.month, julianCal.year)} C.E.`);
      $('#c-iso').html(`${hariLahir}, Minggu ke-<span class="em">${iso.week}</span>, ${iso.year}`);
      $('#c-thai').html(`${hariLahir}, ${formatDateEN(bd,bm,by + 543)} B.E.`);

      // Hijri
      $('#c-hijri').html(`${julDow}, ${hijri.day} ${HIJRI_MONTHS[hijri.month-1]} ${hijri.year} H`);

      // Jawa
      $('#c-jawa').html(`${hijri.day} ${JAWA_MONTHS[jawa.month-1]} <span class="em">${jawa.year} AJ</span>`);
      $('#c-wuku').html(`Wuku <span class="em">${wp.wuku}</span>`);
      $('#c-pasaran').html(`<span class="em">${hariLahir} ${wp.pasaran}</span>`);

      // Chinese
      $('#c-china').html(`Tahun ke-${chinese.yearInCycle} <span class="em">(${chinese.stem}-${chinese.branch})</span>, Siklus ke-${chinese.cycle}`);
      $('#c-shio').html(`<span class="em">${shio}</span>`);
      $('#c-china-age').html(`<span class="em">${chineseAge}</span> tahun`);

      // Bengali
      $('#c-bengali').html(`${bengali.day} <span class="em">${bengali.monthName}</span> ${bengali.year} B.S.`);

      // Mayan
      $('#c-mayan-lc').html(`<span class="em">${mayanLC.baktun}.${mayanLC.katun}.${mayanLC.tun}.${mayanLC.uinal}.${mayanLC.kin}</span>`);
      $('#c-mayan-tz').html(`<span class="em">${mayanTz}</span>`);
      $('#c-mayan-hb').html(`<span class="em">${mayanHb}</span>`);

      // Coptic & Ethiopian
      $('#c-coptic').html(`${julDow}, ${coptic.day} <span class="em">${coptic.monthName}</span> ${coptic.year} A.M.`);
      $('#c-ethiopia').html(`${ethiop.day} <span class="em">${ethiop.monthName}</span> ${ethiop.year} E.E.`);

      // Show results
      $('#result-section').hide().css('display','block');
      $('html,body').animate({ scrollTop: $('#result-section').offset().top - 20 }, 500);
    }

  });
  </script>
</body>
</html>