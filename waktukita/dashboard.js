(function () {
  'use strict';

  // ---------- theme ----------
  const THEME_KEY = 'dashboard.theme';
  const themeBtns = document.querySelectorAll('[data-theme-btn]');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const savedTheme = localStorage.getItem(THEME_KEY) || (prefersDark ? 'dark' : 'light');
  applyThemeRaw(savedTheme);
  themeBtns.forEach(b => b.addEventListener('click', ev => switchTheme(b.dataset.themeBtn, ev)));

  function applyThemeRaw(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem(THEME_KEY, t);
    themeBtns.forEach(b => b.setAttribute('aria-pressed', String(b.dataset.themeBtn === t)));
    if (window.__map) applyMapTiles(t);
  }

  function switchTheme(t, ev) {
    const root = document.documentElement;
    if (root.getAttribute('data-theme') === t) return;
    const cx = ev ? (ev.clientX / window.innerWidth * 100) : 90;
    const cy = ev ? (ev.clientY / window.innerHeight * 100) : 5;
    root.style.setProperty('--tx', cx + '%');
    root.style.setProperty('--ty', cy + '%');

    const enableFallback = () => {
      root.classList.add('theme-anim');
      setTimeout(() => root.classList.remove('theme-anim'), 600);
    };

    if (document.startViewTransition && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      document.startViewTransition(() => applyThemeRaw(t));
    } else {
      enableFallback();
      applyThemeRaw(t);
    }
  }

  // ---------- clock ----------
  const HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  const BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  const hmEl = document.getElementById('hm');
  const ssEl = document.getElementById('ss');
  const apEl = document.getElementById('ap');
  const dateEl = document.getElementById('dateLine');

  const tzEl = document.getElementById('locTz');
  tzEl.textContent = Intl.DateTimeFormat().resolvedOptions().timeZone || '—';

  function pad(n) { return String(n).padStart(2, '0'); }

  // state must exist before first tick() call below
  let nextAdzan = null; // { name, date, key }
  let adzanTimes = null; // { Fajr: 'HH:MM', ... }

  // ---------- clock format ----------
  const FMT_KEY = 'dashboard.clockFmt';
  const fmtBtns = document.querySelectorAll('[data-fmt-btn]');
  let clockFmt = localStorage.getItem(FMT_KEY) || '24';
  // initial UI sync (tick() runs later after all deps declared)
  fmtBtns.forEach(b => b.setAttribute('aria-pressed', String(b.dataset.fmtBtn === clockFmt)));
  apEl.hidden = (clockFmt !== '12');
  fmtBtns.forEach(b => b.addEventListener('click', () => applyFmt(b.dataset.fmtBtn)));
  function applyFmt(f) {
    clockFmt = (f === '12') ? '12' : '24';
    localStorage.setItem(FMT_KEY, clockFmt);
    fmtBtns.forEach(b => b.setAttribute('aria-pressed', String(b.dataset.fmtBtn === clockFmt)));
    apEl.hidden = (clockFmt !== '12');
    tick();
  }

  // ---------- year progress (must init before tick) ----------
  const yEls = {
    num: document.getElementById('yearNum'),
    end: document.getElementById('yearEnd'),
    next: document.getElementById('yearNext'),
    big: document.getElementById('yearPct'),
    bar: document.getElementById('yearBarFill'),
    barWrap: document.querySelector('.year-bar'),
    date: document.getElementById('yNewDate'),
    pct: document.getElementById('yPct'),
    passed: document.getElementById('yPassed'),
    left: document.getElementById('yLeft'),
  };

  function updateYearProgress(now) {
    const y = now.getFullYear();
    const start = new Date(y, 0, 1, 0, 0, 0, 0);
    const end = new Date(y + 1, 0, 1, 0, 0, 0, 0);
    const total = end - start;
    const elapsed = now - start;
    const pct = (elapsed / total) * 100;

    yEls.num.textContent = y;
    yEls.next.textContent = y + 1;
    yEls.end.textContent = `Dec 31, ${y}`;
    yEls.big.textContent = pct.toFixed(7);
    yEls.bar.style.width = pct.toFixed(4) + '%';
    yEls.barWrap.setAttribute('aria-valuenow', pct.toFixed(2));

    const nd = new Date(y + 1, 0, 1);
    yEls.date.textContent = `${HARI[nd.getDay()]}, 1 Januari ${y + 1}`;
    yEls.pct.textContent = pct.toFixed(2) + '%';
    const dayMs = 86400000;
    const passedDays = Math.floor(elapsed / dayMs);
    const leftDays = Math.ceil((end - now) / dayMs);
    yEls.passed.innerHTML = `${passedDays} <em>hari</em>`;
    yEls.left.innerHTML = `${leftDays} <em>hari</em>`;
  }

  function tick() {
    const now = new Date();
    let h = now.getHours();
    if (clockFmt === '12') {
      const ap = h >= 12 ? 'PM' : 'AM';
      h = h % 12; if (h === 0) h = 12;
      apEl.textContent = ap;
    }
    hmEl.textContent = `${pad(h)}:${pad(now.getMinutes())}`;
    ssEl.textContent = pad(now.getSeconds());
    dateEl.innerHTML = `<strong>${HARI[now.getDay()]}</strong>, ${now.getDate()} ${BULAN[now.getMonth()]} ${now.getFullYear()}`;
    if (nextAdzan) updateCountdown(now);
    updateYearProgress(now);
  }
  tick();
  setInterval(tick, 1000);

  // ---------- state ----------
  const adzanNextName = document.getElementById('adzanNextName');
  const adzanCd = document.getElementById('adzanCd');

  function updateCountdown(now) {
    const diff = nextAdzan.date - now;
    if (diff <= 0) {
      recomputeNextFromList();
      return;
    }
    const h = Math.floor(diff / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    adzanCd.textContent = `${pad(h)}:${pad(m)}:${pad(s)}`;
  }

  // ---------- location ----------
  const locPlace = document.getElementById('locPlace');
  const locRegion = document.getElementById('locRegion');
  const locLat = document.getElementById('locLat');
  const locLon = document.getElementById('locLon');
  const locAcc = document.getElementById('locAcc');
  const lStatus = document.getElementById('lStatus');
  const wStatus = document.getElementById('wStatus');
  const aStatus = document.getElementById('aStatus');
  const lastUpdate = document.getElementById('lastUpdate');
  document.querySelectorAll('#refreshBtn, #refreshBtnCard').forEach(b => b.addEventListener('click', getLocation));

  function getLocation() {
    if (!('geolocation' in navigator)) {
      lStatus.textContent = 'Browser tidak mendukung geolokasi.';
      lStatus.classList.add('err');
      fallbackIP();
      return;
    }
    lStatus.textContent = 'Meminta izin lokasi…';
    lStatus.classList.remove('err');
    navigator.geolocation.getCurrentPosition(
      pos => {
        const { latitude, longitude, accuracy } = pos.coords;
        onLocation(latitude, longitude, accuracy, 'GPS');
      },
      err => {
        lStatus.textContent = `Geolokasi ditolak (${err.message}). Menggunakan estimasi IP…`;
        lStatus.classList.add('err');
        fallbackIP();
      },
      { enableHighAccuracy: true, timeout: 12000, maximumAge: 300000 }
    );
  }

  async function fallbackIP() {
    try {
      const r = await fetch('https://ipapi.co/json/');
      if (!r.ok) throw new Error('IP lookup gagal');
      const d = await r.json();
      onLocation(d.latitude, d.longitude, null, 'IP');
    } catch (e) {
      lStatus.textContent = 'Gagal mendeteksi lokasi.';
      lStatus.classList.add('err');
    }
  }

  async function onLocation(lat, lon, acc, source) {
    locLat.textContent = lat.toFixed(4) + '°';
    locLon.textContent = lon.toFixed(4) + '°';
    locAcc.textContent = acc ? `±${Math.round(acc)} m` : source;
    lStatus.textContent = '';
    lStatus.classList.remove('err');
    lastUpdate.textContent = 'Diperbarui ' + new Date().toLocaleTimeString('id-ID');

    renderMap(lat, lon, acc);
    reverseGeocode(lat, lon);
    fetchWeather(lat, lon);
    fetchAdzan(lat, lon);
  }

  // ---------- map ----------
  const TILES = {
    light: {
      url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
      attribution: '&copy; OpenStreetMap &copy; CARTO'
    },
    dark: {
      url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
      attribution: '&copy; OpenStreetMap &copy; CARTO'
    }
  };

  function applyMapTiles(theme) {
    if (!window.__map || !window.__tileLayer) return;
    const conf = TILES[theme] || TILES.light;
    window.__map.removeLayer(window.__tileLayer);
    window.__tileLayer = L.tileLayer(conf.url, {
      maxZoom: 19, subdomains: 'abcd', attribution: conf.attribution
    }).addTo(window.__map);
  }

  function renderMap(lat, lon, acc) {
    if (typeof L === 'undefined') {
      // Leaflet belum siap — retry
      setTimeout(() => renderMap(lat, lon, acc), 200);
      return;
    }
    const theme = document.documentElement.getAttribute('data-theme') || 'light';
    const conf = TILES[theme] || TILES.light;

    if (!window.__map) {
      window.__map = L.map('map', { zoomControl: true, attributionControl: true })
        .setView([lat, lon], 14);
      window.__tileLayer = L.tileLayer(conf.url, {
        maxZoom: 19, subdomains: 'abcd', attribution: conf.attribution
      }).addTo(window.__map);
      window.__marker = L.circleMarker([lat, lon], {
        radius: 8, color: '#ff3b6b', weight: 3,
        fillColor: '#ff3b6b', fillOpacity: .35
      }).addTo(window.__map);
      if (acc) {
        window.__accCircle = L.circle([lat, lon], {
          radius: acc, color: '#ff3b6b', weight: 1,
          fillColor: '#ff3b6b', fillOpacity: .08
        }).addTo(window.__map);
      }
      setTimeout(() => window.__map.invalidateSize(), 150);
    } else {
      window.__map.setView([lat, lon], 14);
      window.__marker.setLatLng([lat, lon]);
      if (window.__accCircle) window.__map.removeLayer(window.__accCircle);
      if (acc) {
        window.__accCircle = L.circle([lat, lon], {
          radius: acc, color: '#ff3b6b', weight: 1,
          fillColor: '#ff3b6b', fillOpacity: .08
        }).addTo(window.__map);
      }
    }
  }

  async function reverseGeocode(lat, lon) {
    try {
      const r = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
      const d = await r.json();
      locPlace.textContent = d.city || d.locality || d.principalSubdivision || 'Lokasi tidak dikenal';
      const parts = [d.principalSubdivision, d.countryName].filter(Boolean);
      locRegion.textContent = parts.join(', ');
    } catch (e) {
      locPlace.textContent = 'Koordinat diketahui';
      locRegion.textContent = '';
    }
  }

  // ---------- weather ----------
  const WMO = {
    0: ['Cerah', '☀️'],
    1: ['Sebagian cerah', '🌤️'], 2: ['Berawan sebagian', '⛅'], 3: ['Mendung', '☁️'],
    45: ['Berkabut', '🌫️'], 48: ['Kabut beku', '🌫️'],
    51: ['Gerimis ringan', '🌦️'], 53: ['Gerimis', '🌦️'], 55: ['Gerimis lebat', '🌦️'],
    56: ['Gerimis dingin', '🌧️'], 57: ['Gerimis dingin lebat', '🌧️'],
    61: ['Hujan ringan', '🌧️'], 63: ['Hujan', '🌧️'], 65: ['Hujan lebat', '🌧️'],
    66: ['Hujan dingin', '🌧️'], 67: ['Hujan dingin lebat', '🌧️'],
    71: ['Salju ringan', '🌨️'], 73: ['Salju', '🌨️'], 75: ['Salju lebat', '🌨️'],
    77: ['Butir salju', '🌨️'],
    80: ['Hujan singkat', '🌦️'], 81: ['Hujan singkat lebat', '🌧️'], 82: ['Hujan deras', '⛈️'],
    85: ['Salju singkat', '🌨️'], 86: ['Salju singkat lebat', '🌨️'],
    95: ['Badai petir', '⛈️'], 96: ['Badai + hujan es', '⛈️'], 99: ['Badai + hujan es besar', '⛈️']
  };

  async function fetchWeather(lat, lon) {
    const wTemp = document.getElementById('wTemp');
    const wCond = document.getElementById('wCond');
    wTemp.textContent = '—';
    wCond.textContent = 'memuat cuaca…';
    wStatus.textContent = '';
    wStatus.classList.remove('err');
    try {
      const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}` +
        `&current=temperature_2m,apparent_temperature,relative_humidity_2m,weather_code,wind_speed_10m,precipitation` +
        `&timezone=auto&wind_speed_unit=kmh`;
      const r = await fetch(url);
      if (!r.ok) throw new Error('HTTP ' + r.status);
      const d = await r.json();
      const c = d.current;
      const [label, icon] = WMO[c.weather_code] || ['—', '•'];
      wTemp.textContent = Math.round(c.temperature_2m) + '°';
      wCond.innerHTML = `<span aria-hidden="true">${icon}</span> ${label}`;
      document.getElementById('wFeels').textContent = Math.round(c.apparent_temperature) + '°C';
      document.getElementById('wHum').textContent = Math.round(c.relative_humidity_2m) + '%';
      document.getElementById('wWind').textContent = Math.round(c.wind_speed_10m) + ' km/j';
      document.getElementById('wPrec').textContent = (c.precipitation ?? 0) + ' mm';
    } catch (e) {
      wStatus.textContent = 'Gagal memuat cuaca: ' + e.message;
      wStatus.classList.add('err');
    }
  }

  // ---------- adzan ----------
  async function fetchAdzan(lat, lon) {
    aStatus.textContent = '';
    aStatus.classList.remove('err');
    try {
      const now = new Date();
      const dd = pad(now.getDate());
      const mm = pad(now.getMonth() + 1);
      const yyyy = now.getFullYear();
      // method 20 = Kemenag RI
      const url = `https://api.aladhan.com/v1/timings/${dd}-${mm}-${yyyy}?latitude=${lat}&longitude=${lon}&method=20`;
      const r = await fetch(url);
      if (!r.ok) throw new Error('HTTP ' + r.status);
      const d = await r.json();
      adzanTimes = d.data.timings;
      document.querySelectorAll('[data-adzan]').forEach(el => {
        const key = el.dataset.adzan;
        const t = adzanTimes[key];
        el.textContent = t || '—';
      });
      recomputeNextFromList();
    } catch (e) {
      aStatus.textContent = 'Gagal memuat jadwal adzan: ' + e.message;
      aStatus.classList.add('err');
    }
  }

  function recomputeNextFromList() {
    if (!adzanTimes) return;
    const order = [
      ['Fajr', 'Subuh'],
      ['Dhuhr', 'Dzuhur'],
      ['Asr', 'Ashar'],
      ['Maghrib', 'Maghrib'],
      ['Isha', 'Isya']
    ];
    const now = new Date();
    let next = null;

    document.querySelectorAll('#adzanList li').forEach(li => {
      li.classList.remove('passed');
      li.dataset.next = 'false';
    });

    for (const [key, label] of order) {
      const t = adzanTimes[key];
      if (!t) continue;
      const [h, m] = t.split(':').map(Number);
      const d = new Date(now);
      d.setHours(h, m, 0, 0);
      const li = document.querySelector(`[data-adzan="${key}"]`).parentElement;
      if (d < now) {
        li.classList.add('passed');
      } else if (!next) {
        next = { name: label, date: d, key };
        li.dataset.next = 'true';
      }
    }
    if (!next) {
      // semua sudah lewat — target Subuh besok
      const [h, m] = adzanTimes.Fajr.split(':').map(Number);
      const d = new Date(now);
      d.setDate(d.getDate() + 1);
      d.setHours(h, m, 0, 0);
      next = { name: 'Subuh (besok)', date: d, key: 'Fajr' };
    }
    nextAdzan = next;
    adzanNextName.textContent = next.name;
  }

  // ---------- boot ----------
  getLocation();

  // refresh cuaca + adzan tiap 15 menit
  setInterval(() => {
    const lat = parseFloat(locLat.textContent);
    const lon = parseFloat(locLon.textContent);
    if (!isNaN(lat) && !isNaN(lon)) {
      fetchWeather(lat, lon);
      fetchAdzan(lat, lon);
    }
  }, 15 * 60 * 1000);
})();
