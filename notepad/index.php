<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NOTEPAD — Local Storage Edition</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="notepad" defer></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  /* ── LIGHT MODE (default) ── */
  :root {
    --ink: #0f0e0d;
    --paper: #f5f0e8;
    --cream: #ede8dc;
    --accent: #e8400c;
    --accent2: #2563eb;
    --gold: #c9a84c;
    --muted: #8a8070;
    --line: #d4cfc5;
    --shadow: rgba(15,14,13,0.6);
    --modal-bg: var(--paper);
    --ctx-bg: var(--paper);
  }

  /* ── DARK MODE ── */
  [data-theme="dark"] {
    --ink: #e8e4dc;
    --paper: #18171a;
    --cream: #211f24;
    --accent: #ff6b35;
    --accent2: #5b9cf6;
    --gold: #d4a843;
    --muted: #7a7468;
    --line: #2e2c32;
    --shadow: rgba(0,0,0,0.8);
    --modal-bg: #211f24;
    --ctx-bg: #211f24;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Syne', sans-serif;
    background: var(--paper);
    color: var(--ink);
    min-height: 100vh;
    overflow-x: hidden;
    transition: background 0.3s, color 0.3s;
  }

  /* Subtle paper texture */
  body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 0;
  }

  .app-wrap {
    position: relative;
    z-index: 1;
    max-width: 960px;
    margin: 0 auto;
    padding: 0 16px 40px;
  }

  /* ── Header ── */
  .header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 28px 0 20px;
    border-bottom: 3px solid var(--ink);
    transition: border-color 0.3s;
  }

  .header-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    letter-spacing: -0.04em;
    line-height: 1;
  }

  .header-title span { color: var(--accent); }

  .header-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
  }

  .header-meta {
    font-family: 'Space Mono', monospace;
    font-size: 0.7rem;
    color: var(--muted);
    text-align: right;
    line-height: 1.6;
  }

  /* ── Theme Toggle Button ── */
  .theme-toggle {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 7px 14px;
    border: 2px solid var(--ink);
    background: var(--paper);
    color: var(--ink);
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 7px;
    user-select: none;
  }
  .theme-toggle:hover { background: var(--ink); color: var(--paper); }
  .theme-toggle:active { transform: scale(0.97); }

  .theme-toggle .toggle-icon {
    width: 14px;
    height: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Sun icon */
  .icon-sun { display: none; }
  .icon-moon { display: block; }
  [data-theme="dark"] .icon-sun { display: block; }
  [data-theme="dark"] .icon-moon { display: none; }

  /* ── Tabs ── */
  .tabs-bar {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 12px 0 0;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .tabs-bar::-webkit-scrollbar { display: none; }

  .tab {
    font-family: 'Space Mono', monospace;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 8px 18px;
    border: 2px solid var(--ink);
    background: var(--cream);
    color: var(--muted);
    cursor: pointer;
    border-bottom: none;
    position: relative;
    top: 2px;
    transition: all 0.15s;
    white-space: nowrap;
    user-select: none;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .tab:hover { background: var(--paper); color: var(--ink); }
  .tab.active {
    background: var(--paper);
    color: var(--ink);
    border-color: var(--ink);
    z-index: 2;
  }

  .tab .del-tab {
    width: 14px; height: 14px;
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 12px;
    color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    border-radius: 2px;
    line-height: 1;
  }
  .tab .del-tab:hover { background: var(--accent); color: white; }

  .tab-add {
    font-size: 1.1rem;
    padding: 6px 14px;
    border: 2px dashed var(--line);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    border-bottom: none;
    top: 2px;
    position: relative;
    transition: all 0.15s;
  }
  .tab-add:hover { border-color: var(--accent); color: var(--accent); }

  /* ── Editor Panel ── */
  .editor-panel {
    border: 2px solid var(--ink);
    border-top: 3px solid var(--ink);
    background: var(--paper);
    position: relative;
    transition: background 0.3s, border-color 0.3s;
  }

  /* Toolbar */
  .toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    padding: 10px 12px;
    border-bottom: 2px solid var(--line);
    background: var(--cream);
    transition: background 0.3s, border-color 0.3s;
  }

  .btn {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 6px 12px;
    border: 2px solid var(--ink);
    background: var(--paper);
    color: var(--ink);
    cursor: pointer;
    transition: all 0.12s;
    line-height: 1;
    user-select: none;
  }
  .btn:hover { background: var(--ink); color: var(--paper); }
  .btn:active { transform: scale(0.97); }
  .btn:disabled { opacity: 0.3; cursor: not-allowed; }
  .btn:disabled:hover { background: var(--paper); color: var(--ink); }

  .btn-accent { border-color: var(--accent); color: var(--accent); }
  .btn-accent:hover { background: var(--accent); color: white; }

  .btn-blue { border-color: var(--accent2); color: var(--accent2); }
  .btn-blue:hover { background: var(--accent2); color: white; }

  .btn-gold { border-color: var(--gold); color: var(--gold); }
  .btn-gold:hover { background: var(--gold); color: white; }

  .toolbar-sep {
    width: 2px;
    background: var(--line);
    align-self: stretch;
    margin: 0 4px;
    transition: background 0.3s;
  }

  /* Textarea */
  .notes-area {
    font-family: 'Space Mono', monospace;
    font-size: 0.9rem;
    line-height: 1.75;
    padding: 24px 28px;
    width: 100%;
    min-height: 420px;
    background: transparent;
    border: none;
    outline: none;
    resize: vertical;
    color: var(--ink);
    caret-color: var(--accent);
    tab-size: 4;
    transition: color 0.3s;
  }

  .notes-area::selection { background: rgba(232,64,12,0.15); }
  [data-theme="dark"] .notes-area::selection { background: rgba(255,107,53,0.2); }

  /* Lined paper effect */
  .notes-area-wrap {
    position: relative;
    background-image: repeating-linear-gradient(
      transparent, transparent 43px,
      var(--line) 43px, var(--line) 45px
    );
    background-position: 0 24px;
    transition: background-image 0.3s;
  }

  /* ── Status bar ── */
  .statusbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    border-top: 2px solid var(--line);
    background: var(--cream);
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
    flex-wrap: wrap;
    gap: 6px;
    transition: background 0.3s, border-color 0.3s;
  }

  .status-msg {
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    transition: all 0.2s;
    min-height: 14px;
  }
  .status-ok { color: #16a34a; }
  .status-err { color: var(--accent); }
  .status-info { color: var(--accent2); }

  /* ── Find & Replace ── */
  .find-bar {
    display: none;
    flex-wrap: wrap;
    gap: 8px;
    padding: 10px 14px;
    border-top: 2px solid var(--ink);
    background: var(--cream);
    align-items: center;
    transition: background 0.3s;
  }
  .find-bar.open { display: flex; }

  .find-input {
    font-family: 'Space Mono', monospace;
    font-size: 0.75rem;
    padding: 6px 10px;
    border: 2px solid var(--ink);
    background: var(--paper);
    color: var(--ink);
    outline: none;
    width: 160px;
    transition: background 0.3s, color 0.3s, border-color 0.3s;
  }
  .find-input:focus { border-color: var(--accent2); }

  .find-count {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
    min-width: 60px;
  }

  /* ── Modal ── */
  .modal-overlay {
    position: fixed; inset: 0;
    background: var(--shadow);
    z-index: 100;
    display: none;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
  }
  .modal-overlay.open { display: flex; }

  .modal-box {
    background: var(--modal-bg);
    border: 3px solid var(--ink);
    padding: 32px 36px;
    width: 90%;
    max-width: 380px;
    box-shadow: 8px 8px 0 var(--ink);
    animation: pop .2s ease;
    transition: background 0.3s, border-color 0.3s;
  }
  @keyframes pop {
    from { transform: scale(0.92) translateY(10px); opacity: 0; }
    to   { transform: scale(1) translateY(0); opacity: 1; }
  }
  .modal-title {
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    margin-bottom: 18px;
  }
  .modal-input {
    font-family: 'Space Mono', monospace;
    font-size: 0.85rem;
    padding: 10px 14px;
    border: 2px solid var(--ink);
    background: var(--cream);
    color: var(--ink);
    width: 100%;
    outline: none;
    margin-bottom: 16px;
    transition: background 0.3s, color 0.3s, border-color 0.3s;
  }
  .modal-input:focus { border-color: var(--accent2); }
  .modal-actions { display: flex; gap: 10px; }

  /* ── Context Menu ── */
  #ctxMenu {
    position: fixed;
    background: var(--ctx-bg);
    border: 2px solid var(--ink);
    box-shadow: 4px 4px 0 var(--ink);
    z-index: 200;
    display: none;
    min-width: 160px;
    overflow: hidden;
    transition: background 0.3s, border-color 0.3s;
  }
  #ctxMenu button {
    display: block;
    width: 100%;
    text-align: left;
    font-family: 'Space Mono', monospace;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 9px 16px;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--ink);
    transition: background 0.1s;
  }
  #ctxMenu button:hover { background: var(--ink); color: var(--paper); }
  #ctxMenu hr { border: none; border-top: 2px solid var(--line); }

  /* ── Stats panel ── */
  .stats-row {
    display: flex;
    gap: 24px;
    padding: 10px 16px;
    border-bottom: 2px solid var(--line);
    background: var(--cream);
    flex-wrap: wrap;
    transition: background 0.3s, border-color 0.3s;
  }
  .stat-item {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .stat-val {
    font-size: 1rem;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    color: var(--ink);
  }

  /* ── Toast ── */
  .toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: var(--ink);
    color: var(--paper);
    font-family: 'Space Mono', monospace;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 12px 20px;
    border: 2px solid var(--gold);
    box-shadow: 4px 4px 0 var(--gold);
    z-index: 300;
    transform: translateY(80px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(.22,1,.36,1);
  }
  .toast.show { transform: translateY(0); opacity: 1; }

  /* Scrollbar */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: var(--cream); }
  ::-webkit-scrollbar-thumb { background: var(--muted); }

  @media (max-width: 600px) {
    .toolbar { gap: 3px; }
    .btn { padding: 5px 8px; font-size: 0.6rem; }
    .notes-area { padding: 16px; font-size: 0.8rem; }
    .stats-row { gap: 12px; }
    .theme-toggle { padding: 5px 10px; font-size: 0.6rem; }
  }
