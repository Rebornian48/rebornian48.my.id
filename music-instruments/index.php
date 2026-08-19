<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Music Studio</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="music" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.49/Tone.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=JetBrains+Mono:wght@300;400;500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            mono: ['JetBrains Mono', 'monospace'],
            body: ['Outfit', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    :root {
      --glow-piano: #6366f1;
      --glow-violin: #f59e0b;
      --glow-trumpet: #ef4444;
      --glow-guitar: #10b981;
      --glow-drum: #ec4899;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { overflow-x: hidden; }

    body {
      background: #0a0a0f;
      font-family: 'Outfit', sans-serif;
    }

    .bg-noise {
      position: fixed; inset: 0; z-index: 0; pointer-events: none; opacity: 0.03;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }

    .tab-btn {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    .tab-btn::before {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(circle at center, currentColor, transparent);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .tab-btn:hover::before { opacity: 0.08; }
    .tab-btn.active { transform: translateY(-2px); }

    .tab-btn.active[data-instrument="piano"] { border-color: var(--glow-piano); box-shadow: 0 4px 30px rgba(99,102,241,0.3); background: rgba(99,102,241,0.1); }
    .tab-btn.active[data-instrument="violin"] { border-color: var(--glow-violin); box-shadow: 0 4px 30px rgba(245,158,11,0.3); background: rgba(245,158,11,0.1); }
    .tab-btn.active[data-instrument="trumpet"] { border-color: var(--glow-trumpet); box-shadow: 0 4px 30px rgba(239,68,68,0.3); background: rgba(239,68,68,0.1); }
    .tab-btn.active[data-instrument="guitar"] { border-color: var(--glow-guitar); box-shadow: 0 4px 30px rgba(16,185,129,0.3); background: rgba(16,185,129,0.1); }
    .tab-btn.active[data-instrument="drum"] { border-color: var(--glow-drum); box-shadow: 0 4px 30px rgba(236,72,153,0.3); background: rgba(236,72,153,0.1); }

    /* Piano Styles */
    .piano-container { display: flex; justify-content: center; perspective: 800px; }
    .piano-keys { display: flex; position: relative; transform: rotateX(2deg); }
    .white-key {
      width: 52px; height: 200px;
      background: linear-gradient(180deg, #f8f8f8 0%, #e8e8e8 85%, #d0d0d0 100%);
      border: 1px solid #bbb;
      border-radius: 0 0 6px 6px;
      cursor: pointer;
      position: relative;
      z-index: 1;
      transition: all 0.08s;
      box-shadow: 0 4px 6px rgba(0,0,0,0.3), inset 0 -2px 4px rgba(0,0,0,0.1);
    }
    .white-key:active, .white-key.pressed {
      background: linear-gradient(180deg, #e0e0e0 0%, #d0d0d0 100%);
      height: 197px;
      box-shadow: 0 2px 3px rgba(0,0,0,0.3), inset 0 1px 3px rgba(0,0,0,0.15);
    }
    .white-key .key-label {
      position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px; color: #999; pointer-events: none;
    }
    .black-key {
      width: 32px; height: 125px;
      background: linear-gradient(180deg, #333 0%, #1a1a1a 80%, #111 100%);
      border-radius: 0 0 4px 4px;
      cursor: pointer;
      position: absolute;
      z-index: 2;
      transition: all 0.08s;
      box-shadow: 0 4px 8px rgba(0,0,0,0.6), inset 0 -2px 3px rgba(255,255,255,0.05);
    }
    .black-key:active, .black-key.pressed {
      background: linear-gradient(180deg, #444 0%, #222 100%);
      height: 122px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .black-key .key-label {
      position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%);
      font-family: 'JetBrains Mono', monospace;
      font-size: 9px; color: #666; pointer-events: none;
    }

    /* Instrument panels */
    .instrument-panel { display: none; animation: fadeSlideIn 0.5s ease; }
    .instrument-panel.active { display: block; }

    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Pad buttons for drums/guitar/etc */
    .sound-pad {
      transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      user-select: none;
      -webkit-user-select: none;
    }
    .sound-pad::after {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(circle at center, white, transparent);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .sound-pad:active::after, .sound-pad.pressed::after { opacity: 0.15; }
    .sound-pad:active, .sound-pad.pressed { transform: scale(0.95); }

    /* Drum pad colors */
    .drum-kick { background: linear-gradient(135deg, #7c1d1d, #991b1b); border-color: #ef4444; }
    .drum-snare { background: linear-gradient(135deg, #713f12, #92400e); border-color: #f59e0b; }
    .drum-hihat { background: linear-gradient(135deg, #1e3a5f, #1e40af); border-color: #3b82f6; }
    .drum-tom { background: linear-gradient(135deg, #4a1d6e, #6b21a8); border-color: #a855f7; }
    .drum-crash { background: linear-gradient(135deg, #064e3b, #065f46); border-color: #10b981; }
    .drum-ride { background: linear-gradient(135deg, #831843, #9d174d); border-color: #ec4899; }

    /* Visualizer */
    #visualizer {
      position: fixed; bottom: 0; left: 0; right: 0; height: 80px;
      pointer-events: none; z-index: 50; opacity: 0.6;
    }

    /* String animation */
    .string-line {
      stroke-dasharray: 4 4;
      animation: stringVibrate 0.1s linear infinite;
      animation-play-state: paused;
    }
    .string-line.vibrating {
      animation-play-state: running;
    }
    @keyframes stringVibrate {
      0%, 100% { transform: translateY(0); }
      25% { transform: translateY(-2px); }
      75% { transform: translateY(2px); }
    }

    .glow-text {
      text-shadow: 0 0 40px currentColor, 0 0 80px currentColor;
    }

    /* Volume slider */
    input[type="range"] {
      -webkit-appearance: none;
      appearance: none;
      background: transparent;
      cursor: pointer;
    }
    input[type="range"]::-webkit-slider-track {
      height: 4px;
      background: rgba(255,255,255,0.15);
      border-radius: 4px;
    }
    input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 16px; height: 16px;
      background: white;
      border-radius: 50%;
      margin-top: -6px;
      box-shadow: 0 0 10px rgba(255,255,255,0.3);
    }

    .key-hint {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 24px; height: 24px;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 4px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      color: rgba(255,255,255,0.4);
      background: rgba(255,255,255,0.05);
    }

    .splash-overlay {
      position: fixed; inset: 0; z-index: 9999;
      background: #0a0a0f;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: opacity 0.6s ease;
    }
    .splash-overlay.hidden { opacity: 0; pointer-events: none; }

    @keyframes pulse-ring {
      0% { transform: scale(1); opacity: 0.6; }
      100% { transform: scale(1.5); opacity: 0; }
    }

    .violin-bow {
      width: 100%; height: 60px;
      cursor: pointer;
      position: relative;
      border-radius: 12px;
      overflow: hidden;
    }
    .violin-bow:hover .bow-fill { width: 100%; }
    .bow-fill {
      position: absolute; left: 0; top: 0; bottom: 0;
      width: 0; transition: width 0.6s ease;
      border-radius: 12px;
    }
  </style>
</head>
<body class="min-h-screen text-white font-body">
  <div class="bg-noise"></div>

  <!-- Splash Screen -->
  <div id="splash" class="splash-overlay">
    <div class="text-center">
      <div class="relative inline-block mb-8">
        <div class="w-24 h-24 rounded-full border-2 border-indigo-400/40 flex items-center justify-center">
          <i class="fa-solid fa-music text-4xl text-indigo-400"></i>
        </div>
        <div class="absolute inset-0 w-24 h-24 rounded-full border-2 border-indigo-400/30" style="animation: pulse-ring 2s infinite"></div>
      </div>
      <h1 class="font-display text-5xl font-bold mb-3 bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 bg-clip-text text-transparent">
        Music Studio
      </h1>
      <p class="text-white/40 font-mono text-sm tracking-widest uppercase mb-8">Virtual Instrument Suite</p>
      <div class="inline-flex items-center gap-2 text-white/50 text-sm border border-white/10 rounded-full px-6 py-3 hover:border-white/20 transition-colors">
        <i class="fa-solid fa-hand-pointer"></i>
        <span>Klik untuk Mulai</span>
      </div>
    </div>
  </div>

  <!-- Main App -->
  <div id="app" class="relative z-10 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="px-6 py-4 flex items-center justify-between border-b border-white/5">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
          <i class="fa-solid fa-music text-xs"></i>
        </div>
        <span class="font-display text-lg font-bold tracking-wide">Music Studio</span>
      </div>
      <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 text-white/40 text-xs">
          <i class="fa-solid fa-volume-high text-[10px]"></i>
          <input type="range" id="masterVolume" min="0" max="100" value="75" class="w-20">
        </div>
        <div id="noteDisplay" class="font-mono text-xs text-white/30 w-16 text-right">—</div>
      </div>
    </header>

    <!-- Instrument Tabs -->
    <nav class="px-6 py-4 flex gap-2 flex-wrap justify-center">
      <button class="tab-btn active px-5 py-2.5 rounded-xl border border-white/10 text-sm font-medium flex items-center gap-2.5 text-white/80" data-instrument="piano">
        <i class="fa-solid fa-piano-keyboard text-indigo-400"></i>
        <span>Piano</span>
      </button>
      <button class="tab-btn px-5 py-2.5 rounded-xl border border-white/10 text-sm font-medium flex items-center gap-2.5 text-white/80" data-instrument="violin">
        <i class="fa-solid fa-guitar text-amber-400"></i>
        <span>Biola</span>
      </button>
      <button class="tab-btn px-5 py-2.5 rounded-xl border border-white/10 text-sm font-medium flex items-center gap-2.5 text-white/80" data-instrument="trumpet">
        <i class="fa-solid fa-trumpet text-red-400"></i>
        <span>Terompet</span>
      </button>
      <button class="tab-btn px-5 py-2.5 rounded-xl border border-white/10 text-sm font-medium flex items-center gap-2.5 text-white/80" data-instrument="guitar">
        <i class="fa-solid fa-guitar text-emerald-400"></i>
        <span>Gitar</span>
      </button>
      <button class="tab-btn px-5 py-2.5 rounded-xl border border-white/10 text-sm font-medium flex items-center gap-2.5 text-white/80" data-instrument="drum">
        <i class="fa-solid fa-drum text-pink-400"></i>
        <span>Drum</span>
      </button>
    </nav>

    <!-- Content Area -->
    <main class="flex-1 px-6 py-6 flex items-center justify-center">

      <!-- PIANO -->
      <div id="panel-piano" class="instrument-panel active w-full max-w-4xl">
        <div class="text-center mb-6">
          <h2 class="font-display text-2xl font-bold text-indigo-300 glow-text mb-1">Grand Piano</h2>
          <p class="text-white/30 text-xs font-mono tracking-wider">GUNAKAN KEYBOARD ATAU KLIK TUTS</p>
        </div>
        <div class="piano-container overflow-x-auto pb-4">
          <div class="piano-keys" id="pianoKeys"></div>
        </div>
        <div class="flex justify-center mt-4 gap-4 text-white/20 text-xs font-mono">
          <span>A-L = Tuts Putih</span>
          <span>W,E,T,Y,U = Tuts Hitam</span>
        </div>
      </div>

      <!-- VIOLIN -->
      <div id="panel-violin" class="instrument-panel w-full max-w-3xl">
        <div class="text-center mb-8">
          <h2 class="font-display text-2xl font-bold text-amber-300 glow-text mb-1">Violin</h2>
          <p class="text-white/30 text-xs font-mono tracking-wider">KLIK SENAR ATAU GUNAKAN TOMBOL 1-8</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="violinStrings"></div>
        <div class="mt-6">
          <div class="violin-bow bg-amber-900/20 border border-amber-500/20" id="violinBow">
            <div class="bow-fill bg-gradient-to-r from-amber-600/30 to-amber-400/30"></div>
            <div class="absolute inset-0 flex items-center justify-center text-amber-300/40 text-sm font-mono">
              <i class="fa-solid fa-arrows-left-right mr-2"></i> Geser untuk efek bow
            </div>
          </div>
        </div>
      </div>

      <!-- TRUMPET -->
      <div id="panel-trumpet" class="instrument-panel w-full max-w-3xl">
        <div class="text-center mb-8">
          <h2 class="font-display text-2xl font-bold text-red-300 glow-text mb-1">Trumpet</h2>
          <p class="text-white/30 text-xs font-mono tracking-wider">KLIK PAD ATAU GUNAKAN TOMBOL 1-8</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="trumpetPads"></div>
      </div>

      <!-- GUITAR -->
      <div id="panel-guitar" class="instrument-panel w-full max-w-3xl">
        <div class="text-center mb-8">
          <h2 class="font-display text-2xl font-bold text-emerald-300 glow-text mb-1">Acoustic Guitar</h2>
          <p class="text-white/30 text-xs font-mono tracking-wider">KLIK SENAR ATAU GUNAKAN TOMBOL 1-6</p>
        </div>
        <div id="guitarStrings" class="space-y-3"></div>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-6" id="guitarChords"></div>
      </div>

      <!-- DRUM -->
      <div id="panel-drum" class="instrument-panel w-full max-w-3xl">
        <div class="text-center mb-8">
          <h2 class="font-display text-2xl font-bold text-pink-300 glow-text mb-1">Drum Kit</h2>
          <p class="text-white/30 text-xs font-mono tracking-wider">KLIK PAD ATAU GUNAKAN KEYBOARD</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" id="drumPads"></div>
      </div>

    </main>

    <!-- Footer Info -->
    <footer class="px-6 py-3 text-center text-white/15 text-xs font-mono border-t border-white/5">
      Tekan tombol keyboard yang tertera untuk bermain lebih cepat
    </footer>
  </div>

  <!-- Audio Visualizer -->
  <canvas id="visualizer"></canvas>

<script>
$(function() {
  // ─── Audio Context & Globals ───────────────────────────
  let audioStarted = false;
  let masterVol;
  let analyser, dataArray, canvasCtx, canvas;
  let currentInstrument = 'piano';

  // Splash screen
  $('#splash').on('click', async function() {
    await Tone.start();
    audioStarted = true;
    masterVol = new Tone.Volume(-6).toDestination();
    setupVisualizer();
    $(this).addClass('hidden');
    setTimeout(() => $(this).remove(), 600);
  });

  // Master volume
  $('#masterVolume').on('input', function() {
    if (masterVol) {
      const val = parseInt($(this).val());
      masterVol.volume.value = val === 0 ? -Infinity : Tone.gainToDb(val / 100);
    }
  });

  // ─── Visualizer ────────────────────────────────────────
  function setupVisualizer() {
    canvas = document.getElementById('visualizer');
    canvasCtx = canvas.getContext('2d');
    analyser = new Tone.Analyser('waveform', 256);
    masterVol.connect(analyser);
    resizeCanvas();
    drawVisualizer();
    $(window).on('resize', resizeCanvas);
  }

  function resizeCanvas() {
    if (!canvas) return;
    canvas.width = window.innerWidth;
    canvas.height = 80;
  }

  const glowColors = {
    piano: '#6366f1', violin: '#f59e0b', trumpet: '#ef4444',
    guitar: '#10b981', drum: '#ec4899'
  };

  function drawVisualizer() {
    requestAnimationFrame(drawVisualizer);
    if (!analyser || !canvasCtx) return;
    const data = analyser.getValue();
    const w = canvas.width, h = canvas.height;
    canvasCtx.clearRect(0, 0, w, h);
    const color = glowColors[currentInstrument] || '#6366f1';
    canvasCtx.strokeStyle = color;
    canvasCtx.lineWidth = 2;
    canvasCtx.shadowBlur = 15;
    canvasCtx.shadowColor = color;
    canvasCtx.beginPath();
    const sliceWidth = w / data.length;
    let x = 0;
    for (let i = 0; i < data.length; i++) {
      const y = (data[i] + 1) / 2 * h;
      i === 0 ? canvasCtx.moveTo(x, y) : canvasCtx.lineTo(x, y);
      x += sliceWidth;
    }
    canvasCtx.stroke();
    canvasCtx.shadowBlur = 0;
  }

  // ─── Tab Switching ─────────────────────────────────────
  $('.tab-btn').on('click', function() {
    const inst = $(this).data('instrument');
    currentInstrument = inst;
    $('.tab-btn').removeClass('active');
    $(this).addClass('active');
    $('.instrument-panel').removeClass('active');
    $(`#panel-${inst}`).addClass('active');
  });

  function showNote(name) {
    $('#noteDisplay').text(name).css('color', glowColors[currentInstrument]);
    clearTimeout(window._noteTimer);
    window._noteTimer = setTimeout(() => {
      $('#noteDisplay').text('—').css('color', '');
    }, 1200);
  }

  // ═══════════════════════════════════════════════════════
  //   PIANO
  // ═══════════════════════════════════════════════════════
  const pianoSynth = new Tone.PolySynth(Tone.Synth, {
    oscillator: { type: 'triangle8' },
    envelope: { attack: 0.005, decay: 1.2, sustain: 0.3, release: 1.5 },
    volume: -4
  });

  const pianoNotes = [
    { note: 'C4', key: 'a', type: 'white' },
    { note: 'C#4', key: 'w', type: 'black' },
    { note: 'D4', key: 's', type: 'white' },
    { note: 'D#4', key: 'e', type: 'black' },
    { note: 'E4', key: 'd', type: 'white' },
    { note: 'F4', key: 'f', type: 'white' },
    { note: 'F#4', key: 't', type: 'black' },
    { note: 'G4', key: 'g', type: 'white' },
    { note: 'G#4', key: 'y', type: 'black' },
    { note: 'A4', key: 'h', type: 'white' },
    { note: 'A#4', key: 'u', type: 'black' },
    { note: 'B4', key: 'j', type: 'white' },
    { note: 'C5', key: 'k', type: 'white' },
    { note: 'C#5', key: 'o', type: 'black' },
    { note: 'D5', key: 'l', type: 'white' },
  ];

  function buildPiano() {
    const container = $('#pianoKeys');
    let whiteIndex = 0;
    pianoNotes.forEach((n) => {
      if (n.type === 'white') {
        container.append(
          `<div class="white-key" data-note="${n.note}" data-key="${n.key}">
            <span class="key-label">${n.key.toUpperCase()}</span>
          </div>`
        );
        whiteIndex++;
      }
    });
    // Place black keys
    let wIdx = 0;
    pianoNotes.forEach((n) => {
      if (n.type === 'white') { wIdx++; return; }
      const offset = (wIdx * 52) - 16;
      container.append(
        `<div class="black-key" data-note="${n.note}" data-key="${n.key}" style="left:${offset}px">
          <span class="key-label">${n.key.toUpperCase()}</span>
        </div>`
      );
    });

    container.on('mousedown touchstart', '.white-key, .black-key', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const note = $(this).data('note');
      playPiano(note);
      $(this).addClass('pressed');
    });
    container.on('mouseup mouseleave touchend', '.white-key, .black-key', function() {
      $(this).removeClass('pressed');
    });
  }

  function playPiano(note) {
    pianoSynth.connect(masterVol);
    pianoSynth.triggerAttackRelease(note, '8n');
    showNote(note);
  }

  buildPiano();

  // Piano keyboard mapping
  const pianoKeyMap = {};
  pianoNotes.forEach(n => { pianoKeyMap[n.key] = n.note; });

  // ═══════════════════════════════════════════════════════
  //   VIOLIN
  // ═══════════════════════════════════════════════════════
  const violinSynth = new Tone.PolySynth(Tone.FMSynth, {
    harmonicity: 3.01,
    modulationIndex: 3,
    oscillator: { type: 'sine' },
    envelope: { attack: 0.3, decay: 0.4, sustain: 0.8, release: 1.2 },
    modulation: { type: 'sine' },
    modulationEnvelope: { attack: 0.5, decay: 0.2, sustain: 0.7, release: 0.8 },
    volume: -8
  });

  const violinVibrato = new Tone.Vibrato(5, 0.3);
  const violinReverb = new Tone.Reverb({ decay: 2.5, wet: 0.3 });

  const violinNotes = [
    { note: 'G3', name: 'Sol 3', key: '1' },
    { note: 'A3', name: 'La 3', key: '2' },
    { note: 'B3', name: 'Si 3', key: '3' },
    { note: 'C4', name: 'Do 4', key: '4' },
    { note: 'D4', name: 'Re 4', key: '5' },
    { note: 'E4', name: 'Mi 4', key: '6' },
    { note: 'F4', name: 'Fa 4', key: '7' },
    { note: 'G4', name: 'Sol 4', key: '8' },
  ];

  function buildViolin() {
    const container = $('#violinStrings');
    violinNotes.forEach((n, i) => {
      container.append(`
        <div class="sound-pad rounded-xl border border-amber-500/20 bg-amber-900/10 p-4 text-center hover:border-amber-400/40 hover:bg-amber-900/20" data-note="${n.note}" data-idx="${i}">
          <div class="text-amber-300 text-2xl mb-2"><i class="fa-solid fa-music"></i></div>
          <div class="font-semibold text-amber-100 text-sm">${n.name}</div>
          <div class="text-amber-400/40 text-xs mt-1 font-mono">${n.note}</div>
          <div class="key-hint mt-2 mx-auto text-amber-300/40 border-amber-500/20">${n.key}</div>
        </div>
      `);
    });

    container.on('mousedown touchstart', '.sound-pad', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const note = $(this).data('note');
      playViolin(note);
      $(this).addClass('pressed');
      setTimeout(() => $(this).removeClass('pressed'), 200);
    });
  }

  function playViolin(note) {
    violinSynth.chain(violinVibrato, violinReverb, masterVol);
    violinSynth.triggerAttackRelease(note, '2n');
    showNote(note);
  }

  buildViolin();

  // ═══════════════════════════════════════════════════════
  //   TRUMPET
  // ═══════════════════════════════════════════════════════
  const trumpetSynth = new Tone.PolySynth(Tone.Synth, {
    oscillator: { type: 'sawtooth' },
    envelope: { attack: 0.1, decay: 0.3, sustain: 0.6, release: 0.8 },
    volume: -10
  });
  const trumpetDist = new Tone.Distortion(0.1);
  const trumpetReverb = new Tone.Reverb({ decay: 1.8, wet: 0.2 });

  const trumpetNotes = [
    { note: 'Bb3', name: 'Bb 3', key: '1' },
    { note: 'C4', name: 'Do 4', key: '2' },
    { note: 'D4', name: 'Re 4', key: '3' },
    { note: 'Eb4', name: 'Eb 4', key: '4' },
    { note: 'F4', name: 'Fa 4', key: '5' },
    { note: 'G4', name: 'Sol 4', key: '6' },
    { note: 'A4', name: 'La 4', key: '7' },
    { note: 'Bb4', name: 'Bb 4', key: '8' },
  ];

  function buildTrumpet() {
    const container = $('#trumpetPads');
    trumpetNotes.forEach((n) => {
      container.append(`
        <div class="sound-pad rounded-xl border border-red-500/20 bg-red-900/10 p-4 text-center hover:border-red-400/40 hover:bg-red-900/20" data-note="${n.note}">
          <div class="text-red-300 text-2xl mb-2"><i class="fa-solid fa-trumpet"></i></div>
          <div class="font-semibold text-red-100 text-sm">${n.name}</div>
          <div class="text-red-400/40 text-xs mt-1 font-mono">${n.note}</div>
          <div class="key-hint mt-2 mx-auto text-red-300/40 border-red-500/20">${n.key}</div>
        </div>
      `);
    });

    container.on('mousedown touchstart', '.sound-pad', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const note = $(this).data('note');
      playTrumpet(note);
      $(this).addClass('pressed');
      setTimeout(() => $(this).removeClass('pressed'), 200);
    });
  }

  function playTrumpet(note) {
    trumpetSynth.chain(trumpetDist, trumpetReverb, masterVol);
    trumpetSynth.triggerAttackRelease(note, '4n');
    showNote(note);
  }

  buildTrumpet();

  // ═══════════════════════════════════════════════════════
  //   GUITAR
  // ═══════════════════════════════════════════════════════
  const guitarSynth = new Tone.PluckSynth({
    attackNoise: 2,
    dampening: 3500,
    resonance: 0.96,
    volume: -4
  });
  const guitarReverb = new Tone.Reverb({ decay: 2.0, wet: 0.15 });

  const guitarStrings = [
    { note: 'E2', name: 'E (Low)', key: '1' },
    { note: 'A2', name: 'A', key: '2' },
    { note: 'D3', name: 'D', key: '3' },
    { note: 'G3', name: 'G', key: '4' },
    { note: 'B3', name: 'B', key: '5' },
    { note: 'E4', name: 'E (High)', key: '6' },
  ];

  const guitarChords = [
    { notes: ['E2','B2','E3','G#3','B3','E4'], name: 'E', key: 'q' },
    { notes: ['A2','E3','A3','C#4','E4'], name: 'A', key: 'w' },
    { notes: ['D3','A3','D4','F#4'], name: 'D', key: 'e' },
    { notes: ['G3','B3','D4','G4','B4','G5'], name: 'G', key: 'r' },
    { notes: ['C3','E3','G3','C4','E4'], name: 'C', key: 't' },
    { notes: ['E2','B2','E3','G3','B3','E4'], name: 'Em', key: 'y' },
  ];

  function buildGuitar() {
    const strContainer = $('#guitarStrings');
    guitarStrings.forEach((s, i) => {
      const thickness = 6 - i;
      strContainer.append(`
        <div class="sound-pad flex items-center gap-4 rounded-lg border border-emerald-500/15 bg-emerald-900/5 px-4 py-3 hover:border-emerald-400/30 hover:bg-emerald-900/15" data-note="${s.note}">
          <div class="key-hint text-emerald-300/40 border-emerald-500/20">${s.key}</div>
          <span class="text-emerald-200/60 text-sm font-mono w-16">${s.name}</span>
          <div class="flex-1 h-px relative">
            <div class="absolute inset-0" style="height:${thickness}px;top:50%;transform:translateY(-50%);background:linear-gradient(90deg,#065f46,#10b981,#065f46);border-radius:2px;opacity:0.5"></div>
          </div>
          <span class="text-emerald-400/30 text-xs font-mono">${s.note}</span>
        </div>
      `);
    });

    strContainer.on('mousedown touchstart', '.sound-pad', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const note = $(this).data('note');
      playGuitar(note);
      $(this).addClass('pressed');
      setTimeout(() => $(this).removeClass('pressed'), 200);
    });

    const chContainer = $('#guitarChords');
    guitarChords.forEach((c) => {
      chContainer.append(`
        <div class="sound-pad rounded-xl border border-emerald-500/20 bg-emerald-900/10 p-3 text-center hover:border-emerald-400/40 hover:bg-emerald-900/20" data-chord='${JSON.stringify(c.notes)}'>
          <div class="font-bold text-emerald-200 text-lg">${c.name}</div>
          <div class="text-emerald-400/30 text-[10px] font-mono mt-1">Chord</div>
          <div class="key-hint mt-1 mx-auto text-emerald-300/40 border-emerald-500/20">${c.key}</div>
        </div>
      `);
    });

    chContainer.on('mousedown touchstart', '.sound-pad', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const chord = JSON.parse($(this).attr('data-chord'));
      playGuitarChord(chord);
      $(this).addClass('pressed');
      setTimeout(() => $(this).removeClass('pressed'), 200);
    });
  }

  function playGuitar(note) {
    guitarSynth.chain(guitarReverb, masterVol);
    guitarSynth.triggerAttack(note);
    showNote(note);
  }

  function playGuitarChord(notes) {
    guitarSynth.chain(guitarReverb, masterVol);
    notes.forEach((n, i) => {
      setTimeout(() => guitarSynth.triggerAttack(n), i * 30);
    });
    showNote(notes[0] + ' chord');
  }

  buildGuitar();

  // ═══════════════════════════════════════════════════════
  //   DRUM KIT
  // ═══════════════════════════════════════════════════════
  const drumSounds = {
    kick: new Tone.MembraneSynth({ pitchDecay: 0.05, octaves: 6, envelope: { attack: 0.001, decay: 0.3, sustain: 0, release: 0.3 }, volume: -2 }),
    snare: new Tone.NoiseSynth({ noise: { type: 'white' }, envelope: { attack: 0.001, decay: 0.15, sustain: 0, release: 0.1 }, volume: -6 }),
    hihat: new Tone.MetalSynth({ frequency: 400, envelope: { attack: 0.001, decay: 0.05, release: 0.01 }, harmonicity: 5.1, modulationIndex: 32, resonance: 4000, octaves: 1.5, volume: -12 }),
    openhat: new Tone.MetalSynth({ frequency: 400, envelope: { attack: 0.001, decay: 0.3, release: 0.1 }, harmonicity: 5.1, modulationIndex: 32, resonance: 4000, octaves: 1.5, volume: -14 }),
    tom1: new Tone.MembraneSynth({ pitchDecay: 0.08, octaves: 4, envelope: { attack: 0.001, decay: 0.25, sustain: 0, release: 0.2 }, volume: -4 }),
    tom2: new Tone.MembraneSynth({ pitchDecay: 0.08, octaves: 4, envelope: { attack: 0.001, decay: 0.25, sustain: 0, release: 0.2 }, volume: -4 }),
    crash: new Tone.MetalSynth({ frequency: 300, envelope: { attack: 0.001, decay: 1.0, release: 0.3 }, harmonicity: 5.1, modulationIndex: 40, resonance: 3500, octaves: 1.5, volume: -14 }),
    ride: new Tone.MetalSynth({ frequency: 500, envelope: { attack: 0.001, decay: 0.6, release: 0.1 }, harmonicity: 5.1, modulationIndex: 20, resonance: 5000, octaves: 1, volume: -16 }),
  };

  const drumKit = [
    { id: 'kick', name: 'Kick', icon: 'fa-drum', cls: 'drum-kick', key: 'b', note: 'C1' },
    { id: 'snare', name: 'Snare', icon: 'fa-drum-steelpan', cls: 'drum-snare', key: 'v', note: null },
    { id: 'hihat', name: 'Hi-Hat', icon: 'fa-compact-disc', cls: 'drum-hihat', key: 'n', note: null },
    { id: 'openhat', name: 'Open Hat', icon: 'fa-circle-dot', cls: 'drum-hihat', key: 'm', note: null },
    { id: 'tom1', name: 'Tom High', icon: 'fa-drum', cls: 'drum-tom', key: 'g', note: 'G2' },
    { id: 'tom2', name: 'Tom Low', icon: 'fa-drum', cls: 'drum-tom', key: 'h', note: 'D2' },
    { id: 'crash', name: 'Crash', icon: 'fa-compact-disc', cls: 'drum-crash', key: 'j', note: null },
    { id: 'ride', name: 'Ride', icon: 'fa-compact-disc', cls: 'drum-ride', key: 'k', note: null },
  ];

  function buildDrums() {
    const container = $('#drumPads');
    drumKit.forEach((d) => {
      container.append(`
        <div class="sound-pad rounded-xl border-2 ${d.cls} p-5 text-center" data-drum="${d.id}">
          <div class="text-3xl mb-2 opacity-80"><i class="fa-solid ${d.icon}"></i></div>
          <div class="font-bold text-sm">${d.name}</div>
          <div class="key-hint mt-2 mx-auto">${d.key.toUpperCase()}</div>
        </div>
      `);
    });

    container.on('mousedown touchstart', '.sound-pad', function(e) {
      e.preventDefault();
      if (!audioStarted) return;
      const drumId = $(this).data('drum');
      playDrum(drumId);
      $(this).addClass('pressed');
      setTimeout(() => $(this).removeClass('pressed'), 150);
    });
  }

  function playDrum(id) {
    const synth = drumSounds[id];
    if (!synth) return;
    synth.connect(masterVol);
    const d = drumKit.find(x => x.id === id);
    if (synth instanceof Tone.NoiseSynth || synth instanceof Tone.MetalSynth) {
      synth.triggerAttackRelease('16n');
    } else {
      synth.triggerAttackRelease(d.note || 'C2', '8n');
    }
    showNote(d.name);
  }

  buildDrums();

  // ═══════════════════════════════════════════════════════
  //   KEYBOARD CONTROLS
  // ═══════════════════════════════════════════════════════
  const pressedKeys = new Set();

  $(document).on('keydown', function(e) {
    if (!audioStarted || pressedKeys.has(e.key.toLowerCase())) return;
    const key = e.key.toLowerCase();
    pressedKeys.add(key);

    if (currentInstrument === 'piano') {
      const note = pianoKeyMap[key];
      if (note) {
        playPiano(note);
        $(`.white-key[data-key="${key}"], .black-key[data-key="${key}"]`).addClass('pressed');
      }
    } else if (currentInstrument === 'violin') {
      const vn = violinNotes.find(n => n.key === key);
      if (vn) {
        playViolin(vn.note);
        $(`#violinStrings .sound-pad`).eq(violinNotes.indexOf(vn)).addClass('pressed');
        setTimeout(() => $(`#violinStrings .sound-pad`).eq(violinNotes.indexOf(vn)).removeClass('pressed'), 200);
      }
    } else if (currentInstrument === 'trumpet') {
      const tn = trumpetNotes.find(n => n.key === key);
      if (tn) {
        playTrumpet(tn.note);
        const idx = trumpetNotes.indexOf(tn);
        $(`#trumpetPads .sound-pad`).eq(idx).addClass('pressed');
        setTimeout(() => $(`#trumpetPads .sound-pad`).eq(idx).removeClass('pressed'), 200);
      }
    } else if (currentInstrument === 'guitar') {
      const gs = guitarStrings.find(s => s.key === key);
      if (gs) {
        playGuitar(gs.note);
        const idx = guitarStrings.indexOf(gs);
        $(`#guitarStrings .sound-pad`).eq(idx).addClass('pressed');
        setTimeout(() => $(`#guitarStrings .sound-pad`).eq(idx).removeClass('pressed'), 200);
      }
      const gc = guitarChords.find(c => c.key === key);
      if (gc) {
        playGuitarChord(gc.notes);
        const idx = guitarChords.indexOf(gc);
        $(`#guitarChords .sound-pad`).eq(idx).addClass('pressed');
        setTimeout(() => $(`#guitarChords .sound-pad`).eq(idx).removeClass('pressed'), 200);
      }
    } else if (currentInstrument === 'drum') {
      const dk = drumKit.find(d => d.key === key);
      if (dk) {
        playDrum(dk.id);
        $(`#drumPads .sound-pad[data-drum="${dk.id}"]`).addClass('pressed');
        setTimeout(() => $(`#drumPads .sound-pad[data-drum="${dk.id}"]`).removeClass('pressed'), 150);
      }
    }
  });

  $(document).on('keyup', function(e) {
    const key = e.key.toLowerCase();
    pressedKeys.delete(key);
    if (currentInstrument === 'piano') {
      $(`.white-key[data-key="${key}"], .black-key[data-key="${key}"]`).removeClass('pressed');
    }
  });

});
</script>
</body>
</html>