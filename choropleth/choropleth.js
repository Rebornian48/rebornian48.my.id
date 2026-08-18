// ═══════════════════════════════════════════════════════
// CONSTANTS
// ═══════════════════════════════════════════════════════
const GEOJSON_URL = '/assets/json/provinsi.json';

const PROVINCE_NAMES = [
  "Aceh","Sumatera Utara","Sumatera Barat","Riau","Jambi",
  "Sumatera Selatan","Bengkulu","Lampung","Kepulauan Bangka Belitung",
  "Kepulauan Riau","DKI Jakarta","Jawa Barat","Jawa Tengah",
  "DI Yogyakarta","Jawa Timur","Banten","Bali",
  "Nusa Tenggara Barat","Nusa Tenggara Timur","Kalimantan Barat",
  "Kalimantan Tengah","Kalimantan Selatan","Kalimantan Timur",
  "Kalimantan Utara","Sulawesi Utara","Sulawesi Tengah",
  "Sulawesi Selatan","Sulawesi Tenggara","Gorontalo","Sulawesi Barat",
  "Maluku","Maluku Utara","Papua Barat","Papua",
  "Papua Selatan","Papua Tengah","Papua Pegunungan","Papua Barat Daya"
];

const REGIONS = {
  "Sumatera":       ["Aceh","Sumatera Utara","Sumatera Barat","Riau","Jambi","Sumatera Selatan","Bengkulu","Lampung","Kepulauan Bangka Belitung","Kepulauan Riau"],
  "Jawa":           ["DKI Jakarta","Jawa Barat","Jawa Tengah","DI Yogyakarta","Jawa Timur","Banten"],
  "Bali & Nusa Tenggara": ["Bali","Nusa Tenggara Barat","Nusa Tenggara Timur"],
  "Kalimantan":     ["Kalimantan Barat","Kalimantan Tengah","Kalimantan Selatan","Kalimantan Timur","Kalimantan Utara"],
  "Sulawesi":       ["Sulawesi Utara","Sulawesi Tengah","Sulawesi Selatan","Sulawesi Tenggara","Gorontalo","Sulawesi Barat"],
  "Maluku":         ["Maluku","Maluku Utara"],
  "Papua":          ["Papua Barat","Papua","Papua Selatan","Papua Tengah","Papua Pegunungan","Papua Barat Daya"]
};

const PROV_REGION = {};
Object.entries(REGIONS).forEach(([r,ps]) => ps.forEach(p => PROV_REGION[p] = r));

const ALIASES = {
  "aceh":"Aceh","nanggroe aceh darussalam":"Aceh","nad":"Aceh",
  "sumatera utara":"Sumatera Utara","sumut":"Sumatera Utara","north sumatra":"Sumatera Utara",
  "sumatera barat":"Sumatera Barat","sumbar":"Sumatera Barat",
  "riau":"Riau","jambi":"Jambi",
  "sumatera selatan":"Sumatera Selatan","sumsel":"Sumatera Selatan",
  "bengkulu":"Bengkulu","lampung":"Lampung",
  "kepulauan bangka belitung":"Kepulauan Bangka Belitung","bangka belitung":"Kepulauan Bangka Belitung","babel":"Kepulauan Bangka Belitung",
  "kepulauan riau":"Kepulauan Riau","kepri":"Kepulauan Riau",
  "dki jakarta":"DKI Jakarta","jakarta":"DKI Jakarta",
  "jawa barat":"Jawa Barat","jabar":"Jawa Barat",
  "jawa tengah":"Jawa Tengah","jateng":"Jawa Tengah",
  "di yogyakarta":"DI Yogyakarta","diy":"DI Yogyakarta","yogyakarta":"DI Yogyakarta","daerah istimewa yogyakarta":"DI Yogyakarta",
  "jawa timur":"Jawa Timur","jatim":"Jawa Timur","banten":"Banten","bali":"Bali",
  "nusa tenggara barat":"Nusa Tenggara Barat","ntb":"Nusa Tenggara Barat",
  "nusa tenggara timur":"Nusa Tenggara Timur","ntt":"Nusa Tenggara Timur",
  "kalimantan barat":"Kalimantan Barat","kalbar":"Kalimantan Barat",
  "kalimantan tengah":"Kalimantan Tengah","kalteng":"Kalimantan Tengah",
  "kalimantan selatan":"Kalimantan Selatan","kalsel":"Kalimantan Selatan",
  "kalimantan timur":"Kalimantan Timur","kaltim":"Kalimantan Timur",
  "kalimantan utara":"Kalimantan Utara","kaltara":"Kalimantan Utara",
  "sulawesi utara":"Sulawesi Utara","sulut":"Sulawesi Utara",
  "sulawesi tengah":"Sulawesi Tengah","sulteng":"Sulawesi Tengah",
  "sulawesi selatan":"Sulawesi Selatan","sulsel":"Sulawesi Selatan",
  "sulawesi tenggara":"Sulawesi Tenggara","sultra":"Sulawesi Tenggara",
  "gorontalo":"Gorontalo","sulawesi barat":"Sulawesi Barat","sulbar":"Sulawesi Barat",
  "maluku":"Maluku","maluku utara":"Maluku Utara",
  "papua barat":"Papua Barat","papua":"Papua","papua selatan":"Papua Selatan",
  "papua tengah":"Papua Tengah","papua pegunungan":"Papua Pegunungan","papua barat daya":"Papua Barat Daya",
};

const PROV_NAME_KEYS = ['Provinsi','PROVINSI','provinsi','Province','PROVINCE','Propinsi','PROPINSI','NAME_1','name_1','WADMPR','name','Name','NAME','nm_prov','NM_PROV'];

// ═══════════════════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════════════════
let appMode = 'tunggal';
let mapBy = 'neraca';
let provinceVal   = {};
let provinceProd  = {};
let provinceNeed  = {};
let colorMin = '#eff6ff', colorMax = '#1d4ed8', colorNoData = '#1a2d47';
let numSteps = 5;
let colorMode = 'gradient';
let classColors = [];
let legendVisible = false;
let intervalMode = 'equal';
let customBreaks = [];
let map, geoLayer, geoJsonData, detectedNameKey, tooltip;

// ═══════════════════════════════════════════════════════
// UTILS
// ═══════════════════════════════════════════════════════
function showToast(msg, type='info') {
  const $t = $('#toast');
  $t.html((type==='success'?'✓ ':type==='error'?'✕ ':'ℹ ')+msg)
    .attr('class','toast show '+(type==='error'?'error':type==='success'?'success':''))
    .css('color',type==='success'?'#86efac':type==='error'?'#fca5a5':'#94a3b8');
  clearTimeout(window._tt);
  window._tt = setTimeout(() => $t.removeClass('show'), 3200);
}

function normalizeName(s) {
  return (s||'').toLowerCase().trim()
    .replace(/\s+/g,' ')
    .replace(/^(provinsi|daerah istimewa|daerah khusus ibukota|dki|di)\s+/,'')
    .trim();
}

function matchProvince(raw) {
  if (!raw) return null;
  const n = normalizeName(raw);
  if (ALIASES[n]) return ALIASES[n];
  for (const p of PROVINCE_NAMES) if (normalizeName(p) === n) return p;
  const partial = PROVINCE_NAMES.filter(p => {
    const pn = normalizeName(p);
    return pn.includes(n) || n.includes(pn);
  });
  return partial.length === 1 ? partial[0] : null;
}

function hexToRgb(h) {
  const clean = h.replace('#','');
  if (clean.length === 3) {
    return [
      parseInt(clean[0]+clean[0],16),
      parseInt(clean[1]+clean[1],16),
      parseInt(clean[2]+clean[2],16)
    ];
  }
  return [
    parseInt(clean.slice(0,2),16)||0,
    parseInt(clean.slice(2,4),16)||0,
    parseInt(clean.slice(4,6),16)||0
  ];
}

function rgbToHex(r,g,b) {
  return '#'+[r,g,b].map(v => Math.round(Math.max(0,Math.min(255,v))).toString(16).padStart(2,'0')).join('');
}

function interpolateColor(c1, c2, t) {
  const [r1,g1,b1] = hexToRgb(c1);
  const [r2,g2,b2] = hexToRgb(c2);
  return rgbToHex(r1+(r2-r1)*t, g1+(g2-g1)*t, b1+(b2-b1)*t);
}

