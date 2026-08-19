<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DevKit ID — Tools & Utilities</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="devkit" defer></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
:root {
  --bg: #070710;
  --sidebar: #0d0d1f;
  --card: #12122a;
  --card2: #161630;
  --border: rgba(255,255,255,0.07);
  --border2: rgba(255,255,255,0.12);
  --text: #e8e8f8;
  --muted: #6b6b9a;
  --accent: #4f8dff;
  --accent2: #a78bfa;
  --pink: #ff3d8e;
  --green: #22d3a0;
  --red: #ff4d4d;
  --sidebar-w: 256px;
}
*{margin:0;padding:0;box-sizing:border-box}
html,body{height:100%;overflow:hidden}
body{font-family:'Manrope',sans-serif;background:var(--bg);color:var(--text);display:flex}

/* ── Sidebar ─────────────────────────────────── */
.sidebar{
  width:var(--sidebar-w);flex-shrink:0;background:var(--sidebar);
  border-right:1px solid var(--border);display:flex;flex-direction:column;
  height:100vh;position:relative;z-index:50;
}
.sidebar-logo{
  padding:28px 24px 20px;
  border-bottom:1px solid var(--border);
}
.logo-mark{
  display:flex;align-items:center;gap:10px;
}
.logo-icon{
  width:36px;height:36px;border-radius:10px;
  background:linear-gradient(135deg,var(--accent),var(--accent2));
  display:flex;align-items:center;justify-content:center;font-size:18px;
  box-shadow:0 4px 20px rgba(79,141,255,0.35);
}
.logo-text{
  font-family:'Syne',sans-serif;font-weight:800;font-size:18px;
  letter-spacing:-0.03em;
}
.logo-sub{font-size:10px;color:var(--muted);letter-spacing:0.1em;text-transform:uppercase;margin-top:1px}

.nav{padding:16px 12px;flex:1;display:flex;flex-direction:column;gap:2px}
.nav-section-label{
  font-size:9.5px;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);
  padding:12px 12px 6px;font-weight:700;
}
.nav-item{
  display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;
  cursor:pointer;font-size:13.5px;font-weight:500;color:var(--muted);
  transition:all .2s;user-select:none;border:1px solid transparent;
  text-decoration:none;
}
.nav-item svg{flex-shrink:0;opacity:0.7;transition:opacity .2s}
.nav-item:hover{color:var(--text);background:rgba(255,255,255,0.05);border-color:var(--border)}
.nav-item:hover svg{opacity:1}
.nav-item.active{
  color:#fff;background:rgba(79,141,255,0.12);border-color:rgba(79,141,255,0.25);
}
.nav-item.active svg{opacity:1}
.nav-badge{
  margin-left:auto;font-size:9px;font-weight:700;letter-spacing:0.08em;
  text-transform:uppercase;padding:2px 7px;border-radius:100px;
}
.badge-new{background:rgba(34,211,160,0.15);color:var(--green);border:1px solid rgba(34,211,160,0.3)}
.badge-api{background:rgba(167,139,250,0.12);color:var(--accent2);border:1px solid rgba(167,139,250,0.25)}

.sidebar-footer{
  padding:16px;border-top:1px solid var(--border);
}
.version-pill{
  display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:8px;
  background:rgba(255,255,255,0.03);border:1px solid var(--border);
  font-size:11px;color:var(--muted);
}
.status-dot{width:6px;height:6px;background:var(--green);border-radius:50%;box-shadow:0 0 6px var(--green);animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}

/* ── Main ────────────────────────────────────── */
.main{flex:1;display:flex;flex-direction:column;overflow:hidden;position:relative}
.topbar{
  padding:0 32px;height:60px;display:flex;align-items:center;justify-content:space-between;
  border-bottom:1px solid var(--border);flex-shrink:0;
  background:rgba(7,7,16,0.8);backdrop-filter:blur(12px);
}
.topbar-title{font-family:'Syne',sans-serif;font-weight:700;font-size:16px;letter-spacing:-0.01em}
.topbar-meta{display:flex;align-items:center;gap:16px}
.topbar-chip{
  font-size:11px;color:var(--muted);font-weight:500;
  padding:4px 10px;border-radius:100px;background:rgba(255,255,255,0.04);border:1px solid var(--border);
}
.page{flex:1;overflow-y:auto;display:none;animation:fadeIn .3s ease}
.page.active{display:block}
@keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

/* Scrollbar */
::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:rgba(255,255,255,0.08);border-radius:4px}

/* ── Shared Components ───────────────────────── */
.page-inner{padding:36px 40px;max-width:880px}
.page-header{margin-bottom:36px}
.page-eyebrow{
  display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;
  letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);margin-bottom:12px;
}
.page-eyebrow span{display:inline-block;width:20px;height:1px;background:var(--muted)}
.page-title{font-family:'Syne',sans-serif;font-weight:800;font-size:36px;line-height:1.1;letter-spacing:-0.03em}
.page-desc{margin-top:8px;font-size:15px;color:var(--muted);font-weight:400;line-height:1.7}