</style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>
<div class="app-wrap">

  <!-- Header -->
  <header class="header">
    <div>
      <div class="header-title">NOTE<span>PAD</span></div>
      <div style="font-family:'Space Mono',monospace;font-size:0.65rem;color:var(--muted);margin-top:4px;letter-spacing:0.08em;">LOCAL STORAGE EDITION — NO SERVER NEEDED</div>
    </div>
    <div class="header-right">
      <!-- Theme Toggle -->
      <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <span class="toggle-icon">
          <!-- Moon icon (light mode) -->
          <svg class="icon-moon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
          </svg>
          <!-- Sun icon (dark mode) -->
          <svg class="icon-sun" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
        </span>
        <span id="themeLabel">DARK MODE</span>
      </button>
      <div class="header-meta">
        <div id="clock">--:--:--</div>
        <div id="datedisp">--- --, ----</div>
        <div style="margin-top:4px;">AUTO-SAVE: <span id="autosave-status" style="color:var(--accent)">OFF</span></div>
      </div>
    </div>
  </header>

  <!-- Tabs -->
  <div style="display:flex;align-items:flex-end;padding-top:16px;">
    <div class="tabs-bar" id="tabsBar"></div>
    <button class="tab-add btn" id="addTabBtn" title="Tambah kategori baru" style="font-size:1.1rem;padding:6px 14px;">＋</button>
  </div>

  <!-- Editor Panel -->
  <div class="editor-panel">

    <!-- Toolbar -->
    <div class="toolbar">
      <button class="btn btn-accent" id="undoBtn" disabled title="Ctrl+Z">↩ Undo</button>
      <button class="btn btn-accent" id="redoBtn" disabled title="Ctrl+Y">↪ Redo</button>
      <div class="toolbar-sep"></div>
      <button class="btn" id="cutBtn" title="Ctrl+X">✂ Cut</button>
      <button class="btn" id="copyBtn" title="Ctrl+C">⎘ Copy</button>
      <button class="btn" id="pasteBtn" title="Ctrl+V">⊕ Paste</button>
      <button class="btn" id="selAllBtn" title="Ctrl+A">⊞ All</button>
      <div class="toolbar-sep"></div>
      <button class="btn btn-blue" id="findBtn" title="Ctrl+F">⌕ Find</button>
      <button class="btn" id="wrapBtn">⇌ Wrap</button>
      <div class="toolbar-sep"></div>
      <button class="btn btn-gold" id="dlTxtBtn">↓ .TXT</button>
      <button class="btn btn-gold" id="dlMdBtn">↓ .MD</button>
      <button class="btn btn-gold" id="dlHtmlBtn">↓ .HTML</button>
      <div class="toolbar-sep"></div>
      <button class="btn" id="autoSaveToggle">⏱ AutoSave</button>
      <button class="btn" id="saveBtn" style="margin-left:auto;">💾 Save</button>
    </div>

    <!-- Stats -->
    <div class="stats-row">
      <div class="stat-item"><span class="stat-val" id="statChars">0</span>Characters</div>
      <div class="stat-item"><span class="stat-val" id="statWords">0</span>Words</div>
      <div class="stat-item"><span class="stat-val" id="statLines">1</span>Lines</div>
      <div class="stat-item"><span class="stat-val" id="statSel">0</span>Selected</div>
      <div class="stat-item"><span class="stat-val" id="statPos">1:1</span>Position</div>
    </div>

    <!-- Find bar -->
    <div class="find-bar" id="findBar">
      <input class="find-input" id="findInput" placeholder="Find...">
      <input class="find-input" id="replaceInput" placeholder="Replace with...">
      <button class="btn btn-blue" id="findPrevBtn">↑</button>
      <button class="btn btn-blue" id="findNextBtn">↓</button>
      <button class="btn" id="replaceOneBtn">Replace</button>
      <button class="btn" id="replaceAllBtn">All</button>
      <span class="find-count" id="findCount"></span>
      <button class="btn btn-accent" id="closeFindBtn">✕</button>
    </div>

    <!-- Textarea -->
    <div class="notes-area-wrap">
      <textarea class="notes-area" id="notes" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off"></textarea>
    </div>

    <!-- Statusbar -->
    <div class="statusbar">
      <span class="status-msg" id="statusMsg"></span>
      <span id="savedLabel" style="font-family:'Space Mono',monospace;font-size:0.65rem;color:var(--muted);">Last saved: —</span>
    </div>
  </div>