function fmtNum(n, dp=2) {
  if (n === null || n === undefined || isNaN(n)) return '—';
  const abs = Math.abs(n);
  if (abs >= 1e9) return (n/1e9).toFixed(dp) + 'M';
  if (abs >= 1e6) return (n/1e6).toFixed(dp) + 'jt';
  if (abs >= 1e3) return n.toLocaleString('id-ID');
  return Number.isInteger(n) ? n.toLocaleString('id-ID') : n.toFixed(dp);
}

function fmtPct(n) {
  if (n === null || n === undefined || isNaN(n) || !isFinite(n)) return '—';
  return (n >= 0 ? '+' : '') + n.toFixed(2) + '%';
}

function parseNumSafe(str) {
  if (str === null || str === undefined || str === '') return null;
  if (typeof str === 'number') return isNaN(str) ? null : str;
  let s = String(str).trim().replace(/[^\d.,\-]/g, '');
  if (!s || s === '-' || s === '.' || s === ',') return null;
  const lastComma = s.lastIndexOf(','), lastDot = s.lastIndexOf('.');
  if (lastComma > -1 && lastDot > -1) {
    if (lastComma > lastDot) s = s.replace(/\./g, '').replace(',', '.');
    else s = s.replace(/,/g, '');
  } else if (lastComma > -1) {
    s = (/,\d{1,2}$/.test(s) && (s.match(/,/g) || []).length === 1)
        ? s.replace(',', '.')
        : s.replace(/,/g, '');
  } else if (lastDot > -1) {
    if (/^-?\d{1,3}(\.\d{3})+$/.test(s)) s = s.replace(/\./g, '');
  }
  const v = parseFloat(s);
  return isNaN(v) ? null : v;
}

// ═══════════════════════════════════════════════════════
// BREAKS & COLOR
// ═══════════════════════════════════════════════════════
function getBreaks(min, max) {
  if (min === max) return [min, max];
  if (intervalMode === 'custom' && customBreaks.length > 0) {
    const valid = customBreaks.filter(b => b > min && b < max).sort((a,b) => a-b);
    return [min, ...valid, max];
  }
  const breaks = [];
  for (let i = 0; i <= numSteps; i++) breaks.push(min + (max-min) * i / numSteps);
  return breaks;
}

function getColorForValue(val, min, max) {
  if (val === null || val === undefined || isNaN(val)) return colorNoData;
  if (max === min) return colorMax;
  const breaks = getBreaks(min, max);
  const n = breaks.length - 1;
  if (n <= 0) return colorMax;
  let cls = n - 1;
  for (let i = 0; i < n; i++) {
    if (val <= breaks[i+1]) { cls = i; break; }
  }
  if (colorMode === 'perclass' && classColors.length === n) {
    return classColors[cls];
  }
  const t = n === 1 ? 1 : cls / (n - 1);
  return interpolateColor(colorMin, colorMax, t);
}

function syncClassColors(n) {
  if (classColors.length !== n) {
    classColors = [];
    for (let i = 0; i < n; i++) {
      classColors.push(interpolateColor(colorMin, colorMax, n===1 ? 1 : i/(n-1)));
    }
  }
}

function getClassColor(i, n) {
  if (colorMode === 'perclass' && classColors.length === n) return classColors[i];
  const t = n === 1 ? 1 : i / (n - 1);
  return interpolateColor(colorMin, colorMax, t);
}

// ═══════════════════════════════════════════════════════
// COMPUTED VALUES
// ═══════════════════════════════════════════════════════
function getMapValue(prov) {
  if (appMode === 'tunggal') return provinceVal[prov] ?? null;
  const prod = provinceProd[prov] ?? null;
  const need = provinceNeed[prov] ?? null;
  if (prod === null && need === null) return null;
  const p = prod ?? 0, ne = need ?? 0;
  if (mapBy === 'produksi') return p;
  if (mapBy === 'kebutuhan') return ne;
  const neraca = p - ne;
  if (mapBy === 'neraca') return neraca;
  if (mapBy === 'persen') return ne !== 0 ? (neraca/ne)*100 : null;
  return neraca;
}

function getNeracaObj(prov) {
  const prod = provinceProd[prov] ?? null;
  const need = provinceNeed[prov] ?? null;
  const p = prod ?? 0, ne = need ?? 0;
  const neraca = (prod !== null || need !== null) ? p - ne : null;
  const pct = (neraca !== null && ne !== 0) ? (neraca/ne)*100 : null;
  return { prod, need, neraca, pct };
}

function getTotalNational(field) {
  let tot = 0;
  PROVINCE_NAMES.forEach(p => {
    let v = null;
    if (field === 'val') v = provinceVal[p];
    else if (field === 'prod') v = provinceProd[p];
    else if (field === 'need') v = provinceNeed[p];
    if (v !== null && v !== undefined && !isNaN(v)) tot += v;
  });
  return tot;
}

function getRegionalAgg() {
  const agg = {};
  Object.keys(REGIONS).forEach(r => {
    agg[r] = { prod:0, need:0, val:0, hasProd:false, hasNeed:false, hasVal:false };
  });
  PROVINCE_NAMES.forEach(p => {
    const r = PROV_REGION[p]; if (!r) return;
    if (appMode === 'tunggal') {
      const v = provinceVal[p];
      if (v !== null && v !== undefined && !isNaN(v)) { agg[r].val += v; agg[r].hasVal = true; }
    } else {
      const pr = provinceProd[p], ne = provinceNeed[p];
      if (pr !== null && pr !== undefined && !isNaN(pr)) { agg[r].prod += pr; agg[r].hasProd = true; }
      if (ne !== null && ne !== undefined && !isNaN(ne)) { agg[r].need += ne; agg[r].hasNeed = true; }
    }
  });
  return agg;
}

function getAllMapValues() {
  return PROVINCE_NAMES.map(p => getMapValue(p)).filter(v => v !== null && !isNaN(v));
}

// ═══════════════════════════════════════════════════════
// MAP
// ═══════════════════════════════════════════════════════
let tileLayer = null;
function currentTileUrl() {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark'
    || (!document.documentElement.getAttribute('data-theme') && matchMedia('(prefers-color-scheme: dark)').matches);
  return isDark
    ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
    : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
}
function initMap() {
  map = L.map('map', {
    center: [-2.5, 118], zoom: 5, minZoom: 4, maxZoom: 10,
    zoomControl: false, attributionControl: false
  });
  tileLayer = L.tileLayer(currentTileUrl(), {subdomains:'abcd',maxZoom:19}).addTo(map);
  L.control.zoom({position:'topright'}).addTo(map);
  L.control.attribution({position:'bottomright',prefix:false})
    .addAttribution('&copy; <a href="https://carto.com" style="color:var(--accent)">CartoDB</a>').addTo(map);
}
new MutationObserver(() => {
  if (!tileLayer) return;
  tileLayer.setUrl(currentTileUrl());
  if (typeof renderGeoLayer === 'function' && geoLayer) renderGeoLayer();
}).observe(document.documentElement, {attributes:true, attributeFilter:['data-theme']});

function detectNameKey(features) {
  if (!features || !features.length) return null;
  const p = features[0].properties; if (!p) return null;
  for (const k of PROV_NAME_KEYS) if (p[k] !== undefined) return k;
  return Object.keys(p).find(k => typeof p[k] === 'string') || null;
}

async function loadGeoJSON() {
  try {
    const r = await fetch(GEOJSON_URL);
    if (!r.ok) throw new Error('HTTP ' + r.status);
    return await r.json();
  } catch(e) {
    console.error('GeoJSON load error:', e);
    return null;
  }
}

function getProvinceName(feature) {
  if (!feature.properties) return '';
  if (detectedNameKey) return feature.properties[detectedNameKey] || '';
  for (const k of PROV_NAME_KEYS) if (feature.properties[k] !== undefined) return feature.properties[k];
  return Object.values(feature.properties).find(v => typeof v === 'string') || '';
}

