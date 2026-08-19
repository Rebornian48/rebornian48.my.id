<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Waktu Shalat & Progres Tahun</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="islamic·shalat" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Amiri:ital,wght@0,400;0,700;1,400&family=DM+Mono:wght@300;400;500&family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --gold: #C9A84C; --gold-light: #E8C97A; --gold-pale: #F5E6B8;
      --navy: #0A0E1A; --navy-mid: #111827; --navy-light: #1a2236;
      --teal: #2DD4BF; --cream: #FFF8E7; --red: #e05c5c;
      --accent: #00e5a0; --accent2: #00aaff;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { background-color: var(--navy); color: var(--cream); font-family: 'Lora', serif; min-height: 100vh; overflow-x: hidden; }

    /* ── GEO BG ── */
    .geo-bg { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
    .glow-circle { border-radius: 50%; background: radial-gradient(circle, rgba(201,168,76,.07) 0%, transparent 70%); pointer-events: none; }
    .ornament-line { height: 2px; background: linear-gradient(90deg, transparent, var(--gold), var(--gold-light), var(--gold), transparent); }
    .ornament-line-thin { height: 1px; background: linear-gradient(90deg, transparent, rgba(201,168,76,.5), rgba(201,168,76,.8), rgba(201,168,76,.5), transparent); }

    /* ── GLASS CARD ── */
    .glass-card {
      background: linear-gradient(135deg, rgba(26,34,54,.92) 0%, rgba(17,24,39,.95) 100%);
      border: 1px solid rgba(201,168,76,.25); backdrop-filter: blur(12px); position: relative; overflow: hidden;
    }
    .glass-card::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse at top left, rgba(201,168,76,.05) 0%, transparent 60%); pointer-events:none; }

    /* ── CORNER ORNAMENTS ── */
    .corner-ornament { width:22px; height:22px; position:absolute; }
    .corner-tl { top:8px; left:8px; border-top:2px solid rgba(201,168,76,.55); border-left:2px solid rgba(201,168,76,.55); }
    .corner-tr { top:8px; right:8px; border-top:2px solid rgba(201,168,76,.55); border-right:2px solid rgba(201,168,76,.55); }
    .corner-bl { bottom:8px; left:8px; border-bottom:2px solid rgba(201,168,76,.55); border-left:2px solid rgba(201,168,76,.55); }
    .corner-br { bottom:8px; right:8px; border-bottom:2px solid rgba(201,168,76,.55); border-right:2px solid rgba(201,168,76,.55); }

    /* ── ANALOG CLOCK ── */
    .analog-wrap { position:relative; width:210px; height:210px; margin:0 auto; }
    .clock-face {
      width:100%; height:100%; border-radius:50%;
      background: radial-gradient(circle at 35% 30%, #1c1c2a, #080810);
      border: 2px solid rgba(201,168,76,.3);
      box-shadow: 0 0 0 5px #0e0e18, 0 0 0 7px rgba(201,168,76,.15), 0 18px 48px rgba(0,0,0,.75), inset 0 0 30px rgba(0,0,0,.65);
      position:relative; overflow:hidden;
    }
    .tick { position:absolute; top:50%; left:50%; width:2px; transform-origin:0 0; }
    .tick-major { height:13px; background:rgba(201,168,76,.5); margin-top:-6.5px; }
    .tick-minor { height:7px; background:rgba(255,255,255,.1); margin-top:-3.5px; width:1px; }
    .num { position:absolute; font-family:'DM Mono',monospace; font-size:.6rem; font-weight:500; color:rgba(201,168,76,.7); transform:translate(-50%,-50%); user-select:none; }
    .hand { position:absolute; bottom:50%; left:50%; transform-origin:bottom center; border-radius:4px 4px 2px 2px; }
    .hour-hand   { width:5px; height:56px; margin-left:-2.5px; background:linear-gradient(to top, var(--gold), #e8d4a8); box-shadow:0 0 10px rgba(200,169,110,.5); }
    .minute-hand { width:3px; height:80px; margin-left:-1.5px; background:linear-gradient(to top, var(--cream), #fff); box-shadow:0 0 5px rgba(255,255,255,.25); }
    .second-hand { width:1.5px; height:88px; margin-left:-.75px; background:var(--red); border-radius:2px; box-shadow:0 0 7px rgba(224,92,92,.75); }
    .second-tail { position:absolute; bottom:calc(50% - 26px); left:50%; width:1.5px; height:24px; margin-left:-.75px; background:var(--red); transform-origin:top center; border-radius:2px; }
    .center-dot { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:10px; height:10px; border-radius:50%; background:var(--gold); box-shadow:0 0 10px var(--gold); z-index:20; }

    /* ── DIGITAL CLOCK ── */
    #clock-display {
      font-family:'Cinzel',serif; font-weight:900; letter-spacing:.05em;
      text-shadow:0 0 40px rgba(201,168,76,.6), 0 0 80px rgba(201,168,76,.2);
      background:linear-gradient(180deg,#F5E6B8 0%,#C9A84C 50%,#A07830 100%);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; line-height:1;
    }
    .digital-display {
      position:relative; background:rgba(4,4,10,.75);
      border:1px solid rgba(201,168,76,.2); border-radius:14px;
      padding:1.2rem 1.6rem 1rem; text-align:center; overflow:hidden;
    }
    .digital-display::after { content:''; position:absolute; inset:0; background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(255,255,255,.011) 2px,rgba(255,255,255,.011) 4px); pointer-events:none; }
    .tz-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(201,168,76,.1); border:1px solid rgba(201,168,76,.25); border-radius:999px; padding:3px 12px; font-size:.68rem; color:var(--gold-light); font-family:'DM Mono',monospace; letter-spacing:.06em; }

    /* ── SEARCH ── */
    .search-wrap { position:relative; }
    .search-input { background:rgba(26,34,54,.95); border:1px solid rgba(201,168,76,.3); color:var(--cream); font-family:'Lora',serif; transition:all .3s ease; width:100%; }
    .search-input:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.1); }
    .search-input::placeholder { color:rgba(245,230,184,.35); }
    .search-hint { font-size:.68rem; color:rgba(245,230,184,.35); font-family:'DM Mono',monospace; margin-top:5px; letter-spacing:.03em; }

    #city-dropdown {
      position:absolute; left:0; right:0; top:100%; margin-top:4px; z-index:50;
      background:#111827; border:1px solid rgba(201,168,76,.3);
      box-shadow:0 24px 64px rgba(0,0,0,.85); border-radius:12px;
      max-height:300px; overflow-y:auto;
      scrollbar-width:thin; scrollbar-color:var(--gold) transparent;
    }
    .dropdown-item { padding:10px 16px; cursor:pointer; border-bottom:1px solid rgba(201,168,76,.07); transition:background .12s; }
    .dropdown-item:last-child { border-bottom:none; }
    .dropdown-item:hover, .dropdown-item.kbd-focus { background:rgba(201,168,76,.1); }
    .d-city { color:var(--gold-pale); font-size:.85rem; font-weight:500; }
    .d-meta { color:rgba(245,230,184,.42); font-size:.7rem; font-family:'DM Mono',monospace; margin-top:2px; }
    .d-tz { color:var(--teal); }
    .d-count { color:rgba(245,230,184,.28); font-size:.62rem; font-family:'DM Mono',monospace; text-align:right; padding:6px 16px 8px; border-top:1px solid rgba(201,168,76,.08); }

    /* ── PRAYER ── */
    .prayer-card { transition:all .3s ease; border:1px solid rgba(201,168,76,.15); background:linear-gradient(135deg,rgba(26,34,54,.8) 0%,rgba(17,24,39,.9) 100%); position:relative; overflow:hidden; }
    .prayer-card::after { content:''; position:absolute; bottom:0; left:0; right:0; height:2px; background:linear-gradient(90deg,transparent,var(--gold),transparent); transform:scaleX(0); transition:transform .3s ease; }
    .prayer-card:hover::after, .prayer-card.active-prayer::after { transform:scaleX(1); }
    .prayer-card:hover { border-color:rgba(201,168,76,.45); transform:translateY(-2px); box-shadow:0 8px 32px rgba(201,168,76,.12); }
    .prayer-card.active-prayer { border-color:rgba(201,168,76,.6); background:linear-gradient(135deg,rgba(201,168,76,.12) 0%,rgba(26,34,54,.95) 100%); box-shadow:0 0 28px rgba(201,168,76,.14), inset 0 1px 0 rgba(201,168,76,.2); }

    .method-select { background:rgba(26,34,54,.9); border:1px solid rgba(201,168,76,.3); color:var(--cream); font-family:'Lora',serif; }
    .method-select:focus { outline:none; border-color:var(--gold); }
    .method-select option { background:var(--navy-mid); }

    .arabic-text { font-family:'Amiri',serif; direction:rtl; }
    .hijri-badge { background:linear-gradient(135deg,rgba(201,168,76,.14),rgba(201,168,76,.04)); border:1px solid rgba(201,168,76,.28); }
    .pulse-dot { width:8px; height:8px; background:var(--teal); border-radius:50%; animation:pulse-dot 2s infinite; }
    .spinner { width:36px; height:36px; border:3px solid rgba(201,168,76,.18); border-top-color:var(--gold); border-radius:50%; animation:spin .8s linear infinite; }
    #countdown-bar { height:3px; background:linear-gradient(90deg,var(--gold),var(--teal)); border-radius:9999px; }

    /* ── NAV TABS ── */
    .nav-tab {
      font-family:'Cinzel',serif; font-size:.72rem; font-weight:700; letter-spacing:.1em;
      padding:.65rem 1.5rem; border-radius:10px; cursor:pointer; transition:all .25s ease;
      border:1px solid rgba(201,168,76,.2); color:rgba(245,230,184,.45); background:transparent;
      text-transform:uppercase;
    }
    .nav-tab.active {
      background:linear-gradient(135deg,rgba(201,168,76,.18),rgba(201,168,76,.06));
      border-color:rgba(201,168,76,.55); color:var(--gold-light);
      box-shadow:0 0 20px rgba(201,168,76,.1);
    }
    .nav-tab:not(.active):hover { border-color:rgba(201,168,76,.35); color:rgba(245,230,184,.7); }

    /* ── YEAR PROGRESS SECTION ── */
    .yp-big {
      font-family:'Space Mono',monospace; font-weight:700; line-height:1; text-align:center;
      background:linear-gradient(135deg, var(--gold) 30%, var(--teal));
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
      transition:all .4s ease;
    }
    .bar-track { width:100%; height:10px; background:rgba(26,34,54,.9); border-radius:99px; border:1px solid rgba(201,168,76,.15); overflow:hidden; }
    .bar-fill { height:100%; width:0%; border-radius:99px; background:linear-gradient(90deg,var(--gold),var(--teal)); box-shadow:0 0 16px rgba(201,168,76,.35); transition:width .9s cubic-bezier(.25,1,.5,1); position:relative; }
    .bar-fill::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg,transparent 60%,rgba(255,255,255,.2)); border-radius:99px; }
    .stat-card { background:linear-gradient(135deg,rgba(26,34,54,.8),rgba(17,24,39,.9)); border:1px solid rgba(201,168,76,.15); border-radius:16px; padding:1.4rem 1.2rem; text-align:center; transition:all .2s ease; }
    .stat-card:hover { border-color:rgba(201,168,76,.4); transform:translateY(-3px); box-shadow:0 8px 32px rgba(201,168,76,.1); }
    .stat-card dt { font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(245,230,184,.4); margin-bottom:.6rem; font-family:'DM Mono',monospace; }
    .stat-card dd { font-family:'Space Mono',monospace; font-size:1.9rem; font-weight:700; line-height:1; }
    .stat-card dd .unit { font-size:.78rem; opacity:.6; margin-left:2px; font-family:'Lora',serif; }
    .stat-gold dd { color:var(--gold-light); }
    .stat-teal dd { color:var(--teal); }
    .stat-orange dd { color:#f97316; }
    .stat-rose  dd { color:#fb7185; }

    /* ── SECTION PANEL ── */
    .section-panel { display:none; }
    .section-panel.active { display:block; }

    /* ── ANIMATIONS ── */
    @keyframes spin { to{transform:rotate(360deg)} }
    @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.8)} }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }
    @keyframes fadeInUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
    .fi { animation:fadeInUp .55s ease forwards; }
    .fi-1 { animation-delay:.08s; opacity:0; }
    .fi-2 { animation-delay:.16s; opacity:0; }
    .fi-3 { animation-delay:.24s; opacity:0; }
    @keyframes slideIn { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    .slide-in { animation:slideIn .4s ease forwards; }

    #toast { transition:all .4s cubic-bezier(.175,.885,.32,1.275); transform:translateY(80px); opacity:0; }
    #toast.show { transform:translateY(0); opacity:1; }
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:rgba(201,168,76,.3); border-radius:3px; }
    @media(max-width:640px) {
      #clock-display{font-size:2.8rem!important}
      .analog-wrap{width:170px;height:170px}
      .yp-big{font-size:4rem!important}
      .stat-card dd{font-size:1.4rem}
    }

    /* eyebrow line */
    .eyebrow-line {
      display:flex; align-items:center; justify-content:center; gap:.75rem;
      font-family:'Space Mono',monospace; font-size:.65rem; letter-spacing:.2em; text-transform:uppercase; color:var(--teal); margin-bottom:.5rem;
    }
    .eyebrow-line::before,.eyebrow-line::after { content:''; display:block; width:36px; height:1px; background:var(--teal); opacity:.5; }
  </style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>