.card-base{
  background:var(--card);border:1px solid var(--border);border-radius:16px;
  padding:24px;transition:all .25s;
}
.card-base:hover{border-color:var(--border2);background:var(--card2)}

.input-group{margin-bottom:16px}
.input-label{
  display:block;font-size:10.5px;font-weight:700;letter-spacing:0.1em;
  text-transform:uppercase;color:var(--muted);margin-bottom:8px;
}
.input-field{
  width:100%;background:rgba(255,255,255,0.04);border:1px solid var(--border);
  border-radius:12px;padding:14px 18px;font-family:'Manrope',sans-serif;
  font-size:15px;color:var(--text);outline:none;transition:all .2s;
}
.input-field::placeholder{color:rgba(107,107,154,0.6)}
.input-field:focus{
  border-color:rgba(79,141,255,0.4);background:rgba(79,141,255,0.04);
  box-shadow:0 0 0 3px rgba(79,141,255,0.1);
}
.btn-primary{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
  padding:14px 28px;border:none;border-radius:12px;cursor:pointer;
  font-family:'Manrope',sans-serif;font-size:14px;font-weight:700;
  background:linear-gradient(135deg,#1a6fff,#7c3aed);color:#fff;
  transition:all .25s;letter-spacing:0.02em;white-space:nowrap;
}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 30px rgba(79,141,255,0.4)}
.btn-primary:active{transform:none}
.btn-primary:disabled{opacity:.5;cursor:not-allowed;transform:none}
.spinner-sm{
  width:16px;height:16px;border-radius:50%;border:2px solid rgba(255,255,255,.25);
  border-top-color:#fff;animation:spin .7s linear infinite;display:none;
}
@keyframes spin{to{transform:rotate(360deg)}}

/* ── HOME page ───────────────────────────────── */
.home-hero{
  background:linear-gradient(135deg,rgba(79,141,255,0.08),rgba(167,139,250,0.06));
  border:1px solid rgba(79,141,255,0.15);border-radius:20px;padding:40px;
  margin-bottom:36px;position:relative;overflow:hidden;
}
.home-hero::before{
  content:'';position:absolute;top:-60px;right:-60px;width:200px;height:200px;
  border-radius:50%;background:radial-gradient(circle,rgba(79,141,255,0.15),transparent 70%);
  pointer-events:none;
}
.hero-kpi{display:flex;gap:32px;margin-top:24px;flex-wrap:wrap}
.kpi{
  display:flex;flex-direction:column;gap:2px;
  padding:12px 20px;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;
}
.kpi-num{font-family:'Syne',sans-serif;font-size:24px;font-weight:800;letter-spacing:-0.03em}
.kpi-label{font-size:11px;color:var(--muted);font-weight:500}
.app-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:36px}
.app-card{
  background:var(--card);border:1px solid var(--border);border-radius:16px;
  padding:24px;cursor:pointer;transition:all .25s;
}
.app-card:hover{
  border-color:var(--border2);background:var(--card2);
  transform:translateY(-2px);box-shadow:0 12px 40px rgba(0,0,0,0.3);
}
.app-icon{
  width:48px;height:48px;border-radius:14px;display:flex;align-items:center;
  justify-content:center;font-size:22px;margin-bottom:16px;
}
.app-card-name{font-family:'Syne',sans-serif;font-size:17px;font-weight:700;margin-bottom:6px}
.app-card-desc{font-size:13px;color:var(--muted);line-height:1.6}
.app-card-tag{
  display:inline-flex;align-items:center;gap:5px;margin-top:14px;
  font-size:11px;font-weight:600;
}

/* ── GENDER page ─────────────────────────────── */
.gender-bg{
  position:fixed;inset:0;pointer-events:none;z-index:0;opacity:0;
  transition:opacity 1s;
}
.gender-orb{
  position:absolute;border-radius:50%;filter:blur(100px);animation:drift 12s ease-in-out infinite;
}
.go1{width:350px;height:350px;background:#1a6fff;top:-100px;right:200px;opacity:.1;animation-delay:0s}
.go2{width:300px;height:300px;background:#ff3d8e;bottom:-80px;right:100px;opacity:.08;animation-delay:-5s}
@keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(20px,-15px)}}

.gender-result-card{
  border-radius:16px;padding:24px;border:1px solid transparent;
  animation:slideUp .4s cubic-bezier(.16,1,.3,1);margin-top:20px;display:none;
}
.gender-result-card.male{
  background:linear-gradient(135deg,rgba(26,111,255,.1),rgba(26,111,255,.03));
  border-color:rgba(26,111,255,.25);
}
.gender-result-card.female{
  background:linear-gradient(135deg,rgba(255,61,142,.1),rgba(255,61,142,.03));
  border-color:rgba(255,61,142,.25);
}
.gender-result-card.unknown{background:rgba(255,255,255,.04);border-color:var(--border)}
@keyframes slideUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