async function loadAndRenderMap() {
  $('#loadingOverlay').show();
  geoJsonData = await loadGeoJSON();
  if (!geoJsonData) {
    showToast('Gagal memuat GeoJSON.', 'error');
    $('#loadingOverlay').hide();
    $('#mapStatus').text('Gagal').css('color','#fca5a5');
    return;
  }
  detectedNameKey = detectNameKey(geoJsonData.features);
  renderGeoLayer();
  $('#mapStatus').text('Siap ✓ · ' + geoJsonData.features.length + ' provinsi').css('color','#86efac');
  showToast('Peta berhasil dimuat!', 'success');
  $('#loadingOverlay').hide();
}

function renderGeoLayer() {
  if (!geoJsonData) return;
  if (geoLayer) { geoLayer.remove(); geoLayer = null; }

  const vals = getAllMapValues();
  const minVal = vals.length ? Math.min(...vals) : 0;
  const maxVal = vals.length ? Math.max(...vals) : 1;

  const breaks = getBreaks(minVal, maxVal);
  const nClasses = Math.max(breaks.length - 1, 1);
  syncClassColors(nClasses);

  geoLayer = L.geoJSON(geoJsonData, {
    style: f => styleFeature(f, minVal, maxVal),
    onEachFeature: (f, l) => {
      l.on({
        mouseover: e => hoverFeature(e, f),
        mouseout: () => { if (tooltip) { tooltip.remove(); tooltip = null; } resetHighlight(); },
        click: e => map.fitBounds(e.target.getBounds(), {maxZoom:8, padding:[20,20]}),
      });
    }
  }).addTo(map);

  updateLegend(minVal, maxVal);
  updateStats(vals);
  rebuildTable();
  updateMapLegendOverlay();
}

function styleFeature(f, minVal, maxVal) {
  const name = getProvinceName(f);
  const matched = matchProvince(name);
  const val = matched ? getMapValue(matched) : undefined;
  const fill = (val !== undefined && val !== null)
    ? getColorForValue(val, minVal, maxVal)
    : colorNoData;
  return {
    fillColor: fill,
    fillOpacity: (val !== undefined && val !== null) ? .83 : .28,
    color: themeColor('--border-strong') || '#14213d', weight: .9, opacity: 1
  };
}

function themeColor(name) {
  return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
}

function hoverFeature(e, feature) {
  const name = getProvinceName(feature);
  const matched = matchProvince(name);
  const unit = $('#dataUnit').val();
  const label = $('#dataLabel').val() || 'Nilai';

  e.target.setStyle({weight:2.5, color: themeColor('--accent') || '#ff3b6b', fillOpacity:.93});
  e.target.bringToFront();

  let html = `<div class="info-tooltip"><div class="prov-name">${matched || name}</div>`;
  if (matched) {
    const region = PROV_REGION[matched] || '—';
    html += `<div style="font-size:10px;color:var(--muted);margin-bottom:6px;">${region}</div>`;
    if (appMode === 'tunggal') {
      const val = provinceVal[matched];
      const natTotal = getTotalNational('val');
      if (val !== undefined && val !== null) {
        const pct = natTotal ? ((val/natTotal)*100) : null;
        html += `<div class="tt-row"><span class="tt-label">${label}</span><span class="tt-val">${fmtNum(val)}${unit?' '+unit:''}</span></div>`;
        html += `<div class="tt-row"><span class="tt-label">% Nasional</span><span class="tt-pct tt-pos">${pct !== null ? pct.toFixed(2)+'%' : '—'}</span></div>`;
      } else {
        html += `<div style="color:var(--muted);font-style:italic;font-size:11px;">Tidak ada data</div>`;
      }
    } else {
      const {prod, need, neraca, pct} = getNeracaObj(matched);
      const hasSome = prod !== null || need !== null;
      if (hasSome) {
        html += `<div class="tt-divider"></div>`;
        if (prod !== null) html += `<div class="tt-row"><span class="tt-label">Produksi</span><span class="tt-val">${fmtNum(prod)}${unit?' '+unit:''}</span></div>`;
        if (need !== null) html += `<div class="tt-row"><span class="tt-label">Kebutuhan</span><span class="tt-val">${fmtNum(need)}${unit?' '+unit:''}</span></div>`;
        if (neraca !== null) {
          const cls = neraca>0?'tt-pos':neraca<0?'tt-neg':'tt-zero';
          html += `<div class="tt-divider"></div>`;
          html += `<div class="tt-row"><span class="tt-label">Neraca</span><span class="tt-pct ${cls}">${fmtNum(neraca)}${unit?' '+unit:''}</span></div>`;
          html += `<div class="tt-row"><span class="tt-label">% Neraca</span><span class="tt-pct ${cls}">${fmtPct(pct)}</span></div>`;
        }
      } else {
        html += `<div style="color:var(--muted);font-style:italic;font-size:11px;">Tidak ada data</div>`;
      }
    }
  } else {
    html += `<div style="color:var(--muted);font-style:italic;font-size:11px;">Provinsi tidak dikenali</div>`;
  }
  html += '</div>';

  if (tooltip) tooltip.remove();
  tooltip = L.popup({closeButton:false, offset:[0,-6], className:'leaflet-hover-popup', maxWidth:240})
    .setLatLng(e.latlng).setContent(html).openOn(map);
}

function resetHighlight() {
  if (!geoLayer) return;
  const vals = getAllMapValues();
  const mn = vals.length ? Math.min(...vals) : 0;
  const mx = vals.length ? Math.max(...vals) : 1;
  geoLayer.setStyle(f => styleFeature(f, mn, mx));
}

// ═══════════════════════════════════════════════════════
// LEGEND & STATS
// ═══════════════════════════════════════════════════════
function renderClassColorsList(n) {
  syncClassColors(n);
  const unit = $('#dataUnit').val();
  const vals = getAllMapValues();
  const minVal = vals.length ? Math.min(...vals) : 0;
  const maxVal = vals.length ? Math.max(...vals) : 100;
  const breaks = getBreaks(minVal, maxVal);
  let html = '';
  for (let i = 0; i < n; i++) {
    const lo = breaks[i] !== undefined ? fmtNum(breaks[i]) : '—';
    const hi = breaks[i+1] !== undefined ? fmtNum(breaks[i+1]) : '—';
    const label = `${lo}${unit?' '+unit:''} – ${hi}${unit?' '+unit:''}`;
    html += `<div class="cls-row">
      <input type="color" class="cls-swatch" data-idx="${i}" value="${classColors[i]}">
      <span class="cls-label" title="${label}">${label}</span>
    </div>`;
  }
  $('#classColorsList').html(html);
  $('#classColorsList .cls-swatch').on('input', function() {
    const idx = parseInt($(this).data('idx'));
    classColors[idx] = this.value;
    renderGeoLayer();
  });
}

function updateLegend(minVal, maxVal) {
  const unit = $('#dataUnit').val();
  if (getAllMapValues().length === 0) {
    $('#legendContent').html('<div style="font-size:11px;color:var(--muted);font-style:italic;">Muat data untuk melihat legenda</div>');
    return;
  }
  const breaks = getBreaks(minVal, maxVal);
  const n = breaks.length - 1;
  if (n <= 0) return;
  syncClassColors(n);
  let html = '';
  for (let i = 0; i < n; i++) {
    const color = getClassColor(i, n);
    const lo = breaks[i], hi = breaks[i+1];
    html += `<div class="legend-item"><div class="legend-swatch" style="background:${color};"></div><span>${fmtNum(lo)}${unit?' '+unit:''} &ndash; ${fmtNum(hi)}${unit?' '+unit:''}</span></div>`;
  }
  html += `<div class="legend-item legend-nodata-row"><div class="legend-swatch" style="background:${colorNoData};"></div><span>Tidak ada data</span></div>`;
  $('#legendContent').html(html);
  if (colorMode === 'perclass') renderClassColorsList(n);
}

function updateMapLegendOverlay() {
  if (!legendVisible) { $('#mapLegendOverlay').addClass('hidden'); return; }
  const unit = $('#dataUnit').val();
  const label = $('#dataLabel').val() || 'Data';
  const vals = getAllMapValues();
  if (!vals.length) { $('#mapLegendOverlay').addClass('hidden'); return; }
  const minVal = Math.min(...vals), maxVal = Math.max(...vals);
  const breaks = getBreaks(minVal, maxVal);
  const n = breaks.length - 1;
  if (n <= 0) return;
  syncClassColors(n);
  $('#mapLegendTitle').text(label);
  let html = '';
  for (let i = 0; i < n; i++) {
    const color = getClassColor(i, n);
    const lo = breaks[i], hi = breaks[i+1];
    html += `<div class="leg-row"><div class="leg-swatch" style="background:${color};"></div><span>${fmtNum(lo)}${unit?' '+unit:''} – ${fmtNum(hi)}${unit?' '+unit:''}</span></div>`;
  }
  html += `<div class="leg-row leg-nodata-row"><div class="leg-swatch" style="background:${colorNoData};"></div><span>Tidak ada data</span></div>`;
  $('#mapLegendItems').html(html);
  $('#mapLegendOverlay').removeClass('hidden');
}