<!-- GEO BG -->
<div class="geo-bg">
  <svg width="100%" height="100%" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" opacity="0.03">
    <defs><pattern id="p" x="0" y="0" width="120" height="120" patternUnits="userSpaceOnUse">
      <polygon points="60,5 69,42 105,42 76,64 87,100 60,80 33,100 44,64 15,42 51,42" fill="none" stroke="#C9A84C" stroke-width="1"/>
    </pattern></defs>
    <rect width="100%" height="100%" fill="url(#p)"/>
  </svg>
  <div class="glow-circle" style="width:600px;height:600px;position:absolute;top:-200px;right:-80px;"></div>
  <div class="glow-circle" style="width:380px;height:380px;position:absolute;bottom:-80px;left:-80px;"></div>
  <div style="position:absolute;width:700px;height:700px;border-radius:50%;background:radial-gradient(circle,rgba(0,229,160,.04) 0%,transparent 70%);top:-180px;left:50%;transform:translateX(-50%);"></div>
</div>

<!-- TOAST -->
<div id="toast" class="fixed bottom-6 left-1/2 z-50 px-6 py-2.5 rounded-xl text-sm font-semibold" style="transform:translateX(-50%);min-width:170px;text-align:center;"></div>

<div class="relative z-10 min-h-screen py-6 px-4">
<div class="max-w-5xl mx-auto">

  <!-- ════════════════ HEADER ════════════════ -->
  <header class="text-center mb-6 fi">
    <div class="eyebrow-line mb-3">Rebornian48</div>
    <h1 style="font-family:'Cinzel',serif;font-size:clamp(1.6rem,5vw,2.6rem);font-weight:900;letter-spacing:.04em;line-height:1.1;background:linear-gradient(180deg,#F5E6B8 0%,#C9A84C 50%,#A07830 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
      Waktu Shalat & Progres Tahun
    </h1>
    <p style="font-size:.75rem;color:rgba(245,230,184,.35);font-family:'DM Mono',monospace;letter-spacing:.08em;margin-top:.4rem;">
      JADWAL IMSAKIYAH · JAM DUNIA · PROGRES TAHUN
    </p>
  </header>

  <!-- ════════════════ NAV TABS ════════════════ -->
  <div class="flex items-center justify-center gap-3 mb-6 fi fi-1">
    <button class="nav-tab active" data-tab="shalat">🕌 Waktu Shalat</button>
    <button class="nav-tab" data-tab="progress">📅 Progres Tahun</button>
  </div>

  <!-- ════════════════════════════════════════
       TAB 1 — WAKTU SHALAT
  ════════════════════════════════════════ -->
  <div id="tab-shalat" class="section-panel active">

    <!-- CLOCK CARD -->
    <div class="glass-card rounded-2xl p-5 mb-5 fi fi-1">
      <div class="corner-ornament corner-tl"></div><div class="corner-ornament corner-tr"></div>
      <div class="corner-ornament corner-bl"></div><div class="corner-ornament corner-br"></div>
      <div class="flex flex-col lg:flex-row items-center gap-6">
        <!-- Analog -->
        <div class="flex flex-col items-center gap-3 flex-shrink-0">
          <p style="font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(245,230,184,.35);">JAM ANALOG</p>
          <div class="analog-wrap">
            <div class="clock-face" id="clock-face">
              <div class="hand hour-hand"   id="hour-hand"></div>
              <div class="hand minute-hand" id="minute-hand"></div>
              <div class="hand second-hand" id="second-hand"></div>
              <div class="second-tail"      id="second-tail"></div>
              <div class="center-dot"></div>
            </div>
          </div>
        </div>
        <div class="hidden lg:block" style="width:1px;height:200px;background:linear-gradient(180deg,transparent,rgba(201,168,76,.28),transparent);"></div>
        <div class="block lg:hidden ornament-line-thin w-full"></div>
        <!-- Digital -->
        <div class="flex-1 w-full">
          <div class="digital-display mb-3">
            <div id="clock-display" style="font-size:3.8rem;">00:00:00</div>
            <div id="digital-ampm" style="font-family:'DM Mono',monospace;font-size:.76rem;color:rgba(245,230,184,.45);letter-spacing:.15em;margin-top:3px;">AM</div>
          </div>
          <div class="flex flex-wrap items-center justify-center gap-3 mb-3">
            <div id="gregorian-date" style="color:rgba(245,230,184,.65);font-size:.82rem;font-family:'DM Mono',monospace;text-align:center;"></div>
            <div class="hijri-badge rounded-full px-3 py-0.5">
              <span id="hijri-date" class="arabic-text" style="color:var(--gold-light);font-size:.88rem;"></span>
            </div>
          </div>
          <div class="flex flex-wrap items-center justify-center gap-2">
            <div class="pulse-dot"></div>
            <span id="current-location-label" style="color:rgba(245,230,184,.5);font-size:.76rem;font-family:'DM Mono',monospace;letter-spacing:.04em;">Mendeteksi lokasi...</span>
            <div class="tz-badge">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span id="tz-label">UTC+00:00</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SEARCH + METHOD -->
    <div class="glass-card rounded-2xl p-5 mb-5 fi fi-2">
      <p style="font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(245,230,184,.35);margin-bottom:10px;">🔍 CARI KOTA DI SELURUH DUNIA — 500+ Kota Tersedia</p>
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 search-wrap">
          <div class="absolute left-3 top-3.5 z-10" style="color:var(--gold);pointer-events:none;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          </div>
          <input id="city-search" type="text" placeholder="Ketik nama kota... Jakarta, Dubai, London, Tokyo, Cairo"
            class="search-input pl-10 pr-10 py-3 rounded-xl text-sm" autocomplete="off" spellcheck="false">
          <button id="clear-btn" class="absolute right-3 top-3.5 z-10 hidden" style="color:rgba(245,230,184,.35);background:none;border:none;cursor:pointer;font-size:.9rem;">✕</button>
          <div id="city-dropdown" class="hidden"></div>
        </div>
        <div class="sm:w-52">
          <select id="method-select" class="method-select w-full px-3 py-3 rounded-xl text-sm">
            <option value="2">ISNA – Amerika Utara</option>
            <option value="1">Univ. Islamic Sciences</option>
            <option value="3">Muslim World League</option>
            <option value="4">Umm Al-Qura (Makkah)</option>
            <option value="5">Egyptian General Authority</option>
            <option value="8">Gulf Region</option>
            <option value="11" selected>MUI – Indonesia</option>
            <option value="12">UOIF – Perancis</option>
            <option value="15">Diyanet – Turkey</option>
          </select>
        </div>
        <button id="search-btn" class="px-6 py-3 rounded-xl font-semibold text-sm"
          style="background:linear-gradient(135deg,#C9A84C,#9A7228);color:#0A0E1A;font-family:'Cinzel',serif;letter-spacing:.05em;flex-shrink:0;transition:filter .2s;"
          onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='brightness(1)'">CARI</button>
      </div>
      <p class="search-hint">⌨ Gunakan ↑↓ untuk navigasi, Enter untuk pilih, Esc untuk tutup</p>
    </div>

    <!-- PRAYER SECTION -->
    <div id="prayer-section" class="fi fi-3">
      <div id="loading-state" class="flex items-center justify-center py-14">
        <div class="text-center">
          <div class="spinner mx-auto mb-3"></div>
          <p style="color:rgba(245,230,184,.4);font-size:.82rem;">Memuat waktu shalat...</p>
        </div>
      </div>
      <div id="prayer-content" class="hidden">
        <div class="glass-card rounded-2xl p-4 mb-4">
          <div class="flex items-center justify-between mb-3">
            <div>
              <p style="color:rgba(245,230,184,.4);font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;" class="mb-1">Shalat Berikutnya</p>
              <p id="next-prayer-name" style="font-family:'Cinzel',serif;color:var(--gold-light);font-size:1.05rem;font-weight:600;"></p>
            </div>
            <div class="text-right">
              <p style="color:rgba(245,230,184,.4);font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;" class="mb-1">Tersisa</p>
              <p id="next-prayer-countdown" style="font-family:'Cinzel',serif;color:var(--teal);font-size:1.25rem;font-weight:700;letter-spacing:.05em;"></p>
            </div>
          </div>
          <div style="height:4px;background:rgba(255,255,255,.05);border-radius:9999px;overflow:hidden;"><div id="countdown-bar" style="width:0%;"></div></div>
        </div>
        <div id="prayers-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3"></div>
      </div>
    </div>

  </div><!-- /tab-shalat -->

  <!-- ════════════════════════════════════════
       TAB 2 — PROGRES TAHUN
  ════════════════════════════════════════ -->
  <div id="tab-progress" class="section-panel">
    <div class="glass-card rounded-2xl p-6 mb-5 fi fi-1">
      <div class="corner-ornament corner-tl"></div><div class="corner-ornament corner-tr"></div>
      <div class="corner-ornament corner-bl"></div><div class="corner-ornament corner-br"></div>

      <div class="text-center mb-5">
        <div class="eyebrow-line mb-2">Progress Tracker</div>
        <h2 style="font-family:'Space Mono',monospace;font-size:clamp(1.4rem,4vw,2.2rem);font-weight:700;color:#fff;letter-spacing:-.02em;">
          Tahun <span style="background:linear-gradient(90deg,var(--gold),var(--teal));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;" id="yp-current-year">—</span>
        </h2>
      </div>

      <!-- Big percentage -->
      <div class="yp-big mb-5" id="yp-big-percent" style="font-size:clamp(4rem,16vw,8.5rem);">—%</div>

      <!-- Progress bar -->
      <div class="bar-track mb-2">
        <div class="bar-fill" id="yp-bar"></div>
      </div>
      <div class="flex justify-between mb-5" style="font-size:.72rem;font-family:'Space Mono',monospace;color:rgba(245,230,184,.35);">
        <span>1 Jan</span>
        <span id="yp-bar-right">31 Des</span>
      </div>

      <!-- Next year note -->
      <p class="text-center mb-5" style="font-size:.92rem;color:rgba(245,230,184,.5);">
        Menuju Tahun Baru &nbsp;<strong id="yp-next-year" style="font-family:'Space Mono',monospace;color:var(--teal);font-size:1.05rem;">—</strong>
      </p>

      <!-- Stat cards -->
      <dl class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="stat-card stat-gold">
          <dt>Tahun Baru jatuh pada</dt>
          <dd id="yp-newyear-date" style="font-size:1rem;line-height:1.3;">—</dd>
        </div>
        <div class="stat-card stat-teal">
          <dt>Progress Tahun Ini</dt>
          <dd id="yp-progress-pct">—</dd>
        </div>
        <div class="stat-card stat-orange">
          <dt>Hari Telah Berlalu</dt>
          <dd id="yp-passed">— <span class="unit">hari</span></dd>
        </div>
        <div class="stat-card stat-rose">
          <dt>Sisa Hari Tahun Ini</dt>
          <dd id="yp-remaining">— <span class="unit">hari</span></dd>
        </div>
      </dl>
    </div>

    <!-- Detailed breakdown -->
    <div class="glass-card rounded-2xl p-5 fi fi-2">
      <p style="font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(245,230,184,.35);margin-bottom:12px;">⏱ Rincian Waktu Berlalu</p>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="yp-detail-grid">
        <!-- filled by JS -->
      </div>
    </div>
  </div><!-- /tab-progress -->

