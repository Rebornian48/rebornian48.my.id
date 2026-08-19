<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jadwal Imsakiyah Digital</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="islamic·imsak" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <style>
    :root {
      --gold: #C9A84C;
      --gold-light: #E8C97A;
      --gold-pale: #F5E6B8;
      --navy: #0A0E1A;
      --navy-mid: #111827;
      --navy-light: #1a2236;
      --teal: #2DD4BF;
      --cream: #FFF8E7;
    }

    * { box-sizing: border-box; }
    body {
      background-color: var(--navy);
      color: var(--cream);
      font-family: 'Lora', serif;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* === GEOMETRIC BACKGROUND === */
    .geo-bg {
      position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
    }
    .geo-bg svg { position: absolute; }

    /* === ORNAMENTAL BORDERS === */
    .ornament-line {
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), var(--gold-light), var(--gold), transparent);
    }
    .ornament-line-thin {
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(201,168,76,0.5), rgba(201,168,76,0.8), rgba(201,168,76,0.5), transparent);
    }

    /* === CARD STYLING === */
    .glass-card {
      background: linear-gradient(135deg, rgba(26,34,54,0.92) 0%, rgba(17,24,39,0.95) 100%);
      border: 1px solid rgba(201,168,76,0.25);
      backdrop-filter: blur(12px);
      position: relative;
      overflow: hidden;
    }
    .glass-card::before {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse at top left, rgba(201,168,76,0.06) 0%, transparent 60%);
      pointer-events: none;
    }

    /* === DIGITAL CLOCK === */
    #clock-display {
      font-family: 'Cinzel', serif;
      font-weight: 900;
      letter-spacing: 0.05em;
      text-shadow: 0 0 40px rgba(201,168,76,0.6), 0 0 80px rgba(201,168,76,0.2);
      background: linear-gradient(180deg, #F5E6B8 0%, #C9A84C 50%, #A07830 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* === PRAYER CARDS === */
    .prayer-card {
      transition: all 0.3s ease;
      border: 1px solid rgba(201,168,76,0.15);
      background: linear-gradient(135deg, rgba(26,34,54,0.8) 0%, rgba(17,24,39,0.9) 100%);
      position: relative;
      overflow: hidden;
    }
    .prayer-card::after {
      content: '';
      position: absolute; bottom: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    .prayer-card:hover::after, .prayer-card.active-prayer::after { transform: scaleX(1); }
    .prayer-card:hover {
      border-color: rgba(201,168,76,0.45);
      transform: translateY(-2px);
      box-shadow: 0 8px 32px rgba(201,168,76,0.12);
    }
    .prayer-card.active-prayer {
      border-color: rgba(201,168,76,0.6);
      background: linear-gradient(135deg, rgba(201,168,76,0.12) 0%, rgba(26,34,54,0.95) 100%);
      box-shadow: 0 0 30px rgba(201,168,76,0.15), inset 0 1px 0 rgba(201,168,76,0.2);
    }

    /* === SEARCH === */
    .search-input {
      background: rgba(26,34,54,0.9);
      border: 1px solid rgba(201,168,76,0.3);
      color: var(--cream);
      font-family: 'Lora', serif;
      transition: all 0.3s ease;
    }
    .search-input:focus {
      outline: none;
      border-color: var(--gold);
      box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
    }
    .search-input::placeholder { color: rgba(245,230,184,0.4); }

    /* === DROPDOWN === */
    #city-dropdown {
      background: var(--navy-light);
      border: 1px solid rgba(201,168,76,0.3);
      box-shadow: 0 20px 60px rgba(0,0,0,0.7);
      max-height: 240px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: var(--gold) transparent;
    }
    .dropdown-item {
      transition: background 0.15s;
      border-bottom: 1px solid rgba(201,168,76,0.08);
      cursor: pointer;
    }
    .dropdown-item:hover { background: rgba(201,168,76,0.12); }
    .dropdown-item .city-name { color: var(--gold-pale); font-weight: 500; }
    .dropdown-item .country-name { color: rgba(245,230,184,0.5); font-size: 0.75rem; }

    /* === COUNTDOWN === */
    #countdown-bar {
      height: 3px;
      background: linear-gradient(90deg, var(--gold), var(--teal));
      transition: width 60s linear;
      border-radius: 9999px;
    }

    /* === ARABIC DATE === */
    .arabic-text {
      font-family: 'Amiri', serif;
      direction: rtl;
    }

    /* === LOADING SPINNER === */
    .spinner {
      width: 40px; height: 40px;
      border: 3px solid rgba(201,168,76,0.2);
      border-top-color: var(--gold);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* === PULSE DOT === */
    .pulse-dot {
      width: 8px; height: 8px;
      background: var(--teal);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(0.8); }
    }

    /* === METHOD SELECT === */
    .method-select {
      background: rgba(26,34,54,0.9);
      border: 1px solid rgba(201,168,76,0.3);
      color: var(--cream);
      font-family: 'Lora', serif;
    }
    .method-select:focus { outline: none; border-color: var(--gold); }
    .method-select option { background: var(--navy-mid); }

    /* === HIJRI BADGE === */
    .hijri-badge {
      background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05));
      border: 1px solid rgba(201,168,76,0.3);
    }

    /* === FADE IN === */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(24px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeInUp 0.6s ease forwards; }
    .fade-in-delay-1 { animation-delay: 0.1s; opacity: 0; }
    .fade-in-delay-2 { animation-delay: 0.2s; opacity: 0; }
    .fade-in-delay-3 { animation-delay: 0.3s; opacity: 0; }
    .fade-in-delay-4 { animation-delay: 0.4s; opacity: 0; }

    /* === CORNER ORNAMENTS === */
    .corner-ornament {
      width: 24px; height: 24px;
      position: absolute;
    }
    .corner-tl { top: 8px; left: 8px; border-top: 2px solid var(--gold); border-left: 2px solid var(--gold); }
    .corner-tr { top: 8px; right: 8px; border-top: 2px solid var(--gold); border-right: 2px solid var(--gold); }
    .corner-bl { bottom: 8px; left: 8px; border-bottom: 2px solid var(--gold); border-left: 2px solid var(--gold); }
    .corner-br { bottom: 8px; right: 8px; border-bottom: 2px solid var(--gold); border-right: 2px solid var(--gold); }

    /* === GLOW CIRCLE === */
    .glow-circle {
      border-radius: 50%;
      background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    /* === SCROLL === */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); border-radius: 3px; }

    /* === NOTIFICATION TOAST === */
    #toast {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      transform: translateY(100px);
      opacity: 0;
    }
    #toast.show { transform: translateY(0); opacity: 1; }

    /* === TABS === */
    .tab-btn {
      transition: all 0.3s;
      border-bottom: 2px solid transparent;
      color: rgba(245,230,184,0.5);
    }
    .tab-btn.active {
      border-bottom-color: var(--gold);
      color: var(--gold-pale);
    }

    /* === RESPONSIVE === */
    @media (max-width: 640px) {
      #clock-display { font-size: 3rem !important; }
    }
  </style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>

