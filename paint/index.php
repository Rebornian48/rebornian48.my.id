<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pixel Studio — Web Paint</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="paint" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --bg-dark: #0e0e12;
    --bg-panel: #16161d;
    --bg-surface: #1e1e28;
    --bg-hover: #2a2a38;
    --accent: #6ee7b7;
    --accent-dim: #34d399;
    --accent-glow: rgba(110, 231, 183, 0.15);
    --text-primary: #e4e4ed;
    --text-muted: #8888a0;
    --border: #2a2a38;
    --danger: #f87171;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Outfit', sans-serif;
    background: var(--bg-dark);
    color: var(--text-primary);
    overflow: hidden;
    height: 100vh;
    user-select: none;
  }

  .font-mono { font-family: 'JetBrains Mono', monospace; }

  /* Custom scrollbar */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: var(--bg-panel); }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

  /* Toolbar */
  .toolbar {
    background: var(--bg-panel);
    border-bottom: 1px solid var(--border);
  }

  .tool-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
    border: 1px solid transparent;
    color: var(--text-muted);
    background: transparent;
    position: relative;
  }

  .tool-btn:hover {
    background: var(--bg-hover);
    color: var(--text-primary);
  }

  .tool-btn.active {
    background: var(--accent-glow);
    color: var(--accent);
    border-color: var(--accent-dim);
    box-shadow: 0 0 12px var(--accent-glow);
  }

  .tool-btn svg { width: 18px; height: 18px; }

  .tool-btn .tooltip {
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--bg-surface);
    color: var(--text-primary);
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 4px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.15s;
    z-index: 100;
    border: 1px solid var(--border);
    font-family: 'JetBrains Mono', monospace;
  }

  .tool-btn:hover .tooltip { opacity: 1; }

  .divider {
    width: 1px;
    height: 28px;
    background: var(--border);
    margin: 0 4px;
  }

  /* Side panel */
  .side-panel {
    background: var(--bg-panel);
    border-right: 1px solid var(--border);
    width: 240px;
    min-width: 240px;
  }

  .panel-section {
    border-bottom: 1px solid var(--border);
    padding: 14px;
  }

  .panel-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    margin-bottom: 10px;
    font-family: 'JetBrains Mono', monospace;
  }

  /* Color swatches */
  .color-swatch {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.12s ease;
    position: relative;
  }

  .color-swatch:hover {
    transform: scale(1.15);
    z-index: 2;
  }

  .color-swatch.active {
    border-color: var(--accent);
    box-shadow: 0 0 8px var(--accent-glow);
    transform: scale(1.1);
  }

  /* Range slider */
  input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 4px;
    background: var(--border);
    border-radius: 4px;
    outline: none;
    cursor: pointer;
  }

  input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--accent);
    cursor: pointer;
    box-shadow: 0 0 6px var(--accent-glow);
  }

  input[type="range"]::-moz-range-thumb {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--accent);
    cursor: pointer;
    border: none;
  }

  /* Canvas area */
  .canvas-wrapper {
    background: var(--bg-dark);
    background-image:
      radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 1px, transparent 0);
    background-size: 24px 24px;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  #paintCanvas {
    background: #ffffff;
    cursor: crosshair;
    border-radius: 4px;
    box-shadow:
      0 0 0 1px rgba(255,255,255,0.05),
      0 20px 60px rgba(0,0,0,0.5),
      0 0 80px rgba(110,231,183,0.03);
  }

  /* Status bar */
  .status-bar {
    background: var(--bg-panel);
    border-top: 1px solid var(--border);
    height: 28px;
    font-size: 11px;
    color: var(--text-muted);
    font-family: 'JetBrains Mono', monospace;
  }

  /* Color picker input hidden */
  .color-picker-hidden {
    position: absolute;
    width: 0;
    height: 0;
    opacity: 0;
    pointer-events: none;
  }

  /* Action buttons */
  .action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
    border: 1px solid var(--border);
    background: var(--bg-surface);
    color: var(--text-primary);
  }

  .action-btn:hover {
    background: var(--bg-hover);
    border-color: var(--accent-dim);
  }

  .action-btn.primary {
    background: var(--accent-dim);
    color: var(--bg-dark);
    border-color: var(--accent);
  }

  .action-btn.primary:hover {
    background: var(--accent);
  }

  .action-btn.danger:hover {
    border-color: var(--danger);
    color: var(--danger);
  }

  /* Preview brush size */
  .brush-preview {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-surface);
    border-radius: 8px;
    margin: 8px auto;
  }

  .brush-dot {
    border-radius: 50%;
    background: var(--text-primary);
  }

  /* Layers / history panel on right */
  .right-panel {
    background: var(--bg-panel);
    border-left: 1px solid var(--border);
    width: 200px;
    min-width: 200px;
  }

  .history-item {
    padding: 6px 14px;
    font-size: 12px;
    color: var(--text-muted);
    cursor: pointer;
    transition: background 0.1s;
    font-family: 'JetBrains Mono', monospace;
  }

  .history-item:hover { background: var(--bg-hover); }
  .history-item.current { color: var(--accent); background: var(--accent-glow); }

  /* Keyboard shortcut hint */
  .kbd {
    display: inline-block;
    padding: 1px 5px;
    font-size: 10px;
    font-family: 'JetBrains Mono', monospace;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 3px;
    color: var(--text-muted);
  }

  /* Zoom controls */
  .zoom-controls {
    position: absolute;
    bottom: 12px;
    right: 12px;
    display: flex;
    gap: 4px;
    z-index: 10;
  }

  .zoom-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-panel);
    border: 1px solid var(--border);
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 14px;
    transition: all 0.12s;
  }

  .zoom-btn:hover {
    background: var(--bg-hover);
    color: var(--text-primary);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animate-in { animation: fadeIn 0.3s ease forwards; }
</style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>
<body>

<!-- Top Toolbar -->
<div class="toolbar flex items-center px-3 py-1.5 gap-1" style="height:52px;">
  <!-- Logo -->
  <div class="flex items-center gap-2 mr-3">
    <div style="width:28px;height:28px;background:var(--accent);border-radius:6px;display:flex;align-items:center;justify-content:center;">
      <svg width="16" height="16" fill="none" stroke="#0e0e12" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/>
        <circle cx="11" cy="11" r="2"/>
      </svg>
    </div>
    <span class="font-semibold text-sm" style="color:var(--text-primary);">Pixel Studio</span>
  </div>

  <div class="divider"></div>

  <!-- Drawing Tools -->
  <div class="flex gap-1 items-center">
    <button class="tool-btn active" data-tool="brush" title="Brush">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.586 7.586"/></svg>
      <span class="tooltip">Brush (B)</span>
    </button>
    <button class="tool-btn" data-tool="eraser" title="Eraser">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 20H7L3 16l9-9 8 8-4 4z"/><path d="M6 11l4-4"/></svg>
      <span class="tooltip">Eraser (E)</span>
    </button>
    <button class="tool-btn" data-tool="fill" title="Fill">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 22l1-1h3l9-9"/><path d="M12 8l4-4 4 4"/><path d="M16 4v10c0 2 2 4 4 4"/></svg>
      <span class="tooltip">Fill (F)</span>
    </button>
    <button class="tool-btn" data-tool="eyedropper" title="Eyedropper">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 22l4-4"/><path d="M6 18L16.5 7.5l0 0c1-1 .5-2.5-.5-3.5s-2.5-1.5-3.5-.5l0 0L2 14v4h4z"/><path d="M21.174 6.812a1 1 0 00-3.986-3.987L16 4l4 4 1.174-1.188z"/></svg>
      <span class="tooltip">Eyedropper (I)</span>
    </button>
  </div>

  <div class="divider"></div>

  <!-- Shape Tools -->
  <div class="flex gap-1 items-center">
    <button class="tool-btn" data-tool="line" title="Line">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="19" x2="19" y2="5"/></svg>
      <span class="tooltip">Line (L)</span>
    </button>
    <button class="tool-btn" data-tool="rect" title="Rectangle">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
      <span class="tooltip">Rectangle (R)</span>
    </button>
    <button class="tool-btn" data-tool="circle" title="Circle">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
      <span class="tooltip">Circle (C)</span>
    </button>
    <button class="tool-btn" data-tool="text" title="Text">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9.5" y1="20" x2="14.5" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
      <span class="tooltip">Text (T)</span>
    </button>
  </div>

  <div class="divider"></div>

  <!-- Actions -->
  <div class="flex gap-1 items-center">
    <button class="tool-btn" id="undoBtn" title="Undo">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
      <span class="tooltip">Undo (Ctrl+Z)</span>
    </button>
    <button class="tool-btn" id="redoBtn" title="Redo">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.13-9.36L23 10"/></svg>
      <span class="tooltip">Redo (Ctrl+Y)</span>
    </button>
  </div>

  <div class="flex-1"></div>

  <!-- Right side actions -->
  <div class="flex gap-2 items-center">
    <button class="action-btn danger" id="clearBtn">Clear All</button>
    <button class="action-btn primary" id="saveBtn">
      <span class="flex items-center gap-1">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Save PNG
      </span>
    </button>
  </div>
</div>

<!-- Main Content -->
<div class="flex" style="height:calc(100vh - 80px);">

  <!-- Left Panel -->
  <div class="side-panel flex flex-col overflow-y-auto">
    <!-- Color Section -->
    <div class="panel-section">
      <div class="panel-label">Color</div>
      <div class="flex items-center gap-3 mb-3">
        <div id="currentColorPreview" style="width:40px;height:40px;border-radius:8px;background:#000000;border:2px solid var(--border);cursor:pointer;" title="Click to pick color"></div>
        <div class="flex flex-col gap-1">
          <span class="font-mono text-xs" style="color:var(--text-muted);" id="colorHexLabel">#000000</span>
          <input type="color" id="colorPicker" class="color-picker-hidden" value="#000000">
        </div>
      </div>
      <div class="flex flex-wrap gap-1.5" id="swatchGrid">
        <!-- Swatches generated by JS -->
      </div>
    </div>

    <!-- Brush Size -->
    <div class="panel-section">
      <div class="panel-label">Brush Size</div>
      <div class="brush-preview">
        <div class="brush-dot" id="brushPreviewDot" style="width:4px;height:4px;"></div>
      </div>
      <div class="flex items-center gap-2 mt-1">
        <input type="range" id="brushSize" min="1" max="80" value="4">
        <span class="font-mono text-xs" style="color:var(--text-muted);min-width:28px;text-align:right;" id="brushSizeLabel">4px</span>
      </div>
    </div>

    <!-- Opacity -->
    <div class="panel-section">
      <div class="panel-label">Opacity</div>
      <div class="flex items-center gap-2">
        <input type="range" id="opacityRange" min="5" max="100" value="100">
        <span class="font-mono text-xs" style="color:var(--text-muted);min-width:32px;text-align:right;" id="opacityLabel">100%</span>
      </div>
    </div>

    <!-- Shape Options -->
    <div class="panel-section" id="shapeOptions" style="display:none;">
      <div class="panel-label">Shape Options</div>
      <label class="flex items-center gap-2 cursor-pointer text-sm" style="color:var(--text-muted);">
        <input type="checkbox" id="shapeFill" class="rounded" style="accent-color:var(--accent);">
        Fill Shape
      </label>
    </div>

    <!-- Text Options -->
    <div class="panel-section" id="textOptions" style="display:none;">
      <div class="panel-label">Text Options</div>
      <input type="text" id="textInput" placeholder="Type text here..." 
        class="w-full px-3 py-2 rounded-md text-sm mb-2"
        style="background:var(--bg-surface);border:1px solid var(--border);color:var(--text-primary);outline:none;">
      <div class="flex items-center gap-2">
        <span class="text-xs" style="color:var(--text-muted);">Size:</span>
        <input type="range" id="textSize" min="10" max="72" value="24">
        <span class="font-mono text-xs" style="color:var(--text-muted);" id="textSizeLabel">24px</span>
      </div>
    </div>

    <!-- Shortcuts -->
    <div class="panel-section">
      <div class="panel-label">Shortcuts</div>
      <div class="flex flex-col gap-1.5 text-xs" style="color:var(--text-muted);">
        <div class="flex justify-between"><span>Brush</span><span class="kbd">B</span></div>
        <div class="flex justify-between"><span>Eraser</span><span class="kbd">E</span></div>
        <div class="flex justify-between"><span>Fill</span><span class="kbd">F</span></div>
        <div class="flex justify-between"><span>Eyedropper</span><span class="kbd">I</span></div>
        <div class="flex justify-between"><span>Line</span><span class="kbd">L</span></div>
        <div class="flex justify-between"><span>Rectangle</span><span class="kbd">R</span></div>
        <div class="flex justify-between"><span>Circle</span><span class="kbd">C</span></div>
        <div class="flex justify-between"><span>Text</span><span class="kbd">T</span></div>
        <div class="flex justify-between"><span>Undo</span><span class="kbd">Ctrl+Z</span></div>
        <div class="flex justify-between"><span>Redo</span><span class="kbd">Ctrl+Y</span></div>
      </div>
    </div>
  </div>

  <!-- Canvas Area -->
  <div class="canvas-wrapper" id="canvasWrapper">
    <canvas id="paintCanvas" width="900" height="600"></canvas>
    <div class="zoom-controls">
      <button class="zoom-btn" id="zoomOut">−</button>
      <span class="font-mono text-xs flex items-center px-2" style="color:var(--text-muted);" id="zoomLevel">100%</span>
      <button class="zoom-btn" id="zoomIn">+</button>
      <button class="zoom-btn" id="zoomReset">⊡</button>
    </div>
  </div>

  <!-- Right Panel: History -->
  <div class="right-panel flex flex-col overflow-hidden">
    <div class="panel-section" style="border-bottom:1px solid var(--border);">
      <div class="panel-label">History</div>
    </div>
    <div class="flex-1 overflow-y-auto" id="historyList">
      <div class="history-item current">Canvas Created</div>
    </div>
  </div>
</div>

<!-- Status Bar -->
<div class="status-bar flex items-center px-4 justify-between">
  <div class="flex items-center gap-4">
    <span>Canvas: <strong>900 × 600</strong></span>
    <span id="cursorPos">X: 0 &nbsp; Y: 0</span>
  </div>
  <div class="flex items-center gap-4">
    <span id="currentToolLabel">Brush</span>
  </div>
</div>

<script>
$(function() {
  // ==== State ====
  const canvas = document.getElementById('paintCanvas');
  const ctx = canvas.getContext('2d');

  let currentTool = 'brush';
  let currentColor = '#000000';
  let brushSize = 4;
  let opacity = 1;
  let isDrawing = false;
  let lastX = 0, lastY = 0;
  let startX = 0, startY = 0;
  let zoom = 1;

  // Undo/Redo
  let undoStack = [];
  let redoStack = [];
  let historyNames = ['Canvas Created'];

  // Save initial state
  saveState('Canvas Created', true);

  // ==== Color Palette ====
  const swatches = [
    '#000000','#434343','#666666','#999999','#b7b7b7','#cccccc','#d9d9d9','#efefef','#f3f3f3','#ffffff',
    '#980000','#ff0000','#ff9900','#ffff00','#00ff00','#00ffff','#4a86e8','#0000ff','#9900ff','#ff00ff',
    '#e6b8af','#f4cccc','#fce5cd','#fff2cc','#d9ead3','#d0e0e3','#c9daf8','#cfe2f3','#d9d2e9','#ead1dc',
    '#dd7e6b','#ea9999','#f9cb9c','#ffe599','#b6d7a8','#a2c4c9','#a4c2f4','#9fc5e8','#b4a7d6','#d5a6bd',
  ];

  const $grid = $('#swatchGrid');
  swatches.forEach((c, i) => {
    const $s = $('<div>')
      .addClass('color-swatch')
      .css('background', c)
      .attr('data-color', c);
    if (i === 0) $s.addClass('active');
    $grid.append($s);
  });

  // ==== Color Events ====
  $(document).on('click', '.color-swatch', function() {
    const c = $(this).data('color');
    setColor(c);
  });

  $('#currentColorPreview').click(() => $('#colorPicker').click());
  $('#colorPicker').on('input', function() { setColor(this.value); });

  function setColor(c) {
    currentColor = c;
    $('#currentColorPreview').css('background', c);
    $('#colorHexLabel').text(c.toUpperCase());
    $('#colorPicker').val(c);
    $('.color-swatch').removeClass('active');
    $(`.color-swatch[data-color="${c}"]`).addClass('active');
  }

  // ==== Brush Size ====
  $('#brushSize').on('input', function() {
    brushSize = parseInt(this.value);
    $('#brushSizeLabel').text(brushSize + 'px');
    const s = Math.min(brushSize, 50);
    $('#brushPreviewDot').css({ width: s + 'px', height: s + 'px' });
  });

  // ==== Opacity ====
  $('#opacityRange').on('input', function() {
    opacity = parseInt(this.value) / 100;
    $('#opacityLabel').text(this.value + '%');
  });

  // ==== Text Size ====
  $('#textSize').on('input', function() {
    $('#textSizeLabel').text(this.value + 'px');
  });

  // ==== Tool Selection ====
  $(document).on('click', '.tool-btn[data-tool]', function() {
    selectTool($(this).data('tool'));
  });

  function selectTool(tool) {
    currentTool = tool;
    $('.tool-btn[data-tool]').removeClass('active');
    $(`.tool-btn[data-tool="${tool}"]`).addClass('active');
    $('#currentToolLabel').text(tool.charAt(0).toUpperCase() + tool.slice(1));

    // Show/hide panels
    const shapeTools = ['rect','circle','line'];
    $('#shapeOptions').toggle(shapeTools.includes(tool));
    $('#textOptions').toggle(tool === 'text');

    // Cursor
    if (tool === 'eyedropper') {
      canvas.style.cursor = 'crosshair';
    } else if (tool === 'fill') {
      canvas.style.cursor = 'cell';
    } else if (tool === 'text') {
      canvas.style.cursor = 'text';
    } else {
      canvas.style.cursor = 'crosshair';
    }
  }

  // ==== Drawing ====
  let tempCanvas = document.createElement('canvas');
  let tempCtx = tempCanvas.getContext('2d');
  tempCanvas.width = canvas.width;
  tempCanvas.height = canvas.height;

  function getPos(e) {
    const rect = canvas.getBoundingClientRect();
    return {
      x: (e.clientX - rect.left) / zoom,
      y: (e.clientY - rect.top) / zoom
    };
  }

  $(canvas).on('mousedown', function(e) {
    const pos = getPos(e);
    isDrawing = true;
    lastX = pos.x;
    lastY = pos.y;
    startX = pos.x;
    startY = pos.y;

    if (currentTool === 'eyedropper') {
      pickColor(pos.x, pos.y);
      isDrawing = false;
      return;
    }

    if (currentTool === 'fill') {
      floodFill(Math.round(pos.x), Math.round(pos.y), currentColor);
      saveState('Fill');
      isDrawing = false;
      return;
    }

    if (currentTool === 'text') {
      const text = $('#textInput').val();
      if (text) {
        ctx.globalAlpha = opacity;
        ctx.fillStyle = currentColor;
        ctx.font = `${$('#textSize').val()}px Outfit, sans-serif`;
        ctx.fillText(text, pos.x, pos.y);
        ctx.globalAlpha = 1;
        saveState('Text');
      }
      isDrawing = false;
      return;
    }

    if (['rect','circle','line'].includes(currentTool)) {
      tempCtx.clearRect(0, 0, tempCanvas.width, tempCanvas.height);
      tempCtx.drawImage(canvas, 0, 0);
    }

    if (currentTool === 'brush' || currentTool === 'eraser') {
      ctx.beginPath();
      ctx.moveTo(pos.x, pos.y);
      ctx.lineTo(pos.x, pos.y);
      ctx.strokeStyle = currentTool === 'eraser' ? '#ffffff' : currentColor;
      ctx.lineWidth = brushSize;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';
      ctx.globalAlpha = currentTool === 'eraser' ? 1 : opacity;
      ctx.stroke();
    }
  });

  $(canvas).on('mousemove', function(e) {
    const pos = getPos(e);
    $('#cursorPos').text(`X: ${Math.round(pos.x)}  Y: ${Math.round(pos.y)}`);

    if (!isDrawing) return;

    if (currentTool === 'brush' || currentTool === 'eraser') {
      ctx.beginPath();
      ctx.moveTo(lastX, lastY);
      ctx.lineTo(pos.x, pos.y);
      ctx.strokeStyle = currentTool === 'eraser' ? '#ffffff' : currentColor;
      ctx.lineWidth = brushSize;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';
      ctx.globalAlpha = currentTool === 'eraser' ? 1 : opacity;
      ctx.stroke();
      lastX = pos.x;
      lastY = pos.y;
    }

    if (['rect','circle','line'].includes(currentTool)) {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(tempCanvas, 0, 0);
      drawShape(pos.x, pos.y);
    }
  });

  $(document).on('mouseup', function() {
    if (!isDrawing) return;
    isDrawing = false;
    ctx.globalAlpha = 1;

    if (['brush','eraser'].includes(currentTool)) {
      saveState(currentTool === 'eraser' ? 'Erase' : 'Brush Stroke');
    }
    if (['rect','circle','line'].includes(currentTool)) {
      saveState(currentTool.charAt(0).toUpperCase() + currentTool.slice(1));
    }
  });

  function drawShape(cx, cy) {
    ctx.strokeStyle = currentColor;
    ctx.fillStyle = currentColor;
    ctx.lineWidth = brushSize;
    ctx.globalAlpha = opacity;
    ctx.lineCap = 'round';

    const fill = $('#shapeFill').is(':checked');

    if (currentTool === 'line') {
      ctx.beginPath();
      ctx.moveTo(startX, startY);
      ctx.lineTo(cx, cy);
      ctx.stroke();
    } else if (currentTool === 'rect') {
      if (fill) {
        ctx.fillRect(startX, startY, cx - startX, cy - startY);
      } else {
        ctx.strokeRect(startX, startY, cx - startX, cy - startY);
      }
    } else if (currentTool === 'circle') {
      const rx = Math.abs(cx - startX) / 2;
      const ry = Math.abs(cy - startY) / 2;
      const centerX = startX + (cx - startX) / 2;
      const centerY = startY + (cy - startY) / 2;
      ctx.beginPath();
      ctx.ellipse(centerX, centerY, rx, ry, 0, 0, Math.PI * 2);
      fill ? ctx.fill() : ctx.stroke();
    }
    ctx.globalAlpha = 1;
  }

  // ==== Eyedropper ====
  function pickColor(x, y) {
    const pixel = ctx.getImageData(Math.round(x), Math.round(y), 1, 1).data;
    const hex = '#' + [pixel[0], pixel[1], pixel[2]].map(v => v.toString(16).padStart(2,'0')).join('');
    setColor(hex);
    selectTool('brush');
  }

  // ==== Flood Fill ====
  function floodFill(sx, sy, fillColor) {
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;
    const w = canvas.width;
    const h = canvas.height;

    const idx = (y, x) => (y * w + x) * 4;
    const sr = data[idx(sy,sx)], sg = data[idx(sy,sx)+1], sb = data[idx(sy,sx)+2], sa = data[idx(sy,sx)+3];

    // Parse fill color
    const fc = document.createElement('canvas').getContext('2d');
    fc.fillStyle = fillColor;
    fc.fillRect(0,0,1,1);
    const fp = fc.getImageData(0,0,1,1).data;
    const fr = fp[0], fg = fp[1], fb = fp[2];

    if (sr === fr && sg === fg && sb === fb && sa === 255) return;

    const stack = [[sx, sy]];
    const visited = new Uint8Array(w * h);

    function match(i) {
      return data[i] === sr && data[i+1] === sg && data[i+2] === sb && data[i+3] === sa;
    }

    while (stack.length) {
      const [x, y] = stack.pop();
      if (x < 0 || x >= w || y < 0 || y >= h) continue;
      const pi = y * w + x;
      if (visited[pi]) continue;
      const i = pi * 4;
      if (!match(i)) continue;

      visited[pi] = 1;
      data[i] = fr;
      data[i+1] = fg;
      data[i+2] = fb;
      data[i+3] = 255;

      stack.push([x+1,y],[x-1,y],[x,y+1],[x,y-1]);
    }

    ctx.putImageData(imageData, 0, 0);
  }

  // ==== Undo / Redo ====
  function saveState(name, init) {
    if (!init) {
      redoStack = [];
    }
    undoStack.push(canvas.toDataURL());
    historyNames.push(name);
    updateHistory();
  }

  function undo() {
    if (undoStack.length <= 1) return;
    redoStack.push(undoStack.pop());
    historyNames.pop();
    const img = new Image();
    img.onload = function() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      updateHistory();
    };
    img.src = undoStack[undoStack.length - 1];
  }

  function redo() {
    if (!redoStack.length) return;
    const state = redoStack.pop();
    undoStack.push(state);
    historyNames.push('Redo');
    const img = new Image();
    img.onload = function() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      updateHistory();
    };
    img.src = state;
  }

  function updateHistory() {
    const $list = $('#historyList').empty();
    historyNames.forEach((name, i) => {
      const $item = $('<div>').addClass('history-item').text(name);
      if (i === historyNames.length - 1) $item.addClass('current');
      $list.append($item);
    });
    $list.scrollTop($list[0].scrollHeight);
  }

  $('#undoBtn').click(undo);
  $('#redoBtn').click(redo);

  // ==== Clear ====
  $('#clearBtn').click(function() {
    if (confirm('Clear entire canvas?')) {
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      saveState('Clear Canvas');
    }
  });

  // ==== Save ====
  $('#saveBtn').click(function() {
    const link = document.createElement('a');
    link.download = 'pixel-studio-' + Date.now() + '.png';
    link.href = canvas.toDataURL();
    link.click();
  });

  // ==== Zoom ====
  function setZoom(z) {
    zoom = Math.max(0.25, Math.min(3, z));
    $(canvas).css('transform', `scale(${zoom})`);
    $('#zoomLevel').text(Math.round(zoom * 100) + '%');
  }

  $('#zoomIn').click(() => setZoom(zoom + 0.25));
  $('#zoomOut').click(() => setZoom(zoom - 0.25));
  $('#zoomReset').click(() => setZoom(1));

  // Mouse wheel zoom
  $('#canvasWrapper').on('wheel', function(e) {
    e.preventDefault();
    const delta = e.originalEvent.deltaY > 0 ? -0.1 : 0.1;
    setZoom(zoom + delta);
  });

  // ==== Keyboard Shortcuts ====
  $(document).on('keydown', function(e) {
    if ($('#textInput').is(':focus')) return;
    const key = e.key.toLowerCase();

    if (e.ctrlKey || e.metaKey) {
      if (key === 'z') { e.preventDefault(); undo(); }
      if (key === 'y') { e.preventDefault(); redo(); }
      return;
    }

    const shortcuts = { b:'brush', e:'eraser', f:'fill', i:'eyedropper', l:'line', r:'rect', c:'circle', t:'text' };
    if (shortcuts[key]) selectTool(shortcuts[key]);
    if (key === '=' || key === '+') setZoom(zoom + 0.25);
    if (key === '-') setZoom(zoom - 0.25);
  });

  // ==== Init Canvas White ====
  ctx.fillStyle = '#ffffff';
  ctx.fillRect(0, 0, canvas.width, canvas.height);
});
</script>
</body>
</html>