function updateStats(vals) {
  const unit = $('#dataUnit').val();
  if (!vals.length) {
    $('#statMin,#statMax,#statAvg,#statCount').text('—');
    $('#statSurplusCard,#statDeficitCard').addClass('hidden');
    return;
  }
  const mn = Math.min(...vals), mx = Math.max(...vals);
  const avg = vals.reduce((a,b) => a+b, 0) / vals.length;
  $('#statMin').text(fmtNum(mn)+(unit?' '+unit:''));
  $('#statMax').text(fmtNum(mx)+(unit?' '+unit:''));
  $('#statAvg').text(fmtNum(avg)+(unit?' '+unit:''));
  $('#statCount').text(vals.length+'/38');
  if (appMode === 'neraca') {
    const surp = PROVINCE_NAMES.filter(p => { const n=getNeracaObj(p).neraca; return n!==null&&n>0; }).length;
    const defi = PROVINCE_NAMES.filter(p => { const n=getNeracaObj(p).neraca; return n!==null&&n<0; }).length;
    $('#statSurplusCard,#statDeficitCard').removeClass('hidden');
    $('#statSurplus').text(surp+' prov');
    $('#statDeficit').text(defi+' prov');
  } else {
    $('#statSurplusCard,#statDeficitCard').addClass('hidden');
  }
}

// ═══════════════════════════════════════════════════════
// TABLE
// ═══════════════════════════════════════════════════════
function rebuildTable() {
  const unit = $('#dataUnit').val();
  const label = $('#dataLabel').val() || 'Data';
  const natVal = getTotalNational('val');
  const natProd = getTotalNational('prod'), natNeed = getTotalNational('need');
  const natNeraca = natProd - natNeed;
  const natPct = natNeed ? ((natNeraca/natNeed)*100) : null;

  let hd = '<tr>';
  if (appMode === 'tunggal') {
    hd += `<th style="width:30px;">#</th><th>Provinsi</th><th>Regional</th>
           <th>${label}${unit?' ('+unit+')':''}</th><th>% Nasional</th>`;
  } else {
    hd += `<th style="width:30px;">#</th><th>Provinsi</th><th>Regional</th>
           <th>Produksi${unit?' ('+unit+')':''}</th><th>Kebutuhan${unit?' ('+unit+')':''}</th>
           <th>Neraca${unit?' ('+unit+')':''}</th><th>% Neraca</th>`;
  }
  hd += '</tr>';
  $('#tableHead').html(hd);

  let rows = ''; let num = 1;
  const regAgg = getRegionalAgg();

  Object.entries(REGIONS).forEach(([reg, provs]) => {
    provs.forEach(p => {
      let tr = `<tr><td class="mono dim-num">${num++}</td><td>${p}</td><td class="muted-cell" style="font-size:11px;">${reg}</td>`;
      if (appMode === 'tunggal') {
        const v = provinceVal[p] ?? null;
        const pct = (v !== null && natVal) ? ((v/natVal)*100) : null;
        tr += `<td class="mono">${v!==null ? fmtNum(v) : '<span class="muted-cell">—</span>'}</td>`;
        tr += `<td class="mono ${pct!==null?'pct-pos':''}">${pct!==null ? pct.toFixed(2)+'%' : '—'}</td>`;
      } else {
        const {prod, need, neraca, pct} = getNeracaObj(p);
        const nc = neraca!==null ? (neraca>0?'surplus':neraca<0?'deficit':'') : '';
        const pc = pct!==null ? (pct>0?'pct-pos':pct<0?'pct-neg':'pct-zero') : '';
        tr += `<td class="mono">${prod!==null ? fmtNum(prod) : '<span class="muted-cell">—</span>'}</td>`;
        tr += `<td class="mono">${need!==null ? fmtNum(need) : '<span class="muted-cell">—</span>'}</td>`;
        tr += `<td class="mono ${nc}">${neraca!==null ? fmtNum(neraca) : '<span class="muted-cell">—</span>'}</td>`;
        tr += `<td class="mono ${pc}">${pct!==null ? fmtPct(pct) : '—'}</td>`;
      }
      tr += '</tr>';
      rows += tr;
    });

    const agg = regAgg[reg];
    let rtr = `<tr class="row-region"><td></td><td colspan="2">▸ ${reg} (${provs.length} provinsi)</td>`;
    if (appMode === 'tunggal') {
      const rv = agg.hasVal ? agg.val : null;
      const rp = (rv !== null && natVal) ? ((rv/natVal)*100) : null;
      rtr += `<td class="mono">${rv!==null ? fmtNum(rv) : '—'}</td>`;
      rtr += `<td class="mono">${rp!==null ? rp.toFixed(2)+'%' : '—'}</td>`;
    } else {
      const rp = agg.hasProd ? agg.prod : null, rn = agg.hasNeed ? agg.need : null;
      const rner = (rp!==null||rn!==null) ? ((rp??0)-(rn??0)) : null;
      const rpct = (rner!==null && rn) ? ((rner/rn)*100) : null;
      const nc = rner!==null ? (rner>0?'surplus':rner<0?'deficit':'') : '';
      const pc = rpct!==null ? (rpct>0?'pct-pos':rpct<0?'pct-neg':'pct-zero') : '';
      rtr += `<td class="mono">${rp!==null ? fmtNum(rp) : '—'}</td>`;
      rtr += `<td class="mono">${rn!==null ? fmtNum(rn) : '—'}</td>`;
      rtr += `<td class="mono ${nc}">${rner!==null ? fmtNum(rner) : '—'}</td>`;
      rtr += `<td class="mono ${pc}">${rpct!==null ? fmtPct(rpct) : '—'}</td>`;
    }
    rtr += '</tr>';
    rows += rtr;
  });

  let ntr = `<tr class="row-national"><td></td><td colspan="2">🇮🇩 NASIONAL (38 provinsi)</td>`;
  if (appMode === 'tunggal') {
    ntr += `<td class="mono">${natVal ? fmtNum(natVal) : '—'}</td><td class="mono">100%</td>`;
  } else {
    const nc = natNeraca>0?'surplus':natNeraca<0?'deficit':'';
    const pc = natPct!==null ? (natPct>0?'pct-pos':natPct<0?'pct-neg':'pct-zero') : '';
    ntr += `<td class="mono">${fmtNum(natProd)}</td>`;
    ntr += `<td class="mono">${fmtNum(natNeed)}</td>`;
    ntr += `<td class="mono ${nc}">${fmtNum(natNeraca)}</td>`;
    ntr += `<td class="mono ${pc}">${natPct!==null ? fmtPct(natPct) : '—'}</td>`;
  }
  ntr += '</tr>';
  rows += ntr;
  $('#tableBody').html(rows);
}

// ═══════════════════════════════════════════════════════
// MODE
// ═══════════════════════════════════════════════════════
function setMode(mode) {
  appMode = mode;
  $('#tabTunggal').toggleClass('active', mode==='tunggal');
  $('#tabNeraca').toggleClass('active', mode==='neraca');
  if (mode === 'tunggal') {
    $('#modeDesc').text('Tampilkan satu nilai per provinsi dengan persentase terhadap total nasional.');
    $('#csvFormatHint').text('Kolom: Provinsi, Nilai');
    $('#neracaMapBy').addClass('hidden');
  } else {
    $('#modeDesc').text('Input produksi & kebutuhan per provinsi. Neraca = Produksi − Kebutuhan.');
    $('#csvFormatHint').text('Kolom: Provinsi, Produksi, Kebutuhan');
    $('#neracaMapBy').removeClass('hidden');
  }
  onDataChange();
  renderGeoLayer();
}

$('#mapBySelect').on('change', function() { mapBy = $(this).val(); onDataChange(); renderGeoLayer(); });