<!-- GEOMETRIC BACKGROUND -->
<div class="geo-bg">
  <svg width="100%" height="100%" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" opacity="0.04">
    <defs>
      <pattern id="star8" x="0" y="0" width="120" height="120" patternUnits="userSpaceOnUse">
        <polygon points="60,5 69,42 105,42 76,64 87,100 60,80 33,100 44,64 15,42 51,42" fill="none" stroke="#C9A84C" stroke-width="1"/>
        <polygon points="60,20 65,42 87,42 70,55 76,77 60,65 44,77 50,55 33,42 55,42" fill="none" stroke="#C9A84C" stroke-width="0.5" opacity="0.5"/>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>
  <div class="glow-circle" style="width:600px;height:600px;position:absolute;top:-200px;right:-100px;"></div>
  <div class="glow-circle" style="width:400px;height:400px;position:absolute;bottom:-100px;left:-100px;"></div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-lg text-sm font-medium" style="background:rgba(201,168,76,0.9);color:#0A0E1A;min-width:200px;text-align:center;"></div>

<!-- MAIN WRAPPER -->
<div class="relative z-10 min-h-screen py-6 px-4">
  <div class="max-w-4xl mx-auto">

    <!-- ===== HEADER ===== -->
    <header class="text-center mb-8 fade-in">
      <div class="ornament-line mb-4"></div>
      <div class="flex items-center justify-center gap-3 mb-2">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
          <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2z" fill="none" stroke="#C9A84C" stroke-width="1.5"/>
          <path d="M16 6c3.5 0 6.5 1.5 8.5 4-1.5-0.5-3-0.8-4.5-0.5-2 0.4-3.5 2-5 3.5-2 2-4.5 3-7 2.5C9 16 8 17.5 8 19c0 4 3.5 7 8 7s8-3.5 8-8c0-1 0-2-0.5-3 1-1 2.5-1.5 4-1 0.3 0.8 0.5 1.6 0.5 2.5C28 22 22.6 27 16 27S4 21.5 4 15C4 9 9.4 4 16 4" fill="#C9A84C"/>
        </svg>
        <h1 style="font-family:'Cinzel',serif;font-size:1.6rem;font-weight:700;" class="tracking-widest uppercase" style="color:var(--gold-pale)">
          <span style="background:linear-gradient(180deg,#F5E6B8,#C9A84C);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Jadwal Imsakiyah</span>
        </h1>
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
          <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14 14-6.268 14-14S23.732 2 16 2z" fill="none" stroke="#C9A84C" stroke-width="1.5"/>
          <path d="M16 6c3.5 0 6.5 1.5 8.5 4-1.5-0.5-3-0.8-4.5-0.5-2 0.4-3.5 2-5 3.5-2 2-4.5 3-7 2.5C9 16 8 17.5 8 19c0 4 3.5 7 8 7s8-3.5 8-8c0-1 0-2-0.5-3 1-1 2.5-1.5 4-1 0.3 0.8 0.5 1.6 0.5 2.5C28 22 22.6 27 16 27S4 21.5 4 15C4 9 9.4 4 16 4" fill="#C9A84C"/>
        </svg>
      </div>
      <p style="font-family:'Amiri',serif;font-size:1.3rem;letter-spacing:0.1em;" class="mb-1" style="color:rgba(245,230,184,0.7)">
        <span style="color:rgba(245,230,184,0.7)">مَوَاقِيتُ الصَّلَاةِ</span>
      </p>
      <p style="color:rgba(245,230,184,0.45);font-size:0.8rem;letter-spacing:0.15em;" class="uppercase tracking-widest">Waktu Shalat & Jadwal Puasa Seluruh Dunia</p>
      <div class="ornament-line mt-4"></div>
    </header>

    <!-- ===== DIGITAL CLOCK CARD ===== -->
    <div class="glass-card rounded-2xl p-6 mb-6 fade-in fade-in-delay-1 relative">
      <div class="corner-ornament corner-tl"></div>
      <div class="corner-ornament corner-tr"></div>
      <div class="corner-ornament corner-bl"></div>
      <div class="corner-ornament corner-br"></div>

      <div class="text-center">
        <!-- Clock -->
        <div id="clock-display" style="font-size:4.5rem;line-height:1;">00:00:00</div>
        <div class="ornament-line-thin my-3"></div>

        <!-- Date Row -->
        <div class="flex flex-wrap items-center justify-center gap-4 mt-2">
          <div id="gregorian-date" style="color:rgba(245,230,184,0.7);font-size:0.9rem;" class="font-medium"></div>
          <div class="hijri-badge rounded-full px-4 py-1">
            <span id="hijri-date" class="arabic-text" style="color:var(--gold-light);font-size:0.95rem;"></span>
          </div>
        </div>

        <!-- Location Tag -->
        <div class="flex items-center justify-center gap-2 mt-3">
          <div class="pulse-dot"></div>
          <span id="current-location-label" style="color:rgba(245,230,184,0.6);font-size:0.8rem;letter-spacing:0.05em;" class="uppercase">Mendeteksi lokasi...</span>
        </div>
      </div>
    </div>

    <!-- ===== SEARCH & METHOD ===== -->
    <div class="glass-card rounded-2xl p-5 mb-6 fade-in fade-in-delay-2">
      <div class="flex flex-col sm:flex-row gap-3">
        <!-- City Search -->
        <div class="flex-1 relative">
          <div class="absolute left-3 top-1/2 -translate-y-1/2" style="color:var(--gold);">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          </div>
          <input id="city-search" type="text" placeholder="Cari kota... (contoh: Jakarta, London, Cairo)"
            class="search-input w-full pl-10 pr-4 py-3 rounded-xl text-sm" autocomplete="off">
          <div id="city-dropdown" class="absolute left-0 right-0 top-full mt-1 rounded-xl z-30 hidden"></div>
        </div>
        <!-- Method -->
        <div class="sm:w-56">
          <select id="method-select" class="method-select w-full px-3 py-3 rounded-xl text-sm">
            <option value="2">ISNA (Amerika Utara)</option>
            <option value="1">University of Islamic Sciences</option>
            <option value="3">Muslim World League</option>
            <option value="4">Umm Al-Qura (Makkah)</option>
            <option value="5">Egyptian General</option>
            <option value="8" selected>Gulf Region</option>
            <option value="11">MUI Indonesia</option>
            <option value="12">UOIF (Perancis)</option>
            <option value="15">Turkey</option>
          </select>
        </div>
        <!-- Search Button -->
        <button id="search-btn" class="px-5 py-3 rounded-xl font-semibold text-sm transition-all duration-300"
          style="background:linear-gradient(135deg,#C9A84C,#A07830);color:#0A0E1A;font-family:'Cinzel',serif;letter-spacing:0.05em;"
          onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
          CARI
        </button>
      </div>
    </div>

    <!-- ===== PRAYER TIMES GRID ===== -->
    <div id="prayer-section" class="fade-in fade-in-delay-3">
      <!-- Loading State -->
      <div id="loading-state" class="flex items-center justify-center py-16">
        <div class="text-center">
          <div class="spinner mx-auto mb-4"></div>
          <p style="color:rgba(245,230,184,0.5);font-size:0.85rem;">Memuat waktu shalat...</p>
        </div>
      </div>

      <!-- Prayer Content (hidden initially) -->
      <div id="prayer-content" class="hidden">
        <!-- Next Prayer Countdown -->
        <div class="glass-card rounded-2xl p-4 mb-5 relative overflow-hidden">
          <div class="flex items-center justify-between mb-3">
            <div>
              <p style="color:rgba(245,230,184,0.5);font-size:0.7rem;" class="uppercase tracking-widest mb-1">Shalat Berikutnya</p>
              <p id="next-prayer-name" style="font-family:'Cinzel',serif;color:var(--gold-light);font-size:1.1rem;font-weight:600;"></p>
            </div>
            <div class="text-right">
              <p style="color:rgba(245,230,184,0.5);font-size:0.7rem;" class="uppercase tracking-widest mb-1">Tersisa</p>
              <p id="next-prayer-countdown" style="font-family:'Cinzel',serif;color:var(--teal);font-size:1.3rem;font-weight:700;"></p>
            </div>
          </div>
          <div style="height:4px;background:rgba(255,255,255,0.05);border-radius:9999px;overflow:hidden;">
            <div id="countdown-bar" style="width:100%;"></div>
          </div>
        </div>

        <!-- Prayer Cards Grid -->
        <div id="prayers-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-5"></div>

        <!-- Tabs: Jadwal Minggu -->
        <div class="glass-card rounded-2xl p-5">
          <div class="flex gap-6 border-b mb-4" style="border-color:rgba(201,168,76,0.15);">
            <button class="tab-btn active pb-3 text-sm font-medium" data-tab="today" style="font-family:'Cinzel',serif;letter-spacing:0.04em;">HARI INI</button>
            <button class="tab-btn pb-3 text-sm font-medium" data-tab="week" style="font-family:'Cinzel',serif;letter-spacing:0.04em;">MINGGUAN</button>
          </div>
          <div id="tab-today" class="tab-panel">
            <div id="today-detail-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-2"></div>
          </div>
          <div id="tab-week" class="tab-panel hidden">
            <div id="week-schedule" class="overflow-x-auto"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="text-center mt-8 fade-in fade-in-delay-4">
      <div class="ornament-line-thin mb-4"></div>
      <p style="color:rgba(245,230,184,0.3);font-size:0.75rem;letter-spacing:0.1em;" class="uppercase">
        Data oleh <a href="https://aladhan.com" target="_blank" style="color:var(--gold);text-decoration:none;">AlAdhan API</a> &nbsp;·&nbsp; Dibuat dengan ♥ untuk Umat Islam Dunia
      </p>
      <p class="arabic-text mt-2" style="color:rgba(201,168,76,0.4);font-size:1rem;">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>
    </footer>

  </div>