</div><!-- /max-w -->
</div><!-- /z-10 -->

<!-- ────────────────────────────────────────────────
     WORLD CITIES DATA
──────────────────────────────────────────────── -->
<script>
const RAW = [
["Banda Aceh","Indonesia","Asia/Jakarta","🇮🇩",11],["Lhokseumawe","Indonesia","Asia/Jakarta","🇮🇩",11],
["Padang","Indonesia","Asia/Jakarta","🇮🇩",11],["Pekanbaru","Indonesia","Asia/Jakarta","🇮🇩",11],
["Batam","Indonesia","Asia/Jakarta","🇮🇩",11],["Medan","Indonesia","Asia/Jakarta","🇮🇩",11],
["Palembang","Indonesia","Asia/Jakarta","🇮🇩",11],["Bengkulu","Indonesia","Asia/Jakarta","🇮🇩",11],
["Bandar Lampung","Indonesia","Asia/Jakarta","🇮🇩",11],["Jakarta","Indonesia","Asia/Jakarta","🇮🇩",11],
["Bogor","Indonesia","Asia/Jakarta","🇮🇩",11],["Depok","Indonesia","Asia/Jakarta","🇮🇩",11],
["Bekasi","Indonesia","Asia/Jakarta","🇮🇩",11],["Tangerang","Indonesia","Asia/Jakarta","🇮🇩",11],
["Serang","Indonesia","Asia/Jakarta","🇮🇩",11],["Cilegon","Indonesia","Asia/Jakarta","🇮🇩",11],
["Bandung","Indonesia","Asia/Jakarta","🇮🇩",11],["Cirebon","Indonesia","Asia/Jakarta","🇮🇩",11],
["Semarang","Indonesia","Asia/Jakarta","🇮🇩",11],["Yogyakarta","Indonesia","Asia/Jakarta","🇮🇩",11],
["Solo","Indonesia","Asia/Jakarta","🇮🇩",11],["Surabaya","Indonesia","Asia/Jakarta","🇮🇩",11],
["Malang","Indonesia","Asia/Jakarta","🇮🇩",11],["Kediri","Indonesia","Asia/Jakarta","🇮🇩",11],
["Madiun","Indonesia","Asia/Jakarta","🇮🇩",11],["Jambi","Indonesia","Asia/Jakarta","🇮🇩",11],
["Denpasar","Indonesia","Asia/Makassar","🇮🇩",11],["Mataram","Indonesia","Asia/Makassar","🇮🇩",11],
["Banjarmasin","Indonesia","Asia/Makassar","🇮🇩",11],["Palangka Raya","Indonesia","Asia/Makassar","🇮🇩",11],
["Balikpapan","Indonesia","Asia/Makassar","🇮🇩",11],["Samarinda","Indonesia","Asia/Makassar","🇮🇩",11],
["Makassar","Indonesia","Asia/Makassar","🇮🇩",11],["Palu","Indonesia","Asia/Makassar","🇮🇩",11],
["Kendari","Indonesia","Asia/Makassar","🇮🇩",11],["Manado","Indonesia","Asia/Makassar","🇮🇩",11],
["Lombok","Indonesia","Asia/Makassar","🇮🇩",11],["Kupang","Indonesia","Asia/Makassar","🇮🇩",11],
["Ambon","Indonesia","Asia/Jayapura","🇮🇩",11],["Ternate","Indonesia","Asia/Jayapura","🇮🇩",11],
["Sorong","Indonesia","Asia/Jayapura","🇮🇩",11],["Manokwari","Indonesia","Asia/Jayapura","🇮🇩",11],
["Jayapura","Indonesia","Asia/Jayapura","🇮🇩",11],
["Kuala Lumpur","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Putrajaya","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],
["Petaling Jaya","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Shah Alam","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],
["Johor Bahru","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Penang","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],
["George Town","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Ipoh","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],
["Kota Bharu","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Kuala Terengganu","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],
["Alor Setar","Malaysia","Asia/Kuala_Lumpur","🇲🇾",3],["Kota Kinabalu","Malaysia","Asia/Kuching","🇲🇾",3],
["Kuching","Malaysia","Asia/Kuching","🇲🇾",3],["Miri","Malaysia","Asia/Kuching","🇲🇾",3],
["Sandakan","Malaysia","Asia/Kuching","🇲🇾",3],
["Bandar Seri Begawan","Brunei","Asia/Brunei","🇧🇳",3],
["Singapore","Singapore","Asia/Singapore","🇸🇬",3],
["Manila","Philippines","Asia/Manila","🇵🇭",3],["Cebu","Philippines","Asia/Manila","🇵🇭",3],
["Davao","Philippines","Asia/Manila","🇵🇭",3],["Zamboanga","Philippines","Asia/Manila","🇵🇭",3],
["Cotabato","Philippines","Asia/Manila","🇵🇭",3],
["Bangkok","Thailand","Asia/Bangkok","🇹🇭",3],["Chiang Mai","Thailand","Asia/Bangkok","🇹🇭",3],
["Hat Yai","Thailand","Asia/Bangkok","🇹🇭",3],["Pattani","Thailand","Asia/Bangkok","🇹🇭",3],
["Hanoi","Vietnam","Asia/Ho_Chi_Minh","🇻🇳",3],["Ho Chi Minh City","Vietnam","Asia/Ho_Chi_Minh","🇻🇳",3],
["Da Nang","Vietnam","Asia/Ho_Chi_Minh","🇻🇳",3],
["Phnom Penh","Cambodia","Asia/Phnom_Penh","🇰🇭",3],
["Yangon","Myanmar","Asia/Rangoon","🇲🇲",1],["Mandalay","Myanmar","Asia/Rangoon","🇲🇲",1],
["Dili","Timor-Leste","Asia/Dili","🇹🇱",3],["Vientiane","Laos","Asia/Vientiane","🇱🇦",3],
["Beijing","China","Asia/Shanghai","🇨🇳",3],["Shanghai","China","Asia/Shanghai","🇨🇳",3],
["Guangzhou","China","Asia/Shanghai","🇨🇳",3],["Shenzhen","China","Asia/Shanghai","🇨🇳",3],
["Chengdu","China","Asia/Shanghai","🇨🇳",3],["Wuhan","China","Asia/Shanghai","🇨🇳",3],
["Nanjing","China","Asia/Shanghai","🇨🇳",3],["Xi'an","China","Asia/Shanghai","🇨🇳",3],
["Urumqi","China","Asia/Urumqi","🇨🇳",3],["Kunming","China","Asia/Shanghai","🇨🇳",3],
["Hong Kong","Hong Kong","Asia/Hong_Kong","🇭🇰",3],["Taipei","Taiwan","Asia/Taipei","🇹🇼",3],
["Tokyo","Japan","Asia/Tokyo","🇯🇵",3],["Osaka","Japan","Asia/Tokyo","🇯🇵",3],
["Fukuoka","Japan","Asia/Tokyo","🇯🇵",3],["Sapporo","Japan","Asia/Tokyo","🇯🇵",3],
["Seoul","South Korea","Asia/Seoul","🇰🇷",3],["Busan","South Korea","Asia/Seoul","🇰🇷",3],
["Incheon","South Korea","Asia/Seoul","🇰🇷",3],["Ulaanbaatar","Mongolia","Asia/Ulaanbaatar","🇲🇳",3],
["Mumbai","India","Asia/Kolkata","🇮🇳",1],["Delhi","India","Asia/Kolkata","🇮🇳",1],
["Bangalore","India","Asia/Kolkata","🇮🇳",1],["Hyderabad","India","Asia/Kolkata","🇮🇳",1],
["Chennai","India","Asia/Kolkata","🇮🇳",1],["Kolkata","India","Asia/Kolkata","🇮🇳",1],
["Ahmedabad","India","Asia/Kolkata","🇮🇳",1],["Lucknow","India","Asia/Kolkata","🇮🇳",1],
["Pune","India","Asia/Kolkata","🇮🇳",1],["Srinagar","India","Asia/Kolkata","🇮🇳",1],
["Karachi","Pakistan","Asia/Karachi","🇵🇰",1],["Lahore","Pakistan","Asia/Karachi","🇵🇰",1],
["Islamabad","Pakistan","Asia/Karachi","🇵🇰",1],["Rawalpindi","Pakistan","Asia/Karachi","🇵🇰",1],
["Faisalabad","Pakistan","Asia/Karachi","🇵🇰",1],["Multan","Pakistan","Asia/Karachi","🇵🇰",1],
["Peshawar","Pakistan","Asia/Karachi","🇵🇰",1],["Quetta","Pakistan","Asia/Karachi","🇵🇰",1],
["Dhaka","Bangladesh","Asia/Dhaka","🇧🇩",1],["Chittagong","Bangladesh","Asia/Dhaka","🇧🇩",1],
["Khulna","Bangladesh","Asia/Dhaka","🇧🇩",1],["Sylhet","Bangladesh","Asia/Dhaka","🇧🇩",1],
["Colombo","Sri Lanka","Asia/Colombo","🇱🇰",1],["Kathmandu","Nepal","Asia/Kathmandu","🇳🇵",1],
["Male","Maldives","Indian/Maldives","🇲🇻",1],
["Kabul","Afghanistan","Asia/Kabul","🇦🇫",1],["Herat","Afghanistan","Asia/Kabul","🇦🇫",1],
["Kandahar","Afghanistan","Asia/Kabul","🇦🇫",1],["Mazar-i-Sharif","Afghanistan","Asia/Kabul","🇦🇫",1],
["Tehran","Iran","Asia/Tehran","🇮🇷",7],["Mashhad","Iran","Asia/Tehran","🇮🇷",7],
["Isfahan","Iran","Asia/Tehran","🇮🇷",7],["Tabriz","Iran","Asia/Tehran","🇮🇷",7],
["Shiraz","Iran","Asia/Tehran","🇮🇷",7],
["Mecca","Saudi Arabia","Asia/Riyadh","🇸🇦",4],["Medina","Saudi Arabia","Asia/Riyadh","🇸🇦",4],
["Riyadh","Saudi Arabia","Asia/Riyadh","🇸🇦",4],["Jeddah","Saudi Arabia","Asia/Riyadh","🇸🇦",4],
["Dammam","Saudi Arabia","Asia/Riyadh","🇸🇦",4],["Khobar","Saudi Arabia","Asia/Riyadh","🇸🇦",4],
["Taif","Saudi Arabia","Asia/Riyadh","🇸🇦",4],["Tabuk","Saudi Arabia","Asia/Riyadh","🇸🇦",4],
["Abha","Saudi Arabia","Asia/Riyadh","🇸🇦",4],
["Dubai","United Arab Emirates","Asia/Dubai","🇦🇪",8],["Abu Dhabi","United Arab Emirates","Asia/Dubai","🇦🇪",8],
["Sharjah","United Arab Emirates","Asia/Dubai","🇦🇪",8],["Ajman","United Arab Emirates","Asia/Dubai","🇦🇪",8],
["Doha","Qatar","Asia/Qatar","🇶🇦",8],["Kuwait City","Kuwait","Asia/Kuwait","🇰🇼",8],
["Manama","Bahrain","Asia/Bahrain","🇧🇭",8],
["Muscat","Oman","Asia/Muscat","🇴🇲",8],["Salalah","Oman","Asia/Muscat","🇴🇲",8],
["Sanaa","Yemen","Asia/Aden","🇾🇪",3],["Aden","Yemen","Asia/Aden","🇾🇪",3],
["Baghdad","Iraq","Asia/Baghdad","🇮🇶",3],["Basra","Iraq","Asia/Baghdad","🇮🇶",3],
["Mosul","Iraq","Asia/Baghdad","🇮🇶",3],["Erbil","Iraq","Asia/Baghdad","🇮🇶",3],
["Najaf","Iraq","Asia/Baghdad","🇮🇶",3],["Karbala","Iraq","Asia/Baghdad","🇮🇶",3],
["Amman","Jordan","Asia/Amman","🇯🇴",3],["Zarqa","Jordan","Asia/Amman","🇯🇴",3],
["Beirut","Lebanon","Asia/Beirut","🇱🇧",3],
["Damascus","Syria","Asia/Damascus","🇸🇾",3],["Aleppo","Syria","Asia/Damascus","🇸🇾",3],
["Homs","Syria","Asia/Damascus","🇸🇾",3],
["Gaza","Palestine","Asia/Gaza","🇵🇸",3],["Jerusalem","Palestine","Asia/Jerusalem","🇵🇸",3],
["Ramallah","Palestine","Asia/Hebron","🇵🇸",3],
["Istanbul","Turkey","Europe/Istanbul","🇹🇷",15],["Ankara","Turkey","Europe/Istanbul","🇹🇷",15],
["Izmir","Turkey","Europe/Istanbul","🇹🇷",15],["Bursa","Turkey","Europe/Istanbul","🇹🇷",15],
["Konya","Turkey","Europe/Istanbul","🇹🇷",15],["Adana","Turkey","Europe/Istanbul","🇹🇷",15],
["Gaziantep","Turkey","Europe/Istanbul","🇹🇷",15],["Antalya","Turkey","Europe/Istanbul","🇹🇷",15],
["Tashkent","Uzbekistan","Asia/Tashkent","🇺🇿",1],["Samarkand","Uzbekistan","Asia/Samarkand","🇺🇿",1],
["Bukhara","Uzbekistan","Asia/Samarkand","🇺🇿",1],
["Almaty","Kazakhstan","Asia/Almaty","🇰🇿",1],["Astana","Kazakhstan","Asia/Almaty","🇰🇿",1],
["Shymkent","Kazakhstan","Asia/Almaty","🇰🇿",1],
["Bishkek","Kyrgyzstan","Asia/Bishkek","🇰🇬",1],["Dushanbe","Tajikistan","Asia/Dushanbe","🇹🇯",1],
["Ashgabat","Turkmenistan","Asia/Ashgabat","🇹🇲",1],["Baku","Azerbaijan","Asia/Baku","🇦🇿",3],
["Tbilisi","Georgia","Asia/Tbilisi","🇬🇪",3],
["Cairo","Egypt","Africa/Cairo","🇪🇬",5],["Alexandria","Egypt","Africa/Cairo","🇪🇬",5],
["Giza","Egypt","Africa/Cairo","🇪🇬",5],["Port Said","Egypt","Africa/Cairo","🇪🇬",5],
["Aswan","Egypt","Africa/Cairo","🇪🇬",5],["Luxor","Egypt","Africa/Cairo","🇪🇬",5],
["Tripoli","Libya","Africa/Tripoli","🇱🇾",3],["Benghazi","Libya","Africa/Tripoli","🇱🇾",3],
["Tunis","Tunisia","Africa/Tunis","🇹🇳",3],["Sfax","Tunisia","Africa/Tunis","🇹🇳",3],
["Algiers","Algeria","Africa/Algiers","🇩🇿",3],["Oran","Algeria","Africa/Algiers","🇩🇿",3],
["Constantine","Algeria","Africa/Algiers","🇩🇿",3],
["Casablanca","Morocco","Africa/Casablanca","🇲🇦",3],["Rabat","Morocco","Africa/Casablanca","🇲🇦",3],
["Marrakech","Morocco","Africa/Casablanca","🇲🇦",3],["Fez","Morocco","Africa/Casablanca","🇲🇦",3],
["Tangier","Morocco","Africa/Casablanca","🇲🇦",3],
["Khartoum","Sudan","Africa/Khartoum","🇸🇩",3],["Omdurman","Sudan","Africa/Khartoum","🇸🇩",3],
["Mogadishu","Somalia","Africa/Mogadishu","🇸🇴",3],["Hargeisa","Somalia","Africa/Mogadishu","🇸🇴",3],
["Addis Ababa","Ethiopia","Africa/Addis_Ababa","🇪🇹",3],["Dire Dawa","Ethiopia","Africa/Addis_Ababa","🇪🇹",3],
["Harar","Ethiopia","Africa/Addis_Ababa","🇪🇹",3],["Djibouti","Djibouti","Africa/Djibouti","🇩🇯",3],
["Nairobi","Kenya","Africa/Nairobi","🇰🇪",3],["Mombasa","Kenya","Africa/Nairobi","🇰🇪",3],
["Dar es Salaam","Tanzania","Africa/Dar_es_Salaam","🇹🇿",3],["Zanzibar","Tanzania","Africa/Dar_es_Salaam","🇹🇿",3],
["Kampala","Uganda","Africa/Kampala","🇺🇬",3],
["Lagos","Nigeria","Africa/Lagos","🇳🇬",3],["Abuja","Nigeria","Africa/Lagos","🇳🇬",3],
["Kano","Nigeria","Africa/Lagos","🇳🇬",3],["Kaduna","Nigeria","Africa/Lagos","🇳🇬",3],
["Maiduguri","Nigeria","Africa/Lagos","🇳🇬",3],
["Dakar","Senegal","Africa/Dakar","🇸🇳",3],["Touba","Senegal","Africa/Dakar","🇸🇳",3],
["Bamako","Mali","Africa/Bamako","🇲🇱",3],["Niamey","Niger","Africa/Niamey","🇳🇪",3],
["Conakry","Guinea","Africa/Conakry","🇬🇳",3],["Accra","Ghana","Africa/Accra","🇬🇭",3],
["Yaounde","Cameroon","Africa/Douala","🇨🇲",3],["Douala","Cameroon","Africa/Douala","🇨🇲",3],
["N'Djamena","Chad","Africa/Ndjamena","🇹🇩",3],
["Johannesburg","South Africa","Africa/Johannesburg","🇿🇦",3],["Cape Town","South Africa","Africa/Johannesburg","🇿🇦",3],
["Durban","South Africa","Africa/Johannesburg","🇿🇦",3],
["London","United Kingdom","Europe/London","🇬🇧",1],["Birmingham","United Kingdom","Europe/London","🇬🇧",1],
["Manchester","United Kingdom","Europe/London","🇬🇧",1],["Bradford","United Kingdom","Europe/London","🇬🇧",1],
["Leeds","United Kingdom","Europe/London","🇬🇧",1],["Leicester","United Kingdom","Europe/London","🇬🇧",1],
["Paris","France","Europe/Paris","🇫🇷",12],["Lyon","France","Europe/Paris","🇫🇷",12],
["Marseille","France","Europe/Paris","🇫🇷",12],["Toulouse","France","Europe/Paris","🇫🇷",12],
["Nice","France","Europe/Paris","🇫🇷",12],["Strasbourg","France","Europe/Paris","🇫🇷",12],
["Berlin","Germany","Europe/Berlin","🇩🇪",3],["Hamburg","Germany","Europe/Berlin","🇩🇪",3],
["Munich","Germany","Europe/Berlin","🇩🇪",3],["Frankfurt","Germany","Europe/Berlin","🇩🇪",3],
["Cologne","Germany","Europe/Berlin","🇩🇪",3],["Stuttgart","Germany","Europe/Berlin","🇩🇪",3],
["Amsterdam","Netherlands","Europe/Amsterdam","🇳🇱",3],["Rotterdam","Netherlands","Europe/Amsterdam","🇳🇱",3],
["Brussels","Belgium","Europe/Brussels","🇧🇪",12],
["Rome","Italy","Europe/Rome","🇮🇹",3],["Milan","Italy","Europe/Rome","🇮🇹",3],
["Naples","Italy","Europe/Rome","🇮🇹",3],
["Madrid","Spain","Europe/Madrid","🇪🇸",3],["Barcelona","Spain","Europe/Madrid","🇪🇸",3],
["Valencia","Spain","Europe/Madrid","🇪🇸",3],["Seville","Spain","Europe/Madrid","🇪🇸",3],
["Lisbon","Portugal","Europe/Lisbon","🇵🇹",3],
["Stockholm","Sweden","Europe/Stockholm","🇸🇪",3],["Gothenburg","Sweden","Europe/Stockholm","🇸🇪",3],
["Oslo","Norway","Europe/Oslo","🇳🇴",3],["Copenhagen","Denmark","Europe/Copenhagen","🇩🇰",3],
["Helsinki","Finland","Europe/Helsinki","🇫🇮",3],["Vienna","Austria","Europe/Vienna","🇦🇹",3],
["Zurich","Switzerland","Europe/Zurich","🇨🇭",3],["Geneva","Switzerland","Europe/Zurich","🇨🇭",3],
["Warsaw","Poland","Europe/Warsaw","🇵🇱",3],["Krakow","Poland","Europe/Warsaw","🇵🇱",3],
["Prague","Czech Republic","Europe/Prague","🇨🇿",3],["Budapest","Hungary","Europe/Budapest","🇭🇺",3],
["Bucharest","Romania","Europe/Bucharest","🇷🇴",3],["Sofia","Bulgaria","Europe/Sofia","🇧🇬",3],
["Athens","Greece","Europe/Athens","🇬🇷",3],["Belgrade","Serbia","Europe/Belgrade","🇷🇸",3],
["Zagreb","Croatia","Europe/Zagreb","🇭🇷",3],
["Sarajevo","Bosnia and Herzegovina","Europe/Sarajevo","🇧🇦",3],
["Skopje","North Macedonia","Europe/Skopje","🇲🇰",3],["Tirana","Albania","Europe/Tirane","🇦🇱",3],
["Kyiv","Ukraine","Europe/Kiev","🇺🇦",3],["Kharkiv","Ukraine","Europe/Kiev","🇺🇦",3],
["Minsk","Belarus","Europe/Minsk","🇧🇾",3],
["Moscow","Russia","Europe/Moscow","🇷🇺",3],["Saint Petersburg","Russia","Europe/Moscow","🇷🇺",3],
["Kazan","Russia","Europe/Moscow","🇷🇺",3],["Yekaterinburg","Russia","Asia/Yekaterinburg","🇷🇺",3],
["Novosibirsk","Russia","Asia/Novosibirsk","🇷🇺",3],["Luxembourg","Luxembourg","Europe/Luxembourg","🇱🇺",12],
["New York","United States","America/New_York","🇺🇸",2],["Boston","United States","America/New_York","🇺🇸",2],
["Philadelphia","United States","America/New_York","🇺🇸",2],["Washington DC","United States","America/New_York","🇺🇸",2],
["Miami","United States","America/New_York","🇺🇸",2],["Atlanta","United States","America/New_York","🇺🇸",2],
["Charlotte","United States","America/New_York","🇺🇸",2],
["Chicago","United States","America/Chicago","🇺🇸",2],["Dallas","United States","America/Chicago","🇺🇸",2],
["Houston","United States","America/Chicago","🇺🇸",2],["Minneapolis","United States","America/Chicago","🇺🇸",2],
["St. Louis","United States","America/Chicago","🇺🇸",2],
["Denver","United States","America/Denver","🇺🇸",2],["Phoenix","United States","America/Phoenix","🇺🇸",2],
["Los Angeles","United States","America/Los_Angeles","🇺🇸",2],["San Francisco","United States","America/Los_Angeles","🇺🇸",2],
["Seattle","United States","America/Los_Angeles","🇺🇸",2],["Las Vegas","United States","America/Los_Angeles","🇺🇸",2],
["Detroit","United States","America/Detroit","🇺🇸",2],
["Toronto","Canada","America/Toronto","🇨🇦",2],["Ottawa","Canada","America/Toronto","🇨🇦",2],
["Montreal","Canada","America/Toronto","🇨🇦",2],["Halifax","Canada","America/Halifax","🇨🇦",2],
["Calgary","Canada","America/Edmonton","🇨🇦",2],["Edmonton","Canada","America/Edmonton","🇨🇦",2],
["Vancouver","Canada","America/Vancouver","🇨🇦",2],
["Mexico City","Mexico","America/Mexico_City","🇲🇽",2],["Monterrey","Mexico","America/Monterrey","🇲🇽",2],
["Guadalajara","Mexico","America/Mexico_City","🇲🇽",2],
["Panama City","Panama","America/Panama","🇵🇦",2],["Bogota","Colombia","America/Bogota","🇨🇴",2],
["Lima","Peru","America/Lima","🇵🇪",2],["Quito","Ecuador","America/Guayaquil","🇪🇨",2],
["Caracas","Venezuela","America/Caracas","🇻🇪",2],
["Sao Paulo","Brazil","America/Sao_Paulo","🇧🇷",2],["Rio de Janeiro","Brazil","America/Sao_Paulo","🇧🇷",2],
["Brasilia","Brazil","America/Sao_Paulo","🇧🇷",2],["Recife","Brazil","America/Recife","🇧🇷",2],
["Buenos Aires","Argentina","America/Argentina/Buenos_Aires","🇦🇷",2],
["Cordoba","Argentina","America/Argentina/Cordoba","🇦🇷",2],
["Santiago","Chile","America/Santiago","🇨🇱",2],["Montevideo","Uruguay","America/Montevideo","🇺🇾",2],
["Havana","Cuba","America/Havana","🇨🇺",2],
["Port of Spain","Trinidad and Tobago","America/Port_of_Spain","🇹🇹",2],
["Sydney","Australia","Australia/Sydney","🇦🇺",3],["Melbourne","Australia","Australia/Melbourne","🇦🇺",3],
["Brisbane","Australia","Australia/Brisbane","🇦🇺",3],["Perth","Australia","Australia/Perth","🇦🇺",3],
["Adelaide","Australia","Australia/Adelaide","🇦🇺",3],["Canberra","Australia","Australia/Sydney","🇦🇺",3],
["Auckland","New Zealand","Pacific/Auckland","🇳🇿",3],["Wellington","New Zealand","Pacific/Auckland","🇳🇿",3],
];
const CITIES = RAW.map(r=>({c:r[0],n:r[1],tz:r[2],f:r[3],m:r[4]}));

// ────────────────────────────────────────────────────────────────
//  PRAYER META
// ────────────────────────────────────────────────────────────────
const PRAYER_META = {
  Imsak:   {label:"Imsak",   arabic:"إِمْسَاك",  icon:"🌙"},
  Fajr:    {label:"Subuh",   arabic:"الفَجْر",   icon:"🌅"},
  Sunrise: {label:"Terbit",  arabic:"الشُّرُوق",  icon:"☀️"},
  Dhuhr:   {label:"Dzuhur",  arabic:"الظُّهْر",   icon:"🌤"},
  Asr:     {label:"Ashar",   arabic:"العَصْر",    icon:"🌇"},
  Maghrib: {label:"Maghrib", arabic:"المَغْرِب",   icon:"🌆"},
  Isha:    {label:"Isya",    arabic:"العِشَاء",    icon:"🌃"},
};
const SHALAT_KEYS = ['Imsak','Fajr','Dhuhr','Asr','Maghrib','Isha'];

let currentCity="Jakarta", currentCountry="Indonesia", currentTZ="Asia/Jakarta";
let countdownInterval=null, kbdIdx=-1;

// ────────────────────────────────────────────────────────────────
//  BUILD ANALOG FACE
// ────────────────────────────────────────────────────────────────
(function(){
  const face=document.getElementById('clock-face');
  const CX=105,CY=105;
  for(let i=0;i<60;i++){
    const maj=i%5===0, el=document.createElement('div');
    el.className='tick '+(maj?'tick-major':'tick-minor');
    const ang=i*6, rad=(ang-90)*Math.PI/180, r=maj?92:93;
    el.style.left=CX+r*Math.cos(rad)+'px'; el.style.top=CY+r*Math.sin(rad)+'px';
    el.style.transform=`rotate(${ang}deg)`; face.insertBefore(el,face.firstChild);
  }
  for(let i=1;i<=12;i++){
    const el=document.createElement('div'); el.className='num'; el.textContent=i;
    const ang=(i*30-90)*Math.PI/180;
    el.style.left=CX+80*Math.cos(ang)+'px'; el.style.top=CY+80*Math.sin(ang)+'px';
    face.insertBefore(el,face.firstChild);
  }
})();

// ────────────────────────────────────────────────────────────────
//  TIMEZONE HELPERS
// ────────────────────────────────────────────────────────────────
function getTimeInTZ(tz){
  const now=new Date();
  const parts=new Intl.DateTimeFormat('en-US',{timeZone:tz,hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false}).formatToParts(now);
  let h=0,m=0,s=0;
  parts.forEach(p=>{if(p.type==='hour')h=parseInt(p.value);if(p.type==='minute')m=parseInt(p.value);if(p.type==='second')s=parseInt(p.value);});
  if(h===24)h=0; return{h,m,s};
}
function getDateInTZ(tz){ return new Intl.DateTimeFormat('id-ID',{timeZone:tz,weekday:'long',day:'numeric',month:'long',year:'numeric'}).format(new Date()); }
function getTZOffset(tz){
  try{
    const now=new Date();
    const u=new Date(now.toLocaleString('en-US',{timeZone:'UTC'}));
    const l=new Date(now.toLocaleString('en-US',{timeZone:tz}));
    const d=(l-u)/60000, sg=d>=0?'+':'-', a=Math.abs(d);
    return `UTC${sg}${String(Math.floor(a/60)).padStart(2,'0')}:${String(a%60).padStart(2,'0')}`;
  }catch{return 'UTC';}
}

// ────────────────────────────────────────────────────────────────
//  CLOCK TICK
// ────────────────────────────────────────────────────────────────
function updateClock(){
  const {h,m,s}=getTimeInTZ(currentTZ);
  const sD=s/60*360, mD=(m+s/60)/60*360, hD=((h%12)+m/60)/12*360;
  document.getElementById('hour-hand').style.transform=`rotate(${hD}deg)`;
  document.getElementById('minute-hand').style.transform=`rotate(${mD}deg)`;
  document.getElementById('second-hand').style.transform=`rotate(${sD}deg)`;
  document.getElementById('second-tail').style.transform=`rotate(${sD}deg)`;
  document.getElementById('clock-display').textContent=`${pad(h%12||12)}:${pad(m)}:${pad(s)}`;
  document.getElementById('digital-ampm').textContent=h>=12?'PM':'AM';
  document.getElementById('gregorian-date').textContent=getDateInTZ(currentTZ);
  document.getElementById('tz-label').textContent=getTZOffset(currentTZ);
}
function pad(n){return String(n).padStart(2,'0');}

// ────────────────────────────────────────────────────────────────
//  HIJRI
// ────────────────────────────────────────────────────────────────
function toHijri(d){
  const jd2=Math.floor((14+d.getMonth()+1)/12),y=d.getFullYear()+4800-jd2,m2=d.getMonth()+1+12*jd2-3;
  let jdn=d.getDate()+Math.floor((153*m2+2)/5)+365*y+Math.floor(y/4)-Math.floor(y/100)+Math.floor(y/400)-32045;
  let l=jdn-1948440+10632,n=Math.floor((l-1)/10631);
  l=l-10631*n+354;
  let j=Math.floor((10985-l)/5316)*Math.floor((50*l)/17719)+Math.floor(l/5670)*Math.floor((43*l)/15238);
  l=l-Math.floor((30-j)/15)*Math.floor((17719*j)/50)-Math.floor(j/16)*Math.floor((15238*j)/43)+29;
  let mo=Math.floor((24*(l-1))/709),day=l-Math.floor((709*mo)/24),yr=30*n+j-30;
  const nm=["Muharram","Safar","Rabi'ul Awal","Rabi'ul Akhir","Jumadil Awal","Jumadil Akhir","Rajab","Sya'ban","Ramadhan","Syawal","Dzulqaidah","Dzulhijjah"];
  return`${day} ${nm[mo-1]} ${yr} H`;
}

// ────────────────────────────────────────────────────────────────
//  YEAR PROGRESS  (replaces progress.php)
// ────────────────────────────────────────────────────────────────
const ID_MONTHS = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
const ID_DAYS   = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

function calcYearProgress(){
  const now      = new Date();
  const yr       = now.getFullYear();
  const nextYr   = yr + 1;
  const startOfYear = new Date(yr,0,1,0,0,0,0);
  const startOfNext = new Date(nextYr,0,1,0,0,0,0);
  const totalMs  = startOfNext - startOfYear;
  const passedMs = now - startOfYear;
  const remMs    = startOfNext - now;
  const pct      = (passedMs / totalMs) * 100;
  const passedDays    = Math.floor(passedMs  / 86400000);
  const remainingDays = Math.floor(remMs     / 86400000);
  // New year label
  const nyDate    = startOfNext;
  const nyLabel   = `${ID_DAYS[nyDate.getDay()]}, ${nyDate.getDate()} ${ID_MONTHS[nyDate.getMonth()]} ${nextYr}`;
  // Detail breakdowns (from now)
  const passedSec = Math.floor(passedMs / 1000);
  const detail = {
    jam:    Math.floor(passedSec / 3600),
    menit:  Math.floor(passedSec / 60),
    detik:  passedSec,
    minggu: Math.floor(passedDays / 7),
    bulan:  now.getMonth() + (now.getDate() > 1 ? 1 : 0),
  };
  return { yr, nextYr, pct, passedDays, remainingDays, nyLabel, detail, pctDisplay: pct.toFixed(8) };
}

function renderYearProgress(){
  const d = calcYearProgress();
  $('#yp-current-year').text(d.yr);
  $('#yp-next-year').text(d.nextYr);
  $('#yp-newyear-date').text(d.nyLabel);
  const pctBar = parseFloat(d.pct.toFixed(2));
  $('#yp-big-percent').text(pctBar.toFixed(2) + '%');
  $('#yp-bar').css('width', Math.min(100, d.pct) + '%');
  $('#yp-bar-right').text(`31 Des ${d.yr}`);
  $('#yp-progress-pct').text(d.pct.toFixed(2) + '%');
  $('#yp-passed').html(`${d.passedDays} <span class="unit">hari</span>`);
  $('#yp-remaining').html(`${d.remainingDays} <span class="unit">hari</span>`);

  // Detail grid
  const items = [
    {label:'Minggu berlalu',  val:d.detail.minggu, unit:'mgg',  color:'var(--gold-light)'},
    {label:'Jam berlalu',     val:d.detail.jam,    unit:'jam',  color:'var(--teal)'},
    {label:'Menit berlalu',   val:d.detail.menit,  unit:'mnt',  color:'#f97316'},
    {label:'Detik berlalu',   val:d.detail.detik,  unit:'dtk',  color:'#fb7185'},
    {label:'Bulan berlalu',   val:d.detail.bulan,  unit:'bln',  color:'#a78bfa'},
    {label:'Hari dalam tahun',val:d.passedDays+d.remainingDays, unit:'hari',color:'rgba(245,230,184,.6)'},
  ];
  let html='';
  items.forEach(it=>{
    html+=`<div class="stat-card" style="border-color:rgba(201,168,76,.12);">
      <dt style="font-size:.65rem;">${it.label}</dt>
      <dd style="font-family:'Space Mono',monospace;font-size:1.35rem;font-weight:700;color:${it.color};">
        ${it.val.toLocaleString('id-ID')} <span class="unit">${it.unit}</span>
      </dd>
    </div>`;
  });
  $('#yp-detail-grid').html(html);
}

// ────────────────────────────────────────────────────────────────
//  PRAYER — set city / fetch
// ────────────────────────────────────────────────────────────────
function setCity(city,country,tz,method){
  currentCity=city; currentCountry=country; currentTZ=tz||'Asia/Jakarta';
  document.getElementById('current-location-label').textContent=`${city}, ${country}`;
  updateClock();
  $('#method-select').val(method||11);
  fetchPrayerTimes(city,country,method||11);
}

function fetchPrayerTimes(city,country,method){
  $('#loading-state').show(); $('#prayer-content').addClass('hidden');
  $.ajax({
    url:`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=${method}`,
    success(res){
      if(res.code===200&&res.data){
        renderPrayerTimes(res.data);
        if(res.data.date?.hijri){const h=res.data.date.hijri;$('#hijri-date').text(`${h.day} ${h.month.en} ${h.year} H`);}
        else $('#hijri-date').text(toHijri(new Date()));
        showToast(`✓ ${city}, ${country}`);
      } else { showToast('Kota tidak ditemukan di API shalat','error'); $('#loading-state').hide(); }
    },
    error(){ showToast('Gagal memuat. Cek koneksi.','error'); $('#loading-state').hide(); }
  });
}

function renderPrayerTimes(data){
  const T=data.timings;
  const ALL=['Imsak','Fajr','Sunrise','Dhuhr','Asr','Maghrib','Isha'];
  const {h,m}=getTimeInTZ(currentTZ);
  const nowM=h*60+m;
  const pM={};
  ALL.forEach(p=>{
    if(T[p]){
      const clean=T[p].replace(/\s*\(.*\)/,'').trim();
      const[a,b]=clean.split(':').map(Number);
      pM[p]=a*60+b;
    }
  });
  let active=null, next=null, nextT=null, prevT=null;
  if(nowM < pM[SHALAT_KEYS[0]]){
    next=SHALAT_KEYS[0]; nextT=pM[SHALAT_KEYS[0]];
    prevT=(pM['Isha']||pM[SHALAT_KEYS[SHALAT_KEYS.length-1]])-1440;
  } else {
    for(let i=0;i<SHALAT_KEYS.length;i++){
      const thisPM=pM[SHALAT_KEYS[i]];
      const nextPM=(i+1<SHALAT_KEYS.length)?pM[SHALAT_KEYS[i+1]]:pM[SHALAT_KEYS[0]]+1440;
      if(nowM>=thisPM&&nowM<nextPM){
        active=SHALAT_KEYS[i]; prevT=thisPM;
        if(i+1<SHALAT_KEYS.length){next=SHALAT_KEYS[i+1];nextT=pM[SHALAT_KEYS[i+1]];}
        else{next=SHALAT_KEYS[0];nextT=pM[SHALAT_KEYS[0]]+1440;}
        break;
      }
    }
  }
  if(!next){next=SHALAT_KEYS[0];nextT=pM[SHALAT_KEYS[0]];prevT=0;}
  let cards='';
  ALL.forEach(p=>{
    if(!T[p])return; const mt=PRAYER_META[p]; const isA=p===active;
    cards+=`<div class="prayer-card rounded-xl p-4 ${isA?'active-prayer':''}">
      <div class="text-2xl mb-1">${mt.icon}</div>
      <div class="arabic-text" style="font-size:.66rem;color:rgba(245,230,184,.32);direction:rtl;margin-bottom:4px;">${mt.arabic}</div>
      <div style="font-family:'Lora',serif;font-weight:600;color:var(--gold-pale);font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">${mt.label}</div>
      <div style="font-family:'Cinzel',serif;font-weight:700;font-size:1.2rem;color:${isA?'var(--gold-light)':'rgba(245,230,184,.9)'};">${fmt(T[p])}</div>
      ${isA?'<div style="margin-top:6px;"><span style="font-size:.62rem;padding:2px 8px;border-radius:999px;background:rgba(201,168,76,.18);color:var(--gold-light);">▸ Sekarang</span></div>':''}
    </div>`;
  });
  $('#prayers-grid').html(cards);
  const mt=PRAYER_META[next];
  $('#next-prayer-name').html(`${mt.icon} ${mt.label} <span class="arabic-text" style="font-size:.88rem;font-weight:400;">(${mt.arabic})</span>`);
  startCountdown(nextT,prevT);
  $('#loading-state').hide(); $('#prayer-content').removeClass('hidden');
}
function fmt(t){if(!t)return'--:--';const clean=t.replace(/\s*\(.*\)/,'').trim();const[a,b]=clean.split(':');return`${pad(a)}:${pad(b)}`;}

function startCountdown(tgt,prevT){
  if(countdownInterval)clearInterval(countdownInterval);
  const totalSpan=tgt-prevT;
  function upd(){
    const{h,m,s}=getTimeInTZ(currentTZ);
    const nowSec=h*3600+m*60+s, tgtSec=tgt*60;
    let diffSec=tgtSec-nowSec;
    if(diffSec<0)diffSec+=86400;
    const hh=Math.floor(diffSec/3600),mm=Math.floor((diffSec%3600)/60),ss=diffSec%60;
    $('#next-prayer-countdown').text(`${pad(hh)}:${pad(mm)}:${pad(ss)}`);
    const elapsed=(totalSpan*60)-diffSec;
    const pct=totalSpan>0?Math.min(100,Math.max(0,(elapsed/(totalSpan*60))*100)):0;
    $('#countdown-bar').css('width',pct+'%');
  }
  upd(); countdownInterval=setInterval(upd,1000);
}

// ────────────────────────────────────────────────────────────────
//  SEARCH
// ────────────────────────────────────────────────────────────────
let searchTimer=null;
function scoreSearch(q){
  const ql=q.toLowerCase(), out=[];
  CITIES.forEach(city=>{
    const cl=city.c.toLowerCase(),nl=city.n.toLowerCase();
    let sc=0;
    if(cl===ql)sc=100; else if(cl.startsWith(ql))sc=85;
    else if(cl.includes(ql))sc=65; else if(nl.startsWith(ql))sc=45;
    else if(nl.includes(ql))sc=25;
    if(sc>0)out.push({...city,sc});
  });
  return out.sort((a,b)=>b.sc-a.sc||a.c.localeCompare(b.c)).slice(0,14);
}
function renderDropdown(results){
  if(!results.length){$('#city-dropdown').addClass('hidden').empty();return;}
  let html='';
  results.forEach((c,i)=>{
    html+=`<div class="dropdown-item" data-idx="${i}" data-city="${c.c}" data-country="${c.n}" data-tz="${c.tz}" data-method="${c.m}">
      <div class="d-city">${c.f} ${c.c}</div>
      <div class="d-meta">${c.n} &nbsp;·&nbsp; <span class="d-tz">${getTZOffset(c.tz)}</span></div>
    </div>`;
  });
  html+=`<div class="d-count">${results.length} dari ${CITIES.length}+ kota</div>`;
  $('#city-dropdown').html(html).removeClass('hidden');
  kbdIdx=-1;
}

$('#city-search').on('input',function(){
  clearTimeout(searchTimer);
  const q=$(this).val().trim();
  $('#clear-btn').toggleClass('hidden',q.length===0);
  if(q.length<2){$('#city-dropdown').addClass('hidden').empty();return;}
  searchTimer=setTimeout(()=>renderDropdown(scoreSearch(q)),100);
});
$('#clear-btn').on('click',function(){$('#city-search').val('').trigger('input').focus();$(this).addClass('hidden');});
$('#city-search').on('keydown',function(e){
  const items=$('#city-dropdown .dropdown-item');
  if(e.key==='ArrowDown'){e.preventDefault();kbdIdx=Math.min(kbdIdx+1,items.length-1);items.removeClass('kbd-focus').eq(kbdIdx).addClass('kbd-focus');}
  else if(e.key==='ArrowUp'){e.preventDefault();kbdIdx=Math.max(kbdIdx-1,0);items.removeClass('kbd-focus').eq(kbdIdx).addClass('kbd-focus');}
  else if(e.key==='Enter'){e.preventDefault();const t=kbdIdx>=0?items.eq(kbdIdx):items.eq(0);if(t.length)t.trigger('click');}
  else if(e.key==='Escape'){$('#city-dropdown').addClass('hidden');kbdIdx=-1;}
});
$(document).on('click','.dropdown-item',function(){
  const city=$(this).data('city'),country=$(this).data('country'),tz=$(this).data('tz')||'Asia/Jakarta',method=parseInt($(this).data('method'))||11;
  $('#city-search').val(`${city}, ${country}`);$('#clear-btn').removeClass('hidden');
  $('#city-dropdown').addClass('hidden');kbdIdx=-1;
  setCity(city,country,tz,method);
});
$(document).on('click',function(e){
  if(!$(e.target).closest('#city-search,#city-dropdown,#clear-btn').length){$('#city-dropdown').addClass('hidden');kbdIdx=-1;}
});
$('#search-btn').on('click',function(){
  const q=$('#city-search').val().trim();
  if(!q)return;
  const r=scoreSearch(q);
  if(r.length){const c=r[0];$('#city-search').val(`${c.c}, ${c.n}`);$('#clear-btn').removeClass('hidden');setCity(c.c,c.n,c.tz,c.m);}
  else{const p=q.split(',').map(s=>s.trim());setCity(p[0],p[1]||currentCountry,currentTZ,parseInt($('#method-select').val()));}
  $('#city-dropdown').addClass('hidden');
});
$('#method-select').on('change',function(){fetchPrayerTimes(currentCity,currentCountry,parseInt($(this).val()));});

// ────────────────────────────────────────────────────────────────
//  NAV TABS
// ────────────────────────────────────────────────────────────────
$('.nav-tab').on('click',function(){
  const tab=$(this).data('tab');
  $('.nav-tab').removeClass('active');
  $(this).addClass('active');
  $('.section-panel').removeClass('active');
  $(`#tab-${tab}`).addClass('active');
  if(tab==='progress') renderYearProgress();
});

// ────────────────────────────────────────────────────────────────
//  TOAST
// ────────────────────────────────────────────────────────────────
function showToast(msg,type='success'){
  const s=type==='error'?'background:rgba(224,92,92,.92);color:#fff':'background:rgba(201,168,76,.95);color:#0A0E1A';
  $('#toast').attr('style',s+';min-width:160px;text-align:center;position:fixed;bottom:24px;left:50%;transform:translateX(-50%);padding:9px 20px;border-radius:12px;font-family:Lora,serif;font-weight:600;font-size:.82rem;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,.5);').text(msg).addClass('show');
  setTimeout(()=>$('#toast').removeClass('show'),3000);
}

// ────────────────────────────────────────────────────────────────
//  GEOLOCATION
// ────────────────────────────────────────────────────────────────
function tryGeolocation(){
  if(!navigator.geolocation){loadDefault();return;}
  navigator.geolocation.getCurrentPosition(pos=>{
    const{latitude:lat,longitude:lon}=pos.coords;
    $.ajax({
      url:`https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=11`,
      success(res){
        if(res.code===200){
          $.ajax({
            url:`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`,
            headers:{'Accept-Language':'id'},
            success(geo){
              const raw=geo.address.city||geo.address.town||geo.address.village||geo.address.county||'Kota Anda';
              const country=geo.address.country||'';
              const match=CITIES.find(c=>c.c.toLowerCase()===raw.toLowerCase())
                ||CITIES.find(c=>raw.toLowerCase().includes(c.c.toLowerCase()))
                ||CITIES.find(c=>c.c.toLowerCase().includes(raw.toLowerCase().split(' ')[0]));
              currentTZ=match?match.tz:(Intl.DateTimeFormat().resolvedOptions().timeZone||'UTC');
              currentCity=raw; currentCountry=country;
              $('#city-search').val(`${raw}, ${country}`);$('#clear-btn').removeClass('hidden');
              $('#current-location-label').text(`📍 ${raw}, ${country}`);
              if(match)$('#method-select').val(match.m);
              renderPrayerTimes(res.data);
              if(res.data.date?.hijri){const h=res.data.date.hijri;$('#hijri-date').text(`${h.day} ${h.month.en} ${h.year} H`);}
              else $('#hijri-date').text(toHijri(new Date()));
              showToast(`📍 ${raw}`);
            },
            error(){currentTZ=Intl.DateTimeFormat().resolvedOptions().timeZone||'UTC';renderPrayerTimes(res.data);}
          });
        }else loadDefault();
      },error(){loadDefault();}
    });
  },()=>loadDefault());
}

function loadDefault(){
  $('#hijri-date').text(toHijri(new Date()));
  $('#current-location-label').text('Jakarta, Indonesia');
  setCity('Jakarta','Indonesia','Asia/Jakarta',11);
}

// ────────────────────────────────────────────────────────────────
//  INIT
// ────────────────────────────────────────────────────────────────
$(document).ready(function(){
  $('#hijri-date').text(toHijri(new Date()));
  updateClock();
  setInterval(updateClock,1000);
  // Year progress updates every second
  setInterval(()=>{
    if($('#tab-progress').hasClass('active')) renderYearProgress();
  },1000);
  tryGeolocation();
});
</script>
</body>
</html>