// ═══════════════════════════════════════════════════════
// DROPDOWNS
// ═══════════════════════════════════════════════════════
const DROPDOWNS = ['#dlDrop', '#tplDrop', '#expDrop'];
function closeAllDropdowns(except) {
  DROPDOWNS.forEach(id => { if (id !== except) $(id).addClass('hidden'); });
}
function toggleDropdown(id) {
  const isHidden = $(id).hasClass('hidden');
  closeAllDropdowns(null);
  if (isHidden) $(id).removeClass('hidden');
  else $(id).addClass('hidden');
}
$('#btnDlToggle').on('click', e => { e.stopPropagation(); toggleDropdown('#dlDrop'); });
$('#btnTemplate').on('click', e => { e.stopPropagation(); toggleDropdown('#tplDrop'); });
$('#btnExportTable').on('click', e => { e.stopPropagation(); toggleDropdown('#expDrop'); });
$(document).on('click', () => closeAllDropdowns(null));
$(DROPDOWNS.join(',')).on('click', e => e.stopPropagation());

// ═══════════════════════════════════════════════════════
// TEMPLATE
// ═══════════════════════════════════════════════════════
function getTemplateData() {
  const label = $('#dataLabel').val() || 'Nilai';
  if (appMode === 'tunggal') {
    return { headers: ['Provinsi', label], rows: PROVINCE_NAMES.map(p => [p, '']) };
  } else {
    return { headers: ['Provinsi', 'Produksi', 'Kebutuhan'], rows: PROVINCE_NAMES.map(p => [p, '', '']) };
  }
}
$('#btnTplCSV').on('click', function() {
  $('#tplDrop').addClass('hidden');
  const {headers, rows} = getTemplateData();
  const csv = [headers.join(','), ...rows.map(r => r.join(','))].join('\n');
  dlBlob(new Blob([csv], {type:'text/csv;charset=utf-8;'}), 'template_peta_indonesia.csv');
  showToast('Template CSV diunduh!', 'success');
});
$('#btnTplXLSX').on('click', function() {
  $('#tplDrop').addClass('hidden');
  const {headers, rows} = getTemplateData();
  const ws = XLSX.utils.aoa_to_sheet([headers, ...rows]);
  ws['!cols'] = headers.map(h => ({wch: Math.max(h.length+4, 18)}));
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Template');
  XLSX.writeFile(wb, 'template_peta_indonesia.xlsx');
  showToast('Template Excel diunduh!', 'success');
});

// ═══════════════════════════════════════════════════════
// UPLOAD
// ═══════════════════════════════════════════════════════
$('#csvUpload').on('change', function(e) {
  const file = e.target.files[0]; if (!file) return;
  const name = file.name.toLowerCase();
  if (name.endsWith('.xlsx') || name.endsWith('.xls')) {
    const reader = new FileReader();
    reader.onload = ev => {
      try {
        const data = new Uint8Array(ev.target.result);
        const wb = XLSX.read(data, {type:'array'});
        const ws = wb.Sheets[wb.SheetNames[0]];
        const rows = XLSX.utils.sheet_to_json(ws, {defval:''});
        if (!rows.length) { showToast('File Excel kosong atau tidak dapat dibaca.', 'error'); return; }
        const fields = Object.keys(rows[0]);
        processCSV(rows, fields);
      } catch(err) {
        showToast('Gagal membaca file Excel: ' + err.message, 'error');
      }
    };
    reader.onerror = () => showToast('Gagal membaca file.', 'error');
    reader.readAsArrayBuffer(file);
  } else {
    Papa.parse(file, {
      header: true,
      skipEmptyLines: true,
      complete: r => {
        if (r.errors.length && !r.data.length) {
          showToast('Gagal parsing CSV.', 'error'); return;
        }
        processCSV(r.data, r.meta.fields);
      },
      error: err => showToast('Error CSV: ' + err.message, 'error')
    });
  }
  this.value = '';
});

$('.upload-area')
  .on('dragover', e => { e.preventDefault(); $(e.currentTarget).css('border-color','var(--accent)'); })
  .on('dragleave', e => $(e.currentTarget).css('border-color',''))
  .on('drop', function(e) {
    e.preventDefault();
    $(this).css('border-color','');
    const file = e.originalEvent.dataTransfer.files[0];
    if (!file) return;
    Papa.parse(file, {header:true, skipEmptyLines:true, complete: r => processCSV(r.data, r.meta.fields)});
  });

function processCSV(rows, fields) {
  if (!fields || fields.length < 2) { showToast('Format tidak valid: minimal 2 kolom.', 'error'); return; }
  const provCol = fields.find(f => /provinsi|province|prov|nama|name/i.test(f)) || fields[0];
  let matched = 0, unmatched = [];

  if (appMode === 'tunggal') {
    const valCol = fields.find(f => f !== provCol && /nilai|value|data|jumlah|angka|total|index|produksi|prod/i.test(f))
                || fields.find(f => f !== provCol) || fields[1];
    provinceVal = {};
    rows.forEach(row => {
      const raw = row[provCol]; if (!raw) return;
      const prov = matchProvince(String(raw));
      const v = parseNumSafe(row[valCol]);
      if (prov) { provinceVal[prov] = v; matched++; }
      else unmatched.push(raw);
    });
  } else {
    const prodCol = fields.find(f => f !== provCol && /produksi|prod|supply|production/i.test(f))
                 || fields.find(f => f !== provCol) || fields[1];
    const needCol = fields.find(f => f !== provCol && f !== prodCol && /kebutuhan|need|demand|konsumsi/i.test(f))
                 || fields.find(f => f !== provCol && f !== prodCol) || fields[2];
    provinceProd = {}; provinceNeed = {};
    rows.forEach(row => {
      const raw = row[provCol]; if (!raw) return;
      const prov = matchProvince(String(raw));
      const p = parseNumSafe(row[prodCol]);
      const n = parseNumSafe(row[needCol]);
      if (prov) { provinceProd[prov] = p; provinceNeed[prov] = n; matched++; }
      else unmatched.push(raw);
    });
  }

  if (matched === 0) {
    showToast('Tidak ada provinsi yang cocok. Periksa nama kolom Provinsi.', 'error');
    return;
  }
  onDataChange();
  renderGeoLayer();
  const unmatchedMsg = unmatched.length ? ` ${unmatched.length} tidak cocok: ${unmatched.slice(0,3).join(', ')}${unmatched.length>3?'…':''}` : '';
  showToast(`${matched} provinsi dimuat.${unmatchedMsg}`, matched > 0 ? 'success' : 'error');
}

// ═══════════════════════════════════════════════════════
// MANUAL EDIT
// ═══════════════════════════════════════════════════════
function buildManualTable() {
  const isN = appMode === 'neraca';
  $('#modalTitle').text(isN ? 'Edit Produksi & Kebutuhan' : 'Edit Data Manual');
  $('#modalSubtitle').text(isN ? 'Isi produksi dan kebutuhan per provinsi' : 'Isi nilai untuk setiap provinsi');
  let head = '<tr><th style="width:28px;">#</th><th>Provinsi</th><th>Regional</th>';
  if (isN) head += '<th>Produksi</th><th>Kebutuhan</th>';
  else head += '<th>Nilai</th>';
  head += '</tr>';
  $('#miHead').html(head);
  let body = '';
  PROVINCE_NAMES.forEach((p, i) => {
    const reg = PROV_REGION[p] || '—';
    body += `<tr><td class="dim-num">${i+1}</td><td style="color:var(--text-soft);">${p}</td><td class="muted-cell" style="font-size:11px;">${reg}</td>`;
    if (isN) {
      const pv = provinceProd[p] ?? '';
      const nv = provinceNeed[p] ?? '';
      body += `<td><input type="number" class="mi-prod" data-prov="${p}" value="${pv!==null?pv:''}" placeholder="—" step="any"></td>`;
      body += `<td><input type="number" class="mi-need" data-prov="${p}" value="${nv!==null?nv:''}" placeholder="—" step="any"></td>`;
    } else {
      const v = provinceVal[p] ?? '';
      body += `<td><input type="number" class="mi-val" data-prov="${p}" value="${v!==null?v:''}" placeholder="—" step="any"></td>`;
    }
    body += '</tr>';
  });
  $('#miBody').html(body);
}