</div>

<!-- SCRIPT -->
<script>
// ========= WORLD CITIES DATA =========
const CITIES = [
  // Indonesia
  {city:"Jakarta",country:"Indonesia",cc:"ID"},{city:"Surabaya",country:"Indonesia",cc:"ID"},{city:"Bandung",country:"Indonesia",cc:"ID"},
  {city:"Medan",country:"Indonesia",cc:"ID"},{city:"Semarang",country:"Indonesia",cc:"ID"},{city:"Yogyakarta",country:"Indonesia",cc:"ID"},
  {city:"Makassar",country:"Indonesia",cc:"ID"},{city:"Palembang",country:"Indonesia",cc:"ID"},{city:"Depok",country:"Indonesia",cc:"ID"},
  {city:"Tangerang",country:"Indonesia",cc:"ID"},{city:"Batam",country:"Indonesia",cc:"ID"},{city:"Bekasi",country:"Indonesia",cc:"ID"},
  {city:"Aceh",country:"Indonesia",cc:"ID"},{city:"Balikpapan",country:"Indonesia",cc:"ID"},{city:"Pontianak",country:"Indonesia",cc:"ID"},
  {city:"Pekanbaru",country:"Indonesia",cc:"ID"},{city:"Denpasar",country:"Indonesia",cc:"ID"},{city:"Manado",country:"Indonesia",cc:"ID"},
  // Malaysia
  {city:"Kuala Lumpur",country:"Malaysia",cc:"MY"},{city:"Johor Bahru",country:"Malaysia",cc:"MY"},{city:"Penang",country:"Malaysia",cc:"MY"},
  {city:"Ipoh",country:"Malaysia",cc:"MY"},{city:"Kota Kinabalu",country:"Malaysia",cc:"MY"},{city:"Kuching",country:"Malaysia",cc:"MY"},
  // Arab Countries
  {city:"Mecca",country:"Saudi Arabia",cc:"SA"},{city:"Medina",country:"Saudi Arabia",cc:"SA"},{city:"Riyadh",country:"Saudi Arabia",cc:"SA"},
  {city:"Jeddah",country:"Saudi Arabia",cc:"SA"},{city:"Dubai",country:"United Arab Emirates",cc:"AE"},
  {city:"Abu Dhabi",country:"United Arab Emirates",cc:"AE"},{city:"Cairo",country:"Egypt",cc:"EG"},
  {city:"Alexandria",country:"Egypt",cc:"EG"},{city:"Baghdad",country:"Iraq",cc:"IQ"},
  {city:"Amman",country:"Jordan",cc:"JO"},{city:"Beirut",country:"Lebanon",cc:"LB"},
  {city:"Damascus",country:"Syria",cc:"SY"},{city:"Doha",country:"Qatar",cc:"QA"},
  {city:"Kuwait City",country:"Kuwait",cc:"KW"},{city:"Muscat",country:"Oman",cc:"OM"},
  {city:"Manama",country:"Bahrain",cc:"BH"},{city:"Sanaa",country:"Yemen",cc:"YE"},
  // Turkey & Iran
  {city:"Istanbul",country:"Turkey",cc:"TR"},{city:"Ankara",country:"Turkey",cc:"TR"},
  {city:"Tehran",country:"Iran",cc:"IR"},{city:"Isfahan",country:"Iran",cc:"IR"},
  // South Asia
  {city:"Karachi",country:"Pakistan",cc:"PK"},{city:"Lahore",country:"Pakistan",cc:"PK"},
  {city:"Islamabad",country:"Pakistan",cc:"PK"},{city:"Dhaka",country:"Bangladesh",cc:"BD"},
  {city:"Chittagong",country:"Bangladesh",cc:"BD"},{city:"Mumbai",country:"India",cc:"IN"},
  {city:"Delhi",country:"India",cc:"IN"},{city:"Hyderabad",country:"India",cc:"IN"},
  {city:"Colombo",country:"Sri Lanka",cc:"LK"},{city:"Kathmandu",country:"Nepal",cc:"NP"},
  // Southeast Asia
  {city:"Manila",country:"Philippines",cc:"PH"},{city:"Singapore",country:"Singapore",cc:"SG"},
  {city:"Bangkok",country:"Thailand",cc:"TH"},{city:"Ho Chi Minh City",country:"Vietnam",cc:"VN"},
  {city:"Phnom Penh",country:"Cambodia",cc:"KH"},{city:"Yangon",country:"Myanmar",cc:"MM"},
  // East Asia
  {city:"Beijing",country:"China",cc:"CN"},{city:"Shanghai",country:"China",cc:"CN"},
  {city:"Urumqi",country:"China",cc:"CN"},{city:"Tokyo",country:"Japan",cc:"JP"},
  {city:"Seoul",country:"South Korea",cc:"KR"},
  // Central Asia
  {city:"Tashkent",country:"Uzbekistan",cc:"UZ"},{city:"Almaty",country:"Kazakhstan",cc:"KZ"},
  {city:"Bishkek",country:"Kyrgyzstan",cc:"KG"},{city:"Dushanbe",country:"Tajikistan",cc:"TJ"},
  {city:"Ashgabat",country:"Turkmenistan",cc:"TM"},{city:"Kabul",country:"Afghanistan",cc:"AF"},
  // Africa
  {city:"Lagos",country:"Nigeria",cc:"NG"},{city:"Kano",country:"Nigeria",cc:"NG"},
  {city:"Nairobi",country:"Kenya",cc:"KE"},{city:"Addis Ababa",country:"Ethiopia",cc:"ET"},
  {city:"Dakar",country:"Senegal",cc:"SN"},{city:"Accra",country:"Ghana",cc:"GH"},
  {city:"Casablanca",country:"Morocco",cc:"MA"},{city:"Rabat",country:"Morocco",cc:"MA"},
  {city:"Tunis",country:"Tunisia",cc:"TN"},{city:"Tripoli",country:"Libya",cc:"LY"},
  {city:"Algiers",country:"Algeria",cc:"DZ"},{city:"Khartoum",country:"Sudan",cc:"SD"},
  {city:"Mogadishu",country:"Somalia",cc:"SO"},{city:"Dar es Salaam",country:"Tanzania",cc:"TZ"},
  // Europe
  {city:"London",country:"United Kingdom",cc:"GB"},{city:"Paris",country:"France",cc:"FR"},
  {city:"Berlin",country:"Germany",cc:"DE"},{city:"Amsterdam",country:"Netherlands",cc:"NL"},
  {city:"Brussels",country:"Belgium",cc:"BE"},{city:"Rome",country:"Italy",cc:"IT"},
  {city:"Madrid",country:"Spain",cc:"ES"},{city:"Barcelona",country:"Spain",cc:"ES"},
  {city:"Stockholm",country:"Sweden",cc:"SE"},{city:"Oslo",country:"Norway",cc:"NO"},
  {city:"Copenhagen",country:"Denmark",cc:"DK"},{city:"Vienna",country:"Austria",cc:"AT"},
  {city:"Warsaw",country:"Poland",cc:"PL"},{city:"Moscow",country:"Russia",cc:"RU"},
  {city:"Istanbul",country:"Turkey",cc:"TR"},{city:"Athens",country:"Greece",cc:"GR"},
  {city:"Sarajevo",country:"Bosnia and Herzegovina",cc:"BA"},{city:"Skopje",country:"North Macedonia",cc:"MK"},
  // Americas
  {city:"New York",country:"United States",cc:"US"},{city:"Los Angeles",country:"United States",cc:"US"},
  {city:"Chicago",country:"United States",cc:"US"},{city:"Houston",country:"United States",cc:"US"},
  {city:"Detroit",country:"United States",cc:"US"},{city:"Toronto",country:"Canada",cc:"CA"},
  {city:"Montreal",country:"Canada",cc:"CA"},{city:"Vancouver",country:"Canada",cc:"CA"},
  {city:"Buenos Aires",country:"Argentina",cc:"AR"},{city:"São Paulo",country:"Brazil",cc:"BR"},
  {city:"Mexico City",country:"Mexico",cc:"MX"},
  // Oceania
  {city:"Sydney",country:"Australia",cc:"AU"},{city:"Melbourne",country:"Australia",cc:"AU"},
  {city:"Perth",country:"Australia",cc:"AU"},{city:"Auckland",country:"New Zealand",cc:"NZ"},
];