.prob-track{height:6px;background:rgba(255,255,255,.08);border-radius:100px;overflow:hidden;margin-top:8px}
.prob-fill{height:100%;border-radius:100px;width:0%;transition:width .8s cubic-bezier(.16,1,.3,1) .2s}
.fill-male{background:linear-gradient(90deg,#1a6fff,#60a5fa)}
.fill-female{background:linear-gradient(90deg,#ff3d8e,#f472b6)}

.meta-pills{display:flex;gap:10px;margin-top:16px;flex-wrap:wrap}
.meta-pill{
  flex:1;min-width:80px;background:rgba(255,255,255,.04);border:1px solid var(--border);
  border-radius:10px;padding:10px 12px;text-align:center;
}
.mp-label{font-size:10px;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:3px}
.mp-value{font-size:14px;font-weight:700}

/* ── NIK page ────────────────────────────────── */
.nik-form-row{display:flex;gap:12px;align-items:flex-end}
.nik-char-count{
  font-size:11px;font-weight:600;margin-top:6px;text-align:right;color:var(--muted);
  transition:color .2s;
}
.nik-data-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin:24px 0}
.nik-data-card{
  background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:12px;
  padding:16px;display:flex;align-items:flex-start;gap:12px;transition:all .2s;
}
.nik-data-card:hover{border-color:rgba(220,38,38,.25);background:rgba(220,38,38,.04)}
.nik-icon{
  width:36px;height:36px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,rgba(220,38,38,.15),rgba(220,38,38,.06));
  color:#f87171;display:flex;align-items:center;justify-content:center;
}
.nik-icon svg{width:18px;height:18px}
.nik-dl{font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:700;margin-bottom:3px}
.nik-dv{font-size:14px;font-weight:700;line-height:1.3}

.nik-valid-badge{
  display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:12px;
  background:rgba(34,211,160,.08);border:1px solid rgba(34,211,160,.2);margin-bottom:20px;
}
.nik-error-badge{
  display:flex;align-items:flex-start;gap:12px;padding:16px 18px;border-radius:12px;
  background:rgba(255,77,77,.08);border:1px solid rgba(255,77,77,.2);
}

#map{height:380px;border-radius:14px;border:1px solid var(--border);overflow:hidden}
.leaflet-tile-container img{filter:brightness(.85) saturate(1.1)}

/* ── ABOUT page ──────────────────────────────── */
.changelog{display:flex;flex-direction:column;gap:0}
.cl-item{
  display:flex;gap:24px;padding-bottom:32px;position:relative;
}
.cl-item:not(:last-child)::after{
  content:'';position:absolute;left:15px;top:32px;bottom:0;width:1px;
  background:linear-gradient(to bottom,var(--border2),var(--border),transparent);
}
.cl-dot{
  width:32px;height:32px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;
  justify-content:center;font-size:12px;border:1px solid;margin-top:2px;position:relative;z-index:1;
}
.cl-dot.latest{background:rgba(34,211,160,.12);border-color:rgba(34,211,160,.4);color:var(--green)}
.cl-dot.update{background:rgba(79,141,255,.12);border-color:rgba(79,141,255,.35);color:var(--accent)}
.cl-dot.fix{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.3);color:#fbbf24}
.cl-content{flex:1;padding-top:4px}
.cl-ver{
  display:inline-flex;align-items:center;gap:8px;margin-bottom:8px;
}
.cl-tag{
  font-family:'Syne',sans-serif;font-weight:700;font-size:15px;
}
.cl-type-badge{
  font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  padding:2px 8px;border-radius:100px;
}
.ct-latest{background:rgba(34,211,160,.12);color:var(--green);border:1px solid rgba(34,211,160,.25)}
.ct-update{background:rgba(79,141,255,.1);color:var(--accent);border:1px solid rgba(79,141,255,.2)}
.ct-fix{background:rgba(251,191,36,.08);color:#fbbf24;border:1px solid rgba(251,191,36,.2)}
.cl-date{font-size:12px;color:var(--muted);margin-bottom:10px;font-weight:500}
.cl-notes{list-style:none;display:flex;flex-direction:column;gap:6px}
.cl-notes li{
  font-size:13.5px;color:rgba(232,232,248,.75);line-height:1.6;
  padding-left:16px;position:relative;
}
.cl-notes li::before{
  content:'—';position:absolute;left:0;color:var(--muted);font-weight:300;
}

.about-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:36px}
.about-info-card{
  background:var(--card);border:1px solid var(--border);border-radius:14px;
  padding:20px;
}
.about-info-icon{font-size:22px;margin-bottom:10px}
.about-info-label{font-size:11px;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);font-weight:700;margin-bottom:4px}
.about-info-val{font-size:15px;font-weight:700}

/* ── Toast ───────────────────────────────────── */
.toast{
  display:none;align-items:center;gap:10px;
  background:rgba(255,77,77,.1);border:1px solid rgba(255,77,77,.25);
  border-radius:10px;padding:12px 16px;margin-top:14px;
  font-size:13px;color:#fca5a5;animation:slideUp .3s ease;
}

/* ── Mobile Hamburger ────────────────────────── */
.ham{display:none;align-items:center;justify-content:center;width:38px;height:38px;border-radius:8px;
  background:rgba(255,255,255,.06);border:1px solid var(--border);cursor:pointer;flex-shrink:0}
.ham svg{width:18px;height:18px}

@media(max-width:720px){
  :root{--sidebar-w:240px}
  .sidebar{position:fixed;left:0;top:0;height:100vh;transform:translateX(-100%);transition:transform .3s}
  .sidebar.open{transform:translateX(0)}
  .main{width:100%}
  .ham{display:flex}
  .page-inner{padding:24px 20px}
  .app-grid{grid-template-columns:1fr}
  .about-info-grid{grid-template-columns:1fr}
  .topbar{padding:0 16px}
  .nik-form-row{flex-direction:column}
  .overlay{display:block !important}
}
.overlay{
  display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:40;
  backdrop-filter:blur(4px);
}
</style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-mark">
      <div class="logo-icon">⚡</div>
      <div>
        <div class="logo-text">DevKit ID</div>
        <div class="logo-sub">Tools Suite</div>
      </div>
    </div>
  </div>

  <nav class="nav">
    <div class="nav-section-label">Menu</div>
    <a class="nav-item active" data-page="beranda" onclick="navigate('beranda',this)">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
      Beranda
    </a>

    <div class="nav-section-label" style="margin-top:8px">Aplikasi</div>
    <a class="nav-item" data-page="gender" onclick="navigate('gender',this)">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0"/></svg>
      GenderSense
      <span class="nav-badge badge-api">API</span>
    </a>
    <a class="nav-item" data-page="nik" onclick="navigate('nik',this)">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/></svg>
      Cek NIK
      <span class="nav-badge badge-new">New</span>
    </a>

    <div class="nav-section-label" style="margin-top:8px">Info</div>
    <a class="nav-item" data-page="tentang" onclick="navigate('tentang',this)">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
      Tentang
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="version-pill">
      <span class="status-dot"></span>
      <span>v1.2.0 — Semua sistem aktif</span>
    </div>
  </div>
</aside>

<!-- ── MAIN ── -->
<div class="main">
  <div class="topbar">
    <div style="display:flex;align-items:center;gap:12px">
      <div class="ham" id="ham" onclick="openSidebar()">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
      </div>
      <span class="topbar-title" id="topbar-title">Beranda</span>
    </div>
    <div class="topbar-meta">
      <span class="topbar-chip">2 Aplikasi Aktif</span>
      <span class="topbar-chip" id="topbar-date"></span>
    </div>
  </div>

  <!-- ── PAGE: BERANDA ── -->
  <div class="page active" id="page-beranda">
    <div class="page-inner">
      <div class="home-hero">
        <div class="page-eyebrow"><span></span> Platform Utilitas<span></span></div>
        <div class="page-title">Selamat Datang di<br>DevKit <span style="background:linear-gradient(135deg,var(--accent),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Indonesia</span></div>
        <p style="margin-top:10px;font-size:14px;color:var(--muted);line-height:1.7;max-width:480px">Kumpulan alat bantu berbasis data dan AI untuk kebutuhan sehari-hari. Ringan, cepat, dan selalu tersedia.</p>
        <div class="hero-kpi">
          <div class="kpi">
            <span class="kpi-num" style="color:var(--accent)">2</span>
            <span class="kpi-label">Aplikasi</span>
          </div>
          <div class="kpi">
            <span class="kpi-num" style="color:var(--green)">100%</span>
            <span class="kpi-label">Free to Use</span>
          </div>
          <div class="kpi">
            <span class="kpi-num" style="color:var(--accent2)">2</span>
            <span class="kpi-label">API Terintegrasi</span>
          </div>
        </div>
      </div>

      <div style="margin-bottom:14px;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)">Daftar Aplikasi</div>
      <div class="app-grid">
        <!-- GenderSense -->
        <div class="app-card" onclick="navigate('gender',null)">
          <div class="app-icon" style="background:linear-gradient(135deg,rgba(26,111,255,.2),rgba(124,58,237,.15))">🧬</div>
          <div class="app-card-name">GenderSense</div>
          <div class="app-card-desc">Deteksi jenis kelamin dari nama menggunakan data global dari jutaan sampel. Mendukung nama Indonesia, Asia, dan internasional.</div>
          <div class="app-card-tag" style="color:var(--accent)">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
            </svg> Genderize.io API
          </div>
        </div>

        <!-- NIK Checker -->
        <div class="app-card" onclick="navigate('nik',null)">
          <div class="app-icon" style="background:linear-gradient(135deg,rgba(220,38,38,.2),rgba(251,113,133,.1))">🪪</div>
          <div class="app-card-name">Cek NIK Indonesia</div>
          <div class="app-card-desc">Parse dan validasi 16 digit NIK. Ekstrak data kependudukan: provinsi, kabupaten, kecamatan, tanggal lahir, dan jenis kelamin beserta visualisasi peta.</div>
          <div class="app-card-tag" style="color:#f87171">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
            Data Wilayah Indonesia
          </div>
        </div>
      </div>

      <!-- Info strip -->
      <div style="margin-top:8px;padding:16px 20px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:12px;display:flex;align-items:center;gap:12px">
        <span style="font-size:18px">💡</span>
        <div>
          <div style="font-size:13px;font-weight:600;margin-bottom:2px">Tentang Platform</div>
          <div style="font-size:12.5px;color:var(--muted);line-height:1.6">Semua aplikasi berjalan langsung di browser tanpa data tersimpan. Klik <strong style="color:var(--text)">Tentang</strong> untuk melihat catatan perubahan lengkap.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── PAGE: GENDER ── -->
  <div class="page" id="page-gender">
    <div class="gender-bg" id="gender-bg">
      <div class="gender-orb go1"></div>
      <div class="gender-orb go2"></div>
    </div>
    <div class="page-inner" style="position:relative;z-index:1">
      <div class="page-header">
        <div class="page-eyebrow"><span></span> Deteksi Berbasis Data<span></span></div>
        <div class="page-title">Gender<span style="background:linear-gradient(135deg,var(--accent),var(--pink));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Sense</span></div>
        <div class="page-desc">Analisis jenis kelamin berdasarkan nama menggunakan database global dari genderize.io.</div>
      </div>

      <div style="max-width:520px">
        <div class="input-group">
          <label class="input-label">Masukkan Nama</label>
          <div style="position:relative">
            <span style="position:absolute;left:16px;top:50%;transform:translateY(-50%);opacity:.4;font-size:16px;pointer-events:none">✦</span>
            <input class="input-field" id="g-name" style="padding-left:44px" placeholder="Contoh: Andi, Dewi, Alex, Sarah…" autocomplete="off">
          </div>
        </div>
        <button class="btn-primary" id="g-btn" style="width:100%">
          <div class="spinner-sm" id="g-spin"></div>
          <span id="g-btn-text">Analisis Sekarang →</span>
        </button>
        <div class="toast" id="g-toast">
          <span>⚠</span><span id="g-toast-msg">Terjadi kesalahan.</span>
        </div>

        <div class="gender-result-card" id="g-result">
          <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
            <div id="g-icon" style="width:54px;height:54px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0"></div>
            <div>
              <div id="g-gender-label" style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:3px;color:var(--muted)"></div>
              <div id="g-name-display" style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;letter-spacing:-.02em"></div>
            </div>
          </div>
          <div id="g-prob-wrap" style="margin-bottom:4px">
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;color:var(--muted)">
              <span>Tingkat Keyakinan</span>
              <span id="g-prob-val" style="font-weight:700;font-size:14px"></span>
            </div>
            <div class="prob-track">
              <div class="prob-fill" id="g-prob-fill"></div>
            </div>
          </div>
          <div class="meta-pills" id="g-meta"></div>
        </div>

        <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border);font-size:12px;color:var(--muted)">
          Data dari <a href="https://genderize.io" target="_blank" style="color:var(--accent);text-decoration:none">genderize.io</a> — database jutaan nama global
        </div>
      </div>
    </div>
  </div>

  <!-- ── PAGE: NIK ── -->
  <div class="page" id="page-nik">
    <div class="page-inner">
      <div class="page-header">
        <div class="page-eyebrow"><span></span> Verifikasi Kependudukan<span></span></div>
        <div class="page-title">Cek <span style="color:#ef4444">NIK</span></div>
        <div class="page-desc">Masukkan 16 digit NIK untuk mendapatkan informasi wilayah dan data kependudukan.</div>
      </div>

      <div class="nik-form-row" style="max-width:600px">
        <div style="flex:1">
          <label class="input-label">Nomor Induk Kependudukan (NIK)</label>
          <input class="input-field" id="nik-input" maxlength="16" placeholder="Contoh: 3201014710050003" autocomplete="off" oninput="nikInputEvent(this)" style="font-size:15px;letter-spacing:.06em;font-weight:600">
          <div class="nik-char-count" id="nik-count">0/16 digit</div>
        </div>
        <button class="btn-primary" id="nik-btn" style="height:52px;padding:0 24px;margin-bottom:22px" onclick="checkNIK()">
          <div class="spinner-sm" id="nik-spin"></div>
          <span id="nik-btn-text">Cek NIK</span>
        </button>
      </div>

      <div id="nik-result" style="display:none;animation:fadeIn .4s ease"></div>
    </div>
  </div>

  <!-- ── PAGE: TENTANG ── -->
  <div class="page" id="page-tentang">
    <div class="page-inner">
      <div class="page-header">
        <div class="page-eyebrow"><span></span> Informasi Aplikasi<span></span></div>
        <div class="page-title">Tentang <span style="color:var(--accent2)">DevKit ID</span></div>
        <div class="page-desc">Platform utilitas ringan berbasis browser untuk kebutuhan data dan analisis kependudukan Indonesia.</div>
      </div>

      <div class="about-info-grid">
        <div class="about-info-card">
          <div class="about-info-icon">⚡</div>
          <div class="about-info-label">Platform</div>
          <div class="about-info-val">DevKit ID Suite</div>
        </div>
        <div class="about-info-card">
          <div class="about-info-icon">🌐</div>
          <div class="about-info-label">Teknologi</div>
          <div class="about-info-val">HTML · CSS · JS · Leaflet</div>
        </div>
        <div class="about-info-card">
          <div class="about-info-icon">🔗</div>
          <div class="about-info-label">API Digunakan</div>
          <div class="about-info-val">Genderize.io · emsifa · Nominatim</div>
        </div>
        <div class="about-info-card">
          <div class="about-info-icon">🔒</div>
          <div class="about-info-label">Privasi</div>
          <div class="about-info-val">No data stored locally</div>
        </div>
      </div>

      <div style="margin-bottom:20px;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)">Changelog</div>
      <div class="changelog">

        <div class="cl-item">
          <div class="cl-dot latest">★</div>
          <div class="cl-content">
            <div class="cl-ver">
              <span class="cl-tag">v1.2.0</span>
              <span class="cl-type-badge ct-latest">Terbaru</span>
            </div>
            <div class="cl-date">Maret 2026</div>
            <ul class="cl-notes">
              <li>Penggabungan GenderSense dan Cek NIK dalam satu platform terpadu</li>
              <li>Desain ulang tampilan dengan sidebar navigasi responsif</li>
              <li>Penambahan halaman Beranda dan Tentang</li>
              <li>Integrasi peta interaktif Leaflet untuk visualisasi wilayah NIK</li>
              <li>Geocoding otomatis kabupaten/kota via Nominatim OSM</li>
            </ul>
          </div>
        </div>

        <div class="cl-item">
          <div class="cl-dot update">↑</div>
          <div class="cl-content">
            <div class="cl-ver">
              <span class="cl-tag">v1.1.0</span>
              <span class="cl-type-badge ct-update">Update</span>
            </div>
            <div class="cl-date">Februari 2026</div>
            <ul class="cl-notes">
              <li>Peluncuran fitur Cek NIK Indonesia</li>
              <li>Parser NIK berbasis JavaScript murni (client-side)</li>
              <li>Integrasi API wilayah dari emsifa untuk data provinsi, kabupaten, kecamatan</li>
              <li>Tampilan data dalam format kartu yang informatif</li>
            </ul>
          </div>
        </div>

        <div class="cl-item">
          <div class="cl-dot fix">⚙</div>
          <div class="cl-content">
            <div class="cl-ver">
              <span class="cl-tag">v1.0.1</span>
              <span class="cl-type-badge ct-fix">Perbaikan</span>
            </div>
            <div class="cl-date">Januari 2026</div>
            <ul class="cl-notes">
              <li>Perbaikan bug animasi probabilitas yang tidak muncul saat pertama kali dijalankan</li>
              <li>Peningkatan responsivitas untuk layar kecil</li>
              <li>Optimasi ukuran animasi background orb</li>
            </ul>
          </div>
        </div>

        <div class="cl-item">
          <div class="cl-dot update">🚀</div>
          <div class="cl-content">
            <div class="cl-ver">
              <span class="cl-tag">v1.0.0</span>
              <span class="cl-type-badge ct-update">Rilis Awal</span>
            </div>
            <div class="cl-date">Desember 2025</div>
            <ul class="cl-notes">
              <li>Peluncuran perdana GenderSense</li>
              <li>Integrasi Genderize.io API untuk deteksi jenis kelamin dari nama</li>
              <li>Tampilan animasi orb dan probabilitas interaktif</li>
              <li>Dukungan nama global (Indonesia, Asia, Eropa, Amerika)</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