$('#btnManualEdit').on('click', () => { buildManualTable(); $('#modalEdit').addClass('active'); });
$('#btnCloseModal,#btnCancelModal').on('click', () => $('#modalEdit').removeClass('active'));
$('#modalEdit').on('click', function(e) { if (e.target === this) $(this).removeClass('active'); });

$('#btnApplyManual').on('click', () => {
  if (appMode === 'tunggal') {
    provinceVal = {};
    $('.mi-val').each(function() {
      const p = $(this).data('prov'), v = $(this).val();
      if (v !== '' && !isNaN(parseFloat(v))) provinceVal[p] = parseFloat(v);
    });
  } else {
    provinceProd = {}; provinceNeed = {};
    $('.mi-prod').each(function() {
      const p = $(this).data('prov'), v = $(this).val();
      if (v !== '' && !isNaN(parseFloat(v))) provinceProd[p] = parseFloat(v);
    });
    $('.mi-need').each(function() {
      const p = $(this).data('prov'), v = $(this).val();
      if (v !== '' && !isNaN(parseFloat(v))) provinceNeed[p] = parseFloat(v);
    });
  }
  onDataChange();
  renderGeoLayer();
  $('#modalEdit').removeClass('active');
  showToast('Data diterapkan!', 'success');
});

$('#btnFillSample').on('click', () => {
  const samples = [5274871,14799361,5534472,6394087,3548228,8467432,1934269,9007848,1455678,2028169,
                   10770487,48683861,36516035,3668719,41151353,12448696,4317404,5261085,5456186,5414390,
                   2660209,4119794,3553143,697485,2621923,3020276,9073509,2702473,1171681,1419229,
                   1848923,1274273,1134068,4303707,450000,600000,900000,350000];
  if (appMode === 'tunggal') {
    $('.mi-val').each(function(i) { $(this).val(samples[i] || Math.floor(Math.random()*5000000+100000)); });
  } else {
    $('.mi-prod').each(function(i) { $(this).val(samples[i] || Math.floor(Math.random()*5000000+100000)); });
    $('.mi-need').each(function(i) { $(this).val(Math.floor((samples[i]||3000000) * (0.7+Math.random()*0.6))); });
  }
});

$('#btnClearAll').on('click', () => $('.mi-val,.mi-prod,.mi-need').val(''));

// ═══════════════════════════════════════════════════════
// COLOR CONTROLS
// ═══════════════════════════════════════════════════════
function setColorMode(mode) {
  colorMode = mode;
  $('#tabGradient').toggleClass('active', mode==='gradient');
  $('#tabPerClass').toggleClass('active', mode==='perclass');
  $('#gradientMode').toggleClass('hidden', mode==='perclass');
  $('#perclassMode').toggleClass('hidden', mode==='gradient');
  if (mode === 'perclass') {
    classColors = [];
    const vals = getAllMapValues();
    const n = getBreaks(vals.length?Math.min(...vals):0, vals.length?Math.max(...vals):100).length - 1;
    renderClassColorsList(Math.max(n, 1));
  }
  renderGeoLayer();
}

$('#btnSyncFromGradient').on('click', function() {
  classColors = [];
  const vals = getAllMapValues();
  const n = getBreaks(vals.length?Math.min(...vals):0, vals.length?Math.max(...vals):100).length - 1;
  renderClassColorsList(Math.max(n, 1));
  renderGeoLayer();
});

function toggleLegendOverlay() {
  legendVisible = !legendVisible;
  $('#btnToggleLegend').text(legendVisible ? 'Sembunyikan ▴' : 'Tampil di Peta ▾');
  updateMapLegendOverlay();
}

$('#colorMin').on('input', function() {
  colorMin = this.value; $('#colorMinHex').text(colorMin);
  classColors = []; updateGP(); renderGeoLayer();
  $('.color-preset').removeClass('active');
});
$('#colorMax').on('input', function() {
  colorMax = this.value; $('#colorMaxHex').text(colorMax);
  classColors = []; updateGP(); renderGeoLayer();
  $('.color-preset').removeClass('active');
});
$('#colorNoData').on('input', function() {
  colorNoData = this.value; renderGeoLayer(); updateMapLegendOverlay();
});
$('#colorSteps').on('input', function() {
  numSteps = parseInt(this.value);
  $('#stepsLabel').text(numSteps);
  classColors = [];
  if (intervalMode === 'custom') autoFillBreaks();
  renderGeoLayer();
});

function onDataChange() {
  classColors = [];
  if (intervalMode === 'custom') {
    if (customBreaks.length !== numSteps - 1) autoFillBreaks();
    else renderBreakInputs();
  }
}

$('.color-preset').on('click', function() {
  colorMin = $(this).data('min');
  colorMax = $(this).data('max');
  $('#colorMin').val(colorMin); $('#colorMax').val(colorMax);
  $('#colorMinHex').text(colorMin); $('#colorMaxHex').text(colorMax);
  classColors = []; updateGP(); renderGeoLayer();
  $('.color-preset').removeClass('active'); $(this).addClass('active');
});

function updateGP() {
  $('#gradientPreview').css('background', `linear-gradient(to right,${colorMin},${colorMax})`);
}

$('#dataLabel,#dataUnit').on('input', () => {
  const v = getAllMapValues();
  if (v.length) updateLegend(Math.min(...v), Math.max(...v));
  rebuildTable();
  updateMapLegendOverlay();
});

// ═══════════════════════════════════════════════════════
// EXPORT
// ═══════════════════════════════════════════════════════
function buildTableMatrix() {
  const unit = $('#dataUnit').val();
  const label = $('#dataLabel').val() || 'Data';
  const natVal = getTotalNational('val');
  const natProd = getTotalNational('prod'), natNeed = getTotalNational('need');
  const natNer = natProd - natNeed;
  const natPct = natNeed ? (natNer/natNeed*100) : null;
  const regAgg = getRegionalAgg();
  const rows = [];

  if (appMode === 'tunggal') {
    rows.push(['Provinsi','Regional', label+(unit?' ('+unit+')':''), '% Nasional']);
    Object.entries(REGIONS).forEach(([reg, provs]) => {
      provs.forEach(p => {
        const v = provinceVal[p] ?? null;
        const pct = v!==null&&natVal ? +((v/natVal)*100).toFixed(4) : null;
        rows.push([p, reg, v, pct]);
      });
      const rv = regAgg[reg].hasVal ? regAgg[reg].val : null;
      const rp = rv!==null&&natVal ? +((rv/natVal)*100).toFixed(4) : null;
      rows.push(['▸ '+reg+' (Regional)', '', rv, rp]);
    });
    rows.push(['🇮🇩 NASIONAL', '', natVal||null, natVal?100:null]);
  } else {
    rows.push(['Provinsi','Regional','Produksi'+(unit?' ('+unit+')':''),'Kebutuhan'+(unit?' ('+unit+')':''),'Neraca','% Neraca']);
    Object.entries(REGIONS).forEach(([reg, provs]) => {
      provs.forEach(p => {
        const {prod, need, neraca, pct} = getNeracaObj(p);
        rows.push([p, reg, prod, need, neraca, pct!==null?+pct.toFixed(4):null]);
      });
      const rp = regAgg[reg].hasProd ? regAgg[reg].prod : null;
      const rn = regAgg[reg].hasNeed ? regAgg[reg].need : null;
      const rner = (rp!==null||rn!==null) ? ((rp??0)-(rn??0)) : null;
      const rpct = (rner!==null&&rn) ? (rner/rn*100) : null;
      rows.push(['▸ '+reg+' (Regional)', '', rp, rn, rner, rpct!==null?+rpct.toFixed(4):null]);
    });
    rows.push(['🇮🇩 NASIONAL', '', natProd, natNeed, natNer, natPct!==null?+natPct.toFixed(4):null]);
  }
  return rows;
}

function dlBlob(blob, name) {
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a'); a.href = url; a.download = name;
  document.body.appendChild(a); a.click(); document.body.removeChild(a);
  setTimeout(() => URL.revokeObjectURL(url), 3000);
}

$('#btnExpCSV').on('click', function() {
  $('#expDrop').addClass('hidden');
  const rows = buildTableMatrix();
  const csv = rows.map(r => r.map(c => c===null||c===undefined ? '' : String(c)).join(',')).join('\n');
  dlBlob(new Blob([csv], {type:'text/csv;charset=utf-8;'}), 'tabel_peta_indonesia.csv');
  showToast('Tabel CSV diekspor!', 'success');
});