// ========= PRAYER ICONS & NAMES =========
const PRAYER_META = {
  Imsak:   { label: "Imsak",   arabic: "إِمْسَاك", icon: "🌙", color: "#7C3AED" },
  Fajr:    { label: "Subuh",   arabic: "الفَجْر",  icon: "🌅", color: "#C9A84C" },
  Sunrise: { label: "Terbit",  arabic: "الشُّرُوق", icon: "☀️", color: "#F59E0B" },
  Dhuhr:   { label: "Dzuhur",  arabic: "الظُّهْر",  icon: "🌤", color: "#10B981" },
  Asr:     { label: "Ashar",   arabic: "العَصْر",   icon: "🌇", color: "#3B82F6" },
  Maghrib: { label: "Maghrib", arabic: "المَغْرِب",  icon: "🌆", color: "#EF4444" },
  Isha:    { label: "Isya",    arabic: "العِشَاء",   icon: "🌃", color: "#8B5CF6" },
  Midnight:{ label: "Tengah Malam", arabic: "مُنْتَصَف اللَّيل", icon: "🌑", color: "#6B7280" },
};

// ========= STATE =========
let currentPrayerData = null;
let currentCity = "Jakarta";
let currentCountry = "Indonesia";
let currentMethod = 11;
let countdownInterval = null;
let clockInterval = null;
let weekData = [];