</div>

<!-- Context Menu -->
<div id="ctxMenu">
  <button id="ctx-cut">✂ Cut</button>
  <button id="ctx-copy">⎘ Copy</button>
  <button id="ctx-paste">⊕ Paste</button>
  <hr>
  <button id="ctx-selall">⊞ Select All</button>
  <button id="ctx-undo">↩ Undo</button>
  <button id="ctx-redo">↪ Redo</button>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal">
  <div class="modal-box">
    <div class="modal-title">New Category</div>
    <input class="modal-input" id="modalInput" placeholder="Category name..." maxlength="30">
    <div class="modal-actions">
      <button class="btn btn-blue" id="modalConfirm" style="flex:1;padding:10px;">Create</button>
      <button class="btn btn-accent" id="modalCancel" style="padding:10px 16px;">✕</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<script>
$(function(){

  // ─── Theme Toggle ───
  const THEME_KEY = 'notepad_theme';

  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      $('#themeLabel').text('LIGHT MODE');
    } else {
      document.documentElement.removeAttribute('data-theme');
      $('#themeLabel').text('DARK MODE');
    }
    localStorage.setItem(THEME_KEY, theme);
  }

  // Load saved theme on startup
  const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
  applyTheme(savedTheme);

  $('#themeToggle').click(function() {
    const current = document.documentElement.getAttribute('data-theme');
    applyTheme(current === 'dark' ? 'light' : 'dark');
    status(current === 'dark' ? 'Light Mode' : 'Dark Mode', 'info');
  });

  // ─── State ───
  const STORAGE_KEY = 'notepad_v2_categories';
  const NOTE_PREFIX = 'notepad_v2_note_';
  let categories = [];
  let activeTab = null;
  let wordWrap = true;
  let autoSave = false;
  let autoSaveTimer = null;
  let autoSaveInterval = null;
  let historyMap = {};
  let historyIndexMap = {};
  let findMatches = [];
  let findCursor = -1;

  const $ta = $('#notes');
  const ta = $ta[0];

  // ─── Persistence ───
  function loadData(){
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      categories = raw ? JSON.parse(raw) : [];
    } catch(e){ categories = []; }
    if(!categories.length) categories = ['Umum','Personal','Work'];
    categories.forEach(c => {
      if(!historyMap[c]) initHistory(c, loadNote(c));
    });
    if(!activeTab || !categories.includes(activeTab)) activeTab = categories[0];
  }

  function saveData(){
    localStorage.setItem(STORAGE_KEY, JSON.stringify(categories));
  }

  function loadNote(cat){
    return localStorage.getItem(NOTE_PREFIX + cat) || '';
  }

  function saveNote(cat, content){
    localStorage.setItem(NOTE_PREFIX + cat, content);
  }

  function deleteNote(cat){
    localStorage.removeItem(NOTE_PREFIX + cat);
  }

  // ─── History ───
  function initHistory(cat, text){
    historyMap[cat] = [text];
    historyIndexMap[cat] = 0;
  }

  function pushHistory(cat, text){
    let h = historyMap[cat] || [''];
    let i = historyIndexMap[cat] || 0;
    h = h.slice(0, i+1);
    if(h[h.length-1] === text) return;
    h.push(text);
    if(h.length > 100) h.shift();
    else i++;
    historyMap[cat] = h;
    historyIndexMap[cat] = h.length-1;
    updateUndoRedo();
  }

  function undoAction(){
    let i = historyIndexMap[activeTab];
    if(i <= 0) return;
    i--;
    historyIndexMap[activeTab] = i;
    ta.value = historyMap[activeTab][i];
    updateStats(); updateUndoRedo();
    status('Undo','info');
  }

  function redoAction(){
    let h = historyMap[activeTab], i = historyIndexMap[activeTab];
    if(i >= h.length-1) return;
    i++;
    historyIndexMap[activeTab] = i;
    ta.value = h[i];
    updateStats(); updateUndoRedo();
    status('Redo','info');
  }

  function updateUndoRedo(){
    const h = historyMap[activeTab]||[], i = historyIndexMap[activeTab]||0;
    $('#undoBtn').prop('disabled', i<=0);
    $('#redoBtn').prop('disabled', i>=h.length-1);
  }

  // ─── Tabs ───
  function renderTabs(){
    const $bar = $('#tabsBar').empty();
    categories.forEach(cat => {
      const isActive = cat === activeTab;
      const $tab = $(`<div class="tab${isActive?' active':''}" data-cat="${cat}">
        <span class="tab-label">${escHtml(cat)}</span>
        <button class="del-tab" data-cat="${cat}" title="Delete">×</button>
      </div>`);
      $bar.append($tab);
    });
  }

  function switchTab(cat){
    if(activeTab) saveNote(activeTab, ta.value);
    activeTab = cat;
    const text = loadNote(cat);
    ta.value = text;
    if(!historyMap[cat]) initHistory(cat, text);
    renderTabs();
    updateStats();
    updateUndoRedo();
    status(`Loaded "${cat}"`, 'info');
  }

  $(document).on('click', '.tab', function(e){
    if($(e.target).hasClass('del-tab')) return;
    switchTab($(this).data('cat'));
  });

  $(document).on('click', '.del-tab', function(e){
    e.stopPropagation();
    const cat = $(this).data('cat');
    if(categories.length === 1){ status('Cannot delete last category','err'); return; }
    if(!confirm(`Delete category "${cat}" and all its notes?`)) return;
    deleteNote(cat);
    delete historyMap[cat]; delete historyIndexMap[cat];
    categories = categories.filter(c => c !== cat);
    saveData();
    if(activeTab === cat) activeTab = categories[0];
    renderTabs();
    switchTab(activeTab);
    status(`Deleted "${cat}"`, 'err');
  });

  // ─── Add Category ───
  $('#addTabBtn').click(() => {
    $('#modal').addClass('open');
    $('#modalInput').val('').focus();
  });

  $('#modalConfirm').click(createCategory);
  $('#modalInput').keypress(e => { if(e.which===13) createCategory(); });
  $('#modalCancel, #modal').click(e => {
    if(e.target === e.currentTarget || $(e.target).is('#modalCancel')) $('#modal').removeClass('open');
  });

  function createCategory(){
    const name = $('#modalInput').val().trim().replace(/[^a-zA-Z0-9_\-\sÀ-ÖØ-öø-ÿ]/g,'').slice(0,30);
    if(!name){ status('Invalid name','err'); return; }
    if(categories.includes(name)){ status('Already exists','err'); return; }
    categories.push(name);
    saveData();
    initHistory(name, '');
    $('#modal').removeClass('open');
    switchTab(name);
    status(`Created "${name}"`, 'ok');
  }

  // ─── Editor events ───
  let inputTimer = null;
  $ta.on('input', function(){
    updateStats();
    clearTimeout(inputTimer);
    inputTimer = setTimeout(() => pushHistory(activeTab, ta.value), 500);
    if(autoSave){
      clearTimeout(autoSaveTimer);
      autoSaveTimer = setTimeout(() => { doSave(); }, 3000);
    }
  });

  $ta.on('keydown', function(e){
    if(e.ctrlKey||e.metaKey){
      switch(e.key.toLowerCase()){
        case 'z': e.preventDefault(); e.shiftKey ? redoAction() : undoAction(); break;
        case 'y': e.preventDefault(); redoAction(); break;
        case 's': e.preventDefault(); doSave(); break;
        case 'f': e.preventDefault(); openFind(); break;
        case 'a': e.preventDefault(); ta.select(); updateStats(); break;
      }
    }
    if(e.key==='Tab'){ e.preventDefault(); insertAtCursor('    '); }
    if(e.key==='Escape') closeFindBar();
  });

  $ta.on('keyup mouseup', updateStats);
  $ta.on('select', updateStats);

  function insertAtCursor(text){
    const s = ta.selectionStart, end = ta.selectionEnd;
    ta.value = ta.value.slice(0,s)+text+ta.value.slice(end);
    ta.selectionStart = ta.selectionEnd = s+text.length;
    updateStats();
    pushHistory(activeTab, ta.value);
  }

  // ─── Save ───
  function doSave(){
    saveNote(activeTab, ta.value);
    pushHistory(activeTab, ta.value);
    const now = new Date();
    const t = now.toLocaleTimeString('id-ID');
    $('#savedLabel').text('Last saved: '+t);
    status('Saved!','ok');
  }

  $('#saveBtn').click(doSave);

  // ─── AutoSave ───
  $('#autoSaveToggle').click(function(){
    autoSave = !autoSave;
    $('#autosave-status').text(autoSave?'ON':'OFF').css('color', autoSave?'#16a34a':'var(--accent)');
    if(autoSave){
      autoSaveInterval = setInterval(doSave, 30000);
      status('AutoSave ON — every 30s','ok');
    } else {
      clearInterval(autoSaveInterval);
      status('AutoSave OFF','info');
    }
  });

  // ─── Clipboard ───
  $('#cutBtn, #ctx-cut').click(async function(){
    const s=ta.selectionStart, e=ta.selectionEnd;
    if(s===e){ status('Nothing selected','err'); return; }
    const text = ta.value.slice(s,e);
    await navigator.clipboard.writeText(text).catch(()=>{});
    ta.value = ta.value.slice(0,s)+ta.value.slice(e);
    ta.selectionStart=ta.selectionEnd=s;
    updateStats(); pushHistory(activeTab, ta.value);
    status('Cut ✓','ok');
  });

  $('#copyBtn, #ctx-copy').click(async function(){
    const text = ta.value.slice(ta.selectionStart, ta.selectionEnd) || ta.value;
    await navigator.clipboard.writeText(text).catch(()=>{});
    status('Copied ✓','ok');
  });

  $('#pasteBtn, #ctx-paste').click(async function(){
    try {
      const text = await navigator.clipboard.readText();
      insertAtCursor(text);
      status('Pasted ✓','ok');
    } catch(e){ status('Clipboard denied','err'); }
  });

  $('#selAllBtn, #ctx-selall').click(function(){ ta.select(); updateStats(); });
  $('#ctx-undo').click(undoAction);
  $('#ctx-redo').click(redoAction);

  // ─── Word Wrap ───
  $('#wrapBtn').click(function(){
    wordWrap = !wordWrap;
    $ta.css({
      'white-space': wordWrap ? 'pre-wrap' : 'pre',
      'overflow-x': wordWrap ? 'hidden' : 'auto'
    });
    $(this).text(wordWrap ? '⇌ Wrap' : '→ No Wrap');
    status('Word Wrap: '+(wordWrap?'ON':'OFF'),'info');
  });

  // ─── Download ───
  function download(content, filename, mime){
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([content], {type:mime}));
    a.download = filename;
    a.click();
    URL.revokeObjectURL(a.href);
    toast('Downloaded: '+filename);
  }

  function filename(ext){ return activeTab.replace(/\s+/g,'_')+'_'+new Date().toISOString().slice(0,10)+'.'+ext; }

  $('#dlTxtBtn').click(() => download(ta.value, filename('txt'), 'text/plain'));
  $('#dlMdBtn').click(() => download(ta.value, filename('md'), 'text/markdown'));
  $('#dlHtmlBtn').click(() => {
    const html = `<!DOCTYPE html>\n<html>\n<head><meta charset="UTF-8"><title>${escHtml(activeTab)}</title><style>body{font-family:monospace;max-width:800px;margin:40px auto;padding:0 20px;line-height:1.7;white-space:pre-wrap;}</style></head>\n<body>${escHtml(ta.value)}</body>\n</html>`;
    download(html, filename('html'), 'text/html');
  });

  // ─── Find & Replace ───
  function openFind(){
    $('#findBar').addClass('open');
    $('#findInput').focus();
    runFind();
  }
  function closeFindBar(){
    $('#findBar').removeClass('open');
    findMatches=[]; findCursor=-1; $('#findCount').text('');
    ta.focus();
  }

  $('#findBtn').click(openFind);
  $('#closeFindBtn').click(closeFindBar);
  $('#findInput').on('input', runFind);

  function runFind(){
    const q = $('#findInput').val();
    findMatches = [];
    if(!q){ $('#findCount').text(''); return; }
    const text = ta.value;
    const re = new RegExp(escapeRe(q), 'gi');
    let m;
    while((m = re.exec(text)) !== null) findMatches.push(m.index);
    findCursor = findMatches.length ? 0 : -1;
    $('#findCount').text(findMatches.length ? `${findCursor+1}/${findMatches.length}` : '0');
    if(findMatches.length) highlightFind();
  }

  function highlightFind(){
    if(findCursor<0||!findMatches.length) return;
    const pos = findMatches[findCursor];
    const len = $('#findInput').val().length;
    ta.focus();
    ta.setSelectionRange(pos, pos+len);
    $('#findCount').text(`${findCursor+1}/${findMatches.length}`);
  }

  $('#findNextBtn').click(() => {
    if(!findMatches.length) return;
    findCursor = (findCursor+1)%findMatches.length;
    highlightFind();
  });

  $('#findPrevBtn').click(() => {
    if(!findMatches.length) return;
    findCursor = (findCursor-1+findMatches.length)%findMatches.length;
    highlightFind();
  });

  $('#replaceOneBtn').click(() => {
    const q=$('#findInput').val(), r=$('#replaceInput').val();
    if(!q||findCursor<0||!findMatches.length) return;
    const pos=findMatches[findCursor];
    ta.value = ta.value.slice(0,pos)+r+ta.value.slice(pos+q.length);
    pushHistory(activeTab, ta.value);
    runFind(); updateStats();
    status(`Replaced 1 occurrence`,'ok');
  });

  $('#replaceAllBtn').click(() => {
    const q=$('#findInput').val(), r=$('#replaceInput').val();
    if(!q) return;
    const re = new RegExp(escapeRe(q),'gi');
    const count = (ta.value.match(re)||[]).length;
    ta.value = ta.value.replace(re, r);
    pushHistory(activeTab, ta.value);
    runFind(); updateStats();
    status(`Replaced ${count} occurrences`,'ok');
  });

  // ─── Stats ───
  function updateStats(){
    const text = ta.value;
    const sel = ta.selectionEnd - ta.selectionStart;
    const chars = text.length;
    const words = text.trim() ? text.trim().split(/\s+/).length : 0;
    const lines = text.split('\n').length;
    const before = text.slice(0, ta.selectionStart);
    const lineNum = before.split('\n').length;
    const col = before.split('\n').pop().length + 1;
    $('#statChars').text(chars.toLocaleString());
    $('#statWords').text(words.toLocaleString());
    $('#statLines').text(lines.toLocaleString());
    $('#statSel').text(sel.toLocaleString());
    $('#statPos').text(`${lineNum}:${col}`);
  }

  // ─── Context Menu ───
  $ta.on('contextmenu', function(e){
    e.preventDefault();
    const $m = $('#ctxMenu');
    $m.css({ display:'block', top: e.clientY+'px', left: e.clientX+'px' });
    const r = $m[0].getBoundingClientRect();
    if(r.right > window.innerWidth) $m.css('left', (e.clientX - r.width)+'px');
    if(r.bottom > window.innerHeight) $m.css('top', (e.clientY - r.height)+'px');
  });

  $(document).on('click', function(){ $('#ctxMenu').hide(); });
  $ta.on('keydown', function(){ $('#ctxMenu').hide(); });

  // ─── Clock ───
  function tick(){
    const now = new Date();
    $('#clock').text(now.toLocaleTimeString('id-ID'));
    $('#datedisp').text(now.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}));
  }
  tick(); setInterval(tick, 1000);

  // ─── Toast ───
  function toast(msg){
    const $t = $('#toast').text(msg).addClass('show');
    setTimeout(() => $t.removeClass('show'), 2800);
  }

  // ─── Status ───
  function status(msg, type='info'){
    const cls = {'ok':'status-ok','err':'status-err','info':'status-info'}[type]||'status-info';
    $('#statusMsg').attr('class','status-msg '+cls).text(msg);
    clearTimeout(window._stTimer);
    window._stTimer = setTimeout(()=>$('#statusMsg').text(''), 2500);
  }

  // ─── Helpers ───
  function escHtml(s){ return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
  function escapeRe(s){ return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }

  // ─── Init ───
  loadData();
  renderTabs();
  ta.value = loadNote(activeTab);
  updateStats();
  updateUndoRedo();
  status('Ready','ok');

  $ta.on('keydown', function(e){
    if(e.key==='F5'){ e.preventDefault(); return; }
  });

  $(window).on('beforeunload', function(){
    saveNote(activeTab, ta.value);
    saveData();
  });

});
</script>
</body>
</html>