$('#btnExpXLSX').on('click', function() {
  $('#expDrop').addClass('hidden');
  const rows = buildTableMatrix();
  const ws = XLSX.utils.aoa_to_sheet(rows);
  const numCols = rows[0].length;
  const colWidths = Array(numCols).fill(10);
  rows.forEach(row => row.forEach((cell, ci) => {
    const len = String(cell===null||cell===undefined?'':cell).length;
    if (len > colWidths[ci]) colWidths[ci] = len;
  }));
  ws['!cols'] = colWidths.map(w => ({wch: Math.min(w+3, 40)}));
  ws['!freeze'] = {xSplit:0, ySplit:1, topLeftCell:'A2', activePane:'bottomLeft', state:'frozen'};
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Data Provinsi');

  const unit = $('#dataUnit').val();
  const label = $('#dataLabel').val() || 'Data';
  const regAgg = getRegionalAgg();
  const sumRows = [['Kawasan','Provinsi (jml)']];
  if (appMode === 'tunggal') sumRows[0].push(label+(unit?' ('+unit+')':''), '% Nasional');
  else sumRows[0].push('Produksi','Kebutuhan','Neraca','% Neraca');
  const natVal = getTotalNational('val'), natProd = getTotalNational('prod'), natNeed = getTotalNational('need');
  Object.entries(REGIONS).forEach(([reg, provs]) => {
    const agg = regAgg[reg];
    if (appMode === 'tunggal') {
      const rv = agg.hasVal ? agg.val : null;
      const rp = rv!==null&&natVal ? +((rv/natVal)*100).toFixed(4) : null;
      sumRows.push([reg, provs.length, rv, rp]);
    } else {
      const rp = agg.hasProd ? agg.prod : null, rn = agg.hasNeed ? agg.need : null;
      const rner = (rp!==null||rn!==null) ? ((rp??0)-(rn??0)) : null;
      const rpct = (rner!==null&&rn) ? +(rner/rn*100).toFixed(4) : null;
      sumRows.push([reg, provs.length, rp, rn, rner, rpct]);
    }
  });
  if (appMode === 'tunggal') sumRows.push(['NASIONAL', 38, natVal||null, natVal?100:null]);
  else { const nner=natProd-natNeed, npct=natNeed?+(nner/natNeed*100).toFixed(4):null; sumRows.push(['NASIONAL',38,natProd,natNeed,nner,npct]); }
  const ws2 = XLSX.utils.aoa_to_sheet(sumRows);
  ws2['!cols'] = sumRows[0].map((_,ci) => ({wch: Math.max(...sumRows.map(r=>String(r[ci]??'').length))+3}));
  XLSX.utils.book_append_sheet(wb, ws2, 'Rekap Regional');
  XLSX.writeFile(wb, 'tabel_peta_indonesia.xlsx');
  showToast('Tabel Excel diekspor!', 'success');
});

// ═══════════════════════════════════════════════════════
// DOWNLOAD MAP (SVG/PNG)
// ═══════════════════════════════════════════════════════
$('#dlDrop').on('click', '.dl-opt', function() {
  const fmt = $(this).data('fmt');
  $('#dlDrop').addClass('hidden');
  if (!geoJsonData) { showToast('Peta belum dimuat.', 'error'); return; }
  showToast('Menyiapkan ekspor ' + fmt.toUpperCase() + '…');
  setTimeout(() => exportMap(fmt), 100);
});

function toMercator(lng, lat) {
  return [lng * Math.PI/180, Math.log(Math.tan(Math.PI/4 + (lat*Math.PI/180)/2))];
}

function exportMap(fmt) {
  let minMX=Infinity, maxMX=-Infinity, minMY=Infinity, maxMY=-Infinity;
  geoJsonData.features.forEach(f => {
    flattenCoords(f.geometry).forEach(([lng, lat]) => {
      const [mx, my] = toMercator(lng, lat);
      if (mx < minMX) minMX = mx; if (mx > maxMX) maxMX = mx;
      if (my < minMY) minMY = my; if (my > maxMY) maxMY = my;
    });
  });
  const SCALE = fmt==='png' ? 2 : 1;
  const PAD = 24*SCALE, W = 1800*SCALE;
  const mercW = maxMX-minMX, mercH = maxMY-minMY;
  const drawW = W-PAD*2, drawH = drawW*(mercH/mercW), H = Math.round(drawH+PAD*2);
  function project(lng, lat) {
    const [mx, my] = toMercator(lng, lat);
    return [PAD+((mx-minMX)/mercW)*drawW, PAD+((maxMY-my)/mercH)*drawH];
  }
  const vals = getAllMapValues();
  const minVal = vals.length ? Math.min(...vals) : 0;
  const maxVal = vals.length ? Math.max(...vals) : 1;
  if (fmt === 'svg') buildSVG(W, H, PAD, SCALE, project, minVal, maxVal);
  else buildPNG(W, H, PAD, SCALE, project, minVal, maxVal);
}

function flattenCoords(geometry) {
  const out = [];
  if (!geometry) return out;
  function walk(arr, depth) {
    if (depth === 0) { out.push(arr); return; }
    arr.forEach(a => walk(a, depth-1));
  }
  if (geometry.type === 'Polygon') geometry.coordinates.forEach(ring => walk(ring, 1));
  else if (geometry.type === 'MultiPolygon') geometry.coordinates.forEach(poly => poly.forEach(ring => walk(ring, 1)));
  else if (geometry.type === 'GeometryCollection') geometry.geometries.forEach(g => flattenCoords(g).forEach(c => out.push(c)));
  return out;
}

function featurePathD(feature, project) {
  let d = '';
  if (!feature.geometry) return d;
  function ring(r) {
    return r.map(([lng, lat], i) => {
      const [x, y] = project(lng, lat);
      return (i?'L':'M') + x.toFixed(2) + ',' + y.toFixed(2);
    }).join(' ') + ' Z';
  }
  if (feature.geometry.type === 'Polygon') feature.geometry.coordinates.forEach(r => { d += ring(r) + ' '; });
  else if (feature.geometry.type === 'MultiPolygon') feature.geometry.coordinates.forEach(poly => poly.forEach(r => { d += ring(r) + ' '; }));
  return d.trim();
}

function buildSVG(W, H, PAD, SCALE, project, minVal, maxVal) {
  const unit = $('#dataUnit').val(), label = $('#dataLabel').val() || 'Data';
  const stroke = themeColor('--border-strong') || '#14213d';
  const bg = themeColor('--surface') || '#ffffff';
  const border = themeColor('--border') || '#e6dfce';
  const text = themeColor('--text') || '#14213d';
  const muted = themeColor('--muted') || '#6b6a5e';
  let paths = '';
  geoJsonData.features.forEach(f => {
    const name = getProvinceName(f), matched = matchProvince(name);
    const val = matched ? getMapValue(matched) : undefined;
    const fill = (val !== undefined && val !== null) ? getColorForValue(val, minVal, maxVal) : colorNoData;
    const op = (val !== undefined && val !== null) ? '0.9' : '0.25';
    const d = featurePathD(f, project); if (!d) return;
    paths += `<path d="${d}" fill="${fill}" fill-opacity="${op}" stroke="${stroke}" stroke-width="0.8"/>\n`;
  });
  const svgBreaks = getBreaks(minVal, maxVal);
  const svgN = svgBreaks.length - 1;
  syncClassColors(svgN);
  const lx = PAD+10, ly = H-PAD-(svgN*22)-34;
  let leg = `<rect x="${lx-6}" y="${ly-24}" width="220" height="${svgN*22+34}" rx="10" fill="${bg}" fill-opacity="0.94" stroke="${border}" stroke-width="1"/>`;
  leg += `<text x="${lx}" y="${ly-8}" font-family="Arial" font-size="11" font-weight="bold" fill="${muted}">${label}</text>`;
  for (let i = 0; i < svgN; i++) {
    const c = getClassColor(i, svgN);
    const lo = svgBreaks[i], hi = svgBreaks[i+1];
    const iy = ly+i*22;
    const rangeStr = fmtNum(lo)+(unit?' '+unit:'')+' – '+fmtNum(hi)+(unit?' '+unit:'');
    leg += `<rect x="${lx}" y="${iy}" width="15" height="15" rx="3" fill="${c}"/>`;
    leg += `<text x="${lx+20}" y="${iy+11}" font-family="Arial" font-size="11" fill="${text}">${rangeStr}</text>`;
  }
  const title = `<text x="${W/2}" y="${PAD+2}" text-anchor="middle" font-family="Arial" font-size="${13*SCALE}" font-weight="bold" fill="${text}">Peta ${label} · 38 Provinsi Indonesia</text>`;
  const svg = `<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" width="${W}" height="${H}" viewBox="0 0 ${W} ${H}"><rect width="${W}" height="${H}" fill="transparent"/>${paths}${leg}${title}</svg>`;
  const blob = new Blob([svg], {type:'image/svg+xml;charset=utf-8'});
  dlFile(URL.createObjectURL(blob), 'peta-indonesia.svg');
  showToast('SVG diunduh!', 'success');
}