// ========= CLOCK =========
function updateClock() {
  const now = new Date();
  const h = String(now.getHours()).padStart(2,'0');
  const m = String(now.getMinutes()).padStart(2,'0');
  const s = String(now.getSeconds()).padStart(2,'0');
  $('#clock-display').text(`${h}:${m}:${s}`);

  const days = ['Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  const dayName = days[now.getDay()];
  const date = now.getDate();
  const month = months[now.getMonth()];
  const year = now.getFullYear();
  $('#gregorian-date').text(`${dayName}, ${date} ${month} ${year}`);
}

// ========= HIJRI DATE =========
function toHijri(date) {
  // Simple Hijri converter
  const jd = Math.floor((14+date.getMonth()+1)/12);
  const y = date.getFullYear() + 4800 - jd;
  const m2 = date.getMonth() + 1 + 12*jd - 3;
  let jdn = date.getDate() + Math.floor((153*m2+2)/5) + 365*y + Math.floor(y/4) - Math.floor(y/100) + Math.floor(y/400) - 32045;
  let l = jdn - 1948440 + 10632;
  let n = Math.floor((l-1)/10631);
  l = l - 10631*n + 354;
  let j = Math.floor((10985-l)/5316)*Math.floor((50*l)/17719) + Math.floor(l/5670)*Math.floor((43*l)/15238);
  l = l - Math.floor((30-j)/15)*Math.floor((17719*j)/50) - Math.floor(j/16)*Math.floor((15238*j)/43) + 29;
  let month = Math.floor((24*(l-1))/709);
  let day = l - Math.floor((709*month)/24);
  let year = 30*n + j - 30;
  const hijriMonths = ['Muharram','Safar','Rabi\'ul Awal','Rabi\'ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya\'ban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'];
  return `${day} ${hijriMonths[month-1]} ${year} H`;
}

// ========= FETCH PRAYER TIMES =========
function fetchPrayerTimes(city, country, method) {
  const url = `https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=${method}`;
  $('#loading-state').show();
  $('#prayer-content').addClass('hidden');

  $.ajax({
    url: url,
    method: 'GET',
    success: function(response) {
      if (response.code === 200 && response.data) {
        currentPrayerData = response.data;
        renderPrayerTimes(response.data);
        fetchHijriDate(response.data.date);
        fetchWeekData(city, country, method);
        showToast(`✓ ${city}, ${country}`);
      } else {
        showToast('Kota tidak ditemukan', 'error');
        $('#loading-state').hide();
      }
    },
    error: function() {
      showToast('Gagal memuat data. Coba lagi.', 'error');
      $('#loading-state').hide();
    }
  });
}

function fetchHijriDate(dateObj) {
  if (dateObj && dateObj.hijri) {
    const h = dateObj.hijri;
    $('#hijri-date').text(`${h.day} ${h.month.en} ${h.year} H`);
  } else {
    $('#hijri-date').text(toHijri(new Date()));
  }
}

// ========= RENDER PRAYER TIMES =========
function renderPrayerTimes(data) {
  const timings = data.timings;
  const PRAYER_ORDER = ['Imsak','Fajr','Sunrise','Dhuhr','Asr','Maghrib','Isha'];

  // Determine current & next prayer
  const now = new Date();
  const nowMins = now.getHours()*60 + now.getMinutes();
  let activePrayer = null;
  let nextPrayer = null;
  let nextPrayerTime = null;

  // Build times in minutes
  const prayerMins = {};
  PRAYER_ORDER.forEach(p => {
    if (timings[p]) {
      const [h,m] = timings[p].split(':').map(Number);
      prayerMins[p] = h*60 + m;
    }
  });

  // Find active and next
  const shalat = ['Imsak','Fajr','Dhuhr','Asr','Maghrib','Isha'];
  for (let i = 0; i < shalat.length; i++) {
    const pMins = prayerMins[shalat[i]];
    const nMins = prayerMins[shalat[i+1]] || (prayerMins[shalat[0]] + 1440);
    if (nowMins >= pMins && nowMins < nMins) {
      activePrayer = shalat[i];
      nextPrayer = shalat[(i+1) % shalat.length];
      nextPrayerTime = prayerMins[nextPrayer] || (prayerMins[shalat[0]] + 1440);
      break;
    }
  }
  if (!nextPrayer) {
    nextPrayer = shalat[0];
    nextPrayerTime = prayerMins[shalat[0]];
  }

  // Render prayer cards
  let cardsHtml = '';
  PRAYER_ORDER.forEach(p => {
    if (!timings[p]) return;
    const meta = PRAYER_META[p];
    const isActive = p === activePrayer;
    const time = timings[p];
    cardsHtml += `
      <div class="prayer-card rounded-xl p-4 ${isActive ? 'active-prayer' : ''}" data-prayer="${p}">
        <div class="text-2xl mb-2">${meta.icon}</div>
        <div class="arabic-text text-xs mb-1" style="color:rgba(245,230,184,0.45);direction:rtl;">${meta.arabic}</div>
        <div style="font-family:'Lora',serif;font-weight:600;color:var(--gold-pale);font-size:0.8rem;" class="uppercase tracking-wide mb-2">${meta.label}</div>
        <div style="font-family:'Cinzel',serif;font-weight:700;font-size:1.3rem;color:${isActive ? 'var(--gold-light)' : 'rgba(245,230,184,0.9)'};">${formatTime(time)}</div>
        ${isActive ? '<div class="mt-2"><span class="text-xs px-2 py-0.5 rounded-full" style="background:rgba(201,168,76,0.2);color:var(--gold-light);">▸ Sekarang</span></div>' : ''}
      </div>
    `;
  });
  $('#prayers-grid').html(cardsHtml);

  // Today detail
  let detailHtml = '';
  PRAYER_ORDER.forEach(p => {
    if (!timings[p]) return;
    const meta = PRAYER_META[p];
    const isActive = p === activePrayer;
    detailHtml += `
      <div class="flex items-center justify-between p-3 rounded-lg ${isActive ? '' : ''}" style="background:rgba(255,255,255,0.02);border:1px solid rgba(201,168,76,${isActive?'0.2':'0.08'});">
        <div class="flex items-center gap-3">
          <span class="text-lg">${meta.icon}</span>
          <div>
            <div style="font-family:'Lora',serif;font-weight:500;color:var(--gold-pale);font-size:0.85rem;">${meta.label}</div>
            <div class="arabic-text text-xs" style="color:rgba(245,230,184,0.4);">${meta.arabic}</div>
          </div>
        </div>
        <div style="font-family:'Cinzel',serif;font-weight:700;font-size:1rem;color:${isActive?'var(--gold-light)':'rgba(245,230,184,0.85)'};">${formatTime(timings[p])}</div>
      </div>
    `;
  });
  $('#today-detail-grid').html(detailHtml);

  // Next prayer countdown
  const meta = PRAYER_META[nextPrayer];
  $('#next-prayer-name').html(`${meta.icon} ${meta.label} <span class="arabic-text text-sm" style="font-weight:400;">(${meta.arabic})</span>`);
  startCountdown(nextPrayerTime, nowMins);

  $('#loading-state').hide();
  $('#prayer-content').removeClass('hidden');
}

function formatTime(timeStr) {
  if (!timeStr) return '--:--';
  const [h,m] = timeStr.split(':');
  return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
}

// ========= COUNTDOWN =========
function startCountdown(targetMins, currentMins) {
  if (countdownInterval) clearInterval(countdownInterval);

  function update() {
    const now = new Date();
    const nowM = now.getHours()*60 + now.getMinutes() + now.getSeconds()/60;
    let diff = targetMins - nowM;
    if (diff < 0) diff += 1440;

    const hours = Math.floor(diff);
    const minutes = Math.floor((diff - hours) * 60);
    const seconds = Math.floor(((diff - hours) * 60 - minutes) * 60);

    $('#next-prayer-countdown').text(
      `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`
    );

    // Bar
    const totalMins = 1440;
    const elapsed = (nowM - (targetMins - totalMins/6 + 1440) % 1440 + 1440) % 1440;
    const pct = Math.min(100, Math.max(0, ((totalMins/6 - diff) / (totalMins/6)) * 100));
    $('#countdown-bar').css('width', pct + '%');
  }

  update();
  countdownInterval = setInterval(update, 1000);
}

// ========= WEEK DATA =========
function fetchWeekData(city, country, method) {
  const now = new Date();
  const month = now.getMonth() + 1;
  const year = now.getFullYear();
  const url = `https://api.aladhan.com/v1/calendarByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=${method}&month=${month}&year=${year}`;

  $.ajax({
    url: url,
    method: 'GET',
    success: function(res) {
      if (res.code === 200) {
        weekData = res.data.slice(0, 7);
        renderWeekTable();
      }
    }
  });
}

function renderWeekTable() {
  const dayNames = ['Ahad','Sen','Sel','Rab','Kam','Jum','Sab'];
  let html = `<table class="w-full text-xs" style="border-collapse:separate;border-spacing:0 4px;">
    <thead>
      <tr>
        <th class="py-2 px-3 text-left" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;letter-spacing:0.08em;">TANGGAL</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">IMSAK</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">SUBUH</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">DZUHUR</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">ASHAR</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">MAGHRIB</th>
        <th class="py-2 px-2 text-center" style="color:var(--gold);font-family:'Cinzel',serif;font-size:0.7rem;">ISYA</th>
      </tr>
    </thead>
    <tbody>`;

  const today = new Date().getDate();
  weekData.forEach(d => {
    const dateNum = parseInt(d.date.gregorian.day);
    const dayIdx = new Date(d.date.gregorian.date).getDay();
    const isToday = dateNum === today;
    const bg = isToday ? 'rgba(201,168,76,0.08)' : 'rgba(255,255,255,0.01)';
    const border = isToday ? 'rgba(201,168,76,0.3)' : 'rgba(201,168,76,0.06)';
    html += `<tr style="background:${bg};border:1px solid ${border};border-radius:8px;">
      <td class="py-2 px-3 rounded-l-lg" style="color:${isToday?'var(--gold-light)':'rgba(245,230,184,0.6)'};font-weight:${isToday?'600':'400'};">
        ${dayNames[dayIdx]} ${dateNum}
      </td>
      <td class="py-2 px-2 text-center" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Imsak)}</td>
      <td class="py-2 px-2 text-center" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Fajr)}</td>
      <td class="py-2 px-2 text-center" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Dhuhr)}</td>
      <td class="py-2 px-2 text-center" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Asr)}</td>
      <td class="py-2 px-2 text-center" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Maghrib)}</td>
      <td class="py-2 px-2 text-center rounded-r-lg" style="font-family:'Cinzel',serif;color:${isToday?'var(--gold-pale)':'rgba(245,230,184,0.55)'};">${formatTime(d.timings.Isha)}</td>
    </tr>`;
  });

  html += '</tbody></table>';
  $('#week-schedule').html(html);
}

// ========= CITY SEARCH =========
let searchTimeout = null;

$('#city-search').on('input', function() {
  clearTimeout(searchTimeout);
  const q = $(this).val().trim().toLowerCase();
  if (q.length < 2) { $('#city-dropdown').addClass('hidden').empty(); return; }

  searchTimeout = setTimeout(() => {
    const results = CITIES.filter(c =>
      c.city.toLowerCase().includes(q) || c.country.toLowerCase().includes(q)
    ).slice(0, 8);

    if (results.length === 0) { $('#city-dropdown').addClass('hidden').empty(); return; }

    let html = '';
    results.forEach(c => {
      html += `<div class="dropdown-item px-4 py-3" data-city="${c.city}" data-country="${c.country}">
        <div class="city-name">${c.city}</div>
        <div class="country-name">${c.country}</div>
      </div>`;
    });
    $('#city-dropdown').html(html).removeClass('hidden');
  }, 150);
});

$(document).on('click', '.dropdown-item', function() {
  const city = $(this).data('city');
  const country = $(this).data('country');
  currentCity = city;
  currentCountry = country;
  $('#city-search').val(`${city}, ${country}`);
  $('#city-dropdown').addClass('hidden');
  $('#current-location-label').text(`${city}, ${country}`);
  fetchPrayerTimes(city, country, parseInt($('#method-select').val()));
});

$(document).on('click', function(e) {
  if (!$(e.target).closest('#city-search, #city-dropdown').length) {
    $('#city-dropdown').addClass('hidden');
  }
});

$('#city-search').on('keydown', function(e) {
  if (e.key === 'Enter') {
    const first = $('#city-dropdown .dropdown-item').first();
    if (first.length) first.trigger('click');
    else {
      const val = $(this).val().trim();
      if (val) {
        const parts = val.split(',').map(s=>s.trim());
        currentCity = parts[0];
        currentCountry = parts[1] || 'Indonesia';
        fetchPrayerTimes(currentCity, currentCountry, parseInt($('#method-select').val()));
        $('#city-dropdown').addClass('hidden');
      }
    }
  }
});

// ========= SEARCH BUTTON =========
$('#search-btn').on('click', function() {
  const val = $('#city-search').val().trim();
  if (val) {
    const parts = val.split(',').map(s=>s.trim());
    currentCity = parts[0];
    currentCountry = parts[1] || currentCountry;
    $('#current-location-label').text(`${currentCity}, ${currentCountry}`);
    fetchPrayerTimes(currentCity, currentCountry, parseInt($('#method-select').val()));
  } else {
    fetchPrayerTimes(currentCity, currentCountry, parseInt($('#method-select').val()));
  }
});

$('#method-select').on('change', function() {
  fetchPrayerTimes(currentCity, currentCountry, parseInt($(this).val()));
});

// ========= TABS =========
$(document).on('click', '.tab-btn', function() {
  $('.tab-btn').removeClass('active');
  $(this).addClass('active');
  const tab = $(this).data('tab');
  $('.tab-panel').addClass('hidden');
  $(`#tab-${tab}`).removeClass('hidden');
  if (tab === 'week' && weekData.length === 0) {
    fetchWeekData(currentCity, currentCountry, parseInt($('#method-select').val()));
  }
});

// ========= TOAST =========
function showToast(msg, type='success') {
  const colors = type === 'error'
    ? 'background:rgba(239,68,68,0.9);color:white'
    : 'background:rgba(201,168,76,0.95);color:#0A0E1A';
  $('#toast').attr('style', colors+';min-width:200px;text-align:center;position:fixed;bottom:24px;left:50%;transform:translateX(-50%);padding:10px 24px;border-radius:12px;font-family:Lora,serif;font-weight:600;z-index:9999;');
  $('#toast').text(msg).addClass('show');
  setTimeout(() => $('#toast').removeClass('show'), 3000);
}

// ========= GEOLOCATION =========
function tryGeolocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(pos) {
        const lat = pos.coords.latitude;
        const lon = pos.coords.longitude;
        const url = `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=11`;
        $.ajax({
          url: url,
          success: function(res) {
            if (res.code === 200) {
              currentPrayerData = res.data;
              renderPrayerTimes(res.data);
              fetchHijriDate(res.data.date);
              // Try reverse geocode from Nominatim
              $.ajax({
                url: `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`,
                headers: {'Accept-Language':'id'},
                success: function(geo) {
                  const city = geo.address.city || geo.address.town || geo.address.state || 'Kota Anda';
                  const country = geo.address.country || '';
                  currentCity = city;
                  currentCountry = country;
                  $('#current-location-label').text(`📍 ${city}, ${country}`);
                  $('#city-search').val(`${city}, ${country}`);
                  showToast(`📍 ${city}`);
                  fetchWeekData(city, country, 11);
                },
                error: function() {
                  $('#current-location-label').text('📍 Lokasi Terdeteksi');
                  showToast('📍 Lokasi GPS terdeteksi');
                }
              });
            }
          },
          error: function() {
            loadDefault();
          }
        });
      },
      function() { loadDefault(); }
    );
  } else {
    loadDefault();
  }
}

function loadDefault() {
  $('#current-location-label').text('Jakarta, Indonesia');
  fetchPrayerTimes('Jakarta', 'Indonesia', 11);
}

// ========= INIT =========
$(document).ready(function() {
  // Start clock
  updateClock();
  clockInterval = setInterval(updateClock, 1000);

  // Initial hijri
  $('#hijri-date').text(toHijri(new Date()));

  // Try geolocation first, fallback to Jakarta
  tryGeolocation();
});
</script>
</body>
</html>