</div><!-- end .main -->

<script>
// ── Router ────────────────────────────────────────
const titles = {beranda:'Beranda',gender:'GenderSense',nik:'Cek NIK',tentang:'Tentang'};

function navigate(page, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-'+page).classList.add('active');
  if(el) el.classList.add('active');
  else document.querySelector(`[data-page="${page}"]`).classList.add('active');
  document.getElementById('topbar-title').textContent = titles[page];
  closeSidebar();
}

function openSidebar(){
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('overlay').style.display='block';
}
function closeSidebar(){
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('overlay').style.display='none';
}

// Date in topbar
const d = new Date();
document.getElementById('topbar-date').textContent =
  d.toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});

// ── GenderSense ───────────────────────────────────
document.getElementById('g-name').addEventListener('keydown', e => { if(e.key==='Enter') checkGender(); });
document.getElementById('g-btn').addEventListener('click', checkGender);

function showGenderToast(msg){
  document.getElementById('g-toast-msg').textContent = msg;
  const t = document.getElementById('g-toast');
  t.style.display='flex';
  setTimeout(()=>t.style.display='none',4000);
}

function checkGender(){
  const name = document.getElementById('g-name').value.trim();
  if(!name){ showGenderToast('Silakan masukkan nama terlebih dahulu.'); return; }

  document.getElementById('g-toast').style.display='none';
  document.getElementById('g-result').style.display='none';
  document.getElementById('g-spin').style.display='block';
  document.getElementById('g-btn-text').textContent='Menganalisis…';
  document.getElementById('g-btn').disabled=true;

  fetch(`https://api.genderize.io/?name=${encodeURIComponent(name)}`)
    .then(r=>{ if(!r.ok) throw new Error(); return r.json(); })
    .then(r=>{
      document.getElementById('g-spin').style.display='none';
      document.getElementById('g-btn-text').textContent='Analisis Sekarang →';
      document.getElementById('g-btn').disabled=false;

      const rc = document.getElementById('g-result');
      rc.className='gender-result-card';

      if(!r.gender){
        rc.classList.add('unknown');
        document.getElementById('g-icon').textContent='❓';
        document.getElementById('g-icon').style.background='rgba(255,255,255,.06)';
        document.getElementById('g-gender-label').textContent='Tidak Diketahui';
        document.getElementById('g-name-display').textContent=r.name;
        document.getElementById('g-prob-wrap').style.display='none';
        document.getElementById('g-meta').innerHTML=`<div class="meta-pill"><div class="mp-label">Status</div><div class="mp-value">Tidak Terdeteksi</div></div>`;
      } else {
        const male = r.gender==='male';
        const pct = (r.probability*100).toFixed(1);
        rc.classList.add(male?'male':'female');

        document.getElementById('g-icon').textContent=male?'♂':'♀';
        document.getElementById('g-icon').style.background=male?'rgba(26,111,255,.15)':'rgba(255,61,142,.15)';
        document.getElementById('g-gender-label').style.color=male?'#6ea8ff':'#ff7eb8';
        document.getElementById('g-gender-label').textContent=male?'Laki-laki':'Perempuan';
        document.getElementById('g-name-display').textContent=r.name;
        document.getElementById('g-prob-wrap').style.display='block';
        document.getElementById('g-prob-val').style.color=male?'#6ea8ff':'#ff7eb8';
        document.getElementById('g-prob-val').textContent=pct+'%';

        const fill=document.getElementById('g-prob-fill');
        fill.className='prob-fill '+(male?'fill-male':'fill-female');
        fill.style.width='0%';
        setTimeout(()=>fill.style.width=pct+'%',100);

        const conf = r.probability>=.95?'Sangat Tinggi':r.probability>=.80?'Tinggi':r.probability>=.60?'Sedang':'Rendah';
        document.getElementById('g-meta').innerHTML=`
          <div class="meta-pill"><div class="mp-label">Nama</div><div class="mp-value">${r.name}</div></div>
          <div class="meta-pill"><div class="mp-label">Keyakinan</div><div class="mp-value">${conf}</div></div>
          <div class="meta-pill"><div class="mp-label">Sampel</div><div class="mp-value">${r.count?r.count.toLocaleString('id-ID'):'—'}</div></div>
        `;

        // Background orb glow
        document.getElementById('gender-bg').style.opacity='1';
      }
      rc.style.display='block';
    })
    .catch(()=>{
      document.getElementById('g-spin').style.display='none';
      document.getElementById('g-btn-text').textContent='Analisis Sekarang →';
      document.getElementById('g-btn').disabled=false;
      showGenderToast('Gagal terhubung ke server. Periksa koneksi internet.');
    });
}