function buildPNG(W, H, PAD, SCALE, project, minVal, maxVal) {
  const canvas = document.createElement('canvas'); canvas.width = W; canvas.height = H;
  const ctx = canvas.getContext('2d');
  const bg = themeColor('--bg') || '#f5f2ec';
  const surface = themeColor('--surface') || '#ffffff';
  const border = themeColor('--border') || '#e6dfce';
  const borderStrong = themeColor('--border-strong') || '#14213d';
  const text = themeColor('--text') || '#14213d';
  const muted = themeColor('--muted') || '#6b6a5e';
  ctx.fillStyle = bg; ctx.fillRect(0,0,W,H);
  geoJsonData.features.forEach(f => {
    const name = getProvinceName(f), matched = matchProvince(name);
    const val = matched ? getMapValue(matched) : undefined;
    const fill = (val !== undefined && val !== null) ? getColorForValue(val, minVal, maxVal) : colorNoData;
    const alpha = (val !== undefined && val !== null) ? .9 : .25;
    ctx.beginPath(); drawPNG(ctx, f, project);
    const [r,g,b] = hexToRgb(fill);
    ctx.fillStyle = `rgba(${r},${g},${b},${alpha})`; ctx.fill();
    ctx.strokeStyle = borderStrong; ctx.lineWidth = .8*SCALE; ctx.stroke();
  });
  const unit = $('#dataUnit').val(), label = $('#dataLabel').val() || 'Data';
  const pngBreaks = getBreaks(minVal, maxVal);
  const pngN = pngBreaks.length - 1;
  syncClassColors(pngN);
  const lx = PAD+10, ly = H-PAD-(pngN*28)-40;
  const [sr,sg,sb] = hexToRgb(surface);
  ctx.fillStyle = `rgba(${sr},${sg},${sb},0.94)`;
  rrect(ctx, lx-8, ly-28, 240*SCALE, pngN*28+42, 10); ctx.fill();
  ctx.strokeStyle = border; ctx.lineWidth = 1; ctx.stroke();
  ctx.font = `bold ${11*SCALE}px Arial`; ctx.fillStyle = muted; ctx.textAlign = 'left';
  ctx.fillText(label, lx, ly-10);
  for (let i = 0; i < pngN; i++) {
    const c = getClassColor(i, pngN);
    const lo = pngBreaks[i], hi = pngBreaks[i+1];
    const iy = ly+i*28;
    const [r,g,b] = hexToRgb(c);
    ctx.fillStyle = `rgb(${r},${g},${b})`; rrect(ctx, lx, iy, 16*SCALE, 16*SCALE, 3); ctx.fill();
    ctx.fillStyle = text; ctx.font = `${11*SCALE}px Arial`;
    ctx.fillText(fmtNum(lo)+(unit?' '+unit:'')+' - '+fmtNum(hi)+(unit?' '+unit:''), lx+22*SCALE, iy+12*SCALE);
  }
  ctx.textAlign = 'center'; ctx.font = `bold ${13*SCALE}px Arial`; ctx.fillStyle = text;
  ctx.fillText('Peta '+(label||'Indonesia')+' · 38 Provinsi Indonesia', W/2, PAD+4);
  dlFile(canvas.toDataURL('image/png'), 'peta-indonesia.png');
  showToast('PNG diunduh!', 'success');
}

function drawPNG(ctx, feature, project) {
  if (!feature.geometry) return;
  function ring(r) {
    r.forEach(([lng, lat], i) => {
      const [x, y] = project(lng, lat);
      i ? ctx.lineTo(x, y) : ctx.moveTo(x, y);
    });
    ctx.closePath();
  }
  if (feature.geometry.type === 'Polygon') feature.geometry.coordinates.forEach(ring);
  else if (feature.geometry.type === 'MultiPolygon') feature.geometry.coordinates.forEach(poly => poly.forEach(ring));
}

function rrect(ctx, x, y, w, h, r) {
  ctx.beginPath();
  ctx.moveTo(x+r, y); ctx.lineTo(x+w-r, y); ctx.quadraticCurveTo(x+w, y, x+w, y+r);
  ctx.lineTo(x+w, y+h-r); ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
  ctx.lineTo(x+r, y+h); ctx.quadraticCurveTo(x, y+h, x, y+h-r);
  ctx.lineTo(x, y+r); ctx.quadraticCurveTo(x, y, x+r, y);
  ctx.closePath();
}

function dlFile(url, name) {
  const a = document.createElement('a'); a.href = url; a.download = name;
  document.body.appendChild(a); a.click(); document.body.removeChild(a);
  setTimeout(() => URL.revokeObjectURL(url), 5000);
}

// ═══════════════════════════════════════════════════════
// CUSTOM BREAKS
// ═══════════════════════════════════════════════════════
function setIntervalMode(mode) {
  intervalMode = mode;
  $('#tabEqual').toggleClass('active', mode==='equal');
  $('#tabCustom').toggleClass('active', mode==='custom');
  $('#equalSection').toggleClass('hidden', mode==='custom');
  $('#customSection').toggleClass('hidden', mode==='equal');
  if (mode === 'custom') {
    if (customBreaks.length !== numSteps - 1) autoFillBreaks();
    else renderBreakInputs();
  }
  renderGeoLayer();
}

function autoFillBreaks() {
  const vals = getAllMapValues();
  if (!vals.length) { customBreaks = []; renderBreakInputs(); return; }
  const mn = Math.min(...vals), mx = Math.max(...vals);
  customBreaks = [];
  for (let i = 1; i < numSteps; i++) {
    customBreaks.push(Math.round((mn + (mx-mn)*i/numSteps) * 1000) / 1000);
  }
  renderBreakInputs();
}

function renderBreakInputs() {
  const vals = getAllMapValues();
  const mn = vals.length ? Math.min(...vals) : 0;
  const mx = vals.length ? Math.max(...vals) : 100;
  while (customBreaks.length < numSteps - 1) {
    const idx = customBreaks.length + 1;
    customBreaks.push(Math.round((mn + (mx-mn)*idx/numSteps) * 1000) / 1000);
  }
  while (customBreaks.length > numSteps - 1) customBreaks.pop();

  let html = `<span class="br-fixed">${fmtNum(mn)}</span>`;
  for (let i = 0; i < customBreaks.length; i++) {
    html += `<span class="br-arrow">›</span>`;
    html += `<input class="br-input" type="number" step="any" data-idx="${i}" value="${customBreaks[i]}">`;
  }
  html += `<span class="br-arrow">›</span><span class="br-fixed">${fmtNum(mx)}</span>`;
  $('#breaksWrap').html(html);

  $('#breaksWrap .br-input').on('input change', function() {
    const idx = parseInt($(this).data('idx'));
    const v = parseFloat($(this).val());
    const prev = idx === 0 ? mn : customBreaks[idx-1];
    const next = idx === customBreaks.length-1 ? mx : customBreaks[idx+1];
    if (isNaN(v) || v <= prev || v >= next) {
      $(this).addClass('invalid');
    } else {
      $(this).removeClass('invalid');
      customBreaks[idx] = v;
      renderGeoLayer();
    }
  });
}

$('#btnAutoBreaks').on('click', function() {
  autoFillBreaks();
  renderGeoLayer();
});

// ═══════════════════════════════════════════════════════
// BOOT
// ═══════════════════════════════════════════════════════
$(document).ready(async () => {
  initMap();
  await loadAndRenderMap();
});
