<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Calculator</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="calc" defer></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --bg-primary: #202020;
    --bg-secondary: #2d2d2d;
    --bg-sidebar: #1a1a1a;
    --bg-btn: #3a3a3a;
    --bg-btn-hover: #484848;
    --bg-btn-active: #555;
    --bg-op: #4a4a4a;
    --bg-op-hover: #5a5a5a;
    --accent: #0078d4;
    --accent-hover: #1084d8;
    --text-primary: #ffffff;
    --text-secondary: #adadad;
    --text-dim: #757575;
    --border: #3a3a3a;
    --btn-eq: #0078d4;
    --btn-eq-hover: #1890ff;
    --btn-op-text: #fff;
    --glass: rgba(255,255,255,0.04);
    --bottom-nav-h: 56px;
  }
  html, body {
    font-family: 'Segoe UI', sans-serif;
    background: #141414;
    height: 100%;
    overflow: hidden;
  }
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    min-height: 100dvh;
  }

  /* ---- APP CONTAINER ---- */
  .app-container {
    display: flex;
    width: 820px;
    height: 620px;
    max-width: 100vw;
    max-height: 100vh;
    max-height: 100dvh;
    background: var(--bg-primary);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.07);
    position: relative;
  }

  /* ---- SIDEBAR (desktop) ---- */
  .sidebar {
    width: 240px;
    min-width: 240px;
    background: var(--bg-sidebar);
    display: flex;
    flex-direction: column;
    border-right: 1px solid var(--border);
    transition: all 0.2s;
    overflow-y: auto;
  }
  .sidebar-title {
    padding: 20px 20px 10px;
    font-size: 22px;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.3px;
  }
  .sidebar-section {
    padding: 6px 8px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--text-dim);
    padding-left: 14px;
    margin-top: 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 14px;
    padding: 10px 14px;
    margin: 1px 8px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 14px;
    transition: background 0.12s, color 0.12s;
    user-select: none;
  }
  .nav-item:hover { background: var(--glass); color: var(--text-primary); }
  .nav-item.active { background: rgba(0,120,212,0.18); color: var(--text-primary); }
  .nav-item .icon { font-size: 17px; width: 22px; text-align: center; }
  .nav-divider { height: 1px; background: var(--border); margin: 8px 12px; }

  /* ---- BOTTOM NAV (mobile) ---- */
  .bottom-nav {
    display: none;
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: var(--bottom-nav-h);
    background: var(--bg-sidebar);
    border-top: 1px solid var(--border);
    z-index: 100;
    overflow-x: auto;
    overflow-y: hidden;
    scrollbar-width: none;
  }
  .bottom-nav::-webkit-scrollbar { display: none; }
  .bottom-nav-inner {
    display: flex;
    height: 100%;
    min-width: max-content;
    padding: 0 4px;
  }
  .bnav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2px;
    padding: 6px 14px;
    cursor: pointer;
    color: var(--text-dim);
    font-size: 10px;
    white-space: nowrap;
    transition: color 0.12s;
    border-top: 2px solid transparent;
    user-select: none;
  }
  .bnav-item.active {
    color: var(--accent);
    border-top-color: var(--accent);
  }
  .bnav-item .icon { font-size: 18px; }

  /* ---- MAIN CALC ---- */
  .calc-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-width: 0;
  }

  /* ---- DISPLAY ---- */
  .display-area {
    padding: 12px 20px 8px;
    background: var(--bg-primary);
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
  }
  .history-line {
    font-size: 13px;
    color: var(--text-dim);
    text-align: right;
    min-height: 20px;
    font-family: 'JetBrains Mono', monospace;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .main-display {
    font-size: 48px;
    font-weight: 300;
    color: var(--text-primary);
    text-align: right;
    line-height: 1.1;
    font-family: 'JetBrains Mono', monospace;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    letter-spacing: -1px;
    min-height: 58px;
    transition: font-size 0.1s;
  }
  .main-display.sm { font-size: 30px; }
  .main-display.xs { font-size: 22px; }

  /* ---- BUTTON AREA ---- */
  .btn-area {
    flex: 1;
    padding: 8px 12px 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0;
  }
  .btn-grid {
    display: grid;
    gap: 5px;
    flex: 1;
    min-height: 0;
  }
  .btn {
    background: var(--bg-btn);
    color: var(--text-primary);
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-family: 'Segoe UI', sans-serif;
    font-weight: 400;
    cursor: pointer;
    transition: background 0.08s, transform 0.06s;
    user-select: none;
    display: flex; align-items: center; justify-content: center;
    min-height: 0;
    touch-action: manipulation;
    -webkit-tap-highlight-color: transparent;
  }
  .btn:hover { background: var(--bg-btn-hover); }
  .btn:active { background: var(--bg-btn-active); transform: scale(0.97); }
  .btn.op { background: var(--bg-op); }
  .btn.op:hover { background: var(--bg-op-hover); }
  .btn.eq { background: var(--btn-eq); font-size: 22px; }
  .btn.eq:hover { background: var(--btn-eq-hover); }
  .btn.fn { background: var(--bg-secondary); font-size: 13px; }
  .btn.fn:hover { background: var(--bg-btn-hover); }
  .btn.clear { background: var(--bg-op); color: #ff6b6b; }
  .btn.clear:hover { background: #5a3535; }
  .btn.neg-btn { color: var(--text-secondary); font-size: 13px; }
  .btn.span2 { grid-column: span 2; }
  .btn.span3 { grid-column: span 3; }

  /* ---- MODE PANELS ---- */
  .mode-panel { display: none; flex: 1; flex-direction: column; overflow: hidden; min-height: 0; }
  .mode-panel.active { display: flex; }

  /* STANDARD */
  #panel-standard .btn-grid {
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(6, 1fr);
  }

  /* SCIENTIFIC */
  #panel-scientific .btn-grid {
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(7, 1fr);
  }
  #panel-scientific .display-area .main-display { font-size: 36px; }

  /* PROGRAMMER */
  #panel-programmer .display-area { padding-bottom: 6px; }
  .prog-bases {
    display: flex; gap: 8px; margin-top: 6px;
  }
  .base-btn {
    flex: 1; padding: 5px 8px; border-radius: 5px; border: 1px solid var(--border);
    background: transparent; color: var(--text-dim); font-size: 12px;
    cursor: pointer; text-align: center; font-family: 'JetBrains Mono';
    transition: all 0.12s;
  }
  .base-btn.active { background: rgba(0,120,212,0.25); color: var(--text-primary); border-color: var(--accent); }
  .base-display {
    display: flex; flex-direction: column; gap: 2px; margin-top: 6px;
  }
  .base-row {
    display: flex; gap: 8px; align-items: center;
  }
  .base-label { font-size: 10px; color: var(--text-dim); width: 26px; font-family: 'JetBrains Mono'; }
  .base-value { font-size: 13px; color: var(--text-secondary); font-family: 'JetBrains Mono'; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  #panel-programmer .btn-grid {
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(6, 1fr);
  }

  /* GRAPHING */
  .graph-container {
    flex: 1; display: flex; flex-direction: column; padding: 10px 12px;
    gap: 8px; overflow: hidden;
  }
  .graph-input-row { display: flex; gap: 6px; flex-shrink: 0; }
  .graph-input {
    flex: 1; background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 8px 12px; color: var(--text-primary);
    font-size: 14px; font-family: 'JetBrains Mono';
    outline: none;
    transition: border-color 0.15s;
  }
  .graph-input:focus { border-color: var(--accent); }
  .graph-plot-btn {
    background: var(--accent); color: #fff; border: none; border-radius: 6px;
    padding: 8px 16px; cursor: pointer; font-size: 14px; font-family: 'Segoe UI';
    transition: background 0.1s; flex-shrink: 0;
  }
  .graph-plot-btn:hover { background: var(--btn-eq-hover); }
  canvas#graph {
    flex: 1; background: #1a1a2e; border-radius: 8px;
    border: 1px solid var(--border); min-height: 0; width: 100%;
  }
  .graph-controls {
    display: flex; gap: 6px; align-items: center; justify-content: center;
    flex-shrink: 0; flex-wrap: wrap;
  }
  .graph-ctrl-btn {
    background: var(--bg-btn); color: var(--text-primary); border: none;
    border-radius: 5px; padding: 4px 10px; cursor: pointer; font-size: 12px;
    transition: background 0.1s;
  }
  .graph-ctrl-btn:hover { background: var(--bg-btn-hover); }
  .graph-range { font-size: 11px; color: var(--text-dim); font-family: 'JetBrains Mono'; }
  .graph-error { color: #ff6b6b; font-size: 12px; min-height: 16px; text-align: center; flex-shrink: 0; }

  /* DATE CALC */
  .date-container {
    flex: 1; padding: 16px 20px; display: flex; flex-direction: column; gap: 14px; overflow-y: auto;
  }
  .date-mode-tabs {
    display: flex; gap: 0; border-radius: 7px; overflow: hidden; border: 1px solid var(--border);
  }
  .date-mode-tab {
    flex: 1; padding: 8px; background: var(--bg-secondary); color: var(--text-dim);
    font-size: 13px; text-align: center; cursor: pointer; border: none;
    transition: all 0.12s; font-family: 'Segoe UI';
  }
  .date-mode-tab.active { background: rgba(0,120,212,0.2); color: var(--text-primary); }
  .date-field { display: flex; flex-direction: column; gap: 4px; }
  .date-label { font-size: 12px; color: var(--text-dim); }
  .date-input {
    background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 9px 12px; color: var(--text-primary);
    font-size: 14px; font-family: 'JetBrains Mono'; outline: none;
    transition: border-color 0.15s; width: 100%;
  }
  .date-input:focus { border-color: var(--accent); }
  .date-result-box {
    background: var(--bg-secondary); border-radius: 8px; padding: 14px 16px;
    border: 1px solid var(--border); flex: 1;
  }
  .date-result-title { font-size: 11px; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
  .date-result-main { font-size: 28px; font-weight: 300; color: var(--text-primary); font-family: 'JetBrains Mono'; }
  .date-result-sub { font-size: 13px; color: var(--text-secondary); margin-top: 6px; line-height: 1.8; }
  .date-add-row { display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap; }
  .date-add-num {
    background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 9px 10px; color: var(--text-primary);
    font-size: 14px; font-family: 'JetBrains Mono'; outline: none; width: 80px;
    transition: border-color 0.15s;
  }
  .date-add-num:focus { border-color: var(--accent); }
  .date-unit-select {
    flex: 1; background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 9px 10px; color: var(--text-primary);
    font-size: 13px; outline: none; cursor: pointer;
    appearance: none;
  }
  .date-add-calc-btn {
    background: var(--accent); color: #fff; border: none; border-radius: 6px;
    padding: 9px 16px; cursor: pointer; font-size: 13px;
    transition: background 0.1s; white-space: nowrap;
  }

  /* HISTORY PANEL */
  .history-panel {
    display: none;
    position: absolute; right: 0; top: 0; bottom: 0;
    width: 220px; background: var(--bg-sidebar);
    border-left: 1px solid var(--border);
    flex-direction: column; z-index: 200;
  }
  .history-panel.open { display: flex; }
  .history-head {
    padding: 14px 16px; font-size: 14px; font-weight: 600; color: var(--text-primary);
    border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;
  }
  .history-close { cursor: pointer; color: var(--text-dim); font-size: 18px; }
  .history-list { flex: 1; overflow-y: auto; padding: 8px; }
  .history-entry {
    padding: 8px 10px; border-radius: 5px; margin-bottom: 4px;
    cursor: pointer; transition: background 0.1s;
  }
  .history-entry:hover { background: var(--glass); }
  .history-expr { font-size: 11px; color: var(--text-dim); font-family: 'JetBrains Mono'; }
  .history-val { font-size: 16px; color: var(--text-primary); font-family: 'JetBrains Mono'; }
  .history-clear-btn {
    padding: 8px 12px; border-top: 1px solid var(--border);
    background: none; border: none; border-top: 1px solid var(--border);
    color: var(--text-dim); font-size: 12px; cursor: pointer; text-align: center;
    transition: color 0.1s;
  }
  .history-clear-btn:hover { color: #ff6b6b; }

  .topbar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 4px 8px; flex-shrink: 0;
  }
  .topbar-title { font-size: 13px; color: var(--text-dim); padding: 4px 8px; }
  .topbar-actions { display: flex; gap: 4px; }
  .topbar-btn {
    background: none; border: none; color: var(--text-dim); cursor: pointer;
    padding: 4px 8px; border-radius: 4px; font-size: 14px;
    transition: background 0.1s, color 0.1s;
  }
  .topbar-btn:hover { background: var(--glass); color: var(--text-primary); }

  /* Scrollbar */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #555; border-radius: 4px; }

  /* Bit display for programmer */
  .bit-display {
    display: flex; gap: 3px; flex-wrap: wrap; margin-top: 4px;
  }
  .bit {
    width: 20px; height: 20px; background: var(--bg-btn); border-radius: 3px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-family: 'JetBrains Mono'; color: var(--text-dim);
    cursor: pointer; border: 1px solid var(--border); transition: all 0.1s;
  }
  .bit.on { background: rgba(0,120,212,0.35); color: var(--text-primary); border-color: var(--accent); }
  .bit:hover { border-color: var(--accent); }
  .bit-sep { width: 4px; }

  /* UNIT CONVERTER */
  .conv-container {
    padding: 16px 20px; display: flex; flex-direction: column; gap: 12px; flex: 1; overflow-y: auto;
  }

  /* CURRENCY CONVERTER */
  .currency-container {
    padding: 14px 16px; display: flex; flex-direction: column; gap: 10px; flex: 1; overflow-y: auto;
  }
  .currency-search-wrap {
    position: relative;
  }
  .currency-search {
    width: 100%; background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 8px 12px 8px 34px; color: var(--text-primary);
    font-size: 13px; font-family: 'Segoe UI'; outline: none;
    transition: border-color 0.15s;
  }
  .currency-search:focus { border-color: var(--accent); }
  .currency-search-icon {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: var(--text-dim); font-size: 14px; pointer-events: none;
  }
  .currency-row {
    display: flex; gap: 10px; align-items: flex-end;
  }
  .currency-field { display: flex; flex-direction: column; gap: 4px; flex: 1; min-width: 0; }
  .currency-label { font-size: 11px; color: var(--text-dim); font-weight: 500; text-transform: uppercase; letter-spacing: 0.8px; }
  .currency-select-wrap { position: relative; }
  .currency-select {
    width: 100%; background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 9px 28px 9px 10px; color: var(--text-primary);
    font-size: 13px; font-family: 'JetBrains Mono'; outline: none; cursor: pointer;
    appearance: none; transition: border-color 0.15s; text-overflow: ellipsis;
  }
  .currency-select:focus { border-color: var(--accent); }
  .currency-select-arrow {
    position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
    color: var(--text-dim); font-size: 10px; pointer-events: none;
  }
  .currency-swap-btn {
    background: var(--bg-btn); border: 1px solid var(--border); color: var(--text-secondary);
    border-radius: 6px; width: 36px; height: 36px; cursor: pointer; font-size: 16px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background 0.1s, color 0.1s, transform 0.2s; margin-bottom: 0;
  }
  .currency-swap-btn:hover { background: var(--bg-btn-hover); color: var(--accent); }
  .currency-swap-btn.spinning { transform: rotate(180deg); }
  .currency-amount-row {
    display: flex; gap: 10px; align-items: flex-end;
  }
  .currency-amount-input {
    flex: 1; background: var(--bg-secondary); border: 1px solid var(--border);
    border-radius: 6px; padding: 10px 12px; color: var(--text-primary);
    font-size: 20px; font-family: 'JetBrains Mono'; outline: none; font-weight: 300;
    transition: border-color 0.15s; min-width: 0;
  }
  .currency-amount-input:focus { border-color: var(--accent); }
  .currency-convert-btn {
    background: var(--accent); color: #fff; border: none; border-radius: 6px;
    padding: 10px 16px; cursor: pointer; font-size: 13px; font-family: 'Segoe UI';
    font-weight: 500; transition: background 0.1s; flex-shrink: 0; white-space: nowrap;
  }
  .currency-convert-btn:hover { background: var(--btn-eq-hover); }
  .currency-convert-btn:disabled { background: #444; cursor: default; }
  .currency-result-box {
    background: var(--bg-secondary); border-radius: 8px; padding: 14px 16px;
    border: 1px solid var(--border); flex: 1; min-height: 0; display: flex; flex-direction: column; justify-content: center;
  }
  .currency-result-from {
    font-size: 13px; color: var(--text-dim); font-family: 'JetBrains Mono'; margin-bottom: 6px;
  }
  .currency-result-main {
    font-size: 32px; font-weight: 300; color: var(--text-primary);
    font-family: 'JetBrains Mono'; letter-spacing: -0.5px; line-height: 1.2;
  }
  .currency-result-code {
    font-size: 14px; color: var(--accent); font-family: 'JetBrains Mono'; margin-top: 4px;
  }
  .currency-result-rate {
    font-size: 11px; color: var(--text-dim); font-family: 'JetBrains Mono'; margin-top: 8px;
    border-top: 1px solid var(--border); padding-top: 8px;
  }
  .currency-status {
    font-size: 11px; text-align: center; min-height: 16px; padding: 2px 0;
    display: flex; align-items: center; justify-content: center; gap: 6px;
  }
  .currency-status.loading { color: var(--text-dim); }
  .currency-status.error { color: #ff6b6b; }
  .currency-status.ok { color: #4caf50; }
  .currency-status .spin {
    display: inline-block; animation: spin 0.8s linear infinite;
  }
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  .currency-updated {
    font-size: 10px; color: var(--text-dim); text-align: right; font-family: 'JetBrains Mono';
  }
  /* Dropdown filter for currency */
  .currency-dropdown {
    position: absolute; top: calc(100% + 4px); left: 0; right: 0; z-index: 300;
    background: var(--bg-sidebar); border: 1px solid var(--border); border-radius: 7px;
    max-height: 200px; overflow-y: auto; box-shadow: 0 8px 24px rgba(0,0,0,0.5);
    display: none;
  }
  .currency-dropdown.open { display: block; }
  .currency-dropdown-item {
    padding: 8px 12px; cursor: pointer; display: flex; gap: 10px; align-items: center;
    transition: background 0.08s; font-size: 13px;
  }
  .currency-dropdown-item:hover, .currency-dropdown-item.selected { background: rgba(0,120,212,0.18); }
  .currency-dropdown-item .cdi-code {
    font-family: 'JetBrains Mono'; font-size: 12px; font-weight: 600;
    color: var(--accent); min-width: 42px;
  }
  .currency-dropdown-item .cdi-name {
    color: var(--text-secondary); font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  }

  /* Animations */
  @keyframes fadeIn { from { opacity:0; transform: translateY(4px); } to { opacity:1; transform: none; } }
  .mode-panel.active { animation: fadeIn 0.15s ease-out; }

  /* ================================================================
     MOBILE RESPONSIVE
     ================================================================ */
  @media (max-width: 820px) {
    body { align-items: stretch; justify-content: stretch; background: #141414; }
    .app-container {
      width: 100%;
      height: 100vh;
      height: 100dvh;
      border-radius: 0;
      box-shadow: none;
      flex-direction: column;
    }

    /* Hide desktop sidebar, show bottom nav */
    .sidebar { display: none; }
    .bottom-nav { display: flex; }

    /* calc-main takes full width and leaves room for bottom nav */
    .calc-main {
      flex: 1;
      padding-bottom: var(--bottom-nav-h);
      min-height: 0;
    }

    /* History panel full-width on mobile */
    .history-panel {
      width: 100%;
      bottom: var(--bottom-nav-h);
    }

    /* Display area */
    .display-area {
      padding: 8px 14px 6px;
    }
    .main-display {
      font-size: 40px;
      min-height: 48px;
    }
    .main-display.sm { font-size: 26px; }
    .main-display.xs { font-size: 20px; }
    #panel-scientific .display-area .main-display { font-size: 28px; }
    #panel-programmer .main-display { font-size: 28px !important; }

    /* Button area */
    .btn-area {
      padding: 4px 6px 6px;
    }
    .btn-grid { gap: 4px; }
    .btn { border-radius: 5px; font-size: 15px; }
    .btn.fn { font-size: 11px; }
    .btn.eq { font-size: 20px; }

    /* Topbar */
    .topbar { padding: 2px 6px; }
    .topbar-title { font-size: 12px; }

    /* History line */
    .history-line { font-size: 11px; min-height: 16px; }

    /* Programmer panel */
    .base-display { display: none; } /* hide on small screens to save space */
    .prog-bases { gap: 4px; margin-top: 4px; }
    .base-btn { padding: 4px 6px; font-size: 11px; }
    .bit-display { display: none; } /* hide bit display on mobile */

    /* Date container */
    .date-container { padding: 12px 14px; gap: 10px; }
    .date-result-main { font-size: 22px; }
    .date-add-row { flex-wrap: wrap; }
    .date-add-num { width: 72px; }
    .date-add-calc-btn { padding: 9px 10px; font-size: 12px; }

    /* Graph */
    .graph-container { padding: 8px 10px; gap: 6px; }

    /* Converter */
    .conv-container { padding: 12px 14px; gap: 10px; }
    /* Currency Converter */
    .currency-container { padding: 10px 12px; gap: 8px; }
    .currency-result-main { font-size: 24px; }
    .currency-amount-input { font-size: 16px; }
  }

  /* Extra small (iPhone SE, etc) */
  @media (max-width: 380px) {
    .main-display { font-size: 34px; min-height: 42px; }
    .btn { font-size: 14px; }
    .btn.fn { font-size: 10px; }
    .btn-grid { gap: 3px; }
    .btn-area { padding: 3px 5px 5px; }
  }

  /* Landscape mobile */
  @media (max-width: 820px) and (orientation: landscape) {
    :root { --bottom-nav-h: 44px; }
    .display-area { padding: 4px 12px 3px; }
    .main-display { font-size: 28px; min-height: 34px; }
    .history-line { min-height: 14px; font-size: 10px; }
    .btn-area { padding: 3px 6px 4px; }
    .btn-grid { gap: 3px; }
    .topbar { padding: 1px 6px; }
    .bnav-item { font-size: 9px; padding: 4px 10px; }
    .bnav-item .icon { font-size: 15px; }
  }
</style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>

<div class="app-container" style="position:relative;">

  <!-- SIDEBAR (desktop) -->
  <div class="sidebar">
    <div class="sidebar-title">Calculator</div>
    <div class="nav-item active" data-mode="standard">
      <span class="icon">⊞</span> Standard
    </div>
    <div class="nav-item" data-mode="scientific">
      <span class="icon">∑</span> Scientific
    </div>
    <div class="nav-item" data-mode="graphing">
      <span class="icon">📈</span> Graphing
    </div>
    <div class="nav-item" data-mode="programmer">
      <span class="icon">&lt;/&gt;</span> Programmer
    </div>
    <div class="nav-item" data-mode="date">
      <span class="icon">📅</span> Date Calculation
    </div>
    <div class="nav-divider"></div>
    <div class="sidebar-section">Converter</div>
    <div class="nav-item" data-mode="converter">
      <span class="icon">⇄</span> Unit Converter
    </div>
    <div class="nav-item" data-mode="currency">
      <span class="icon">💱</span> Currency
    </div>
  </div>

  <!-- BOTTOM NAV (mobile) -->
  <div class="bottom-nav">
    <div class="bottom-nav-inner">
      <div class="bnav-item active" data-mode="standard">
        <span class="icon">⊞</span>
        Standard
      </div>
      <div class="bnav-item" data-mode="scientific">
        <span class="icon">∑</span>
        Scientific
      </div>
      <div class="bnav-item" data-mode="graphing">
        <span class="icon">📈</span>
        Graphing
      </div>
      <div class="bnav-item" data-mode="programmer">
        <span class="icon">&lt;/&gt;</span>
        Programmer
      </div>
      <div class="bnav-item" data-mode="date">
        <span class="icon">📅</span>
        Date
      </div>
      <div class="bnav-item" data-mode="converter">
        <span class="icon">⇄</span>
        Converter
      </div>
      <div class="bnav-item" data-mode="currency">
        <span class="icon">💱</span>
        Currency
      </div>
    </div>
  </div>

  <!-- MAIN -->
  <div class="calc-main">

    <!-- ======== STANDARD ======== -->
    <div class="mode-panel active" id="panel-standard">
      <div class="topbar">
        <span class="topbar-title">Standard</span>
        <div class="topbar-actions">
          <button class="topbar-btn" id="history-toggle" title="History">⏱</button>
        </div>
      </div>
      <div class="display-area">
        <div class="history-line" id="std-history"></div>
        <div class="main-display" id="std-display">0</div>
      </div>
      <div class="btn-area">
        <div class="btn-grid" id="std-grid">
          <button class="btn fn" data-action="mc">MC</button>
          <button class="btn fn" data-action="mr">MR</button>
          <button class="btn fn" data-action="m+">M+</button>
          <button class="btn fn" data-action="m-">M−</button>
          <button class="btn clear" data-action="ac">AC</button>
          <button class="btn op" data-action="sign">+/−</button>
          <button class="btn op" data-action="percent">%</button>
          <button class="btn op" data-action="div">÷</button>
          <button class="btn" data-action="7">7</button>
          <button class="btn" data-action="8">8</button>
          <button class="btn" data-action="9">9</button>
          <button class="btn op" data-action="mul">×</button>
          <button class="btn" data-action="4">4</button>
          <button class="btn" data-action="5">5</button>
          <button class="btn" data-action="6">6</button>
          <button class="btn op" data-action="sub">−</button>
          <button class="btn" data-action="1">1</button>
          <button class="btn" data-action="2">2</button>
          <button class="btn" data-action="3">3</button>
          <button class="btn op" data-action="add">+</button>
          <button class="btn span2" data-action="0">0</button>
          <button class="btn" data-action="dot">.</button>
          <button class="btn eq" data-action="eq">=</button>
        </div>
      </div>
    </div>

    <!-- ======== SCIENTIFIC ======== -->
    <div class="mode-panel" id="panel-scientific">
      <div class="topbar">
        <span class="topbar-title">Scientific</span>
        <div class="topbar-actions">
          <button class="topbar-btn" id="sci-inv-toggle" title="Inverse">INV</button>
          <button class="topbar-btn" id="sci-deg-toggle" title="Degrees/Radians">DEG</button>
        </div>
      </div>
      <div class="display-area">
        <div class="history-line" id="sci-history"></div>
        <div class="main-display" id="sci-display">0</div>
      </div>
      <div class="btn-area">
        <div class="btn-grid" id="sci-grid">
          <button class="btn fn sci" data-fn="inv_toggle">2nd</button>
          <button class="btn fn sci" data-fn="pi">π</button>
          <button class="btn fn sci" data-fn="e_const">e</button>
          <button class="btn clear" data-action="ac">C</button>
          <button class="btn op" data-action="del">⌫</button>
          <button class="btn fn sci" data-fn="sq" id="sci-sq">x²</button>
          <button class="btn fn sci" data-fn="cube" id="sci-cube">x³</button>
          <button class="btn fn sci" data-fn="pow">xʸ</button>
          <button class="btn fn sci" data-fn="exp10">10ˣ</button>
          <button class="btn fn sci" data-fn="log10">log</button>
          <button class="btn fn sci" data-fn="sqrt" id="sci-sqrt">√x</button>
          <button class="btn fn sci" data-fn="cbrt">∛x</button>
          <button class="btn fn sci" data-fn="abs">|x|</button>
          <button class="btn fn sci" data-fn="ln">ln</button>
          <button class="btn fn sci" data-fn="log2">log₂</button>
          <button class="btn fn sci" data-fn="sin" id="sci-sin">sin</button>
          <button class="btn fn sci" data-fn="cos" id="sci-cos">cos</button>
          <button class="btn fn sci" data-fn="tan" id="sci-tan">tan</button>
          <button class="btn fn sci" data-fn="inv">1/x</button>
          <button class="btn op" data-action="div">÷</button>
          <button class="btn" data-action="7">7</button>
          <button class="btn" data-action="8">8</button>
          <button class="btn" data-action="9">9</button>
          <button class="btn op" data-action="mul">×</button>
          <button class="btn op" data-action="sub">−</button>
          <button class="btn" data-action="4">4</button>
          <button class="btn" data-action="5">5</button>
          <button class="btn" data-action="6">6</button>
          <button class="btn op" data-action="add">+</button>
          <button class="btn eq" data-action="eq">=</button>
          <button class="btn" data-action="0">0</button>
          <button class="btn" data-action="1">1</button>
          <button class="btn" data-action="2">2</button>
          <button class="btn" data-action="3">3</button>
          <button class="btn" data-action="dot">.</button>
        </div>
      </div>
    </div>

    <!-- ======== PROGRAMMER ======== -->
    <div class="mode-panel" id="panel-programmer">
      <div class="topbar">
        <span class="topbar-title">Programmer</span>
      </div>
      <div class="display-area" style="padding-bottom:6px;">
        <div class="main-display" id="prog-display" style="font-size:34px;">0</div>
        <div class="base-display" id="prog-base-display">
          <div class="base-row"><span class="base-label">HEX</span><span class="base-value" id="pb-hex">0</span></div>
          <div class="base-row"><span class="base-label">DEC</span><span class="base-value" id="pb-dec">0</span></div>
          <div class="base-row"><span class="base-label">OCT</span><span class="base-value" id="pb-oct">0</span></div>
          <div class="base-row"><span class="base-label">BIN</span><span class="base-value" id="pb-bin">0</span></div>
        </div>
        <div class="prog-bases">
          <button class="base-btn" data-base="HEX">HEX</button>
          <button class="base-btn active" data-base="DEC">DEC</button>
          <button class="base-btn" data-base="OCT">OCT</button>
          <button class="base-btn" data-base="BIN">BIN</button>
        </div>
        <div class="bit-display" id="bit-display"></div>
      </div>
      <div class="btn-area">
        <div class="btn-grid" id="prog-grid">
          <button class="btn clear" data-action="ac">CE</button>
          <button class="btn op" data-action="del">⌫</button>
          <button class="btn fn" data-prog="lsh">LSH</button>
          <button class="btn fn" data-prog="rsh">RSH</button>
          <button class="btn op" data-action="div">÷</button>
          <button class="btn fn prog-hex" data-action="A">A</button>
          <button class="btn fn prog-hex" data-action="B">B</button>
          <button class="btn fn" data-prog="and">AND</button>
          <button class="btn fn" data-prog="or">OR</button>
          <button class="btn op" data-action="mul">×</button>
          <button class="btn fn prog-hex" data-action="C">C</button>
          <button class="btn fn prog-hex" data-action="D">D</button>
          <button class="btn fn" data-prog="xor">XOR</button>
          <button class="btn fn" data-prog="not">NOT</button>
          <button class="btn op" data-action="sub">−</button>
          <button class="btn fn prog-hex" data-action="E">E</button>
          <button class="btn fn prog-hex" data-action="F">F</button>
          <button class="btn" data-action="7">7</button>
          <button class="btn" data-action="8">8</button>
          <button class="btn" data-action="9">9</button>
          <button class="btn op" data-action="add">+</button>
          <button class="btn" data-action="4">4</button>
          <button class="btn" data-action="5">5</button>
          <button class="btn" data-action="6">6</button>
          <button class="btn fn" data-prog="mod">MOD</button>
          <button class="btn" data-action="1">1</button>
          <button class="btn" data-action="2">2</button>
          <button class="btn" data-action="3">3</button>
          <button class="btn" data-action="0">0</button>
          <button class="btn eq" data-action="eq">=</button>
        </div>
      </div>
    </div>

    <!-- ======== GRAPHING ======== -->
    <div class="mode-panel" id="panel-graphing">
      <div class="topbar">
        <span class="topbar-title">Graphing</span>
      </div>
      <div class="graph-container">
        <div class="graph-input-row">
          <input class="graph-input" id="graph-expr" placeholder="f(x) = e.g. sin(x), x^2-3" value="sin(x)"/>
          <button class="graph-plot-btn" id="graph-plot-btn">Plot</button>
        </div>
        <canvas id="graph"></canvas>
        <div class="graph-error" id="graph-error"></div>
        <div class="graph-controls">
          <button class="graph-ctrl-btn" id="g-zoom-in">＋ Zoom In</button>
          <button class="graph-ctrl-btn" id="g-zoom-out">－ Zoom Out</button>
          <button class="graph-ctrl-btn" id="g-reset">⟳ Reset</button>
          <span class="graph-range" id="g-range-label">x: [−10, 10]</span>
        </div>
      </div>
    </div>

    <!-- ======== DATE ======== -->
    <div class="mode-panel" id="panel-date">
      <div class="topbar">
        <span class="topbar-title">Date Calculation</span>
      </div>
      <div class="date-container">
        <div class="date-mode-tabs">
          <button class="date-mode-tab active" data-dmode="diff">Difference</button>
          <button class="date-mode-tab" data-dmode="add">Add / Subtract</button>
        </div>
        <div id="date-diff-panel">
          <div class="date-field" style="margin-bottom:10px;">
            <div class="date-label">Start Date</div>
            <input type="date" class="date-input" id="date-start"/>
          </div>
          <div class="date-field" style="margin-bottom:10px;">
            <div class="date-label">End Date</div>
            <input type="date" class="date-input" id="date-end"/>
          </div>
          <div class="date-result-box" id="date-diff-result">
            <div class="date-result-title">Difference</div>
            <div class="date-result-main" id="date-diff-main">—</div>
            <div class="date-result-sub" id="date-diff-sub"></div>
          </div>
        </div>
        <div id="date-add-panel" style="display:none;">
          <div class="date-field" style="margin-bottom:10px;">
            <div class="date-label">Start Date</div>
            <input type="date" class="date-input" id="date-add-start"/>
          </div>
          <div class="date-add-row" style="margin-bottom:10px;">
            <div class="date-field" style="flex:0 0 auto;">
              <div class="date-label">Amount</div>
              <input type="number" class="date-add-num" id="date-add-amount" value="30"/>
            </div>
            <div class="date-field" style="flex:1;">
              <div class="date-label">Unit</div>
              <select class="date-unit-select" id="date-add-unit">
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
              </select>
            </div>
            <button class="date-add-calc-btn" id="date-add-plus">+ Add</button>
            <button class="date-add-calc-btn" id="date-add-minus" style="background:#c0392b;">− Sub</button>
          </div>
          <div class="date-result-box">
            <div class="date-result-title">Result Date</div>
            <div class="date-result-main" id="date-add-result">—</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ======== UNIT CONVERTER ======== -->
    <div class="mode-panel" id="panel-converter">
      <div class="topbar"><span class="topbar-title">Unit Converter</span></div>
      <div class="conv-container">
        <div class="date-field">
          <div class="date-label">Category</div>
          <select class="date-unit-select" id="conv-category">
            <option value="length">Length</option>
            <option value="weight">Weight / Mass</option>
            <option value="temperature">Temperature</option>
            <option value="area">Area</option>
            <option value="speed">Speed</option>
            <option value="volume">Volume</option>
          </select>
        </div>
        <div style="display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
          <div class="date-field" style="flex:1; min-width:120px;">
            <div class="date-label">From</div>
            <select class="date-unit-select" id="conv-from-unit"></select>
          </div>
          <div class="date-field" style="flex:1; min-width:120px;">
            <div class="date-label">To</div>
            <select class="date-unit-select" id="conv-to-unit"></select>
          </div>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
          <div class="date-field" style="flex:1; min-width:120px;">
            <div class="date-label">Input Value</div>
            <input type="number" class="date-input" id="conv-input" value="1" step="any"/>
          </div>
          <div class="date-field" style="flex:1; min-width:120px;">
            <div class="date-label">Result</div>
            <input type="text" class="date-input" id="conv-output" readonly style="color:var(--accent);"/>
          </div>
        </div>
        <div class="date-result-box" style="flex:0;">
          <div class="date-result-title">Formula</div>
          <div id="conv-formula" style="font-size:13px; color:var(--text-secondary); font-family:'JetBrains Mono';">—</div>
        </div>
      </div>
    </div>

    <!-- ======== CURRENCY CONVERTER ======== -->
    <div class="mode-panel" id="panel-currency">
      <div class="topbar">
        <span class="topbar-title">Currency Converter</span>
        <div class="topbar-actions">
          <span class="currency-updated" id="currency-updated"></span>
        </div>
      </div>
      <div class="currency-container">

        <!-- Search / Filter -->
        <div class="currency-search-wrap">
          <span class="currency-search-icon">🔍</span>
          <input type="text" class="currency-search" id="currency-filter"
            placeholder="Filter currency by name or code (e.g. USD, Euro)…"/>
        </div>

        <!-- From / Swap / To -->
        <div class="currency-row">
          <div class="currency-field">
            <div class="currency-label">From</div>
            <div class="currency-select-wrap" style="position:relative;">
              <select class="currency-select" id="cc-from"></select>
              <span class="currency-select-arrow">▼</span>
            </div>
          </div>
          <button class="currency-swap-btn" id="cc-swap" title="Swap currencies">⇄</button>
          <div class="currency-field">
            <div class="currency-label">To</div>
            <div class="currency-select-wrap" style="position:relative;">
              <select class="currency-select" id="cc-to"></select>
              <span class="currency-select-arrow">▼</span>
            </div>
          </div>
        </div>

        <!-- Amount + Convert Button -->
        <div class="currency-amount-row">
          <input type="number" class="currency-amount-input" id="cc-amount" value="1" min="0" step="any" placeholder="Amount"/>
          <button class="currency-convert-btn" id="cc-convert-btn" disabled>Convert</button>
        </div>

        <!-- Status -->
        <div class="currency-status" id="cc-status">
          <span class="spin">⟳</span> Loading currencies…
        </div>

        <!-- Result -->
        <div class="currency-result-box" id="cc-result-box">
          <div class="currency-result-from" id="cc-result-from">—</div>
          <div class="currency-result-main" id="cc-result-main">—</div>
          <div class="currency-result-code" id="cc-result-code"></div>
          <div class="currency-result-rate" id="cc-result-rate"></div>
        </div>

      </div>
    </div>

  </div><!-- end calc-main -->

  <!-- HISTORY PANEL -->
  <div class="history-panel" id="history-panel">
    <div class="history-head">
      History
      <span class="history-close" id="history-close">✕</span>
    </div>
    <div class="history-list" id="history-list">
      <div style="text-align:center; color:var(--text-dim); font-size:12px; padding:20px;">No history yet</div>
    </div>
    <button class="history-clear-btn" id="history-clear">Clear History</button>
  </div>

</div><!-- app-container -->

<script>
$(function(){

/* ============================================================
   SHARED CALC ENGINE
   ============================================================ */
let memory = 0;
let calcState = {
  display: '0', history: '', firstOperand: null,
  operator: null, waitingForSecond: false, justCalc: false
};
let historyLog = [];

function resetState(s) {
  s.display = '0'; s.history = ''; s.firstOperand = null;
  s.operator = null; s.waitingForSecond = false; s.justCalc = false;
}
let sciState = $.extend(true, {}, calcState);
let progState = $.extend(true, {}, calcState);

function fitDisplay(val, $el) {
  const len = val.toString().length;
  $el.removeClass('sm xs');
  if (len > 18) $el.addClass('xs');
  else if (len > 12) $el.addClass('sm');
}

function renderStd() {
  fitDisplay(calcState.display, $('#std-display'));
  $('#std-display').text(calcState.display);
  $('#std-history').text(calcState.history);
}
function renderSci() {
  fitDisplay(sciState.display, $('#sci-display'));
  $('#sci-display').text(sciState.display);
  $('#sci-history').text(sciState.history);
}

function applyOperator(a, op, b) {
  switch(op) {
    case '+': return a + b;
    case '-': return a - b;
    case '*': return a * b;
    case '/': return b === 0 ? 'Cannot divide by zero' : a / b;
    case '^': return Math.pow(a, b);
    case '%mod%': return a % b;
    case 'lsh': return (a << b);
    case 'rsh': return (a >> b);
    case 'and': return (a & b);
    case 'or': return (a | b);
    case 'xor': return (a ^ b);
  }
  return b;
}

function formatNum(n) {
  if (typeof n === 'string') return n;
  if (!isFinite(n)) return 'Overflow';
  if (Math.abs(n) < 1e-10 && n !== 0) return n.toExponential(6);
  if (Math.abs(n) > 1e15) return n.toExponential(6);
  let s = parseFloat(n.toPrecision(12)).toString();
  return s;
}

function pushHistory(expr, val) {
  historyLog.unshift({expr, val});
  if (historyLog.length > 30) historyLog.pop();
  renderHistory();
}
function renderHistory() {
  const $list = $('#history-list');
  if (historyLog.length === 0) {
    $list.html('<div style="text-align:center;color:var(--text-dim);font-size:12px;padding:20px;">No history yet</div>');
    return;
  }
  $list.empty();
  historyLog.forEach((h) => {
    $list.append(`
      <div class="history-entry" data-val="${h.val}">
        <div class="history-expr">${h.expr}</div>
        <div class="history-val">${h.val}</div>
      </div>
    `);
  });
}

/* ============================================================
   STANDARD CALCULATOR
   ============================================================ */
function handleStdAction(action) {
  if (action === undefined || action === null) return;
  action = String(action);
  let s = calcState;
  if (/^[0-9]$/.test(action)) {
    if (s.waitingForSecond || s.justCalc) { s.display = action; s.waitingForSecond = false; s.justCalc = false; }
    else s.display = s.display === '0' ? action : s.display + action;
  } else if (action === 'dot') {
    if (s.waitingForSecond) { s.display = '0.'; s.waitingForSecond = false; }
    if (!s.display.includes('.')) s.display += '.';
  } else if (action === 'del') {
    s.display = s.display.length > 1 ? s.display.slice(0, -1) : '0';
  } else if (action === 'ac') {
    resetState(s);
  } else if (action === 'sign') {
    s.display = formatNum(-parseFloat(s.display));
  } else if (action === 'percent') {
    s.display = formatNum(parseFloat(s.display) / 100);
  } else if (['add','sub','mul','div'].includes(action)) {
    const opMap = {add:'+', sub:'-', mul:'*', div:'/'};
    const op = opMap[action];
    if (s.firstOperand !== null && s.operator && !s.waitingForSecond) {
      const res = applyOperator(s.firstOperand, s.operator, parseFloat(s.display));
      s.display = formatNum(res);
      s.firstOperand = typeof res === 'string' ? 0 : res;
    } else { s.firstOperand = parseFloat(s.display); }
    s.operator = op; s.history = `${formatNum(s.firstOperand)} ${op}`; s.waitingForSecond = true; s.justCalc = false;
  } else if (action === 'eq') {
    if (s.firstOperand !== null && s.operator) {
      const b = parseFloat(s.display);
      const expr = `${s.history} ${s.display} =`;
      const res = applyOperator(s.firstOperand, s.operator, b);
      const resStr = formatNum(res);
      pushHistory(expr, resStr);
      s.history = expr; s.display = resStr; s.firstOperand = null; s.operator = null; s.justCalc = true;
    }
  } else if (action === 'mc') { memory = 0; }
  else if (action === 'mr') { s.display = formatNum(memory); }
  else if (action === 'm+') { memory += parseFloat(s.display); }
  else if (action === 'm-') { memory -= parseFloat(s.display); }
  renderStd();
}

$('#panel-standard').on('click', '.btn', function(){
  handleStdAction($(this).data('action'));
});

/* ============================================================
   SCIENTIFIC CALCULATOR
   ============================================================ */
let sciInverse = false;
let sciAngleMode = 'deg';

$('#sci-inv-toggle').on('click', function(){
  sciInverse = !sciInverse;
  $(this).css('color', sciInverse ? 'var(--accent)' : '');
  updateSciLabels();
});
$('#sci-deg-toggle').on('click', function(){
  sciAngleMode = sciAngleMode === 'deg' ? 'rad' : 'deg';
  $(this).text(sciAngleMode.toUpperCase());
});

function updateSciLabels() {
  if (sciInverse) {
    $('#sci-sin').text('sin⁻¹'); $('#sci-cos').text('cos⁻¹'); $('#sci-tan').text('tan⁻¹');
    $('#sci-sq').text('√x'); $('#sci-sqrt').text('x²'); $('#sci-cube').text('y√x');
  } else {
    $('#sci-sin').text('sin'); $('#sci-cos').text('cos'); $('#sci-tan').text('tan');
    $('#sci-sq').text('x²'); $('#sci-sqrt').text('√x'); $('#sci-cube').text('x³');
  }
}

function toRad(x) { return sciAngleMode === 'deg' ? x * Math.PI / 180 : x; }
function fromRad(x) { return sciAngleMode === 'deg' ? x * 180 / Math.PI : x; }

function handleSciAction(action, fn) {
  if (action !== undefined && action !== null) action = String(action);
  let s = sciState;
  if (action && /^[0-9]$/.test(action)) {
    if (s.waitingForSecond || s.justCalc) { s.display = action; s.waitingForSecond = false; s.justCalc = false; }
    else s.display = s.display === '0' ? action : s.display + action;
  } else if (action === 'dot') {
    if (s.waitingForSecond) { s.display = '0.'; s.waitingForSecond = false; }
    if (!s.display.includes('.')) s.display += '.';
  } else if (action === 'del') {
    s.display = s.display.length > 1 ? s.display.slice(0,-1) : '0';
  } else if (action === 'ac') {
    resetState(s);
  } else if (action === 'sign') {
    s.display = formatNum(-parseFloat(s.display));
  } else if (['add','sub','mul','div'].includes(action)) {
    const opMap = {add:'+',sub:'-',mul:'*',div:'/'};
    const op = opMap[action];
    if (s.firstOperand !== null && s.operator && !s.waitingForSecond) {
      const res = applyOperator(s.firstOperand, s.operator, parseFloat(s.display));
      s.display = formatNum(res);
      s.firstOperand = typeof res === 'string' ? 0 : res;
    } else { s.firstOperand = parseFloat(s.display); }
    s.operator = op; s.history = `${formatNum(s.firstOperand)} ${op}`; s.waitingForSecond = true;
  } else if (action === 'eq') {
    if (s.firstOperand !== null && s.operator) {
      const b = parseFloat(s.display);
      const expr = `${s.history} ${s.display} =`;
      const res = applyOperator(s.firstOperand, s.operator, b);
      const rs = formatNum(res);
      pushHistory(expr, rs);
      s.history = expr; s.display = rs; s.firstOperand = null; s.operator = null; s.justCalc = true;
    }
  }
  if (fn) {
    let x = parseFloat(s.display);
    let res;
    switch(fn) {
      case 'pi': res = Math.PI; break;
      case 'e_const': res = Math.E; break;
      case 'sq': res = sciInverse ? Math.sqrt(x) : x*x; break;
      case 'cube': res = sciInverse ? Math.cbrt(x) : x*x*x; break;
      case 'sqrt': res = sciInverse ? x*x : Math.sqrt(x); break;
      case 'cbrt': res = Math.cbrt(x); break;
      case 'inv': res = x !== 0 ? 1/x : 'Cannot divide by zero'; break;
      case 'abs': res = Math.abs(x); break;
      case 'ln': res = sciInverse ? Math.exp(x) : Math.log(x); break;
      case 'log10': res = sciInverse ? Math.pow(10, x) : Math.log10(x); break;
      case 'log2': res = Math.log2(x); break;
      case 'exp10': res = Math.pow(10, x); break;
      case 'sin': res = sciInverse ? fromRad(Math.asin(x)) : Math.sin(toRad(x)); break;
      case 'cos': res = sciInverse ? fromRad(Math.acos(x)) : Math.cos(toRad(x)); break;
      case 'tan': res = sciInverse ? fromRad(Math.atan(x)) : Math.tan(toRad(x)); break;
      case 'pow': s.firstOperand = x; s.operator = '^'; s.history = `${x} ^`; s.waitingForSecond = true; renderSci(); return;
      case 'inv_toggle': sciInverse = !sciInverse; $('#sci-inv-toggle').css('color', sciInverse ? 'var(--accent)' : ''); updateSciLabels(); return;
    }
    s.display = formatNum(res);
    s.justCalc = true;
  }
  renderSci();
}

$('#panel-scientific').on('click', '.btn', function(){
  handleSciAction($(this).data('action'), $(this).data('fn'));
});

/* ============================================================
   PROGRAMMER CALCULATOR
   ============================================================ */
let progBase = 'DEC';
let progOp = null;
let progFirst = null;
let progWaiting = false;

function getProgVal() {
  const txt = $('#prog-display').text().replace(/\s/g,'');
  if (txt === '' || txt === '0') return 0;
  switch(progBase) {
    case 'HEX': return parseInt(txt, 16);
    case 'DEC': return parseInt(txt, 10);
    case 'OCT': return parseInt(txt, 8);
    case 'BIN': return parseInt(txt, 2);
  }
  return 0;
}

function setProgVal(n) {
  n = Math.trunc(n);
  let disp;
  switch(progBase) {
    case 'HEX': disp = n.toString(16).toUpperCase(); break;
    case 'DEC': disp = n.toString(10); break;
    case 'OCT': disp = n.toString(8); break;
    case 'BIN': disp = n.toString(2); break;
    default: disp = n.toString();
  }
  $('#prog-display').text(disp);
  updateProgBases(n);
  updateBitDisplay(n);
}

function updateProgBases(n) {
  n = Math.trunc(n);
  $('#pb-hex').text(n.toString(16).toUpperCase() || '0');
  $('#pb-dec').text(n.toString(10) || '0');
  $('#pb-oct').text(n.toString(8) || '0');
  let bin = n.toString(2);
  bin = bin.padStart(Math.ceil(bin.length/4)*4, '0');
  bin = bin.replace(/(.{4})/g, '$1 ').trim();
  $('#pb-bin').text(bin || '0');
}

function updateBitDisplay(n) {
  n = Math.trunc(n) & 0xFFFFFFFF;
  const bin = (n >>> 0).toString(2).padStart(32, '0');
  const $bd = $('#bit-display');
  $bd.empty();
  for (let i = 0; i < 32; i++) {
    if (i > 0 && i % 4 === 0) $bd.append('<span class="bit-sep"></span>');
    const bit = bin[i];
    $bd.append(`<span class="bit ${bit==='1'?'on':''}" data-bit="${31-i}">${bit}</span>`);
  }
}

$('#bit-display').on('click', '.bit', function(){
  const bitPos = parseInt($(this).data('bit'));
  let n = Math.trunc(getProgVal()) & 0xFFFFFFFF;
  n ^= (1 << bitPos);
  setProgVal(n);
});

$('.base-btn').on('click', function(){
  const newBase = $(this).data('base');
  const curVal = getProgVal();
  progBase = newBase;
  $('.base-btn').removeClass('active');
  $(this).addClass('active');
  updateProgButtons();
  setProgVal(curVal);
});

function updateProgButtons() {
  $('.prog-hex').each(function(){
    const isHex = progBase === 'HEX';
    $(this).css('opacity', isHex ? '1' : '0.3').prop('disabled', !isHex);
  });
  $('#prog-grid .btn').each(function(){
    const action = $(this).data('action');
    if (action === undefined || action === null) return;
    const str = String(action);
    if (!/^[0-9]$/.test(str)) return;
    const d = parseInt(str, 10);
    let enabled = true;
    if (progBase === 'BIN' && d > 1) enabled = false;
    else if (progBase === 'OCT' && d > 7) enabled = false;
    $(this).css('opacity', enabled ? '1' : '0.3').prop('disabled', !enabled);
  });
}

$('#panel-programmer').on('click', '.btn', function(){
  const action = $(this).data('action');
  const prog = $(this).data('prog');
  if (prog) {
    const a = getProgVal();
    if (['and','or','xor','lsh','rsh'].includes(prog)) { progFirst = a; progOp = prog; progWaiting = true; return; }
    if (prog === 'not') { setProgVal(~a); return; }
    if (prog === 'mod') { progFirst = a; progOp = 'mod'; progWaiting = true; return; }
  }
  if (!action) return;
  const cur = $('#prog-display').text();
  if (action === 'ac') { $('#prog-display').text('0'); progFirst = null; progOp = null; progWaiting = false; updateProgBases(0); updateBitDisplay(0); return; }
  if (action === 'del') {
    const t = cur.length > 1 ? cur.slice(0,-1) : '0';
    $('#prog-display').text(t); updateProgBases(getProgVal()); updateBitDisplay(getProgVal()); return;
  }
  if (action === 'eq') {
    if (progFirst !== null && progOp) {
      const b = getProgVal();
      let res = applyOperator(progFirst, progOp === 'mod' ? '%mod%' : progOp, b);
      setProgVal(typeof res === 'string' ? 0 : res);
      progFirst = null; progOp = null; progWaiting = false;
    }
    return;
  }
  if (['add','sub','mul','div'].includes(action)) {
    const opMap = {add:'+',sub:'-',mul:'*',div:'/'};
    progFirst = getProgVal(); progOp = opMap[action]; progWaiting = true; return;
  }
  const ch = action.toString();
  const validChars = { HEX: /^[0-9A-Fa-f]$/, DEC: /^[0-9]$/, OCT: /^[0-7]$/, BIN: /^[01]$/ };
  if (validChars[progBase].test(ch)) {
    if (progWaiting) { $('#prog-display').text(ch); progWaiting = false; }
    else { const t = cur === '0' ? ch : cur + ch; $('#prog-display').text(t); }
    updateProgBases(getProgVal()); updateBitDisplay(getProgVal());
  }
});

updateProgButtons();
updateBitDisplay(0);

/* ============================================================
   GRAPHING
   ============================================================ */
let graphRange = { xMin: -10, xMax: 10 };
let graphExpr = 'sin(x)';
const canvas = document.getElementById('graph');
const ctx = canvas.getContext('2d');

function evalExpr(expr, xVal) {
  try {
    let e = expr.trim()
      .replace(/\^/g, '**')
      .replace(/\bpi\b/gi, '(' + Math.PI + ')')
      .replace(/\basin\b/g, 'Math.asin').replace(/\bacos\b/g, 'Math.acos').replace(/\batan\b/g, 'Math.atan')
      .replace(/\bsinh\b/g, 'Math.sinh').replace(/\bcosh\b/g, 'Math.cosh').replace(/\btanh\b/g, 'Math.tanh')
      .replace(/\bsin\b/g, 'Math.sin').replace(/\bcos\b/g, 'Math.cos').replace(/\btan\b/g, 'Math.tan')
      .replace(/\bsqrt\b/g, 'Math.sqrt').replace(/\bcbrt\b/g, 'Math.cbrt').replace(/\babs\b/g, 'Math.abs')
      .replace(/\blog10\b/g, 'Math.log10').replace(/\blog2\b/g, 'Math.log2').replace(/\bln\b/g, 'Math.log').replace(/\blog\b/g, 'Math.log10')
      .replace(/\bexp\b/g, 'Math.exp').replace(/\bpow\b/g, 'Math.pow')
      .replace(/\bceil\b/g, 'Math.ceil').replace(/\bfloor\b/g, 'Math.floor').replace(/\bround\b/g, 'Math.round').replace(/\bsign\b/g, 'Math.sign')
      .replace(/\be\b/g, '(' + Math.E + ')')
      .replace(/\bx\b/g, '(' + xVal + ')');
    return eval(e);
  } catch(err) { return NaN; }
}

function drawGraph() {
  const W = canvas.offsetWidth || 550;
  const H = canvas.offsetHeight || 200;
  canvas.width = W; canvas.height = H;
  ctx.clearRect(0, 0, W, H);
  const { xMin, xMax } = graphRange;
  const yPad = 30, xPad = 36;
  const pts = [];
  const steps = W * 2;
  for (let i = 0; i <= steps; i++) {
    const x = xMin + (xMax - xMin) * i / steps;
    const y = evalExpr(graphExpr, x);
    pts.push({ x, y });
  }
  const yVals = pts.map(p => p.y).filter(v => isFinite(v));
  let yMin = Math.min(...yVals), yMax = Math.max(...yVals);
  if (yMin === yMax) { yMin -= 1; yMax += 1; }
  const yRange = yMax - yMin;
  yMin -= yRange * 0.1; yMax += yRange * 0.1;
  function toCanvasX(x) { return xPad + (x - xMin) / (xMax - xMin) * (W - xPad*2); }
  function toCanvasY(y) { return H - yPad - (y - yMin) / (yMax - yMin) * (H - yPad*2); }
  ctx.strokeStyle = 'rgba(255,255,255,0.06)'; ctx.lineWidth = 1;
  for (let i = 0; i <= 10; i++) { const cx = toCanvasX(xMin + (xMax - xMin) * i / 10); ctx.beginPath(); ctx.moveTo(cx, yPad); ctx.lineTo(cx, H - yPad); ctx.stroke(); }
  for (let i = 0; i <= 8; i++) { const cy = toCanvasY(yMin + (yMax - yMin) * i / 8); ctx.beginPath(); ctx.moveTo(xPad, cy); ctx.lineTo(W - xPad, cy); ctx.stroke(); }
  ctx.strokeStyle = 'rgba(255,255,255,0.2)'; ctx.lineWidth = 1.5;
  const cy0 = toCanvasY(0), cx0 = toCanvasX(0);
  if (cy0 > yPad && cy0 < H - yPad) { ctx.beginPath(); ctx.moveTo(xPad, cy0); ctx.lineTo(W - xPad, cy0); ctx.stroke(); }
  if (cx0 > xPad && cx0 < W - xPad) { ctx.beginPath(); ctx.moveTo(cx0, yPad); ctx.lineTo(cx0, H - yPad); ctx.stroke(); }
  ctx.fillStyle = 'rgba(255,255,255,0.35)'; ctx.font = '9px JetBrains Mono'; ctx.textAlign = 'center';
  for (let i = 0; i <= 10; i += 2) { const x = xMin + (xMax - xMin) * i / 10; ctx.fillText(x.toFixed(1), toCanvasX(x), H - 4); }
  ctx.textAlign = 'right';
  for (let i = 0; i <= 8; i += 2) { const y = yMin + (yMax - yMin) * i / 8; ctx.fillText(y.toFixed(1), xPad - 3, toCanvasY(y) + 3); }
  ctx.strokeStyle = '#3f9fff'; ctx.lineWidth = 2.5; ctx.lineJoin = 'round';
  ctx.shadowColor = '#3f9fff'; ctx.shadowBlur = 8;
  ctx.beginPath();
  let started = false;
  for (const p of pts) {
    if (!isFinite(p.y)) { started = false; continue; }
    const cx = toCanvasX(p.x), cy = toCanvasY(p.y);
    if (!started) { ctx.moveTo(cx, cy); started = true; } else ctx.lineTo(cx, cy);
  }
  ctx.stroke(); ctx.shadowBlur = 0;
  $('#g-range-label').text(`x: [${xMin.toFixed(1)}, ${xMax.toFixed(1)}]`);
}

function plotGraph() {
  graphExpr = $('#graph-expr').val().trim();
  $('#graph-error').text('');
  try { drawGraph(); } catch(e) { $('#graph-error').text('Invalid expression: ' + e.message); }
}

$('#graph-plot-btn').on('click', plotGraph);
$('#graph-expr').on('keypress', function(e){ if (e.which === 13) plotGraph(); });
$('#g-zoom-in').on('click', function(){ const c = (graphRange.xMin + graphRange.xMax)/2, r = (graphRange.xMax - graphRange.xMin)/4; graphRange.xMin = c-r; graphRange.xMax = c+r; drawGraph(); });
$('#g-zoom-out').on('click', function(){ const c = (graphRange.xMin + graphRange.xMax)/2, r = (graphRange.xMax - graphRange.xMin); graphRange.xMin = c-r; graphRange.xMax = c+r; drawGraph(); });
$('#g-reset').on('click', function(){ graphRange = { xMin: -10, xMax: 10 }; drawGraph(); });

/* ============================================================
   DATE CALCULATION
   ============================================================ */
function today() { return new Date().toISOString().split('T')[0]; }
$('#date-start').val(today()); $('#date-end').val(today()); $('#date-add-start').val(today());

function calcDateDiff() {
  const s = new Date($('#date-start').val()), e = new Date($('#date-end').val());
  if (isNaN(s) || isNaN(e)) return;
  const diff = e - s;
  const sign = diff >= 0 ? '' : '-';
  const totalDays = Math.round(Math.abs(diff) / 86400000);
  const years = Math.floor(totalDays / 365.25);
  const rem = totalDays - Math.floor(years * 365.25);
  const months = Math.floor(rem / 30.44);
  const days = Math.round(rem - months * 30.44);
  let mainText = years > 0 ? `${sign}${years}y ${months}m ${days}d` : months > 0 ? `${sign}${months}m ${days}d` : `${sign}${totalDays} days`;
  $('#date-diff-main').text(mainText);
  const weeks = Math.floor(totalDays / 7);
  $('#date-diff-sub').html(`<b>${sign}${totalDays}</b> total days<br><b>${sign}${weeks}</b> weeks, <b>${totalDays%7}</b> days<br><b>${sign}${Math.round(totalDays * 24)}</b> hours`);
}

$('#date-start, #date-end').on('change', calcDateDiff);
calcDateDiff();

$('.date-mode-tab').on('click', function(){
  $('.date-mode-tab').removeClass('active'); $(this).addClass('active');
  const mode = $(this).data('dmode');
  if (mode === 'diff') { $('#date-diff-panel').show(); $('#date-add-panel').hide(); }
  else { $('#date-diff-panel').hide(); $('#date-add-panel').show(); }
});

function calcDateAdd(sign) {
  const s = new Date($('#date-add-start').val());
  if (isNaN(s)) return;
  const amount = parseInt($('#date-add-amount').val()) * sign;
  const unit = $('#date-add-unit').val();
  let result = new Date(s);
  if (unit === 'days') result.setDate(result.getDate() + amount);
  else if (unit === 'weeks') result.setDate(result.getDate() + amount * 7);
  else if (unit === 'months') result.setMonth(result.getMonth() + amount);
  else if (unit === 'years') result.setFullYear(result.getFullYear() + amount);
  $('#date-add-result').text(result.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' }));
}
$('#date-add-plus').on('click', function(){ calcDateAdd(1); });
$('#date-add-minus').on('click', function(){ calcDateAdd(-1); });

/* ============================================================
   UNIT CONVERTER
   ============================================================ */
const converters = {
  length: { units: ['Meter','Kilometer','Centimeter','Millimeter','Inch','Foot','Yard','Mile','Nautical Mile'], toBase: [1,1000,0.01,0.001,0.0254,0.3048,0.9144,1609.344,1852] },
  weight: { units: ['Kilogram','Gram','Milligram','Pound','Ounce','Ton (metric)','Stone'], toBase: [1,0.001,0.000001,0.453592,0.0283495,1000,6.35029] },
  temperature: { units: ['Celsius','Fahrenheit','Kelvin'], toBase: null,
    convert(val, from, to) {
      let c = from === 'Celsius' ? val : from === 'Fahrenheit' ? (val-32)*5/9 : val-273.15;
      return to === 'Celsius' ? c : to === 'Fahrenheit' ? c*9/5+32 : c+273.15;
    }
  },
  area: { units: ['m²','km²','cm²','mm²','ft²','in²','acre','hectare'], toBase: [1,1e6,1e-4,1e-6,0.092903,0.000645,4046.86,10000] },
  speed: { units: ['m/s','km/h','mph','knot','ft/s'], toBase: [1,0.277778,0.44704,0.514444,0.3048] },
  volume: { units: ['Liter','Milliliter','Cubic meter','Gallon (US)','Quart','Pint','Cup','Fluid oz'], toBase: [1,0.001,1000,3.78541,0.946353,0.473176,0.236588,0.0295735] }
};

function populateConvUnits(cat) {
  const c = converters[cat];
  $('#conv-from-unit, #conv-to-unit').empty();
  c.units.forEach(u => { $('#conv-from-unit').append(`<option>${u}</option>`); $('#conv-to-unit').append(`<option>${u}</option>`); });
  $('#conv-to-unit option:eq(1)').prop('selected', true);
  doConvert();
}

function doConvert() {
  const cat = $('#conv-category').val(), c = converters[cat];
  const from = $('#conv-from-unit').val(), to = $('#conv-to-unit').val();
  const val = parseFloat($('#conv-input').val());
  if (isNaN(val)) return;
  let result = c.convert ? c.convert(val, from, to) : val * c.toBase[c.units.indexOf(from)] / c.toBase[c.units.indexOf(to)];
  const formatted = result % 1 === 0 ? result : parseFloat(result.toPrecision(8));
  $('#conv-output').val(formatted);
  $('#conv-formula').text(`${val} ${from} = ${formatted} ${to}`);
}

$('#conv-category').on('change', function(){ populateConvUnits($(this).val()); });
$('#conv-from-unit, #conv-to-unit, #conv-input').on('change input', doConvert);
populateConvUnits('length');

/* ============================================================
   MODE SWITCHING (sidebar + bottom nav)
   ============================================================ */
function switchMode(mode) {
  $('.nav-item').removeClass('active');
  $(`.nav-item[data-mode="${mode}"]`).addClass('active');
  $('.bnav-item').removeClass('active');
  $(`.bnav-item[data-mode="${mode}"]`).addClass('active');
  $('.mode-panel').removeClass('active');
  $(`#panel-${mode}`).addClass('active');
  if (mode === 'graphing') { setTimeout(plotGraph, 80); }
}

$('.nav-item').on('click', function(){ switchMode($(this).data('mode')); });
$('.bnav-item').on('click', function(){ switchMode($(this).data('mode')); });

/* ============================================================
   HISTORY
   ============================================================ */
$('#history-toggle').on('click', function(){ $('#history-panel').toggleClass('open'); });
$('#history-close').on('click', function(){ $('#history-panel').removeClass('open'); });
$('#history-clear').on('click', function(){ historyLog = []; renderHistory(); });
$(document).on('click', '.history-entry', function(){
  const val = $(this).data('val');
  calcState.display = val.toString(); calcState.justCalc = true;
  renderStd();
  $('#history-panel').removeClass('open');
  switchMode('standard');
});

/* ============================================================
   KEYBOARD SUPPORT
   ============================================================ */
$(document).on('keydown', function(e) {
  const activeMode = $('.nav-item.active').data('mode') || $('.bnav-item.active').data('mode');
  if (activeMode !== 'standard' && activeMode !== 'scientific') return;
  const s = activeMode === 'standard' ? handleStdAction : handleSciAction;
  const key = e.key;
  if (key.match(/^[0-9]$/)) s(key);
  else if (key === '+') s('add');
  else if (key === '-') s('sub');
  else if (key === '*') s('mul');
  else if (key === '/') { e.preventDefault(); s('div'); }
  else if (key === 'Enter' || key === '=') s('eq');
  else if (key === 'Backspace') s('del');
  else if (key === 'Escape') s('ac');
  else if (key === '.') s('dot');
  else if (key === '%') s('percent');
});

// Initial render
renderStd();
renderSci();

/* ============================================================
   CURRENCY CONVERTER (fawazahmed0/exchange-api)
   Primary:  https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/...
   Fallback: https://latest.currency-api.pages.dev/v1/...
   ============================================================ */
let ccCurrencies = {};   // { code: name }
let ccRatesCache = {};   // { fromCode: { toCode: rate, date: '...' } }
let ccFilteredCodes = [];
let ccAllOptions = '';   // pre-built option HTML for all currencies

const CC_CDN  = (path) => `https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/${path}`;
const CC_FALL = (path) => `https://latest.currency-api.pages.dev/v1/${path}`;

async function ccFetchWithFallback(path) {
  // Try in order: CDN min → fallback min → CDN json → fallback json
  const urls = [
    CC_CDN(path.replace('.json', '.min.json')),
    CC_FALL(path.replace('.json', '.min.json')),
    CC_CDN(path),
    CC_FALL(path),
  ];
  for (const url of urls) {
    try {
      const r = await fetch(url);
      if (!r.ok) continue;
      return await r.json();
    } catch(e) { /* try next */ }
  }
  throw new Error('All endpoints failed');
}

function ccSetStatus(msg, type) {
  const $s = $('#cc-status');
  $s.removeClass('loading error ok');
  if (!msg) { $s.html(''); return; }
  const icon = type === 'loading' ? '<span class="spin">⟳</span> '
             : type === 'error'   ? '⚠ '
             : '✓ ';
  $s.addClass(type).html(icon + msg);
}

async function ccLoadCurrencies() {
  ccSetStatus('Loading currency list…', 'loading');
  try {
    const data = await ccFetchWithFallback('currencies.json');
    // data = { "eur": "Euro", "usd": "United States Dollar", ... }
    ccCurrencies = {};
    Object.entries(data).forEach(([code, name]) => {
      ccCurrencies[code.toLowerCase()] = name;
    });
    ccFilteredCodes = Object.keys(ccCurrencies).sort();
    buildCcOptions(ccFilteredCodes);
    // Set sensible defaults
    ccSetFromTo('usd', 'idr');
    ccSetStatus('', '');
    $('#cc-convert-btn').prop('disabled', false);
    await ccConvert();
  } catch(e) {
    ccSetStatus('Failed to load currencies. Check connection.', 'error');
  }
}

function buildCcOptions(codes) {
  let html = '';
  codes.forEach(code => {
    const name = ccCurrencies[code] || code;
    const label = `${code.toUpperCase()} – ${name}`;
    html += `<option value="${code}" title="${name}">${label}</option>`;
  });
  ccAllOptions = html;
  $('#cc-from, #cc-to').html(html);
}

function ccSetFromTo(from, to) {
  if (ccCurrencies[from]) $('#cc-from').val(from);
  if (ccCurrencies[to])   $('#cc-to').val(to);
}

// Filter: rebuild selects based on search input
$('#currency-filter').on('input', function() {
  const q = $(this).val().toLowerCase().trim();
  const fromVal = $('#cc-from').val();
  const toVal   = $('#cc-to').val();
  let filtered;
  if (!q) {
    filtered = Object.keys(ccCurrencies).sort();
  } else {
    filtered = Object.keys(ccCurrencies).sort().filter(code => {
      const name = (ccCurrencies[code] || '').toLowerCase();
      return code.includes(q) || name.includes(q);
    });
  }
  let html = '';
  filtered.forEach(code => {
    const name = ccCurrencies[code] || code;
    html += `<option value="${code}">${code.toUpperCase()} – ${name}</option>`;
  });
  $('#cc-from, #cc-to').html(html);
  // Restore previous selection if still in filtered list
  if (filtered.includes(fromVal)) $('#cc-from').val(fromVal);
  if (filtered.includes(toVal))   $('#cc-to').val(toVal);
});

// Swap button
$('#cc-swap').on('click', function() {
  const from = $('#cc-from').val();
  const to   = $('#cc-to').val();
  $(this).addClass('spinning');
  setTimeout(() => $(this).removeClass('spinning'), 300);
  $('#cc-from').val(to);
  $('#cc-to').val(from);
  ccConvert();
});

// Convert on button or input change
$('#cc-convert-btn').on('click', ccConvert);
$('#cc-amount').on('input', function() {
  if (Object.keys(ccCurrencies).length > 0) ccConvert();
});
$('#cc-from, #cc-to').on('change', ccConvert);

async function ccConvert() {
  const fromCode = $('#cc-from').val();
  const toCode   = $('#cc-to').val();
  const amount   = parseFloat($('#cc-amount').val());
  if (!fromCode || !toCode || isNaN(amount)) return;

  if (fromCode === toCode) {
    $('#cc-result-from').text(`${amount.toLocaleString()} ${fromCode.toUpperCase()}`);
    $('#cc-result-main').text(amount.toLocaleString('en-US', { maximumFractionDigits: 6 }));
    $('#cc-result-code').text(toCode.toUpperCase() + ' – ' + (ccCurrencies[toCode] || ''));
    $('#cc-result-rate').text('1 ' + fromCode.toUpperCase() + ' = 1 ' + toCode.toUpperCase());
    ccSetStatus('', '');
    return;
  }

  // Use cache if available
  if (ccRatesCache[fromCode] && ccRatesCache[fromCode][toCode] !== undefined) {
    ccDisplayResult(fromCode, toCode, amount, ccRatesCache[fromCode][toCode], ccRatesCache[fromCode]._date);
    return;
  }

  ccSetStatus('Fetching exchange rates…', 'loading');
  try {
    const data = await ccFetchWithFallback(`currencies/${fromCode}.json`);
    // Response: { "date": "2024-03-06", "eur": { "usd": 1.09, "idr": 17234, ... } }
    const rates = data[fromCode] || {};
    ccRatesCache[fromCode] = { ...rates, _date: data.date };

    const rate = rates[toCode];
    if (rate === undefined) {
      ccSetStatus(`Rate for ${toCode.toUpperCase()} not found.`, 'error');
      return;
    }
    ccDisplayResult(fromCode, toCode, amount, rate, data.date);
    ccSetStatus('', '');
    $('#currency-updated').text('Updated: ' + (data.date || 'latest'));
  } catch(e) {
    ccSetStatus('Failed to fetch rate. Try again.', 'error');
  }
}

function ccDisplayResult(from, to, amount, rate, date) {
  const result = amount * rate;
  const fromName = ccCurrencies[from] || from.toUpperCase();
  const toName   = ccCurrencies[to]   || to.toUpperCase();

  $('#cc-result-from').text(
    `${amount.toLocaleString('en-US', { maximumFractionDigits: 6 })} ${from.toUpperCase()} (${fromName})`
  );
  $('#cc-result-main').text(
    result.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 6 })
  );
  $('#cc-result-code').text(to.toUpperCase() + ' – ' + toName);
  $('#cc-result-rate').text(
    `1 ${from.toUpperCase()} = ${rate.toLocaleString('en-US', { maximumFractionDigits: 8 })} ${to.toUpperCase()}`
    + (date ? `  ·  Rate date: ${date}` : '')
  );
  ccSetStatus('', '');
}

// Load currencies on init (defer so app loads first)
setTimeout(ccLoadCurrencies, 300);

});
</script>
</body>
</html>