// ── NIK Checker ───────────────────────────────────
function nikInputEvent(el){
  el.value = el.value.replace(/\D/g,'').slice(0,16);
  const len = el.value.length;
  const cc = document.getElementById('nik-count');
  cc.textContent=`${len}/16 digit`;
  cc.style.color = len===16?'#22d3a0':len>0?'#fbbf24':null;
}

const PROV_ICONS = {
  'Provinsi':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>',
  'Kabupaten/Kota':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/></svg>',
  'Kecamatan':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819"/></svg>',
  'Tanggal Lahir':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>',
  'Jenis Kelamin':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>',
  'Nomor Urut':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5"/></svg>',
};

let nikMap=null;

async function checkNIK(){
  const nik = document.getElementById('nik-input').value.trim();
  if(nik.length!==16||!/^\d+$/.test(nik)){
    showNIKResult({valid:false,errors:['NIK harus 16 digit angka.']});return;
  }

  document.getElementById('nik-spin').style.display='block';
  document.getElementById('nik-btn-text').textContent='Memproses…';
  document.getElementById('nik-btn').disabled=true;
  document.getElementById('nik-result').style.display='none';

  try{
    const provCode = nik.substring(0,2);
    const regCode  = nik.substring(0,4);
    const distCode = nik.substring(0,6);

    let day = parseInt(nik.substring(6,8));
    const month = nik.substring(8,10);
    const yearSh = nik.substring(10,12);
    const seq   = nik.substring(12,16);

    const gender = day>40?'Perempuan':'Laki-laki';
    if(day>40) day-=40;
    const dayStr = String(day).padStart(2,'0');
    const curY2  = new Date().getFullYear()%100;
    const fullY  = parseInt(yearSh)<=curY2?'20'+yearSh:'19'+yearSh;

    const testDate = new Date(`${fullY}-${month}-${dayStr}`);
    if(isNaN(testDate)||testDate.getMonth()+1!==parseInt(month)||testDate.getDate()!==day){
      showNIKResult({valid:false,errors:['Tanggal lahir tidak valid dalam NIK.']});return;
    }

    const [provRes,regRes,distRes] = await Promise.all([
      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`).then(r=>r.json()),
      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provCode}.json`).then(r=>r.json()),
      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regCode}.json`).then(r=>r.json()).catch(()=>[]),
    ]);

    const prov = provRes.find(p=>p.id===provCode)?.name||'Tidak ditemukan';
    const reg  = regRes.find(r=>r.id===regCode)?.name||'Tidak ditemukan';
    const dist = distRes.find(d=>d.id===distCode)?.name||'Tidak ditemukan';

    showNIKResult({
      valid:true,
      data:{
        'Provinsi':prov,
        'Kabupaten/Kota':reg,
        'Kecamatan':dist,
        'Tanggal Lahir':`${dayStr}-${month}-${fullY}`,
        'Jenis Kelamin':gender,
        'Nomor Urut':seq,
      },
      kabName:reg,
      provName:prov
    });
  }catch(e){
    showNIKResult({valid:false,errors:['Gagal mengambil data wilayah. Periksa koneksi internet.']});
  }finally{
    document.getElementById('nik-spin').style.display='none';
    document.getElementById('nik-btn-text').textContent='Cek NIK';
    document.getElementById('nik-btn').disabled=false;
  }
}

function showNIKResult(r){
  const container = document.getElementById('nik-result');
  container.style.display='block';

  if(!r.valid){
    container.innerHTML=`
      <div class="nik-error-badge">
        <div style="width:36px;height:36px;background:rgba(255,77,77,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#f87171;font-size:16px">✕</div>
        <div>
          <div style="font-weight:700;font-size:14px;color:#fca5a5;margin-bottom:4px">NIK Tidak Valid</div>
          ${r.errors.map(e=>`<div style="font-size:13px;color:rgba(252,165,165,.7)">${e}</div>`).join('')}
        </div>
      </div>`;
    return;
  }

  let cardsHtml='';
  for(const [label,value] of Object.entries(r.data)){
    cardsHtml+=`
      <div class="nik-data-card">
        <div class="nik-icon">${PROV_ICONS[label]||''}</div>
        <div>
          <div class="nik-dl">${label}</div>
          <div class="nik-dv" title="${value}">${value}</div>
        </div>
      </div>`;
  }

  container.innerHTML=`
    <div class="nik-valid-badge">
      <div style="width:36px;height:36px;background:rgba(34,211,160,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#22d3a0;font-size:16px">✓</div>
      <div>
        <div style="font-weight:700;font-size:14px;color:#6ee7c7">NIK Valid — Data Berhasil Ditemukan</div>
        <div style="font-size:12px;color:rgba(110,231,199,.6);margin-top:2px">Semua informasi kependudukan tersedia</div>
      </div>
    </div>
    <div class="nik-data-grid">${cardsHtml}</div>
    <div style="font-size:12px;color:var(--muted);font-weight:600;margin-bottom:12px;text-transform:uppercase;letter-spacing:.08em">📍 Peta Wilayah — ${r.kabName}</div>
    <div id="map" style="max-width:760px"></div>
  `;

  // Init map after DOM update
  setTimeout(()=>initNIKMap(r.kabName, r.provName), 100);
}

function initNIKMap(kabName, provName){
  if(nikMap){ nikMap.remove(); nikMap=null; }
  nikMap = L.map('map').setView([-2.5,118],5);
  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
    attribution:'&copy; OpenStreetMap &copy; CARTO',maxZoom:18
  }).addTo(nikMap);

  const query = `${kabName}, ${provName}, Indonesia`;
  fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`,{
    headers:{'User-Agent':'DevKitID/1.2.0'}
  })
  .then(r=>r.json())
  .then(data=>{
    if(data&&data.length>0){
      const lat=parseFloat(data[0].lat);
      const lon=parseFloat(data[0].lon);
      nikMap.setView([lat,lon],10);

      const icon = L.divIcon({
        html:`<div style="width:14px;height:14px;background:#ef4444;border:3px solid rgba(239,68,68,.4);border-radius:50%;box-shadow:0 0 0 8px rgba(239,68,68,.15)"></div>`,
        iconSize:[14,14],iconAnchor:[7,7],className:''
      });
      L.marker([lat,lon],{icon}).addTo(nikMap)
        .bindPopup(`<b style="font-family:Manrope,sans-serif">${kabName}</b><br><span style="font-size:12px;color:#888">${provName}</span>`)
        .openPopup();

      L.circle([lat,lon],{radius:15000,color:'#ef4444',weight:1.5,opacity:.6,fillColor:'#ef4444',fillOpacity:.08}).addTo(nikMap);
    }
  })
  .catch(()=>{/* map stays at default */});
}

// Enter key for NIK
document.getElementById('nik-input').addEventListener('keydown',e=>{if(e.key==='Enter')checkNIK()});
</script>
</body>
</html>