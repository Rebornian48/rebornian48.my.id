<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Rebornian48 — Game Suite</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="randomizer" defer></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cinzel:wght@400;600;900&family=DM+Mono:wght@400;500&family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Orbitron:wght@400;700;900&family=Syne:wght@400;600;700;800&family=Space+Mono:wght@400;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,400&family=EB+Garamond:ital,wght@0,400;1,400&display=swap" rel="stylesheet"/>
<style>
:root {
  --bg: #07080f;
  --surface: #0d0f1c;
  --surface2: #131627;
  --border: rgba(255,255,255,0.07);
  --accent: #c9a84c;
  --accent2: #00f5ff;
  --accent3: #ff2d78;
  --text: #e8e8f0;
  --muted: #5a5a7a;
  --sidebar-w: 220px;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{background:var(--bg);color:var(--text);font-family:'Syne',sans-serif;min-height:100vh;overflow-x:hidden;}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(0,245,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(0,245,255,0.02) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;z-index:0;}

/* SIDEBAR */
.sidebar{position:fixed;left:0;top:0;bottom:0;width:var(--sidebar-w);background:var(--surface);border-right:1px solid var(--border);z-index:100;display:flex;flex-direction:column;overflow:hidden;}
.sidebar-logo{padding:24px 20px 20px;border-bottom:1px solid var(--border);}
.logo-title{font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:.12em;color:var(--accent);text-shadow:0 0 20px rgba(201,168,76,.4);line-height:1;}
.logo-sub{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.3em;color:var(--muted);margin-top:3px;}
.sidebar-nav{flex:1;padding:12px 0;overflow-y:auto;}
.sidebar-nav::-webkit-scrollbar{width:3px;}
.sidebar-nav::-webkit-scrollbar-thumb{background:var(--border);}
.nav-section{padding:16px 20px 6px;font-family:'DM Mono',monospace;font-size:.52rem;letter-spacing:.3em;color:var(--muted);text-transform:uppercase;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 20px;cursor:pointer;transition:all .2s;border-left:2px solid transparent;font-size:.85rem;font-weight:600;color:var(--muted);position:relative;}
.nav-item:hover{background:rgba(255,255,255,.03);color:var(--text);border-left-color:rgba(201,168,76,.3);}
.nav-item.active{background:rgba(201,168,76,.08);color:var(--accent);border-left-color:var(--accent);}
.nav-icon{font-size:1.1rem;width:22px;text-align:center;flex-shrink:0;}
.nav-badge{margin-left:auto;font-family:'DM Mono',monospace;font-size:.5rem;padding:2px 6px;border-radius:10px;background:rgba(0,245,255,.1);color:var(--accent2);border:1px solid rgba(0,245,255,.2);}
.sidebar-footer{padding:16px 20px;border-top:1px solid var(--border);}
.footer-text{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.1em;color:var(--muted);line-height:1.6;}

/* MAIN */
.main{margin-left:var(--sidebar-w);min-height:100vh;position:relative;z-index:1;}
.page{display:none;min-height:100vh;}
.page.active{display:block;}

/* ── HOME PAGE ── */
.home-hero{padding:60px 48px 40px;border-bottom:1px solid var(--border);}
.hero-eyebrow{font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.3em;color:var(--accent2);text-transform:uppercase;margin-bottom:12px;}
.hero-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(3rem,6vw,5.5rem);letter-spacing:.08em;line-height:1;background:linear-gradient(135deg,var(--accent) 0%,#f0d080 40%,var(--accent) 80%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-desc{font-size:1rem;color:var(--muted);margin-top:12px;max-width:500px;line-height:1.7;font-weight:400;}
.features-grid{padding:40px 48px;display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;}
.feature-card{background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:28px;cursor:pointer;transition:all .25s;position:relative;overflow:hidden;}
.feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;transition:opacity .25s;}
.feature-card:hover{border-color:rgba(255,255,255,.15);transform:translateY(-4px);box-shadow:0 20px 60px rgba(0,0,0,.5);}
.feature-card:hover::before{opacity:1;}
.fc-gold::before{background:linear-gradient(90deg,transparent,var(--accent),transparent);opacity:.5;}
.fc-cyan::before{background:linear-gradient(90deg,transparent,var(--accent2),transparent);opacity:.5;}
.fc-pink::before{background:linear-gradient(90deg,transparent,var(--accent3),transparent);opacity:.5;}
.fc-green::before{background:linear-gradient(90deg,transparent,#06d6a0,transparent);opacity:.5;}
.fc-purple::before{background:linear-gradient(90deg,transparent,#818cf8,transparent);opacity:.5;}
.fc-yellow::before{background:linear-gradient(90deg,transparent,#ffbe0b,transparent);opacity:.5;}
.fc-teal::before{background:linear-gradient(90deg,transparent,#00f5c4,transparent);opacity:.5;}
.fc-lime::before{background:linear-gradient(90deg,transparent,#a3e635,transparent);opacity:.5;}
.fc-orange::before{background:linear-gradient(90deg,transparent,#ff9f43,transparent);opacity:.5;}
.fc-violet::before{background:linear-gradient(90deg,transparent,#a78bfa,transparent);opacity:.5;}
.card-emoji{font-size:2.5rem;margin-bottom:14px;display:block;}
.card-title{font-family:'Bebas Neue',sans-serif;font-size:1.4rem;letter-spacing:.08em;margin-bottom:6px;}
.card-desc{font-size:.8rem;color:var(--muted);line-height:1.6;font-weight:400;}
.card-tag{margin-top:14px;display:inline-block;font-family:'DM Mono',monospace;font-size:.55rem;padding:3px 10px;border-radius:20px;letter-spacing:.1em;text-transform:uppercase;}

/* ── SECTION HEADERS ── */
.page-header{padding:36px 48px 28px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:16px;}
.page-back{width:36px;height:36px;border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;font-size:1rem;color:var(--muted);flex-shrink:0;}
.page-back:hover{border-color:var(--accent);color:var(--accent);}
.page-title-wrap{}
.page-eyebrow{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);margin-bottom:4px;}
.page-title{font-family:'Bebas Neue',sans-serif;font-size:2.2rem;letter-spacing:.08em;color:var(--accent);}
.page-content{padding:36px 48px;}

/* ── ABOUT PAGE ── */
.about-wrap{max-width:680px;margin:0 auto;padding:60px 48px;}
.about-badge{display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(201,168,76,.3);padding:6px 16px;border-radius:20px;font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.2em;color:var(--accent);margin-bottom:32px;}
.about-title{font-family:'Cinzel',serif;font-size:clamp(2rem,4vw,3.5rem);font-weight:900;color:var(--text);line-height:1.2;margin-bottom:20px;}
.about-title span{color:var(--accent);}
.about-body{font-size:1rem;color:var(--muted);line-height:1.9;margin-bottom:28px;font-weight:400;}
.about-divider{height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent);margin:36px 0;}
.about-credit{display:flex;align-items:center;gap:20px;padding:24px;background:var(--surface);border:1px solid var(--border);border-radius:12px;}
.credit-ai{width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,var(--accent),#f0d080);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;}
.credit-text{}
.credit-main{font-family:'Cinzel',serif;font-size:1.1rem;font-weight:600;color:var(--text);margin-bottom:4px;}
.credit-sub{font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.15em;color:var(--muted);}
.feature-list-about{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:28px;}
.fla-item{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--surface);border:1px solid var(--border);border-radius:8px;font-size:.82rem;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.fla-item:hover{border-color:rgba(201,168,76,.3);color:var(--text);}
.fla-icon{font-size:1.1rem;}

/* ══════════════════════════════
   CARD DRAW
══════════════════════════════ */
#page-card .inner{max-width:720px;}
.gold-divider{display:flex;align-items:center;gap:12px;margin:20px 0;}
.gold-divider::before,.gold-divider::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--accent),transparent);}
.gold-divider-diamond{width:6px;height:6px;background:var(--accent);transform:rotate(45deg);}
.count-btns{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:20px;}
.count-btn-c{font-family:'Cinzel',serif;font-weight:600;width:50px;height:50px;border-radius:50%;border:1px solid rgba(201,168,76,.3);background:rgba(255,255,255,.03);color:rgba(201,168,76,.5);font-size:1.1rem;cursor:pointer;transition:all .25s;}
.count-btn-c.active,.count-btn-c:hover{border-color:var(--accent);color:#f0d080;background:rgba(201,168,76,.15);box-shadow:0 0 18px rgba(201,168,76,.2);}
.cards-container{display:flex;flex-wrap:wrap;justify-content:center;gap:20px;min-height:220px;align-items:center;margin:20px 0;}
.playing-card{width:130px;height:185px;background:#faf6ef;border-radius:10px;position:relative;box-shadow:0 20px 50px rgba(0,0,0,.7);transform:translateY(40px) rotateY(90deg) scale(.8);opacity:0;transition:transform .5s cubic-bezier(.175,.885,.32,1.275),opacity .4s ease;cursor:pointer;overflow:hidden;}
.playing-card.revealed{transform:translateY(0) rotateY(0deg) scale(1);opacity:1;}
.playing-card:hover{transform:translateY(-10px) scale(1.05) rotate(-1deg);z-index:10;}
.playing-card::before{content:'';position:absolute;inset:5px;border:1px solid rgba(0,0,0,.08);border-radius:4px;pointer-events:none;}
.card-corner{position:absolute;display:flex;flex-direction:column;align-items:center;line-height:1;font-family:'Playfair Display',serif;font-weight:700;}
.card-corner.tl{top:8px;left:8px;}
.card-corner.br{bottom:8px;right:8px;transform:rotate(180deg);}
.card-rank{font-size:1.05rem;font-weight:900;}
.card-suit-small{font-size:.8rem;}
.card-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.card-suit-large{font-size:3rem;line-height:1;}
.card-rank-large{font-family:'Playfair Display',serif;font-weight:900;font-size:1.1rem;}
.text-red{color:#C41E3A;}
.text-black-card{color:#1a1a1a;}
.draw-btn-c{font-family:'Cinzel',serif;font-weight:600;letter-spacing:.18em;font-size:.8rem;padding:14px 44px;background:linear-gradient(135deg,#8B6914 0%,var(--accent) 40%,#F0D080 50%,var(--accent) 65%,#8B6914 100%);color:#1a0f00;border:none;border-radius:2px;cursor:pointer;text-transform:uppercase;box-shadow:0 4px 20px rgba(201,168,76,.4);transition:all .25s;}
.draw-btn-c:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(201,168,76,.6);}
.draw-btn-c:disabled{opacity:.5;cursor:not-allowed;transform:none;}
.card-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:20px;}
.cstat{text-align:center;font-family:'EB Garamond',serif;font-style:italic;color:rgba(201,168,76,.45);font-size:.85rem;}
.cstat span{font-family:'Cinzel',serif;font-style:normal;color:rgba(201,168,76,.7);font-size:1rem;font-weight:600;display:block;}
.card-history{display:flex;flex-wrap:wrap;gap:6px;margin-top:14px;}
.ch-item{font-family:'Playfair Display',serif;font-size:.75rem;padding:2px 8px;border:1px solid rgba(201,168,76,.15);border-radius:3px;background:rgba(255,255,255,.02);}
.empty-state-c{color:rgba(201,168,76,.2);font-family:'Cinzel',serif;font-size:.7rem;letter-spacing:.3em;text-align:center;}

/* ══════════════════════════════
   COIN FLIP
══════════════════════════════ */
#page-coin .inner{max-width:900px;display:grid;grid-template-columns:1fr 320px;gap:24px;}
.coin-scene{perspective:800px;width:200px;height:200px;margin:0 auto 40px;}
.coin-3d{width:100%;height:100%;position:relative;transform-style:preserve-3d;transition:transform .1s;}
.coin-face{position:absolute;inset:0;border-radius:50%;backface-visibility:hidden;display:flex;align-items:center;justify-content:center;flex-direction:column;}
.coin-face-heads{background:conic-gradient(from 0deg,#C9961A,#F5C842,#FFE680,#F5C842,#C9961A,#A07010,#F5C842,#C9961A);box-shadow:inset 0 0 0 6px rgba(0,0,0,.2),inset 0 0 0 10px rgba(255,255,255,.08),0 20px 50px rgba(245,200,66,.3),0 4px 20px rgba(0,0,0,.8);}
.coin-face-tails{background:conic-gradient(from 0deg,#7B8594,#C0C7D4,#E2E6EC,#C0C7D4,#7B8594,#586070,#C0C7D4,#7B8594);transform:rotateY(180deg);box-shadow:inset 0 0 0 6px rgba(0,0,0,.2),0 20px 50px rgba(192,199,212,.2),0 4px 20px rgba(0,0,0,.8);}
.coin-inner-ring{position:absolute;width:80%;height:80%;border-radius:50%;border:2px solid rgba(0,0,0,.2);display:flex;align-items:center;justify-content:center;}
.coin-symbol{font-family:'Bebas Neue',sans-serif;font-size:3rem;color:rgba(0,0,0,.35);text-shadow:0 2px 0 rgba(255,255,255,.25);user-select:none;}
.coin-symbol-sub{font-family:'DM Mono',monospace;font-size:.5rem;letter-spacing:.3em;color:rgba(0,0,0,.3);text-transform:uppercase;}
@keyframes coinFlip{0%{transform:rotateY(0)}10%{transform:rotateY(180deg) rotateX(15deg) translateY(-20px)}30%{transform:rotateY(540deg) rotateX(-10deg) translateY(-60px)}50%{transform:rotateY(900deg) rotateX(8deg) translateY(-40px)}70%{transform:rotateY(1260deg) rotateX(-5deg) translateY(-20px)}85%{transform:rotateY(1530deg) rotateX(3deg) translateY(-5px)}100%{transform:rotateY(1800deg)}}
.coin-3d.flipping{animation:coinFlip 2.2s cubic-bezier(.25,.46,.45,.94) forwards;}
.coin-3d.show-tails{transform:rotateY(180deg);}
.coin-3d.show-heads{transform:rotateY(0deg);}
.coin-result{text-align:center;margin-bottom:32px;min-height:70px;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.coin-result-label{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.3em;color:var(--muted);margin-bottom:6px;}
.coin-result-val{font-family:'Bebas Neue',sans-serif;font-size:3.5rem;letter-spacing:.1em;line-height:1;}
.coin-result-val.heads{color:#F5C842;text-shadow:0 0 30px rgba(245,200,66,.5);}
.coin-result-val.tails{color:#C0C7D4;text-shadow:0 0 30px rgba(192,199,212,.4);}
.coin-result-val.idle{color:var(--muted);}
.coin-streak{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);margin-top:4px;min-height:14px;}
.flip-btn-c{background:none;border:none;cursor:pointer;padding:0;}
.flip-btn-inner-c{display:flex;align-items:center;gap:12px;background:#F5C842;color:#0A0A0F;font-family:'Bebas Neue',sans-serif;font-size:1.2rem;letter-spacing:.2em;padding:16px 44px;border-radius:4px;transition:all .2s;box-shadow:0 0 0 1px rgba(245,200,66,.3),0 8px 24px rgba(245,200,66,.2);}
.flip-btn-c:hover:not(:disabled) .flip-btn-inner-c{background:#FFE153;box-shadow:0 12px 40px rgba(245,200,66,.35);transform:translateY(-2px);}
.flip-btn-c:disabled .flip-btn-inner-c{opacity:.4;cursor:not-allowed;}
.coin-panel{background:var(--surface);border:1px solid var(--border);border-radius:10px;}
.coin-panel-sec{padding:20px;border-bottom:1px solid var(--border);}
.coin-panel-sec:last-child{border-bottom:none;}
.cpanel-label{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);margin-bottom:14px;text-transform:uppercase;}
.coin-stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.csgrid-item{background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:12px 10px;position:relative;overflow:hidden;}
.csgrid-item::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;}
.csgrid-gold::before{background:var(--accent);}
.csgrid-silver::before{background:#C0C7D4;}
.csgrid-total::before{background:linear-gradient(to right,var(--accent),#C0C7D4);}
.csgrid-purple::before{background:#818CF8;}
.csitem-name{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.15em;color:var(--muted);margin-bottom:6px;text-transform:uppercase;}
.csitem-val{font-family:'Bebas Neue',sans-serif;font-size:2rem;line-height:1;}
.csitem-val.gold{color:var(--accent);}
.csitem-val.silver{color:#C0C7D4;}
.csitem-val.white{color:var(--text);}
.csitem-val.purple{color:#818CF8;}
.csitem-sub{font-size:.58rem;color:var(--muted);margin-top:2px;}
.progress-track-c{height:5px;background:var(--bg);border-radius:3px;margin-top:14px;overflow:hidden;border:1px solid var(--border);}
.progress-fill-c{height:100%;background:linear-gradient(to right,var(--accent),#C0C7D4);border-radius:3px;transition:width .5s cubic-bezier(.34,1.56,.64,1);width:50%;}
.progress-labels-c{display:flex;justify-content:space-between;margin-top:5px;font-family:'DM Mono',monospace;font-size:.55rem;color:var(--muted);}
.coin-history-feed{display:flex;flex-direction:column;gap:5px;max-height:220px;overflow-y:auto;}
.coin-history-feed::-webkit-scrollbar{width:3px;}
.coin-history-feed::-webkit-scrollbar-thumb{background:var(--border);}
.chi-item{display:flex;align-items:center;gap:8px;padding:6px 10px;background:var(--bg);border:1px solid var(--border);border-radius:4px;font-family:'DM Mono',monospace;font-size:.65rem;}
.chi-badge{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:.55rem;flex-shrink:0;}
.chi-badge.heads{background:radial-gradient(circle,var(--accent),#C9961A);color:rgba(0,0,0,.6);}
.chi-badge.tails{background:radial-gradient(circle,#C0C7D4,#7B8594);color:rgba(0,0,0,.6);}
.chi-result.heads{color:var(--accent);}
.chi-result.tails{color:#C0C7D4;}
.chi-num{color:var(--muted);font-size:.58rem;margin-left:auto;}
.reset-btn-c{width:100%;padding:10px;background:transparent;border:1px solid var(--border);color:var(--muted);font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;border-radius:4px;cursor:pointer;transition:all .2s;margin-top:12px;}
.reset-btn-c:hover{border-color:rgba(255,255,255,.2);color:var(--text);}
.particle-container{position:fixed;inset:0;pointer-events:none;z-index:9999;overflow:hidden;}
.particle{position:absolute;border-radius:50%;animation:particleFall 1.2s ease-out forwards;}
@keyframes particleFall{0%{opacity:1;transform:translateY(0) scale(1)}100%{opacity:0;transform:translateY(200px) scale(0)}}

/* ══════════════════════════════
   PIGMENT
══════════════════════════════ */
#page-pigment .inner{max-width:380px;margin:0 auto;}
.swatch-box{border-radius:4px 4px 0 0;height:240px;position:relative;overflow:hidden;transition:background .7s cubic-bezier(.22,1,.36,1);}
.swatch-box::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.15) 0%,transparent 60%,rgba(0,0,0,.08) 100%);pointer-events:none;}
.swatch-box::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(0deg,transparent,transparent 39px,rgba(0,0,0,.04) 39px,rgba(0,0,0,.04) 40px);pointer-events:none;z-index:1;}
.swatch-name-p{position:absolute;bottom:16px;left:20px;font-family:'Cormorant Garamond',serif;font-style:italic;font-size:13px;letter-spacing:.1em;color:rgba(0,0,0,.35);z-index:2;}
.shimmer-p{position:absolute;inset:0;background:white;opacity:0;pointer-events:none;z-index:3;}
@keyframes shimmerAnim{0%{opacity:.5}100%{opacity:0}}
.shimmer-p.flash{animation:shimmerAnim .45s ease-out forwards;}
.pigment-vals{border:1px solid rgba(28,25,23,.12);border-top:none;border-radius:0 0 4px 4px;}
.pval-row{display:flex;align-items:center;justify-content:space-between;padding:11px 16px;border-bottom:1px solid rgba(28,25,23,.07);cursor:pointer;transition:background .15s;}
.pval-row:last-child{border-bottom:none;}
.pval-row:hover{background:rgba(200,169,110,.07);}
.pval-row.copied .pval-data{color:#5a7a5a !important;}
.pval-key{font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.2em;color:rgba(100,90,80,.7);text-transform:uppercase;}
.pval-data{font-family:'DM Mono',monospace;font-size:.8rem;color:rgba(28,25,23,.8);}
.gen-btn-p{width:100%;border:1px solid rgba(28,25,23,.7);background:transparent;color:rgba(28,25,23,.8);font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;padding:14px;cursor:pointer;transition:all .3s;position:relative;overflow:hidden;margin-top:12px;}
.gen-btn-p .fill{position:absolute;inset:0;background:rgba(28,25,23,.85);transform:translateY(101%);transition:transform .4s cubic-bezier(.22,1,.36,1);}
.gen-btn-p:hover .fill{transform:translateY(0);}
.gen-btn-p:hover{color:#faf8f5;}
.gen-btn-p span{position:relative;z-index:1;}
.pigment-hist{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;}
.phist-dot{width:26px;height:26px;border-radius:50%;border:2px solid transparent;cursor:pointer;transition:all .2s;flex-shrink:0;}
.phist-dot:hover{transform:scale(1.3);border-color:rgba(28,25,23,.7);}
.phist-dot.active{border-color:rgba(28,25,23,.7);}
.pigment-counter-row{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:16px;}
.pigment-label-small{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.25em;color:rgba(100,90,80,.5);text-transform:uppercase;}
.pigment-num-big{font-family:'DM Mono',monospace;font-size:1.5rem;color:rgba(28,25,23,.7);}

/* ══════════════════════════════
   DICE
══════════════════════════════ */
#page-dice .inner{max-width:560px;}
.die{display:grid;grid-template-columns:repeat(3,1fr);grid-template-rows:repeat(3,1fr);width:90px;height:90px;background:#f5edd6;border-radius:14px;padding:10px;gap:3px;box-shadow:inset -3px -3px 6px rgba(0,0,0,.15),inset 2px 2px 5px rgba(255,255,255,.6),0 8px 24px rgba(0,0,0,.5);}
.dot{border-radius:50%;background:#1a1a1a;box-shadow:inset 1px 1px 2px rgba(255,255,255,.1);display:none;}
.die[data-v="1"] .dot[data-p="5"]{display:block;}
.die[data-v="2"] .dot[data-p="3"],.die[data-v="2"] .dot[data-p="7"]{display:block;}
.die[data-v="3"] .dot[data-p="3"],.die[data-v="3"] .dot[data-p="5"],.die[data-v="3"] .dot[data-p="7"]{display:block;}
.die[data-v="4"] .dot[data-p="1"],.die[data-v="4"] .dot[data-p="3"],.die[data-v="4"] .dot[data-p="7"],.die[data-v="4"] .dot[data-p="9"]{display:block;}
.die[data-v="5"] .dot[data-p="1"],.die[data-v="5"] .dot[data-p="3"],.die[data-v="5"] .dot[data-p="5"],.die[data-v="5"] .dot[data-p="7"],.die[data-v="5"] .dot[data-p="9"]{display:block;}
.die[data-v="6"] .dot[data-p="1"],.die[data-v="6"] .dot[data-p="3"],.die[data-v="6"] .dot[data-p="4"],.die[data-v="6"] .dot[data-p="6"],.die[data-v="6"] .dot[data-p="7"],.die[data-v="6"] .dot[data-p="9"]{display:block;}
@keyframes diceRoll{0%{transform:rotate(0) scale(1) translateY(0)}25%{transform:rotate(-15deg) scale(.9) translateY(-10px)}50%{transform:rotate(20deg) scale(1.05) translateY(-16px)}75%{transform:rotate(-8deg) scale(.97) translateY(-4px)}100%{transform:rotate(0) scale(1) translateY(0)}}
.die.rolling{animation:diceRoll .55s ease-in-out;}
.dice-area{display:flex;justify-content:center;align-items:center;gap:14px;flex-wrap:wrap;min-height:110px;margin:20px 0;}
.dice-selector{display:flex;justify-content:center;gap:10px;margin-bottom:20px;}
.dsel-btn{width:46px;height:46px;border-radius:10px;border:2px solid rgba(201,168,76,.3);background:rgba(0,0,0,.3);color:var(--accent);font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;cursor:pointer;transition:all .18s;}
.dsel-btn.active{background:var(--accent);color:#0a1f14;border-color:var(--accent);box-shadow:0 0 16px rgba(201,168,76,.4);transform:translateY(-2px);}
.roll-btn-d{width:100%;padding:16px;border-radius:10px;border:2px solid rgba(255,255,255,.15);background:linear-gradient(135deg,#c0392b,#96281b,#c0392b);color:#f5edd6;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;letter-spacing:.1em;cursor:pointer;transition:all .15s;box-shadow:0 6px 20px rgba(192,57,43,.35),inset 0 1px 0 rgba(255,255,255,.2);}
.roll-btn-d:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(192,57,43,.5);}
.roll-btn-d:disabled{opacity:.6;cursor:not-allowed;transform:none;}
.dice-result-panel{display:none;margin-top:16px;border-radius:10px;padding:16px 20px;text-align:center;background:rgba(0,0,0,.25);border:1px solid rgba(201,168,76,.2);}
.dice-total-lbl{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:rgba(232,201,110,.6);margin-bottom:6px;text-transform:uppercase;}
.dice-total-val{font-family:'Playfair Display',serif;font-size:2.8rem;font-weight:900;color:var(--accent);text-shadow:0 0 20px rgba(201,168,76,.5);}
.dice-detail-val{font-size:.85rem;color:rgba(245,237,214,.4);margin-top:4px;}
.dice-hist{display:flex;gap:8px;flex-wrap:wrap;margin-top:16px;justify-content:center;}
.dhist-chip{font-family:'DM Mono',monospace;font-size:.7rem;padding:4px 12px;border-radius:8px;background:rgba(255,255,255,.04);border:1px solid rgba(201,168,76,.15);color:rgba(245,237,214,.5);}
.dhist-chip span{color:var(--accent);font-weight:700;}

/* ══════════════════════════════
   RANDOM NUMBER
══════════════════════════════ */
#page-rng .inner{max-width:400px;margin:0 auto;}
.rng-display{position:relative;background:#06060f;border:1px solid rgba(0,245,255,.2);border-radius:4px;padding:32px 20px;text-align:center;margin-bottom:20px;overflow:hidden;}
.rng-display::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(0,245,255,.05) 0%,transparent 70%);}
#rng-number{font-family:'Orbitron',sans-serif;font-size:5rem;font-weight:900;color:var(--accent2);text-shadow:0 0 20px var(--accent2),0 0 60px rgba(0,245,255,.5);line-height:1;display:block;}
@keyframes rngRoll{0%{opacity:.3;transform:translateY(-6px) scale(.97)}60%{opacity:1;transform:translateY(1px) scale(1.04)}100%{opacity:1;transform:translateY(0) scale(1)}}
#rng-number.rolling{animation:rngRoll .28s ease-out forwards;}
.rng-lbl{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.3em;color:rgba(0,245,255,.3);text-transform:uppercase;margin-top:8px;}
.rng-input-wrap{margin-bottom:16px;}
.rng-input-label{display:block;font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:rgba(0,245,255,.5);text-transform:uppercase;margin-bottom:6px;}
.rng-input{width:100%;background:#06060f;border:1px solid rgba(0,245,255,.25);color:var(--accent2);font-family:'Orbitron',sans-serif;font-size:1rem;padding:10px 14px;border-radius:3px;outline:none;transition:border-color .2s;letter-spacing:.1em;}
.rng-input:focus{border-color:var(--accent2);box-shadow:0 0 12px rgba(0,245,255,.2);}
.rng-btn-row{display:flex;gap:10px;margin-bottom:10px;}
.rng-btn{flex:1;font-family:'Orbitron',sans-serif;font-size:.7rem;font-weight:700;letter-spacing:.1em;padding:12px 8px;border-radius:3px;border:1px solid;cursor:pointer;transition:transform .1s;}
.rng-btn:active{transform:scale(.96);}
.rng-minus{color:#ff2d78;border-color:rgba(255,45,120,.4);background:rgba(255,45,120,.06);}
.rng-plus{color:#39ff7a;border-color:rgba(57,255,122,.4);background:rgba(57,255,122,.06);}
.rng-main-btn{width:100%;font-family:'Orbitron',sans-serif;font-size:.8rem;font-weight:700;letter-spacing:.2em;padding:14px;border-radius:3px;border:1px solid #ffe600;background:#ffe600;color:#0a0a12;cursor:pointer;box-shadow:0 0 20px rgba(255,230,0,.3);transition:all .15s;}
.rng-main-btn:hover{box-shadow:0 0 32px rgba(255,230,0,.5);background:#fff176;}
.rng-hist-label{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.2em;color:rgba(0,245,255,.25);text-transform:uppercase;margin:14px 0 8px;}
.rng-hist-pills{display:flex;flex-wrap:wrap;gap:6px;}
.rng-pill{font-family:'Orbitron',monospace;font-size:.65rem;color:rgba(0,245,255,.5);border:1px solid rgba(0,245,255,.15);padding:3px 10px;border-radius:2px;letter-spacing:.1em;}

/* ══════════════════════════════
   ROCK PAPER SCISSORS
══════════════════════════════ */
#page-rps .inner{max-width:640px;}
.rps-score-panel{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:20px 24px;margin-bottom:16px;}
.rps-score-grid{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:12px;}
.rps-score-col{text-align:center;}
.rps-tag{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.2em;margin-bottom:4px;}
.rps-tag.p{color:rgba(0,245,255,.6);}
.rps-tag.c{color:rgba(255,0,110,.6);}
.rps-num{font-family:'Bebas Neue',sans-serif;font-size:3rem;line-height:1;}
.rps-num.p{color:var(--accent2);text-shadow:0 0 16px var(--accent2);}
.rps-num.c{color:var(--accent3);text-shadow:0 0 16px var(--accent3);}
.rps-center{text-align:center;}
.rps-round-lbl{font-family:'DM Mono',monospace;font-size:.52rem;letter-spacing:.2em;color:var(--muted);}
.rps-round{font-family:'Bebas Neue',sans-serif;font-size:2rem;color:#ffbe0b;text-shadow:0 0 12px #ffbe0b;line-height:1;}
.rps-streak{font-family:'DM Mono',monospace;font-size:.6rem;color:#ffbe0b;margin-top:4px;}
.rps-draw-row{border-top:1px solid var(--border);margin-top:12px;padding-top:10px;text-align:center;font-family:'DM Mono',monospace;font-size:.58rem;color:rgba(255,190,11,.45);}
.rps-arena{background:var(--surface);border:1px solid rgba(255,0,110,.15);border-radius:10px;padding:24px 20px;margin-bottom:16px;position:relative;}
.rps-arena-lbl{text-align:center;font-family:'DM Mono',monospace;font-size:.52rem;letter-spacing:.35em;color:rgba(255,0,110,.35);margin-bottom:16px;text-transform:uppercase;}
.rps-arena-row{display:flex;align-items:center;justify-content:space-between;gap:8px;}
.rps-slot{text-align:center;flex:1;}
.rps-slot-lbl{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.2em;margin-bottom:10px;}
.rps-slot-lbl.p{color:rgba(0,245,255,.5);}
.rps-slot-lbl.c{color:rgba(255,0,110,.5);}
.rps-circle{width:110px;height:110px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.4rem;border:2px solid;margin:0 auto;transition:all .3s;}
.rps-circle.p{border-color:var(--accent2);box-shadow:0 0 16px rgba(0,245,255,.3);}
.rps-circle.c{border-color:var(--accent3);box-shadow:0 0 16px rgba(255,0,110,.3);}
.rps-circle.winner{animation:rpsWin .7s ease-in-out 3;}
@keyframes rpsWin{0%,100%{transform:scale(1)}50%{transform:scale(1.15);filter:brightness(1.5)}}
.rps-vs{text-align:center;flex-shrink:0;display:flex;flex-direction:column;align-items:center;gap:10px;}
.rps-vs-text{font-family:'Bebas Neue',sans-serif;font-size:2rem;color:#ffbe0b;text-shadow:0 0 16px #ffbe0b;}
.rps-badge{font-family:'Bebas Neue',sans-serif;font-size:.9rem;letter-spacing:.1em;padding:6px 10px;border-radius:3px;border:2px solid transparent;opacity:0;transform:scale(.6);transition:all .3s cubic-bezier(.34,1.56,.64,1);min-width:90px;text-align:center;}
.rps-badge.show{opacity:1;transform:scale(1);}
.rps-badge.win{color:#06d6a0;border-color:#06d6a0;background:rgba(6,214,160,.08);box-shadow:0 0 12px rgba(6,214,160,.3);}
.rps-badge.lose{color:var(--accent3);border-color:var(--accent3);background:rgba(255,0,110,.08);box-shadow:0 0 12px rgba(255,0,110,.3);}
.rps-badge.draw{color:#ffbe0b;border-color:#ffbe0b;background:rgba(255,190,11,.08);box-shadow:0 0 12px rgba(255,190,11,.3);}
.rps-buttons{display:flex;justify-content:center;gap:14px;margin-bottom:16px;flex-wrap:wrap;}
.rps-choice-btn{background:var(--surface);border:2px solid rgba(0,245,255,.28);border-radius:10px;padding:14px 10px;cursor:pointer;transition:all .2s;display:flex;flex-direction:column;align-items:center;gap:6px;width:110px;}
.rps-choice-btn:hover{border-color:var(--accent2);box-shadow:0 0 20px rgba(0,245,255,.4);transform:translateY(-4px);}
.rps-choice-btn .rps-btn-emoji{font-size:2.1rem;transition:transform .2s;}
.rps-choice-btn:hover .rps-btn-emoji{transform:scale(1.2) rotate(-6deg);}
.rps-choice-btn .rps-btn-lbl{font-family:'Orbitron',monospace;font-size:.5rem;font-weight:700;letter-spacing:.15em;color:rgba(0,245,255,.7);text-transform:uppercase;}
.rps-choice-btn.active-pick{border-color:#ffbe0b;box-shadow:0 0 16px rgba(255,190,11,.4);}
.rps-reset-btn{font-family:'Orbitron',monospace;font-size:.65rem;font-weight:700;letter-spacing:.18em;padding:9px 24px;background:transparent;color:var(--accent3);border:2px solid var(--accent3);border-radius:4px;cursor:pointer;transition:all .2s;text-transform:uppercase;}
.rps-reset-btn:hover{background:var(--accent3);color:#000;box-shadow:0 0 18px rgba(255,0,110,.4);}
.rps-hist-box{background:var(--surface);border:1px solid var(--border);border-radius:8px;max-height:180px;overflow-y:auto;}
.rps-hist-box::-webkit-scrollbar{width:3px;}
.rps-hist-box::-webkit-scrollbar-thumb{background:var(--accent2);border-radius:2px;}
.rps-h-item{display:flex;justify-content:space-between;align-items:center;padding:8px 14px;border-bottom:1px solid rgba(255,255,255,.04);font-family:'DM Mono',monospace;font-size:.65rem;}
.rps-h-item.win-r{border-left:3px solid #06d6a0;}
.rps-h-item.lose-r{border-left:3px solid var(--accent3);}
.rps-h-item.draw-r{border-left:3px solid #ffbe0b;}
.rps-h-rn{color:var(--muted);min-width:30px;}
.rps-h-moves{color:rgba(255,255,255,.6);flex:1;text-align:center;}
.rps-h-res.win-r{color:#06d6a0;}
.rps-h-res.lose-r{color:var(--accent3);}
.rps-h-res.draw-r{color:#ffbe0b;}
.rps-no-data{padding:16px;text-align:center;font-family:'DM Mono',monospace;font-size:.62rem;color:var(--muted);letter-spacing:.18em;}
@keyframes rpsShake{0%,100%{transform:translateX(0)}20%{transform:translateX(-8px) rotate(-2deg)}40%{transform:translateX(8px) rotate(2deg)}60%{transform:translateX(-5px)}80%{transform:translateX(5px)}}
.rps-shake{animation:rpsShake .4s ease;}

/* ══════════════════════════════
   SEAT PICKER
══════════════════════════════ */
#page-seat .inner{max-width:1100px;}
.seat-layout{display:grid;grid-template-columns:1fr 300px;gap:20px;}
.seat-config-bar{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:16px 20px;background:var(--surface);border:1px solid var(--border);border-radius:10px;margin-bottom:16px;}
.seat-cfg-lbl{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;}
.seat-cfg-iw{display:flex;align-items:center;gap:8px;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:7px 12px;}
.seat-cfg-iw label{font-family:'DM Mono',monospace;font-size:.6rem;color:var(--muted);}
.seat-cfg-iw input[type=number]{background:none;border:none;outline:none;color:var(--text);font-family:'Space Mono',monospace;font-size:.9rem;font-weight:700;width:46px;text-align:center;}
.seat-range{-webkit-appearance:none;appearance:none;width:80px;height:4px;background:var(--border);border-radius:2px;outline:none;}
.seat-range::-webkit-slider-thumb{-webkit-appearance:none;width:14px;height:14px;background:#00f5c4;border-radius:50%;cursor:pointer;}
.seat-build-btn{margin-left:auto;background:#00f5c4;color:#000;border:none;border-radius:6px;padding:9px 18px;font-family:'Syne',sans-serif;font-size:.8rem;font-weight:700;cursor:pointer;transition:all .2s;}
.seat-build-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,245,196,.3);}
.seat-area-box{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:20px;overflow:auto;}
.seat-area-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.seat-area-title{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;}
.seat-legend{display:flex;gap:14px;}
.seat-legend-item{display:flex;align-items:center;gap:5px;font-family:'DM Mono',monospace;font-size:.58rem;color:var(--muted);}
.seat-legend-dot{width:10px;height:10px;border-radius:2px;}
.seat-tbl-wrap{overflow:auto;}
.seat-table{border-collapse:separate;border-spacing:4px;min-width:max-content;}
.seat-table th{font-family:'Space Mono',monospace;font-size:.6rem;color:var(--muted);padding:0 3px 6px;text-align:center;font-weight:400;}
.seat-row-hdr{font-family:'Space Mono',monospace;font-size:.65rem;color:var(--muted);padding-right:8px;text-align:right;white-space:nowrap;}
.seat-cell{width:42px;height:36px;background:#1a1a2e;border:1px solid #1e1e35;border-radius:5px;cursor:pointer;transition:all .15s;text-align:center;vertical-align:middle;}
.seat-cell-inner{display:flex;align-items:center;justify-content:center;height:100%;pointer-events:none;}
.seat-cell-id{font-family:'Space Mono',monospace;font-size:.58rem;color:var(--muted);transition:color .15s;}
.seat-cell:hover{background:#252540;border-color:#00f5c4;transform:scale(1.1);z-index:10;box-shadow:0 4px 14px rgba(0,245,196,.15);}
.seat-cell:hover .seat-cell-id{color:#00f5c4;}
.seat-cell.selected{background:rgba(0,245,196,.1);border-color:#00f5c4;box-shadow:0 0 0 1px #00f5c4,0 4px 16px rgba(0,245,196,.18);}
.seat-cell.selected .seat-cell-id{color:#00f5c4;}
@keyframes seatPulse{0%{transform:scale(1);box-shadow:0 0 0 0 rgba(0,245,196,.8)}40%{transform:scale(1.2);box-shadow:0 0 0 10px rgba(0,245,196,0)}70%{transform:scale(1.05)}100%{transform:scale(1)}}
.seat-cell.just-picked{animation:seatPulse .6s ease forwards;}
.seat-pick-card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:20px;margin-bottom:14px;}
.seat-pick-title{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;margin-bottom:14px;}
.seat-pick-display{background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:18px;text-align:center;min-height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:14px;position:relative;overflow:hidden;}
.seat-pick-id{font-family:'Space Mono',monospace;font-size:2.8rem;font-weight:700;color:#00f5c4;line-height:1;transition:all .3s;}
.seat-pick-id.flash{animation:seatFlash .4s ease;}
@keyframes seatFlash{0%{opacity:0;transform:scale(.6) translateY(8px)}60%{transform:scale(1.08)}100%{opacity:1;transform:scale(1)}}
.seat-pick-sub{font-family:'Space Mono',monospace;font-size:.65rem;color:var(--muted);margin-top:4px;}
.seat-pick-empty{font-family:'DM Mono',monospace;font-size:.75rem;color:var(--muted);}
.seat-pick-btn{width:100%;background:linear-gradient(135deg,#00f5c4,#00c4a0);color:#000;border:none;border-radius:8px;padding:13px;font-family:'Syne',sans-serif;font-size:.9rem;font-weight:800;cursor:pointer;transition:all .2s;}
.seat-pick-btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(0,245,196,.3);}
.seat-pick-btn:disabled{background:var(--border);color:var(--muted);cursor:not-allowed;transform:none;box-shadow:none;}
.seat-action-row{display:flex;gap:8px;margin-top:10px;}
.seat-sec-btn{flex:1;background:none;border:1px solid var(--border);color:var(--muted);border-radius:6px;padding:8px;font-family:'Syne',sans-serif;font-size:.7rem;font-weight:600;cursor:pointer;transition:all .2s;}
.seat-sec-btn:hover{border-color:var(--accent3);color:var(--accent3);}
.seat-hist-card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:20px;}
.seat-hist-title{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;margin-bottom:12px;}
.seat-hist-list{display:flex;flex-direction:column;gap:5px;max-height:280px;overflow-y:auto;}
.seat-hist-list::-webkit-scrollbar{width:3px;}
.seat-hist-list::-webkit-scrollbar-thumb{background:var(--border);}
.seat-h-item{display:flex;align-items:center;gap:8px;padding:7px 10px;background:var(--bg);border:1px solid var(--border);border-radius:6px;font-family:'DM Mono',monospace;font-size:.62rem;}
.seat-h-num{color:var(--muted);min-width:22px;}
.seat-h-seat{font-family:'Space Mono',monospace;font-size:.8rem;font-weight:700;color:#00f5c4;min-width:44px;}
.seat-h-mode{font-family:'DM Mono',monospace;font-size:.52rem;padding:2px 6px;border-radius:3px;font-weight:600;text-transform:uppercase;}
.seat-h-mode.random{background:rgba(0,245,196,.1);color:#00f5c4;border:1px solid rgba(0,245,196,.2);}
.seat-h-mode.manual{background:rgba(124,58,237,.1);color:#a78bfa;border:1px solid rgba(124,58,237,.2);}
.seat-h-time{color:var(--muted);font-size:.55rem;margin-left:auto;}
.seat-hist-empty{color:var(--muted);font-size:.72rem;text-align:center;padding:20px 0;font-family:'DM Mono',monospace;}
.seat-clear-btn{width:100%;background:none;border:1px solid var(--border);color:var(--muted);border-radius:6px;padding:8px;font-family:'Syne',sans-serif;font-size:.7rem;font-weight:600;cursor:pointer;transition:all .2s;margin-top:10px;}
.seat-clear-btn:hover{border-color:var(--accent3);color:var(--accent3);}
.seat-stat-hdr{display:flex;gap:20px;margin-bottom:4px;}
.seat-stat-item{font-family:'DM Mono',monospace;font-size:.6rem;color:var(--muted);}
.seat-stat-item b{color:var(--text);}
.seat-empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;height:200px;gap:10px;}
.seat-empty-icon{font-size:3rem;opacity:.2;}
.seat-empty-txt{font-family:'DM Mono',monospace;font-size:.72rem;color:var(--muted);}

/* ══════════════════════════════
   PASSWORD GENERATOR
══════════════════════════════ */
#page-pwd .inner{max-width:520px;margin:0 auto;}
.pwd-output-box{position:relative;background:#05060e;border:1px solid rgba(163,230,53,.25);border-radius:8px;padding:22px 56px 22px 20px;margin-bottom:20px;overflow:hidden;min-height:78px;display:flex;align-items:center;}
.pwd-output-box::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 30% 50%,rgba(163,230,53,.04),transparent 70%);}
#pwd-output{font-family:'Space Mono',monospace;font-size:1.05rem;font-weight:700;color:#a3e635;letter-spacing:.08em;word-break:break-all;line-height:1.6;position:relative;z-index:1;flex:1;min-height:28px;}
#pwd-output.empty{color:rgba(163,230,53,.2);font-style:italic;font-size:.75rem;letter-spacing:.2em;}
.pwd-copy-icon{position:absolute;right:14px;top:50%;transform:translateY(-50%);width:34px;height:34px;border-radius:6px;border:1px solid rgba(163,230,53,.3);background:rgba(163,230,53,.06);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;z-index:2;}
.pwd-copy-icon:hover{background:rgba(163,230,53,.15);border-color:#a3e635;box-shadow:0 0 12px rgba(163,230,53,.25);}
.pwd-copy-icon svg{width:16px;height:16px;stroke:#a3e635;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
.pwd-copy-icon.copied{background:rgba(163,230,53,.2);border-color:#a3e635;}
.pwd-strength-wrap{margin-bottom:20px;}
.pwd-strength-lbl-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;}
.pwd-strength-lbl{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.22em;color:var(--muted);text-transform:uppercase;}
.pwd-strength-tag{font-family:'DM Mono',monospace;font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;transition:color .3s;}
.pwd-strength-bar-track{height:5px;background:rgba(255,255,255,.06);border-radius:3px;overflow:hidden;}
.pwd-strength-bar-fill{height:100%;border-radius:3px;transition:width .4s cubic-bezier(.34,1.56,.64,1),background .3s;}
.pwd-len-wrap{margin-bottom:22px;}
.pwd-len-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
.pwd-len-lbl{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.22em;color:var(--muted);text-transform:uppercase;}
.pwd-len-val{font-family:'Orbitron',sans-serif;font-size:1.4rem;font-weight:900;color:#a3e635;text-shadow:0 0 16px rgba(163,230,53,.4);line-height:1;}
.pwd-len-slider{-webkit-appearance:none;appearance:none;width:100%;height:5px;border-radius:3px;background:rgba(255,255,255,.08);outline:none;cursor:pointer;transition:background .2s;}
.pwd-len-slider::-webkit-slider-thumb{-webkit-appearance:none;width:18px;height:18px;border-radius:50%;background:#a3e635;box-shadow:0 0 10px rgba(163,230,53,.5);cursor:pointer;border:2px solid #07080f;transition:transform .15s,box-shadow .15s;}
.pwd-len-slider::-webkit-slider-thumb:hover{transform:scale(1.2);box-shadow:0 0 18px rgba(163,230,53,.7);}
.pwd-len-ticks{display:flex;justify-content:space-between;margin-top:5px;font-family:'DM Mono',monospace;font-size:.5rem;color:var(--muted);}
.pwd-options-wrap{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px 20px;margin-bottom:22px;}
.pwd-options-title{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);text-transform:uppercase;margin-bottom:14px;}
.pwd-option-row{display:flex;align-items:center;gap:14px;padding:10px 12px;border-radius:6px;cursor:pointer;transition:background .15s;user-select:none;margin-bottom:2px;}
.pwd-option-row:last-child{margin-bottom:0;}
.pwd-option-row:hover{background:rgba(255,255,255,.03);}
.pwd-option-row.disabled-row{opacity:.4;cursor:not-allowed;}
.pwd-cb{width:20px;height:20px;border-radius:4px;border:1.5px solid rgba(163,230,53,.4);background:rgba(163,230,53,.04);flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all .2s;position:relative;}
.pwd-cb.checked{background:rgba(163,230,53,.15);border-color:#a3e635;box-shadow:0 0 8px rgba(163,230,53,.3);}
.pwd-cb.checked::after{content:'';position:absolute;width:5px;height:9px;border:2px solid #a3e635;border-left:none;border-top:none;transform:rotate(45deg) translate(-1px,-1px);}
.pwd-option-label{flex:1;}
.pwd-option-name{font-family:'Space Mono',monospace;font-size:.78rem;font-weight:700;color:var(--text);display:block;line-height:1.2;}
.pwd-option-chars{font-family:'DM Mono',monospace;font-size:.6rem;color:var(--muted);display:block;margin-top:1px;letter-spacing:.05em;}
.pwd-option-badge{font-family:'DM Mono',monospace;font-size:.5rem;padding:2px 7px;border-radius:3px;text-transform:uppercase;letter-spacing:.1em;flex-shrink:0;}
.pwd-btn-row{display:flex;gap:12px;}
.pwd-gen-btn{flex:1;font-family:'Orbitron',sans-serif;font-size:.82rem;font-weight:900;letter-spacing:.18em;padding:15px 20px;border-radius:6px;border:none;background:linear-gradient(135deg,#5a8a00,#a3e635,#d4ff52,#a3e635,#5a8a00);background-size:200% auto;color:#07080f;cursor:pointer;transition:all .25s;box-shadow:0 4px 24px rgba(163,230,53,.35);text-transform:uppercase;}
.pwd-gen-btn:hover{background-position:right center;box-shadow:0 8px 32px rgba(163,230,53,.55);transform:translateY(-2px);}
.pwd-gen-btn:active{transform:translateY(0);}
.pwd-copy-btn{font-family:'Orbitron',sans-serif;font-size:.7rem;font-weight:700;letter-spacing:.1em;padding:15px 22px;border-radius:6px;border:1.5px solid rgba(163,230,53,.4);background:rgba(163,230,53,.06);color:#a3e635;cursor:pointer;transition:all .2s;white-space:nowrap;}
.pwd-copy-btn:hover{border-color:#a3e635;background:rgba(163,230,53,.14);box-shadow:0 0 20px rgba(163,230,53,.25);}
.pwd-copy-btn.copied-btn{background:rgba(163,230,53,.2);border-color:#a3e635;color:#d4ff52;}
.pwd-hist-wrap{margin-top:22px;}
.pwd-hist-label{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.22em;color:var(--muted);text-transform:uppercase;margin-bottom:10px;}
.pwd-hist-list{display:flex;flex-direction:column;gap:6px;max-height:200px;overflow-y:auto;}
.pwd-hist-list::-webkit-scrollbar{width:3px;}
.pwd-hist-list::-webkit-scrollbar-thumb{background:rgba(163,230,53,.2);}
.pwd-hist-item{display:flex;align-items:center;gap:10px;padding:8px 12px;background:var(--surface);border:1px solid var(--border);border-radius:6px;cursor:pointer;transition:border-color .2s;}
.pwd-hist-item:hover{border-color:rgba(163,230,53,.3);}
.pwd-hist-pw{font-family:'Space Mono',monospace;font-size:.72rem;color:rgba(163,230,53,.7);flex:1;word-break:break-all;letter-spacing:.04em;}
.pwd-hist-len{font-family:'DM Mono',monospace;font-size:.55rem;color:var(--muted);flex-shrink:0;}

/* ══════════════════════════════
   QR CODE GENERATOR
══════════════════════════════ */
#page-qr .inner{max-width:620px;margin:0 auto;}

/* Input area */
.qr-input-wrap{margin-bottom:20px;}
.qr-input-label{display:block;font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.22em;color:var(--muted);text-transform:uppercase;margin-bottom:8px;}
.qr-textarea{width:100%;background:#06060e;border:1px solid rgba(167,139,250,.25);color:#c4b5fd;font-family:'Space Mono',monospace;font-size:.92rem;padding:14px 16px;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;resize:vertical;min-height:80px;line-height:1.6;letter-spacing:.02em;}
.qr-textarea:focus{border-color:#a78bfa;box-shadow:0 0 16px rgba(167,139,250,.18);}
.qr-textarea::placeholder{color:rgba(167,139,250,.25);font-style:italic;}
.qr-char-count{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.12em;color:var(--muted);text-align:right;margin-top:4px;}
.qr-char-count.warn{color:#ff9f43;}
.qr-char-count.over{color:#ff2d78;}

/* Options panel */
.qr-options{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px 20px;margin-bottom:20px;}
.qr-options-title{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);text-transform:uppercase;margin-bottom:16px;}
.qr-options-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.qr-opt-group{display:flex;flex-direction:column;gap:6px;}
.qr-opt-lbl{font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.18em;color:var(--muted);text-transform:uppercase;}
.qr-select{width:100%;background:#06060e;border:1px solid rgba(167,139,250,.2);color:#c4b5fd;font-family:'DM Mono',monospace;font-size:.7rem;padding:8px 10px;border-radius:6px;outline:none;cursor:pointer;appearance:none;-webkit-appearance:none;transition:border-color .2s;}
.qr-select:focus,.qr-select:hover{border-color:rgba(167,139,250,.5);}
.qr-color-row{display:flex;align-items:center;gap:10px;}
.qr-color-inp{width:38px;height:32px;border:1px solid rgba(167,139,250,.3);border-radius:5px;cursor:pointer;background:none;padding:2px;outline:none;}
.qr-color-inp::-webkit-color-swatch{border:none;border-radius:3px;}
.qr-color-hex{font-family:'DM Mono',monospace;font-size:.65rem;color:#c4b5fd;letter-spacing:.1em;flex:1;}

/* QR display */
.qr-display-wrap{display:flex;justify-content:center;margin-bottom:20px;}
.qr-frame{position:relative;padding:20px;background:#fff;border-radius:16px;box-shadow:0 0 0 1px rgba(167,139,250,.15),0 20px 60px rgba(0,0,0,.6),0 0 40px rgba(167,139,250,.1);display:inline-block;transition:transform .3s,box-shadow .3s;}
.qr-frame:hover{transform:translateY(-4px) scale(1.02);box-shadow:0 0 0 2px rgba(167,139,250,.3),0 28px 70px rgba(0,0,0,.7),0 0 50px rgba(167,139,250,.2);}
.qr-frame.dark-bg{background:#0a0a12;}
#qr-canvas-container{display:flex;align-items:center;justify-content:center;}
#qr-canvas-container canvas,#qr-canvas-container img{display:block;}

/* Placeholder state */
.qr-placeholder{width:200px;height:200px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;border:2px dashed rgba(167,139,250,.2);border-radius:8px;}
.qr-ph-icon{font-size:3rem;opacity:.25;}
.qr-ph-text{font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.15em;color:rgba(167,139,250,.3);}

/* Action buttons */
.qr-actions{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;}
.qr-gen-btn{flex:1;min-width:160px;font-family:'Bebas Neue',sans-serif;font-size:1.1rem;letter-spacing:.18em;padding:14px 24px;border:none;border-radius:8px;background:linear-gradient(135deg,#5b2e8a,#a78bfa,#c4b5fd,#a78bfa,#5b2e8a);background-size:200% auto;color:#0a0614;cursor:pointer;transition:all .25s;box-shadow:0 4px 20px rgba(167,139,250,.35);}
.qr-gen-btn:hover{background-position:right center;box-shadow:0 8px 30px rgba(167,139,250,.55);transform:translateY(-2px);}
.qr-dl-btn{font-family:'DM Mono',monospace;font-size:.62rem;font-weight:700;letter-spacing:.12em;padding:14px 20px;border-radius:8px;border:1.5px solid rgba(167,139,250,.35);background:rgba(167,139,250,.05);color:#a78bfa;cursor:pointer;transition:all .2s;white-space:nowrap;text-transform:uppercase;}
.qr-dl-btn:hover{border-color:#a78bfa;background:rgba(167,139,250,.12);box-shadow:0 0 18px rgba(167,139,250,.2);}
.qr-dl-btn:disabled{opacity:.35;cursor:not-allowed;}
.qr-copy-img-btn{font-family:'DM Mono',monospace;font-size:.62rem;font-weight:700;letter-spacing:.12em;padding:14px 20px;border-radius:8px;border:1.5px solid rgba(255,255,255,.1);background:rgba(255,255,255,.03);color:var(--muted);cursor:pointer;transition:all .2s;white-space:nowrap;text-transform:uppercase;}
.qr-copy-img-btn:hover:not(:disabled){border-color:rgba(255,255,255,.2);color:var(--text);}
.qr-copy-img-btn:disabled{opacity:.35;cursor:not-allowed;}

/* Stats */
.qr-stats{display:flex;gap:16px;padding:14px 18px;background:var(--surface);border:1px solid var(--border);border-radius:10px;margin-bottom:20px;flex-wrap:wrap;align-items:center;}
.qr-stat-item{display:flex;flex-direction:column;gap:2px;align-items:center;}
.qr-stat-val{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;line-height:1;color:#a78bfa;}
.qr-stat-lbl{font-family:'DM Mono',monospace;font-size:.5rem;letter-spacing:.15em;color:var(--muted);text-transform:uppercase;}
.qr-stat-div{width:1px;height:32px;background:var(--border);}
.qr-stat-input-preview{font-family:'Space Mono',monospace;font-size:.65rem;color:rgba(167,139,250,.5);flex:1;text-align:right;word-break:break-all;max-height:36px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}

/* History */
.qr-hist-wrap{margin-top:4px;}
.qr-hist-title{font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.22em;color:var(--muted);text-transform:uppercase;margin-bottom:10px;}
.qr-hist-list{display:flex;flex-direction:column;gap:7px;max-height:260px;overflow-y:auto;}
.qr-hist-list::-webkit-scrollbar{width:3px;}
.qr-hist-list::-webkit-scrollbar-thumb{background:rgba(167,139,250,.25);}
.qr-hist-item{display:flex;align-items:center;gap:12px;padding:10px 14px;background:var(--surface);border:1px solid var(--border);border-radius:8px;cursor:pointer;transition:border-color .2s;border-left:3px solid rgba(167,139,250,.25);}
.qr-hist-item:hover{border-color:rgba(167,139,250,.4);border-left-color:#a78bfa;}
.qr-hist-thumb{width:44px;height:44px;border-radius:6px;background:#fff;flex-shrink:0;overflow:hidden;display:flex;align-items:center;justify-content:center;}
.qr-hist-thumb img{width:100%;height:100%;object-fit:contain;}
.qr-hist-info{flex:1;min-width:0;}
.qr-hist-text{font-family:'Space Mono',monospace;font-size:.72rem;color:rgba(196,181,253,.7);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px;}
.qr-hist-meta{font-family:'DM Mono',monospace;font-size:.52rem;color:var(--muted);display:flex;gap:8px;}
.qr-hist-dl{flex-shrink:0;font-family:'DM Mono',monospace;font-size:.58rem;color:rgba(167,139,250,.5);border:1px solid rgba(167,139,250,.2);padding:3px 10px;border-radius:5px;transition:all .2s;}
.qr-hist-item:hover .qr-hist-dl{color:#a78bfa;border-color:#a78bfa;}

/* Responsive */
@media(max-width:600px){
  .qr-options-grid{grid-template-columns:1fr 1fr;}
  .qr-actions{flex-direction:column;}
}

/* TOAST */
.toast-bar{position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--surface);border:1px solid var(--border);padding:10px 22px;border-radius:4px;font-family:'DM Mono',monospace;font-size:.65rem;letter-spacing:.15em;color:var(--text);opacity:0;transition:all .3s;z-index:9999;pointer-events:none;}
.toast-bar.show{opacity:1;transform:translateX(-50%) translateY(0);}

/* RESPONSIVE */
@media(max-width:900px){
  :root{--sidebar-w:64px;}
  .logo-title,.logo-sub,.nav-item span:not(.nav-icon){display:none;}
  .nav-item{padding:14px;justify-content:center;}
  .sidebar-footer,.nav-section,.nav-badge{display:none;}
  .home-hero,.page-content{padding:24px 20px;}
  .features-grid{padding:24px 20px;grid-template-columns:1fr 1fr;}
  #page-coin .inner,.seat-layout{grid-template-columns:1fr;}
  .quote-card{padding:28px 24px 24px;}
}
@media(max-width:600px){
  .features-grid{grid-template-columns:1fr;}
  .feature-list-about{grid-template-columns:1fr;}
  .pwd-btn-row{flex-direction:column;}
  .quote-actions{flex-direction:column;}
}
</style>
</head>
<body>

<div class="particle-container" id="particles"></div>
<div class="toast-bar" id="toast"></div>

<!-- SIDEBAR -->
<nav class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-title">R48</div>
    <div class="logo-sub">// Game Suite</div>
  </div>
  <div class="sidebar-nav">
    <div class="nav-section">Menu</div>
    <div class="nav-item active" data-page="home">
      <span class="nav-icon">🏠</span><span>Beranda</span>
    </div>
    <div class="nav-section">Tools</div>
    <div class="nav-item" data-page="card">
      <span class="nav-icon">🃏</span><span>Royal Card Draw</span>
    </div>
    <div class="nav-item" data-page="coin">
      <span class="nav-icon">🪙</span><span>Coin Flip</span>
    </div>
    <div class="nav-item" data-page="pigment">
      <span class="nav-icon">🎨</span><span>Pigment Studio</span>
    </div>
    <div class="nav-item" data-page="dice">
      <span class="nav-icon">🎲</span><span>Dadu</span>
    </div>
    <div class="nav-item" data-page="rng">
      <span class="nav-icon">🔢</span><span>Random Number</span>
    </div>
    <div class="nav-item" data-page="rps">
      <span class="nav-icon">⚔️</span><span>Battle Clash</span>
    </div>
    <div class="nav-item" data-page="seat">
      <span class="nav-icon">💺</span><span>Seat Picker</span>
    </div>
    <div class="nav-item" data-page="pwd">
      <span class="nav-icon">🔐</span><span>Password Gen</span>
      <span class="nav-badge">NEW</span>
    </div>
    <div class="nav-item" data-page="quote">
      <span class="nav-icon">💬</span><span>Quote Generator</span>
      <span class="nav-badge" style="background:rgba(255,159,67,.1);color:#ff9f43;border-color:rgba(255,159,67,.3);">NEW</span>
    </div>
    <div class="nav-item" data-page="qr">
      <span class="nav-icon">📱</span><span>QR Code Gen</span>
      <span class="nav-badge" style="background:rgba(167,139,250,.1);color:#a78bfa;border-color:rgba(167,139,250,.3);">NEW</span>
    </div>
    <div class="nav-section">Info</div>
    <div class="nav-item" data-page="about">
      <span class="nav-icon">ℹ️</span><span>Tentang</span>
    </div>
  </div>
  <div class="sidebar-footer">
    <div class="footer-text">Rebornian48<br/>Game Suite v1.3</div>
  </div>
</nav>

<!-- MAIN CONTENT -->
<main class="main">

  <!-- ══ HOME ══ -->
  <section class="page active" id="page-home">
    <div class="home-hero">
      <div class="hero-eyebrow">// Rebornian48 — Game Suite</div>
      <div class="hero-title">Semua<br/>Tools<br/>Randommu</div>
      <p class="hero-desc">Koleksi lengkap 10 tools randomizer dan mini-game interaktif dalam satu platform yang elegan. Pilih fitur dari sidebar atau klik kartu di bawah.</p>
    </div>
    <div class="features-grid">
      <div class="feature-card fc-gold" data-page="card">
        <span class="card-emoji">🃏</span>
        <div class="card-title">Royal Card Draw</div>
        <div class="card-desc">Tarik 1 hingga 4 kartu dari deck standar 52 kartu dengan animasi reveal yang mewah.</div>
        <span class="card-tag" style="background:rgba(201,168,76,.1);color:var(--accent);border:1px solid rgba(201,168,76,.2);">CARDS</span>
      </div>
      <div class="feature-card fc-cyan" data-page="coin">
        <span class="card-emoji">🪙</span>
        <div class="card-title">Coin Flip</div>
        <div class="card-desc">Lempar koin dengan animasi 3D realistis. Lacak statistik, streak, dan riwayat pelemparan.</div>
        <span class="card-tag" style="background:rgba(0,245,255,.1);color:var(--accent2);border:1px solid rgba(0,245,255,.2);">FLIP</span>
      </div>
      <div class="feature-card fc-pink" data-page="pigment">
        <span class="card-emoji">🎨</span>
        <div class="card-title">Pigment Studio</div>
        <div class="card-desc">Generator warna acak dengan nilai HEX, RGB, HSL, dan CMYK yang dapat disalin seketika.</div>
        <span class="card-tag" style="background:rgba(255,45,120,.1);color:var(--accent3);border:1px solid rgba(255,45,120,.2);">COLOR</span>
      </div>
      <div class="feature-card fc-gold" data-page="dice">
        <span class="card-emoji">🎲</span>
        <div class="card-title">Pelemparan Dadu</div>
        <div class="card-desc">Lempar hingga 4 dadu sekaligus dengan animasi rolling dan tampilan meja kasino.</div>
        <span class="card-tag" style="background:rgba(201,168,76,.1);color:var(--accent);border:1px solid rgba(201,168,76,.2);">DICE</span>
      </div>
      <div class="feature-card fc-cyan" data-page="rng">
        <span class="card-emoji">🔢</span>
        <div class="card-title">Random Number</div>
        <div class="card-desc">Generator angka acak dengan tampilan neon retro-futuristik dan riwayat angka terakhir.</div>
        <span class="card-tag" style="background:rgba(0,245,255,.1);color:var(--accent2);border:1px solid rgba(0,245,255,.2);">RNG</span>
      </div>
      <div class="feature-card fc-pink" data-page="rps">
        <span class="card-emoji">⚔️</span>
        <div class="card-title">Battle Clash</div>
        <div class="card-desc">Batu Gunting Kertas bergaya arcade dengan papan skor, streak, dan battle log lengkap.</div>
        <span class="card-tag" style="background:rgba(255,45,120,.1);color:var(--accent3);border:1px solid rgba(255,45,120,.2);">RPS</span>
      </div>
      <div class="feature-card fc-teal" data-page="seat">
        <span class="card-emoji">💺</span>
        <div class="card-title">Seat Picker Pro</div>
        <div class="card-desc">Pilih kursi secara acak dari grid yang dapat dikonfigurasi. Cocok untuk event, kelas, atau pertandingan.</div>
        <span class="card-tag" style="background:rgba(0,245,196,.1);color:#00f5c4;border:1px solid rgba(0,245,196,.2);">SEAT</span>
      </div>
      <div class="feature-card fc-lime" data-page="pwd">
        <span class="card-emoji">🔐</span>
        <div class="card-title">Password Generator</div>
        <div class="card-desc">Generate password acak 4–100 karakter. Pilih huruf besar, kecil, angka, dan simbol. Copy in one click.</div>
        <span class="card-tag" style="background:rgba(163,230,53,.1);color:#a3e635;border:1px solid rgba(163,230,53,.2);">PASSWORD</span>
      </div>
      <div class="feature-card fc-orange" data-page="quote">
        <span class="card-emoji">💬</span>
        <div class="card-title">Quote Generator</div>
        <div class="card-desc">Temukan kata-kata inspiratif bahasa Indonesia dari 980+ quotes. Filter per kategori, salin, dan bagikan.</div>
        <span class="card-tag" style="background:rgba(255,159,67,.1);color:#ff9f43;border:1px solid rgba(255,159,67,.2);">QUOTE</span>
      </div>
      <div class="feature-card fc-violet" data-page="qr">
        <span class="card-emoji">📱</span>
        <div class="card-title">QR Code Generator</div>
        <div class="card-desc">Buat QR code dari teks atau URL apapun. Atur ukuran, koreksi error, warna custom, lalu unduh sebagai PNG.</div>
        <span class="card-tag" style="background:rgba(167,139,250,.1);color:#a78bfa;border:1px solid rgba(167,139,250,.2);">QR CODE</span>
      </div>
    </div>
  </section>

  <!-- ══ CARD DRAW ══ -->
  <section class="page" id="page-card">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Randomizer</div>
        <div class="page-title">Royal Card Draw</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner" style="max-width:660px;">
        <p style="font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);margin-bottom:10px;">PILIH JUMLAH KARTU</p>
        <div class="count-btns">
          <button class="count-btn-c active" data-count="1">1</button>
          <button class="count-btn-c" data-count="2">2</button>
          <button class="count-btn-c" data-count="3">3</button>
          <button class="count-btn-c" data-count="4">4</button>
        </div>
        <div class="gold-divider"><div class="gold-divider-diamond"></div></div>
        <div class="cards-container" id="cards-container">
          <p class="empty-state-c">✦ &nbsp; Tarik Kartumu &nbsp; ✦</p>
        </div>
        <div class="gold-divider"><div class="gold-divider-diamond"></div></div>
        <div style="text-align:center;margin:16px 0;">
          <button class="draw-btn-c" id="draw-btn">Draw Cards</button>
        </div>
        <div class="card-stats">
          <div class="cstat"><span id="card-stat-draws">0</span>Draws</div>
          <div class="cstat"><span id="card-stat-last">—</span>Last Hand</div>
          <div class="cstat"><span id="card-stat-fav">—</span>Fav Suit</div>
        </div>
        <div style="margin-top:12px;">
          <p style="font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.25em;color:var(--muted);text-align:center;margin-bottom:8px;">RIWAYAT</p>
          <div class="card-history" id="card-history">
            <span style="font-size:.7rem;color:var(--muted);font-family:'DM Mono',monospace;">Belum ada</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ COIN FLIP ══ -->
  <section class="page" id="page-coin">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Probability</div>
        <div class="page-title">FLIP — Coin Simulator</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div>
          <div class="coin-scene">
            <div class="coin-3d show-heads" id="coin3d">
              <div class="coin-face coin-face-heads"><div class="coin-inner-ring"><div style="text-align:center"><div class="coin-symbol">H</div><div class="coin-symbol-sub">Heads</div></div></div></div>
              <div class="coin-face coin-face-tails"><div class="coin-inner-ring" style="border-color:rgba(0,0,0,.2)"><div style="text-align:center"><div class="coin-symbol">T</div><div class="coin-symbol-sub">Tails</div></div></div></div>
            </div>
          </div>
          <div class="coin-result">
            <div class="coin-result-label">— result —</div>
            <div class="coin-result-val idle" id="coin-result-val">FLIP IT</div>
            <div class="coin-streak" id="coin-streak"></div>
          </div>
          <div style="text-align:center;margin-bottom:14px;">
            <button class="flip-btn-c" id="flip-btn">
              <div class="flip-btn-inner-c"><span>⟳</span><span>FLIP THE COIN</span></div>
            </button>
          </div>
          <div style="text-align:center;font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.18em;color:var(--muted);">
            Press <kbd style="border:1px solid var(--border);padding:2px 7px;border-radius:3px;font-size:.65rem;color:var(--text);">SPACE</kbd> to flip
          </div>
        </div>
        <div class="coin-panel">
          <div class="coin-panel-sec">
            <div class="cpanel-label">// Statistics</div>
            <div class="coin-stats-grid">
              <div class="csgrid-item csgrid-gold"><div class="csitem-name">Heads</div><div class="csitem-val gold" id="c-heads">0</div><div class="csitem-sub" id="c-heads-pct">— %</div></div>
              <div class="csgrid-item csgrid-silver"><div class="csitem-name">Tails</div><div class="csitem-val silver" id="c-tails">0</div><div class="csitem-sub" id="c-tails-pct">— %</div></div>
              <div class="csgrid-item csgrid-total"><div class="csitem-name">Total</div><div class="csitem-val white" id="c-total">0</div><div class="csitem-sub">all time</div></div>
              <div class="csgrid-item csgrid-purple"><div class="csitem-name">Streak</div><div class="csitem-val purple" id="c-streak">0</div><div class="csitem-sub" id="c-streak-type">—</div></div>
            </div>
            <div class="progress-track-c"><div class="progress-fill-c" id="c-progress"></div></div>
            <div class="progress-labels-c"><span id="c-h-lbl">H — 50%</span><span id="c-t-lbl">T — 50%</span></div>
          </div>
          <div class="coin-panel-sec">
            <div class="cpanel-label">// Recent Flips</div>
            <div class="coin-history-feed" id="coin-hist-feed">
              <div style="color:var(--muted);font-size:.62rem;letter-spacing:.15em;text-align:center;padding:14px 0;">No flips yet…</div>
            </div>
          </div>
          <div class="coin-panel-sec">
            <button class="reset-btn-c" id="coin-reset-btn">↺ Reset All</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ PIGMENT ══ -->
  <section class="page" id="page-pigment">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Color</div>
        <div class="page-title">Pigment Studio</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div class="pigment-counter-row">
          <div><div class="pigment-label-small">Studio</div><div style="font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:300;color:rgba(28,25,23,.1);" id="pigment-title-big">Pigment</div></div>
          <div style="text-align:right;"><div class="pigment-label-small">No.</div><div class="pigment-num-big" id="pig-counter">001</div></div>
        </div>
        <div class="swatch-box" id="pig-swatch" style="background:#e8e0d5;">
          <div class="shimmer-p" id="pig-shimmer"></div>
          <span class="swatch-name-p" id="pig-name">Warm Linen</span>
        </div>
        <div class="pigment-vals">
          <div class="pval-row" id="prow-hex" data-key="hex"><span class="pval-key">Hex</span><span class="pval-data" id="pval-hex">—</span></div>
          <div class="pval-row" id="prow-rgb" data-key="rgb"><span class="pval-key">RGB</span><span class="pval-data" id="pval-rgb">—</span></div>
          <div class="pval-row" id="prow-hsl" data-key="hsl"><span class="pval-key">HSL</span><span class="pval-data" id="pval-hsl">—</span></div>
          <div class="pval-row" id="prow-cmyk" data-key="cmyk"><span class="pval-key">CMYK</span><span class="pval-data" id="pval-cmyk">—</span></div>
        </div>
        <button class="gen-btn-p" id="pig-gen-btn"><div class="fill"></div><span>Generate Color</span></button>
        <div style="display:flex;align-items:center;gap:8px;margin-top:14px;">
          <span class="pigment-label-small" style="margin-right:6px;">History</span>
          <div class="pigment-hist" id="pig-history"></div>
        </div>
        <p style="text-align:center;font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:rgba(100,90,80,.4);margin-top:12px;">Press <kbd style="border:1px solid rgba(28,25,23,.12);border-radius:3px;padding:1px 6px;">Space</kbd> to generate</p>
      </div>
    </div>
  </section>

  <!-- ══ DICE ══ -->
  <section class="page" id="page-dice">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Randomizer</div>
        <div class="page-title">🎲 DADU</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div style="background:#1a4a2e;border:2px solid var(--accent);border-radius:20px;padding:28px;position:relative;box-shadow:0 0 0 6px #0a1f14,0 0 0 8px rgba(201,168,76,.2),0 20px 60px rgba(0,0,0,.7);">
          <p style="text-align:center;font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.25em;color:rgba(232,201,110,.7);text-transform:uppercase;margin-bottom:12px;">JUMLAH DADU</p>
          <div class="dice-selector" id="dice-selector">
            <button class="dsel-btn active" data-count="1">1</button>
            <button class="dsel-btn" data-count="2">2</button>
            <button class="dsel-btn" data-count="3">3</button>
            <button class="dsel-btn" data-count="4">4</button>
          </div>
          <div class="dice-area" id="dice-area"></div>
          <button class="roll-btn-d" id="roll-btn">🎲 Lempar Dadu</button>
          <div class="dice-result-panel" id="dice-result">
            <div class="dice-total-lbl">TOTAL</div>
            <div class="dice-total-val" id="dice-total"></div>
            <div class="dice-detail-val" id="dice-detail"></div>
          </div>
        </div>
        <div style="margin-top:20px;">
          <p style="font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);text-align:center;margin-bottom:10px;">RIWAYAT</p>
          <div class="dice-hist" id="dice-hist"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ RNG ══ -->
  <section class="page" id="page-rng">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Generator</div>
        <div class="page-title">Random.exe</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div style="font-family:'Orbitron',sans-serif;font-size:.75rem;font-weight:900;letter-spacing:.18em;color:var(--accent2);text-align:center;margin-bottom:4px;text-shadow:0 0 18px var(--accent2);">RANDOM.EXE</div>
        <div style="text-align:center;font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.25em;color:var(--muted);margin-bottom:20px;">// Generator Angka Acak</div>
        <div class="rng-display">
          <span id="rng-number">0</span>
          <div class="rng-lbl">// output value</div>
        </div>
        <div class="rng-input-wrap">
          <label class="rng-input-label">▸ Batas Maksimum</label>
          <input type="number" class="rng-input" id="rng-max" value="100" min="1"/>
        </div>
        <div class="rng-btn-row">
          <button class="rng-btn rng-minus" id="rng-dec">− Kurang</button>
          <button class="rng-btn rng-plus" id="rng-inc">+ Tambah</button>
        </div>
        <button class="rng-main-btn" id="rng-main-btn">🎲 &nbsp;ACAK SEKARANG</button>
        <div class="rng-hist-label">// riwayat terakhir</div>
        <div class="rng-hist-pills" id="rng-hist"></div>
      </div>
    </div>
  </section>

  <!-- ══ BATTLE CLASH ══ -->
  <section class="page" id="page-rps">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Game · Arcade</div>
        <div class="page-title">Battle Clash</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div class="rps-score-panel">
          <div class="rps-score-grid">
            <div class="rps-score-col"><div class="rps-tag p">YOU</div><div class="rps-num p" id="rps-sp">00</div><div style="font-family:'DM Mono',monospace;font-size:.5rem;letter-spacing:.15em;color:var(--muted);">PLAYER</div></div>
            <div class="rps-center"><div class="rps-round-lbl">ROUND</div><div class="rps-round" id="rps-round">01</div><div class="rps-streak" id="rps-streak">STREAK: 0</div></div>
            <div class="rps-score-col"><div class="rps-tag c">CPU</div><div class="rps-num c" id="rps-sc">00</div><div style="font-family:'DM Mono',monospace;font-size:.5rem;letter-spacing:.15em;color:var(--muted);">CPU</div></div>
          </div>
          <div class="rps-draw-row">DRAWS: <span id="rps-sd">0</span> &nbsp;|&nbsp; TOTAL: <span id="rps-total">0</span> GAMES</div>
        </div>
        <div class="rps-arena">
          <div class="rps-arena-lbl">— BATTLE ARENA —</div>
          <div class="rps-arena-row">
            <div class="rps-slot"><div class="rps-slot-lbl p">PLAYER</div><div class="rps-circle p" id="rps-cp"><span id="rps-ep">❓</span></div></div>
            <div class="rps-vs"><div class="rps-vs-text">VS</div><div class="rps-badge" id="rps-badge">—</div></div>
            <div class="rps-slot"><div class="rps-slot-lbl c">COMPUTER</div><div class="rps-circle c" id="rps-cc"><span id="rps-ec">🤖</span></div></div>
          </div>
        </div>
        <div style="text-align:center;font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.25em;color:var(--muted);margin-bottom:12px;">— CHOOSE YOUR WEAPON —</div>
        <div class="rps-buttons">
          <button class="rps-choice-btn" data-choice="rock"><span class="rps-btn-emoji">🪨</span><span class="rps-btn-lbl">ROCK</span></button>
          <button class="rps-choice-btn" data-choice="paper"><span class="rps-btn-emoji">📄</span><span class="rps-btn-lbl">PAPER</span></button>
          <button class="rps-choice-btn" data-choice="scissors"><span class="rps-btn-emoji">✂️</span><span class="rps-btn-lbl">SCISSORS</span></button>
        </div>
        <div style="text-align:center;margin-bottom:12px;">
          <button class="rps-reset-btn" id="rps-reset">⟳ RESET GAME</button>
        </div>
        <div style="font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.18em;color:var(--muted);text-align:center;margin-bottom:10px;">[R] ROCK · [P] PAPER · [S] SCISSORS</div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;padding:0 2px;">
          <span style="font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.15em;color:var(--muted);">⬛ BATTLE LOG</span>
          <span style="font-family:'DM Mono',monospace;font-size:.58rem;color:var(--accent2);" id="rps-log-count">0 RECORDS</span>
        </div>
        <div class="rps-hist-box" id="rps-hist-log">
          <div class="rps-no-data">NO BATTLES YET — MAKE YOUR MOVE</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ SEAT PICKER ══ -->
  <section class="page" id="page-seat">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Event</div>
        <div class="page-title">SeatPick Pro</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div style="display:flex;gap:20px;margin-bottom:12px;flex-wrap:wrap;">
          <div style="font-family:'Space Mono',monospace;font-size:.7rem;color:var(--muted);">Total: <b id="seat-stat-total" style="color:var(--text);">—</b></div>
          <div style="font-family:'Space Mono',monospace;font-size:.7rem;color:var(--muted);">Available: <b id="seat-stat-avail" style="color:var(--text);">—</b></div>
          <div style="font-family:'Space Mono',monospace;font-size:.7rem;color:var(--muted);">Picked: <b id="seat-stat-picked" style="color:#00f5c4;">0</b></div>
        </div>
        <div class="seat-config-bar">
          <span class="seat-cfg-lbl">Konfigurasi Grid</span>
          <div class="seat-cfg-iw"><label>BARIS</label><input type="number" id="seat-rows" value="6" min="1" max="26"></div>
          <input type="range" class="seat-range" id="seat-rows-range" min="1" max="26" value="6">
          <div class="seat-cfg-iw"><label>KOLOM</label><input type="number" id="seat-cols" value="10" min="1" max="50"></div>
          <input type="range" class="seat-range" id="seat-cols-range" min="1" max="50" value="10">
          <button class="seat-build-btn" id="seat-build-btn">▶ BUILD GRID</button>
        </div>
        <div class="seat-layout">
          <div>
            <div class="seat-area-box">
              <div class="seat-area-hdr">
                <span class="seat-area-title">Peta Kursi</span>
                <div class="seat-legend">
                  <div class="seat-legend-item"><div class="seat-legend-dot" style="background:#1a1a2e;border:1px solid #1e1e35;"></div>Tersedia</div>
                  <div class="seat-legend-item"><div class="seat-legend-dot" style="background:rgba(0,245,196,.12);border:1px solid #00f5c4;"></div>Dipilih</div>
                </div>
              </div>
              <div class="seat-tbl-wrap">
                <div class="seat-empty-state" id="seat-empty">
                  <div class="seat-empty-icon">💺</div>
                  <div class="seat-empty-txt">Belum ada grid — klik BUILD GRID</div>
                </div>
                <table class="seat-table" id="seat-table" style="display:none;"></table>
              </div>
            </div>
          </div>
          <div>
            <div class="seat-pick-card">
              <div class="seat-pick-title">// Random Picker</div>
              <div class="seat-pick-display">
                <div id="seat-pick-result"><div class="seat-pick-empty">Belum ada kursi dipilih</div></div>
              </div>
              <button class="seat-pick-btn" id="seat-pick-btn" disabled>🎲 Pick Random Seat</button>
              <div class="seat-action-row">
                <button class="seat-sec-btn" id="seat-clear-sel">Clear Selection</button>
                <button class="seat-sec-btn" id="seat-reset-all">Reset All</button>
              </div>
            </div>
            <div class="seat-hist-card">
              <div class="seat-pick-title">// Pick History <span id="seat-hist-count" style="color:#00f5c4;font-size:.55rem;">0</span></div>
              <div class="seat-hist-list" id="seat-hist-list">
                <div class="seat-hist-empty">Belum ada pilihan</div>
              </div>
              <button class="seat-clear-btn" id="seat-clear-hist">✕ Clear History</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ PASSWORD GENERATOR ══ -->
  <section class="page" id="page-pwd">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Security</div>
        <div class="page-title">Password Generator</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">
        <div class="pwd-output-box">
          <span id="pwd-output" class="empty">— klik Generate —</span>
          <div class="pwd-copy-icon" id="pwd-copy-icon" title="Copy to clipboard">
            <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          </div>
        </div>
        <div class="pwd-strength-wrap">
          <div class="pwd-strength-lbl-row">
            <span class="pwd-strength-lbl">// Kekuatan Password</span>
            <span class="pwd-strength-tag" id="pwd-strength-tag" style="color:var(--muted);">—</span>
          </div>
          <div class="pwd-strength-bar-track">
            <div class="pwd-strength-bar-fill" id="pwd-strength-bar" style="width:0%;background:#555;"></div>
          </div>
        </div>
        <div class="pwd-len-wrap">
          <div class="pwd-len-header">
            <span class="pwd-len-lbl">// Panjang Password</span>
            <span class="pwd-len-val" id="pwd-len-display">16</span>
          </div>
          <input type="range" class="pwd-len-slider" id="pwd-len-slider" min="4" max="100" value="16">
          <div class="pwd-len-ticks">
            <span>4</span><span>25</span><span>50</span><span>75</span><span>100</span>
          </div>
        </div>
        <div class="pwd-options-wrap">
          <div class="pwd-options-title">// Karakter yang Digunakan</div>
          <div class="pwd-option-row" id="opt-num" data-key="numbers">
            <div class="pwd-cb checked" id="cb-numbers"></div>
            <div class="pwd-option-label">
              <span class="pwd-option-name">Number [ 0 - 9 ]</span>
              <span class="pwd-option-chars">0 1 2 3 4 5 6 7 8 9</span>
            </div>
            <span class="pwd-option-badge" style="background:rgba(0,245,255,.08);color:var(--accent2);border:1px solid rgba(0,245,255,.2);">10 chars</span>
          </div>
          <div class="pwd-option-row" id="opt-lower" data-key="lower">
            <div class="pwd-cb checked" id="cb-lower"></div>
            <div class="pwd-option-label">
              <span class="pwd-option-name">Lower Case [ a - z ]</span>
              <span class="pwd-option-chars">a b c d e f … x y z</span>
            </div>
            <span class="pwd-option-badge" style="background:rgba(163,230,53,.08);color:#a3e635;border:1px solid rgba(163,230,53,.2);">26 chars</span>
          </div>
          <div class="pwd-option-row" id="opt-upper" data-key="upper">
            <div class="pwd-cb checked" id="cb-upper"></div>
            <div class="pwd-option-label">
              <span class="pwd-option-name">Upper Case [ A - Z ]</span>
              <span class="pwd-option-chars">A B C D E F … X Y Z</span>
            </div>
            <span class="pwd-option-badge" style="background:rgba(255,190,11,.08);color:#ffbe0b;border:1px solid rgba(255,190,11,.2);">26 chars</span>
          </div>
          <div class="pwd-option-row" id="opt-special" data-key="special">
            <div class="pwd-cb checked" id="cb-special"></div>
            <div class="pwd-option-label">
              <span class="pwd-option-name">Special Characters [ ~!@#$%^&amp;*()… ]</span>
              <span class="pwd-option-chars">! @ # $ % ^ &amp; * ( ) _ + - = [ ] { } | ; : , . ?</span>
            </div>
            <span class="pwd-option-badge" style="background:rgba(255,45,120,.08);color:var(--accent3);border:1px solid rgba(255,45,120,.2);">32 chars</span>
          </div>
        </div>
        <div class="pwd-btn-row">
          <button class="pwd-gen-btn" id="pwd-gen-btn">⚡ Generate</button>
          <button class="pwd-copy-btn" id="pwd-copy-btn">📋 Copy</button>
        </div>
        <div class="pwd-hist-wrap">
          <div class="pwd-hist-label">// Riwayat (klik untuk copy)</div>
          <div class="pwd-hist-list" id="pwd-hist-list">
            <div style="font-family:'DM Mono',monospace;font-size:.65rem;color:var(--muted);text-align:center;padding:14px 0;letter-spacing:.15em;">Belum ada riwayat…</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ QUOTE GENERATOR ══ -->
  <section class="page" id="page-quote">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Inspirasi</div>
        <div class="page-title">Quote Generator</div>
      </div>
      <a href="https://quotes.liupurnomo.com/" target="_blank" style="margin-left:auto;font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.15em;color:var(--muted);border:1px solid var(--border);padding:6px 14px;border-radius:6px;text-decoration:none;transition:all .2s;white-space:nowrap;" onmouseover="this.style.borderColor='#ff9f43';this.style.color='#ff9f43'" onmouseout="this.style.borderColor='';this.style.color=''">↗ Buka di Tab Baru</a>
    </div>
    <div style="height:calc(100vh - 97px);padding:0;">
      <iframe
        src="https://quotes.liupurnomo.com/"
        style="width:100%;height:100%;border:none;display:block;"
        title="Quote Generator — quotes.liupurnomo.com"
        loading="lazy"
        allow="clipboard-write"
      ></iframe>
    </div>
  </section>

  <!-- ══ QR CODE GENERATOR ══ -->
  <section class="page" id="page-qr">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Tools · Utility</div>
        <div class="page-title">QR Code Generator</div>
      </div>
    </div>
    <div class="page-content">
      <div class="inner">

        <!-- Stats -->
        <div class="qr-stats">
          <div class="qr-stat-item">
            <div class="qr-stat-val" id="qr-stat-gen">0</div>
            <div class="qr-stat-lbl">Generated</div>
          </div>
          <div class="qr-stat-div"></div>
          <div class="qr-stat-item">
            <div class="qr-stat-val" id="qr-stat-dl">0</div>
            <div class="qr-stat-lbl">Diunduh</div>
          </div>
          <div class="qr-stat-div"></div>
          <div class="qr-stat-item">
            <div class="qr-stat-val" id="qr-stat-size">—</div>
            <div class="qr-stat-lbl">Ukuran (px)</div>
          </div>
          <div class="qr-stat-input-preview" id="qr-stat-preview">Belum ada input…</div>
        </div>

        <!-- Input -->
        <div class="qr-input-wrap">
          <label class="qr-input-label">// Teks / URL</label>
          <textarea class="qr-textarea" id="qr-input" placeholder="Masukkan URL, teks, nomor telepon, email…" maxlength="2000"></textarea>
          <div class="qr-char-count" id="qr-char-count">0 / 2000 karakter</div>
        </div>

        <!-- Options -->
        <div class="qr-options">
          <div class="qr-options-title">// Pengaturan QR Code</div>
          <div class="qr-options-grid">
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Ukuran</div>
              <select class="qr-select" id="qr-size">
                <option value="128">128 × 128</option>
                <option value="200" selected>200 × 200</option>
                <option value="256">256 × 256</option>
                <option value="300">300 × 300</option>
                <option value="400">400 × 400</option>
                <option value="512">512 × 512</option>
              </select>
            </div>
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Error Correction</div>
              <select class="qr-select" id="qr-ecl">
                <option value="L">L — Low (7%)</option>
                <option value="M" selected>M — Medium (15%)</option>
                <option value="Q">Q — Quartile (25%)</option>
                <option value="H">H — High (30%)</option>
              </select>
            </div>
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Render Type</div>
              <select class="qr-select" id="qr-type">
                <option value="canvas" selected>Canvas (PNG)</option>
                <option value="img">SVG / IMG</option>
              </select>
            </div>
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Warna QR</div>
              <div class="qr-color-row">
                <input type="color" class="qr-color-inp" id="qr-fg-color" value="#000000" title="Warna Foreground">
                <span class="qr-color-hex" id="qr-fg-hex">#000000</span>
              </div>
            </div>
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Warna Background</div>
              <div class="qr-color-row">
                <input type="color" class="qr-color-inp" id="qr-bg-color" value="#ffffff" title="Warna Background">
                <span class="qr-color-hex" id="qr-bg-hex">#ffffff</span>
              </div>
            </div>
            <div class="qr-opt-group">
              <div class="qr-opt-lbl">Download Format</div>
              <select class="qr-select" id="qr-dl-fmt">
                <option value="png">PNG</option>
                <option value="jpg">JPG</option>
              </select>
            </div>
          </div>
        </div>

        <!-- QR Display -->
        <div class="qr-display-wrap">
          <div class="qr-frame" id="qr-frame">
            <div id="qr-canvas-container">
              <div class="qr-placeholder" id="qr-placeholder">
                <div class="qr-ph-icon">📱</div>
                <div class="qr-ph-text">QR akan muncul di sini</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="qr-actions">
          <button class="qr-gen-btn" id="qr-gen-btn">⬡ Generate QR Code</button>
          <button class="qr-dl-btn" id="qr-dl-btn" disabled>⬇ Download</button>
          <button class="qr-copy-img-btn" id="qr-copy-img-btn" disabled>📋 Salin Gambar</button>
        </div>

        <p style="font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.18em;color:var(--muted);text-align:center;margin-bottom:24px;">
          Press <kbd style="border:1px solid var(--border);padding:2px 7px;border-radius:3px;font-size:.65rem;color:var(--text);">Enter</kbd> untuk generate saat di kolom input
        </p>

        <!-- History -->
        <div class="qr-hist-wrap">
          <div class="qr-hist-title">// Riwayat QR Code (klik untuk load kembali)</div>
          <div class="qr-hist-list" id="qr-hist-list">
            <div style="font-family:'DM Mono',monospace;font-size:.65rem;color:var(--muted);text-align:center;padding:16px 0;letter-spacing:.15em;">Belum ada QR yang digenerate…</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══ ABOUT ══ -->
  <section class="page" id="page-about">
    <div class="page-header">
      <div class="page-back" data-page="home">←</div>
      <div class="page-title-wrap">
        <div class="page-eyebrow">// Info</div>
        <div class="page-title">Tentang</div>
      </div>
    </div>
    <div class="page-content">
      <div class="about-wrap" style="padding:0;">
        <div class="about-badge">✦ GAME SUITE v1.3</div>
        <div class="about-title">Koleksi Tools<br/>oleh <span>Rebornian48</span></div>
        <div class="about-body">
          Platform ini menggabungkan 10 tools randomizer dan mini-game interaktif dalam satu antarmuka yang unified dan elegan. Setiap fitur dirancang untuk memberikan pengalaman yang menyenangkan dengan animasi dan desain premium.
        </div>
        <div class="about-credit">
          <div class="credit-ai">✦</div>
          <div class="credit-text">
            <div class="credit-main">Dibuat dengan menggunakan Claude AI</div>
            <div class="credit-sub">oleh Rebornian48 · 2025</div>
          </div>
        </div>
        <div class="about-divider"></div>
        <div style="font-family:'DM Mono',monospace;font-size:.6rem;letter-spacing:.2em;color:var(--muted);margin-bottom:18px;text-transform:uppercase;">// Changelog</div>

        <!-- v1.3 -->
        <div style="margin-bottom:22px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.1rem;letter-spacing:.12em;color:#a78bfa;">v1.3</div>
            <div style="font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.15em;padding:2px 8px;border:1px solid rgba(167,139,250,.3);border-radius:10px;color:#a78bfa;">LATEST</div>
            <div style="flex:1;height:1px;background:linear-gradient(to right,rgba(167,139,250,.3),transparent);"></div>
          </div>
          <div style="display:flex;flex-direction:column;gap:7px;padding-left:12px;border-left:2px solid rgba(167,139,250,.25);">
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#a78bfa;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">📱 <b style="color:var(--text);">QR Code Generator</b> — generate QR dari teks atau URL bebas menggunakan library QRCodeJS</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#a78bfa;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">Pengaturan ukuran (128–512px), Error Correction Level (L/M/Q/H), render type Canvas/SVG, warna foreground & background custom</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#a78bfa;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">Download PNG/JPG, salin gambar ke clipboard, riwayat 8 QR terakhir dengan thumbnail yang bisa di-load ulang</span>
            </div>
          </div>
        </div>

        <!-- v1.2 -->
        <div style="margin-bottom:22px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.1rem;letter-spacing:.12em;color:#ff9f43;">v1.2</div>
            <div style="flex:1;height:1px;background:linear-gradient(to right,rgba(255,159,67,.3),transparent);"></div>
          </div>
          <div style="display:flex;flex-direction:column;gap:7px;padding-left:12px;border-left:2px solid rgba(255,159,67,.25);">
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#ff9f43;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">💬 <b style="color:var(--text);">Quote Generator</b> — embed quotes.liupurnomo.com via iframe (980+ quotes inspiratif bahasa Indonesia)</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#ff9f43;margin-top:1px;flex-shrink:0;">FIX</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">Pendekatan custom API fetch + CORS proxy diganti dengan iframe langsung agar lebih stabil dan tanpa error</span>
            </div>
          </div>
        </div>

        <!-- v1.1 -->
        <div style="margin-bottom:22px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.1rem;letter-spacing:.12em;color:#a3e635;">v1.1</div>
            <div style="flex:1;height:1px;background:linear-gradient(to right,rgba(163,230,53,.3),transparent);"></div>
          </div>
          <div style="display:flex;flex-direction:column;gap:7px;padding-left:12px;border-left:2px solid rgba(163,230,53,.25);">
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#a3e635;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🔐 <b style="color:var(--text);">Password Generator</b> — panjang 4–100 karakter, pilih kombinasi angka, huruf kecil/besar, dan simbol</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:#a3e635;margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">Indikator kekuatan password real-time (Very Weak → Very Strong), copy satu klik, riwayat 6 password terakhir</span>
            </div>
          </div>
        </div>

        <!-- v1.0 -->
        <div style="margin-bottom:22px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.1rem;letter-spacing:.12em;color:var(--accent);">v1.0</div>
            <div style="font-family:'DM Mono',monospace;font-size:.55rem;letter-spacing:.15em;padding:2px 8px;border:1px solid rgba(201,168,76,.3);border-radius:10px;color:var(--accent);">INITIAL</div>
            <div style="flex:1;height:1px;background:linear-gradient(to right,rgba(201,168,76,.3),transparent);"></div>
          </div>
          <div style="display:flex;flex-direction:column;gap:7px;padding-left:12px;border-left:2px solid rgba(201,168,76,.25);">
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🃏 <b style="color:var(--text);">Royal Card Draw</b> — tarik 1–4 kartu dari deck 52, animasi reveal flip, statistik suit favorit</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🪙 <b style="color:var(--text);">Coin Flip</b> — animasi koin 3D, statistik heads/tails, streak tracker, shortcut SPACE</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🎨 <b style="color:var(--text);">Pigment Studio</b> — warna acak dengan nilai HEX, RGB, HSL, CMYK, klik untuk salin, riwayat 10 warna</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🎲 <b style="color:var(--text);">Dadu</b> — lempar 1–4 dadu sekaligus, animasi rolling, total otomatis, riwayat lemparan</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">🔢 <b style="color:var(--text);">Random Number</b> — tampilan neon retro-futuristik, batas maksimum custom, riwayat 8 angka terakhir</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">⚔️ <b style="color:var(--text);">Battle Clash</b> — Batu Gunting Kertas vs CPU, papan skor, streak, battle log 20 ronde, shortcut R/P/S</span>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;">
              <span style="font-family:'DM Mono',monospace;font-size:.55rem;color:var(--accent);margin-top:1px;flex-shrink:0;">NEW</span>
              <span style="font-family:'DM Mono',monospace;font-size:.68rem;color:var(--muted);line-height:1.5;">💺 <b style="color:var(--text);">Seat Picker Pro</b> — grid kursi konfigurasi bebas (maks 26 baris × 50 kolom), random pick, riwayat pilihan manual & acak</span>
            </div>
          </div>
        </div>

        <div class="about-divider"></div>
        <div style="font-family:'DM Mono',monospace;font-size:.58rem;letter-spacing:.15em;color:var(--muted);line-height:2;">
          Powered by Anthropic Claude AI<br/>
          Interface: HTML + CSS + JavaScript<br/>
          Library: jQuery · Tailwind CSS · QRCodeJS<br/>
          Fonts: Google Fonts<br/>
          Quotes: quotes.liupurnomo.com
        </div>
      </div>
    </div>
  </section>

</main>

<script>
$(function(){

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// NAVIGATION
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
function showPage(pageId){
  $('.page').removeClass('active');
  $('.nav-item').removeClass('active');
  $('#page-'+pageId).addClass('active');
  $(`.nav-item[data-page="${pageId}"]`).addClass('active');
  window.scrollTo(0,0);
  if(pageId==='pigment' && pigCount===0) pigGenerate();
  if(pageId==='seat' && !seatBuilt) seatBuildGrid();
  if(pageId==='qr' && !qrInitialized) qrInit();
}

$(document).on('click','.nav-item',function(){ showPage($(this).data('page')); });
$(document).on('click','.feature-card,.fla-item',function(){ showPage($(this).data('page')); });
$(document).on('click','.page-back',function(){ showPage($(this).data('page')); });

// Toast
function showToast(msg){
  const $t=$('#toast');
  $t.text(msg).addClass('show');
  setTimeout(()=>$t.removeClass('show'),2500);
}


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// CARD DRAW
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let cardCount=1,cardDraws=0,cardSuitHist={'♥':0,'♦':0,'♣':0,'♠':0},cardHistLog=[];
const SUITS=[{s:'♥',c:'text-red'},{s:'♦',c:'text-red'},{s:'♣',c:'text-black-card'},{s:'♠',c:'text-black-card'}];
const RANKS=['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
const FNAMES={J:'Jack',Q:'Queen',K:'King',A:'Ace'};
function buildDeck(){let d=[];SUITS.forEach(s=>RANKS.forEach(r=>d.push({rank:r,suit:s.s,color:s.c})));return d;}
function shuffleArr(a){let b=[...a];for(let i=b.length-1;i>0;i--){const j=Math.floor(Math.random()*(i+1));[b[i],b[j]]=[b[j],b[i]];}return b;}
function cardLabel(r){return FNAMES[r]||r;}
function buildCardHTML(card,idx){
  const delay=idx*120;
  return `<div class="playing-card" style="transition-delay:${delay}ms">
    <div class="card-corner tl ${card.color}"><span class="card-rank">${card.rank}</span><span class="card-suit-small">${card.suit}</span></div>
    <div class="card-center ${card.color}"><div class="card-suit-large">${card.suit}</div><div class="card-rank-large">${cardLabel(card.rank)}</div></div>
    <div class="card-corner br ${card.color}"><span class="card-rank">${card.rank}</span><span class="card-suit-small">${card.suit}</span></div>
  </div>`;}
$('.count-btn-c').on('click',function(){$('.count-btn-c').removeClass('active');$(this).addClass('active');cardCount=parseInt($(this).data('count'));});
$('#draw-btn').on('click',function(){
  const $btn=$(this);$btn.prop('disabled',true).text('...');
  setTimeout(()=>{
    const deck=shuffleArr(buildDeck());const cards=deck.slice(0,cardCount);
    const html=cards.map((c,i)=>buildCardHTML(c,i)).join('');
    $('#cards-container').html(html);
    setTimeout(()=>{
      cards.forEach((_,i)=>{setTimeout(()=>$($('.playing-card')[i]).addClass('revealed'),i*130+50);});
      cardDraws++;cards.forEach(c=>{cardSuitHist[c.suit]++;});
      const fav=Object.entries(cardSuitHist).sort((a,b)=>b[1]-a[1])[0][0];
      const last=cards.map(c=>c.rank+c.suit).join(' ');
      $('#card-stat-draws').text(cardDraws);$('#card-stat-last').text(last);$('#card-stat-fav').text(fav);
      cardHistLog.unshift(last);if(cardHistLog.length>12)cardHistLog.pop();
      const histHTML=cardHistLog.map((h,i)=>{const isR=h.includes('♥')||h.includes('♦');return `<span class="ch-item${isR?' text-red':''}">${h}</span>`;}).join('');
      $('#card-history').html(histHTML);
      $btn.prop('disabled',false).text('Draw Again');
    },400);
  },300);
});


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// COIN FLIP
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let cHeads=0,cTails=0,cTotal=0,cStreak=0,cLastResult=null,cFlipping=false,cHistory=[];
function doFlip(){
  if(cFlipping)return;cFlipping=true;$('#flip-btn').prop('disabled',true);
  $('#coin-result-val').removeClass('heads tails').addClass('idle').text('...');$('#coin-streak').text('');
  const $coin=$('#coin3d');
  $coin.removeClass('flipping show-heads show-tails');
  const result=Math.random()<.5?'heads':'tails';
  void $coin[0].offsetWidth;$coin.addClass('flipping');
  setTimeout(()=>{
    cTotal++;cHistory.unshift({result,num:cTotal});if(cHistory.length>20)cHistory.pop();
    if(result==='heads'){cHeads++;cStreak=(cLastResult==='heads')?cStreak+1:1;}
    else{cTails++;cStreak=(cLastResult==='tails')?cStreak+1:1;}
    cLastResult=result;
    $coin.removeClass('flipping').addClass(result==='heads'?'show-heads':'show-tails');
    const label=result==='heads'?'HEADS':'TAILS';
    $('#coin-result-val').removeClass('idle').addClass(result).text(label);
    if(cStreak>=2)$('#coin-streak').text(cStreak+'× '+result.toUpperCase()+' IN A ROW');
    const hP=cTotal>0?Math.round((cHeads/cTotal)*100):50;const tP=100-hP;
    $('#c-heads').text(cHeads);$('#c-tails').text(cTails);$('#c-total').text(cTotal);
    $('#c-heads-pct').text(hP+'%');$('#c-tails-pct').text(tP+'%');
    $('#c-streak').text(cStreak);$('#c-streak-type').text(cStreak>1?result:'—');
    $('#c-progress').css('width',hP+'%');$('#c-h-lbl').text('H — '+hP+'%');$('#c-t-lbl').text('T — '+tP+'%');
    let hHtml='';
    cHistory.forEach(item=>{hHtml+=`<div class="chi-item"><div class="chi-badge ${item.result}">${item.result==='heads'?'H':'T'}</div><div class="chi-result ${item.result}" style="flex:1">${item.result}</div><div class="chi-num">#${item.num}</div></div>`;});
    $('#coin-hist-feed').html(hHtml||'<div style="color:var(--muted);font-size:.62rem;text-align:center;padding:12px;">No flips yet…</div>');
    if(cStreak===5)showToast('5× Streak! 🔥');if(cStreak===10)showToast('10× Mega Streak! ⚡');
    coinParticles(result);
    cFlipping=false;$('#flip-btn').prop('disabled',false);
  },2200);
}
$('#flip-btn').on('click',()=>doFlip());
$('#coin-reset-btn').on('click',function(){
  cHeads=cTails=cTotal=cStreak=0;cLastResult=null;cHistory=[];
  $('#c-heads,#c-tails,#c-total,#c-streak').text('0');$('#c-heads-pct,#c-tails-pct').text('— %');$('#c-streak-type').text('—');
  $('#c-progress').css('width','50%');$('#c-h-lbl').text('H — 50%');$('#c-t-lbl').text('T — 50%');
  $('#coin-result-val').removeClass('heads tails').addClass('idle').text('FLIP IT');$('#coin-streak').text('');
  $('#coin-hist-feed').html('<div style="color:var(--muted);font-size:.62rem;text-align:center;padding:14px;">No flips yet…</div>');
  $('#coin3d').removeClass('flipping show-tails').addClass('show-heads');showToast('Reset!');
});
function coinParticles(result){
  const color=result==='heads'?'#F5C842':'#C0C7D4';
  const coin=document.querySelector('.coin-scene');if(!coin)return;
  const rect=coin.getBoundingClientRect();const cx=rect.left+rect.width/2;const cy=rect.top+rect.height/2;
  for(let i=0;i<16;i++){
    const p=document.createElement('div');p.className='particle';
    const sz=Math.random()*7+3,ang=Math.random()*360,dist=Math.random()*80+30;
    const dx=Math.cos(ang*Math.PI/180)*dist,dy=Math.sin(ang*Math.PI/180)*dist-40;
    p.style.cssText=`width:${sz}px;height:${sz}px;left:${cx+dx-sz/2}px;top:${cy+dy}px;background:${color};box-shadow:0 0 ${sz}px ${color};animation-delay:${Math.random()*.3}s;animation-duration:${Math.random()*.6+.8}s;`;
    document.getElementById('particles').appendChild(p);
    setTimeout(()=>p.remove(),1500);
  }
}


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// PIGMENT
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let pigCount=0,pigCurrentVals={},pigHistColors=[];
function hexToRgb(hex){return{r:parseInt(hex.slice(1,3),16),g:parseInt(hex.slice(3,5),16),b:parseInt(hex.slice(5,7),16)};}
function rgbToHsl(r,g,b){r/=255;g/=255;b/=255;const max=Math.max(r,g,b),min=Math.min(r,g,b);let h,s,l=(max+min)/2;if(max===min){h=s=0;}else{const d=max-min;s=l>.5?d/(2-max-min):d/(max+min);switch(max){case r:h=((g-b)/d+(g<b?6:0))/6;break;case g:h=((b-r)/d+2)/6;break;case b:h=((r-g)/d+4)/6;break;}}return{h:Math.round(h*360),s:Math.round(s*100),l:Math.round(l*100)};}
function rgbToCmyk(r,g,b){let c=1-r/255,m=1-g/255,y=1-b/255,k=Math.min(c,m,y);if(k===1)return{c:0,m:0,y:0,k:100};return{c:Math.round(((c-k)/(1-k))*100),m:Math.round(((m-k)/(1-k))*100),y:Math.round(((y-k)/(1-k))*100),k:Math.round(k*100)};}
function pigColorName(hsl){const names=[[15,'Burnt Sienna'],[30,'Terracotta'],[45,'Amber Gold'],[60,'Citron'],[80,'Moss'],[120,'Sage Green'],[150,'Seafoam'],[180,'Cool Cyan'],[210,'Slate Blue'],[240,'Cobalt'],[270,'Amethyst'],[300,'Mauve'],[330,'Rose Blush'],[360,'Burnt Sienna']];if(hsl.s<10){if(hsl.l>80)return'Ivory White';if(hsl.l>50)return'Pearl Mist';if(hsl.l>25)return'Graphite';return'Obsidian';}for(const[h,n]of names){if(hsl.h<=h)return n;}return'Mystery Hue';}
function pigApply(hex){
  pigCount++;const rgb=hexToRgb(hex);const hsl=rgbToHsl(rgb.r,rgb.g,rgb.b);const cmyk=rgbToCmyk(rgb.r,rgb.g,rgb.b);const name=pigColorName(hsl);
  pigCurrentVals={hex:hex.toUpperCase(),rgb:`${rgb.r}, ${rgb.g}, ${rgb.b}`,hsl:`${hsl.h}°  ${hsl.s}%  ${hsl.l}%`,cmyk:`${cmyk.c}  ${cmyk.m}  ${cmyk.y}  ${cmyk.k}`};
  $('#pig-swatch').css('background',hex);$('#pig-name').text(name);$('#pig-counter').text(String(pigCount).padStart(3,'0'));
  $('#pval-hex').text(pigCurrentVals.hex);$('#pval-rgb').text(pigCurrentVals.rgb);$('#pval-hsl').text(pigCurrentVals.hsl);$('#pval-cmyk').text(pigCurrentVals.cmyk);
  $('#pig-shimmer').removeClass('flash');setTimeout(()=>$('#pig-shimmer').addClass('flash'),10);
  pigHistColors.unshift(hex);if(pigHistColors.length>10)pigHistColors.pop();
  const $h=$('#pig-history').empty();
  pigHistColors.forEach((c,i)=>{
    const $d=$('<div>').addClass('phist-dot'+(i===0?' active':'')).css('background',c).on('click',()=>pigApply(c));
    $h.append($d);
  });
}
function pigGenerate(){pigApply('#'+Math.floor(Math.random()*16777215).toString(16).padStart(6,'0'));}
$('#pig-gen-btn').on('click',pigGenerate);
$('.pval-row').on('click',function(){
  const key=$(this).data('key');const val=pigCurrentVals[key];if(!val||val==='—')return;
  navigator.clipboard.writeText(val).catch(()=>{});
  const $r=$(this);$r.addClass('copied');setTimeout(()=>$r.removeClass('copied'),900);
  showToast('Copied: '+val);
});


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// DICE
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let diceCount=1,diceRolling=false,diceHistLog=[];
function makeDie(){
  let html='<div class="die" data-v="0" style="opacity:0;transition:opacity .2s;">';
  for(let i=1;i<=9;i++)html+=`<div class="dot" data-p="${i}"></div>`;
  html+='</div>';return $(html);
}
function renderDice(){$('#dice-area').empty();for(let i=0;i<diceCount;i++){const $d=makeDie();$('#dice-area').append($d);setTimeout(()=>$d.css('opacity','1'),40*i);}$('#dice-result').hide();}
$(document).on('click','.dsel-btn',function(){if(diceRolling)return;$('.dsel-btn').removeClass('active');$(this).addClass('active');diceCount=parseInt($(this).data('count'));renderDice();});
$('#roll-btn').on('click',function(){
  if(diceRolling)return;diceRolling=true;$(this).prop('disabled',true).text('⏳ Mengocok...');$('#dice-result').hide();
  const $dice=$('#dice-area .die');
  const sT=setInterval(()=>{$dice.each(function(){$(this).attr('data-v',Math.ceil(Math.random()*6));});},80);
  $dice.addClass('rolling');
  setTimeout(()=>{
    clearInterval(sT);const results=[];
    $dice.each(function(){$(this).removeClass('rolling');const v=Math.ceil(Math.random()*6);results.push(v);$(this).attr('data-v',v);});
    const total=results.reduce((a,b)=>a+b,0);
    $('#dice-total').text(total);$('#dice-detail').text(results.length>1?results.join(' + ')+' = '+total:'');
    $('#dice-result').show();
    diceHistLog.unshift({results,total});if(diceHistLog.length>8)diceHistLog.pop();
    const $h=$('#dice-hist').empty();
    diceHistLog.forEach(h=>{const det=h.results.length>1?h.results.join('+')+' = ':'';$h.append(`<div class="dhist-chip">${det}<span>${h.total}</span></div>`);});
    diceRolling=false;$('#roll-btn').prop('disabled',false).text('🎲 Lempar Dadu');
  },700);
});
renderDice();


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// RNG
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let rngCurrent=0,rngHistory=[];
function rngUpdate(animate=false){
  const $el=$('#rng-number');$el.removeClass('rolling');
  if(animate){void $el[0].offsetWidth;$el.addClass('rolling');}
  $el.text(rngCurrent);
}
function rngAddHist(n){rngHistory.unshift(n);if(rngHistory.length>8)rngHistory.pop();const $h=$('#rng-hist').empty();rngHistory.forEach(v=>$h.append($('<span class="rng-pill">').text(v)));}
$('#rng-main-btn').on('click',function(){
  const max=parseInt($('#rng-max').val())||100;let ticks=0,total=10;
  const iv=setInterval(()=>{ticks++;$('#rng-number').text(Math.floor(Math.random()*max));if(ticks>=total){clearInterval(iv);rngCurrent=Math.floor(Math.random()*max);rngUpdate(true);rngAddHist(rngCurrent);}},40);
});
$('#rng-inc').on('click',()=>{rngCurrent++;rngUpdate(true);});
$('#rng-dec').on('click',()=>{rngCurrent--;rngUpdate(true);});


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// BATTLE CLASH (RPS)
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
const RPS_CHOICES={rock:{emoji:'🪨',label:'ROCK'},paper:{emoji:'📄',label:'PAPER'},scissors:{emoji:'✂️',label:'SCISSORS'}};
const RPS_BEATS={rock:'scissors',scissors:'paper',paper:'rock'};
let rpsS={sp:0,sc:0,sd:0,round:1,streak:0,total:0,busy:false};
function rpsResult(p,c){return p===c?'draw':RPS_BEATS[p]===c?'win':'lose';}
function rpsUI(){$('#rps-sp').text(String(rpsS.sp).padStart(2,'0'));$('#rps-sc').text(String(rpsS.sc).padStart(2,'0'));$('#rps-sd').text(rpsS.sd);$('#rps-round').text(String(rpsS.round).padStart(2,'0'));$('#rps-total').text(rpsS.total);$('#rps-log-count').text(rpsS.total+' RECORDS');$('#rps-streak').text(rpsS.streak>0?'STREAK: '+rpsS.streak+'🔥':'STREAK: 0');}
function rpsPlay(pk){
  if(rpsS.busy)return;rpsS.busy=true;
  $('.rps-choice-btn').removeClass('active-pick');$(`.rps-choice-btn[data-choice="${pk}"]`).addClass('active-pick');
  $('#rps-ep').text('⌛');$('#rps-ec').text('⌛');$('#rps-badge').removeClass('show win lose draw');$('#rps-cp,#rps-cc').removeClass('winner');
  const spin=['🎲','⚡','💥','🎯'];let si=0;const iv=setInterval(()=>$('#rps-ec').text(spin[si++%spin.length]),140);
  setTimeout(()=>{
    clearInterval(iv);const ck=Object.keys(RPS_CHOICES)[Math.floor(Math.random()*3)];const res=rpsResult(pk,ck);
    $('#rps-ep').text(RPS_CHOICES[pk].emoji);$('#rps-ec').text(RPS_CHOICES[ck].emoji);
    rpsS.total++;rpsS.round++;
    if(res==='win'){rpsS.sp++;rpsS.streak++;$('#rps-cp').addClass('winner');}
    else if(res==='lose'){rpsS.sc++;rpsS.streak=0;$('#rps-cc').addClass('winner');$('#rps-cp').addClass('rps-shake');setTimeout(()=>$('#rps-cp').removeClass('rps-shake'),450);}
    else{rpsS.sd++;rpsS.streak=0;}
    const M={win:{t:'⚡ YOU WIN! ⚡',c:'win'},lose:{t:'💀 YOU LOSE',c:'lose'},draw:{t:'🤝 DRAW',c:'draw'}};
    const {t,c}=M[res];$('#rps-badge').removeClass('show win lose draw').text(t).addClass(c);setTimeout(()=>$('#rps-badge').addClass('show'),10);
    const cls={win:'win-r',lose:'lose-r',draw:'draw-r'}[res];const lbl={win:'✅ WIN',lose:'❌ LOSE',draw:'🤝 DRAW'}[res];
    if(rpsS.total===1)$('#rps-hist-log').empty();
    const p=RPS_CHOICES[pk],cv=RPS_CHOICES[ck];
    $('#rps-hist-log').prepend(`<div class="rps-h-item ${cls}"><span class="rps-h-rn">R${String(rpsS.round-1).padStart(2,'0')}</span><span class="rps-h-moves">${p.emoji} ${p.label} vs ${cv.emoji} ${cv.label}</span><span class="rps-h-res ${cls}">${lbl}</span></div>`);
    $('#rps-hist-log .rps-h-item:gt(19)').remove();
    rpsUI();rpsS.busy=false;
  },680);
}
$('.rps-choice-btn').on('click',function(){rpsPlay($(this).data('choice'));});
$('#rps-reset').on('click',function(){
  Object.assign(rpsS,{sp:0,sc:0,sd:0,round:1,streak:0,total:0,busy:false});
  $('#rps-ep').text('❓');$('#rps-ec').text('🤖');$('#rps-badge').removeClass('show win lose draw').text('—');
  $('#rps-cp,#rps-cc').removeClass('winner');$('.rps-choice-btn').removeClass('active-pick');
  $('#rps-hist-log').html('<div class="rps-no-data">NO BATTLES YET — MAKE YOUR MOVE</div>');rpsUI();
});
rpsUI();


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// SEAT PICKER
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let seatBuilt=false,seatRows=0,seatCols=0,seatHistLog=[],seatPickCount=0;
function seatRowLabel(i){if(i<=26)return String.fromCharCode(64+i);return String.fromCharCode(64+Math.floor((i-1)/26))+String.fromCharCode(65+((i-1)%26));}
const syncSeat=(numId,rangeId)=>{const n=document.getElementById(numId),r=document.getElementById(rangeId);if(n&&r){n.addEventListener('input',()=>{r.value=n.value;});r.addEventListener('input',()=>{n.value=r.value;});}};
syncSeat('seat-rows','seat-rows-range');syncSeat('seat-cols','seat-cols-range');
function seatBuildGrid(){
  seatRows=Math.max(1,Math.min(26,parseInt($('#seat-rows').val())||6));seatCols=Math.max(1,Math.min(50,parseInt($('#seat-cols').val())||10));
  const table=$('#seat-table');table.empty();
  const thead=$('<thead>');let hRow='<tr><th></th>';for(let c=1;c<=seatCols;c++)hRow+=`<th>${c}</th>`;hRow+='</tr>';thead.html(hRow);table.append(thead);
  const tbody=$('<tbody>');
  for(let r=1;r<=seatRows;r++){const tr=$('<tr>');const rl=seatRowLabel(r);tr.append(`<td class="seat-row-hdr">${rl}</td>`);
    for(let c=1;c<=seatCols;c++){const sid=`${rl}${c}`;const td=$('<td>').addClass('seat-cell').attr({'data-seat':sid,'data-row':r,'data-col':c});td.html(`<div class="seat-cell-inner"><span class="seat-cell-id">${sid}</span></div>`);td.on('click',function(){seatToggleCell(this);});tr.append(td);}
    tbody.append(tr);}
  table.append(tbody);$('#seat-empty').hide();table.show();$('#seat-pick-btn').prop('disabled',false);seatUpdateStats();seatBuilt=true;
}
function seatToggleCell(td){const isS=$(td).hasClass('selected');$(td).toggleClass('selected');const sid=$(td).attr('data-seat');const t=new Date().toTimeString().slice(0,8);if(!isS)seatAddHist(sid,'MANUAL',t);seatUpdateStats();}
$('#seat-build-btn').on('click',seatBuildGrid);
$('#seat-pick-btn').on('click',function(){
  const all=$('.seat-cell:not(.selected)');if(!all.length){$('#seat-pick-result').html('<div class="seat-pick-empty">Semua kursi dipilih!</div>');return;}
  const picked=all[Math.floor(Math.random()*all.length)];$(picked).addClass('selected just-picked');setTimeout(()=>$(picked).removeClass('just-picked'),700);
  picked.scrollIntoView({behavior:'smooth',block:'center'});
  const sid=$(picked).attr('data-seat'),rn=$(picked).attr('data-row'),cn=$(picked).attr('data-col');
  $('#seat-pick-result').html(`<div class="seat-pick-id flash">${sid}</div><div class="seat-pick-sub">Baris ${seatRowLabel(parseInt(rn))} · Kolom ${cn}</div>`);
  const t=new Date().toTimeString().slice(0,8);seatAddHist(sid,'RANDOM',t);seatUpdateStats();
});
function seatAddHist(sid,mode,time){
  seatPickCount++;const list=$('#seat-hist-list');
  if(list.find('.seat-hist-empty').length)list.empty();
  const mCls=mode==='RANDOM'?'random':'manual';
  const item=$('<div>').addClass('seat-h-item').html(`<span class="seat-h-num">#${seatPickCount}</span><span class="seat-h-seat">${sid}</span><span class="seat-h-mode ${mCls}">${mode}</span><span class="seat-h-time">${time}</span>`);
  list.prepend(item);$('#seat-hist-count').text(seatPickCount);$('#seat-stat-picked').text(seatPickCount);
}
$('#seat-clear-sel').on('click',function(){$('.seat-cell.selected').removeClass('selected');$('#seat-pick-result').html('<div class="seat-pick-empty">Seleksi dihapus</div>');seatUpdateStats();});
$('#seat-reset-all').on('click',function(){$('.seat-cell.selected').removeClass('selected');$('#seat-pick-result').html('<div class="seat-pick-empty">Belum ada kursi dipilih</div>');seatUpdateStats();});
$('#seat-clear-hist').on('click',function(){seatHistLog=[];seatPickCount=0;$('#seat-hist-list').html('<div class="seat-hist-empty">Belum ada pilihan</div>');$('#seat-hist-count').text('0');$('#seat-stat-picked').text('0');});
function seatUpdateStats(){const total=$('.seat-cell').length;const sel=$('.seat-cell.selected').length;const avail=total-sel;$('#seat-stat-total').text(total||'—');$('#seat-stat-avail').text(total?avail:'—');}


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// PASSWORD GENERATOR
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
const PWD_CHARS = {
  numbers:  '0123456789',
  lower:    'abcdefghijklmnopqrstuvwxyz',
  upper:    'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
  special:  '!@#$%^&*()_+-=[]{}|;:,.<>?~'
};
let pwdState = { numbers: true, lower: true, upper: true, special: true };
let pwdCurrent = '';
let pwdHistory = [];

$('#pwd-len-slider').on('input', function() {
  $('#pwd-len-display').text($(this).val());
  updateSliderBg();
});

function updateSliderBg() {
  const s = document.getElementById('pwd-len-slider');
  const pct = ((s.value - s.min) / (s.max - s.min)) * 100;
  s.style.background = `linear-gradient(to right, #a3e635 0%, #a3e635 ${pct}%, rgba(255,255,255,.08) ${pct}%, rgba(255,255,255,.08) 100%)`;
}
updateSliderBg();

$(document).on('click', '.pwd-option-row', function() {
  const key = $(this).data('key');
  const checked = Object.values(pwdState).filter(Boolean).length;
  if (pwdState[key] && checked <= 1) {
    showToast('Minimal 1 tipe karakter harus dipilih!');
    $(this).addClass('disabled-row');
    setTimeout(() => $(this).removeClass('disabled-row'), 600);
    return;
  }
  pwdState[key] = !pwdState[key];
  const $cb = $('#cb-' + key);
  if (pwdState[key]) $cb.addClass('checked');
  else $cb.removeClass('checked');
});

function pwdGetCharset() {
  let charset = '';
  if (pwdState.numbers) charset += PWD_CHARS.numbers;
  if (pwdState.lower)   charset += PWD_CHARS.lower;
  if (pwdState.upper)   charset += PWD_CHARS.upper;
  if (pwdState.special) charset += PWD_CHARS.special;
  return charset;
}

function pwdGenerate() {
  const len = parseInt($('#pwd-len-slider').val()) || 16;
  const charset = pwdGetCharset();
  if (!charset) { showToast('Pilih minimal 1 tipe karakter!'); return; }
  let pwd = '';
  const types = [];
  if (pwdState.numbers) types.push(PWD_CHARS.numbers);
  if (pwdState.lower)   types.push(PWD_CHARS.lower);
  if (pwdState.upper)   types.push(PWD_CHARS.upper);
  if (pwdState.special) types.push(PWD_CHARS.special);
  for (const t of types) { if (pwd.length < len) pwd += t[Math.floor(Math.random() * t.length)]; }
  for (let i = pwd.length; i < len; i++) { pwd += charset[Math.floor(Math.random() * charset.length)]; }
  pwd = pwd.split('').sort(() => Math.random() - 0.5).join('');
  pwdCurrent = pwd;
  const $out = $('#pwd-output');
  $out.removeClass('empty').text('');
  const delay = Math.min(18, Math.floor(280 / len));
  let i = 0;
  const iv = setInterval(() => { $out.text(pwd.slice(0, i + 1)); i++; if (i >= pwd.length) clearInterval(iv); }, delay);
  pwdUpdateStrength(pwd);
  pwdAddHistory(pwd, len);
}

function pwdUpdateStrength(pwd) {
  const len = pwd.length;
  const hasN = /[0-9]/.test(pwd), hasL = /[a-z]/.test(pwd), hasU = /[A-Z]/.test(pwd), hasS = /[^a-zA-Z0-9]/.test(pwd);
  const typesUsed = [hasN, hasL, hasU, hasS].filter(Boolean).length;
  let score = 0;
  if (len >= 8) score += 20; if (len >= 12) score += 15; if (len >= 16) score += 10; if (len >= 24) score += 10; if (len >= 32) score += 5;
  score += typesUsed * 10;
  score = Math.min(score, 100);
  let label, color;
  if (score < 30) { label = 'VERY WEAK'; color = '#ff4444'; }
  else if (score < 50) { label = 'WEAK'; color = '#ff8c42'; }
  else if (score < 65) { label = 'FAIR'; color = '#ffbe0b'; }
  else if (score < 80) { label = 'STRONG'; color = '#06d6a0'; }
  else { label = 'VERY STRONG'; color = '#a3e635'; }
  $('#pwd-strength-tag').text(label).css('color', color);
  $('#pwd-strength-bar').css({ width: score + '%', background: color });
}

function pwdAddHistory(pwd, len) {
  pwdHistory.unshift({ pwd, len });
  if (pwdHistory.length > 6) pwdHistory.pop();
  const $list = $('#pwd-hist-list');
  $list.empty();
  pwdHistory.forEach(item => {
    const $item = $('<div class="pwd-hist-item">').on('click', function() {
      navigator.clipboard.writeText(item.pwd).catch(() => {});
      showToast('✓ Copied from history!');
    });
    $item.html(`<span class="pwd-hist-pw">${item.pwd}</span><span class="pwd-hist-len">${item.len}c</span>`);
    $list.append($item);
  });
}

function pwdCopyToClipboard() {
  if (!pwdCurrent) { showToast('Generate password dulu!'); return; }
  navigator.clipboard.writeText(pwdCurrent).then(() => {
    showToast('✓ Password copied!');
    $('#pwd-copy-btn').addClass('copied-btn').text('✓ Copied!');
    $('#pwd-copy-icon').addClass('copied');
    setTimeout(() => { $('#pwd-copy-btn').removeClass('copied-btn').text('📋 Copy'); $('#pwd-copy-icon').removeClass('copied'); }, 1800);
  }).catch(() => {
    const ta = document.createElement('textarea'); ta.value = pwdCurrent; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
    showToast('✓ Password copied!');
  });
}

$('#pwd-gen-btn').on('click', pwdGenerate);
$('#pwd-copy-btn').on('click', pwdCopyToClipboard);
$('#pwd-copy-icon').on('click', pwdCopyToClipboard);


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// QR CODE GENERATOR
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
let qrInitialized = false;
let qrInstance = null;
let qrStatGen = 0;
let qrStatDl = 0;
let qrHistory = [];
let qrCurrentInput = '';

function qrInit() {
  qrInitialized = true;
}

// Live char count
$('#qr-input').on('input', function() {
  const len = $(this).val().length;
  const $c = $('#qr-char-count');
  $c.text(len + ' / 2000 karakter');
  $c.removeClass('warn over');
  if (len > 1500) $c.addClass('warn');
  if (len > 1900) $c.addClass('over');
});

// Color picker sync
$('#qr-fg-color').on('input', function() {
  $('#qr-fg-hex').text($(this).val().toUpperCase());
});
$('#qr-bg-color').on('input', function() {
  const val = $(this).val().toUpperCase();
  $('#qr-bg-hex').text(val);
  // Dark bg frame
  const isDark = qrColorIsDark($(this).val());
  $('#qr-frame').toggleClass('dark-bg', isDark);
});

function qrColorIsDark(hex) {
  const r = parseInt(hex.slice(1,3),16);
  const g = parseInt(hex.slice(3,5),16);
  const b = parseInt(hex.slice(5,7),16);
  return (r*299 + g*587 + b*114) / 1000 < 128;
}

function qrGenerate() {
  const text = $('#qr-input').val().trim();
  if (!text) {
    showToast('Masukkan teks atau URL terlebih dahulu!');
    $('#qr-input').focus();
    return;
  }

  const size    = parseInt($('#qr-size').val()) || 200;
  const ecl     = $('#qr-ecl').val();
  const type    = $('#qr-type').val();
  const fgColor = $('#qr-fg-color').val();
  const bgColor = $('#qr-bg-color').val();

  // Clear container
  const $container = $('#qr-canvas-container');
  $container.empty();
  $('#qr-placeholder').hide();

  // Create fresh div for QRCode
  const $qrDiv = $('<div>').attr('id', 'qr-inner-div');
  $container.append($qrDiv);

  try {
    qrInstance = new QRCode($qrDiv[0], {
      text: text,
      width: size,
      height: size,
      colorDark: fgColor,
      colorLight: bgColor,
      correctLevel: QRCode.CorrectLevel[ecl] || QRCode.CorrectLevel.M,
      useSVG: (type === 'img')
    });

    // Stats
    qrCurrentInput = text;
    qrStatGen++;
    $('#qr-stat-gen').text(qrStatGen);
    $('#qr-stat-size').text(size);
    const preview = text.length > 40 ? text.slice(0,40) + '…' : text;
    $('#qr-stat-preview').text(preview);

    // Enable buttons
    $('#qr-dl-btn, #qr-copy-img-btn').prop('disabled', false);

    // Frame bg
    const isDark = qrColorIsDark(bgColor);
    $('#qr-frame').toggleClass('dark-bg', isDark);

    // Save to history (after slight delay so canvas is drawn)
    setTimeout(() => {
      qrSaveHistory(text, size, ecl, fgColor, bgColor);
    }, 150);

  } catch(e) {
    $container.html('<div style="font-family:\'DM Mono\',monospace;font-size:.65rem;color:#ff2d78;text-align:center;padding:20px;">Error: Teks terlalu panjang atau karakter tidak valid.</div>');
    showToast('Gagal generate QR: ' + (e.message || 'unknown error'));
  }
}

function qrGetCanvas() {
  const canvas = document.querySelector('#qr-canvas-container canvas');
  if (canvas) return canvas;
  // If SVG/img type, create canvas from img
  const img = document.querySelector('#qr-canvas-container img');
  if (img) {
    const c = document.createElement('canvas');
    c.width = img.naturalWidth || img.width;
    c.height = img.naturalHeight || img.height;
    const ctx = c.getContext('2d');
    ctx.drawImage(img, 0, 0);
    return c;
  }
  return null;
}

function qrDownload() {
  const canvas = qrGetCanvas();
  if (!canvas) { showToast('Generate QR dulu!'); return; }

  const fmt = $('#qr-dl-fmt').val();
  const mimeType = fmt === 'jpg' ? 'image/jpeg' : 'image/png';
  const ext = fmt;

  // For JPG we need white background
  let exportCanvas = canvas;
  if (fmt === 'jpg') {
    exportCanvas = document.createElement('canvas');
    exportCanvas.width = canvas.width;
    exportCanvas.height = canvas.height;
    const ctx = exportCanvas.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
    ctx.drawImage(canvas, 0, 0);
  }

  const link = document.createElement('a');
  const slug = qrCurrentInput.replace(/[^a-zA-Z0-9]/g, '_').slice(0, 20) || 'qrcode';
  link.download = `qr_${slug}.${ext}`;
  link.href = exportCanvas.toDataURL(mimeType, 0.92);
  link.click();

  qrStatDl++;
  $('#qr-stat-dl').text(qrStatDl);
  showToast('✓ QR Code berhasil diunduh!');

  // Update history dl count
  if (qrHistory.length > 0) {
    qrHistory[0].dlCount = (qrHistory[0].dlCount || 0) + 1;
    renderQrHistory();
  }
}

function qrCopyImage() {
  const canvas = qrGetCanvas();
  if (!canvas) { showToast('Generate QR dulu!'); return; }

  canvas.toBlob(blob => {
    if (!blob) { showToast('Gagal menyalin gambar.'); return; }
    try {
      navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })]).then(() => {
        showToast('✓ Gambar QR disalin ke clipboard!');
        $('#qr-copy-img-btn').text('✓ Tersalin!');
        setTimeout(() => $('#qr-copy-img-btn').text('📋 Salin Gambar'), 1800);
      }).catch(() => {
        showToast('Browser tidak mendukung copy gambar. Gunakan Download.');
      });
    } catch(e) {
      showToast('Browser tidak mendukung copy gambar. Gunakan Download.');
    }
  }, 'image/png');
}

function qrSaveHistory(text, size, ecl, fg, bg) {
  const canvas = qrGetCanvas();
  const thumb = canvas ? canvas.toDataURL('image/png') : null;

  // Avoid duplicate at top
  if (qrHistory.length > 0 && qrHistory[0].text === text && qrHistory[0].size === size) return;

  qrHistory.unshift({ text, size, ecl, fg, bg, thumb, dlCount: 0, ts: new Date().toTimeString().slice(0,5) });
  if (qrHistory.length > 8) qrHistory.pop();
  renderQrHistory();
}

function renderQrHistory() {
  const $list = $('#qr-hist-list');
  if (!qrHistory.length) {
    $list.html('<div style="font-family:\'DM Mono\',monospace;font-size:.65rem;color:var(--muted);text-align:center;padding:16px 0;letter-spacing:.15em;">Belum ada QR yang digenerate…</div>');
    return;
  }
  $list.empty();
  qrHistory.forEach((item, idx) => {
    const shortText = item.text.length > 48 ? item.text.slice(0, 48) + '…' : item.text;
    const $item = $('<div>').addClass('qr-hist-item').on('click', function() {
      // Reload settings and regenerate
      $('#qr-input').val(item.text);
      $('#qr-size').val(item.size);
      $('#qr-ecl').val(item.ecl);
      $('#qr-fg-color').val(item.fg);
      $('#qr-bg-color').val(item.bg);
      $('#qr-fg-hex').text(item.fg.toUpperCase());
      $('#qr-bg-hex').text(item.bg.toUpperCase());
      $('#qr-char-count').text(item.text.length + ' / 2000 karakter');
      qrGenerate();
    });
    const thumbHtml = item.thumb
      ? `<img src="${item.thumb}" alt="qr thumbnail">`
      : '<div style="width:44px;height:44px;background:#1a1a2e;border-radius:4px;"></div>';
    $item.html(`
      <div class="qr-hist-thumb">${thumbHtml}</div>
      <div class="qr-hist-info">
        <div class="qr-hist-text">${shortText}</div>
        <div class="qr-hist-meta">
          <span>${item.size}px</span>
          <span>ECL: ${item.ecl}</span>
          <span>${item.ts}</span>
        </div>
      </div>
      <div class="qr-hist-dl">↺ Load</div>`);
    $list.append($item);
  });
}

$('#qr-gen-btn').on('click', qrGenerate);
$('#qr-dl-btn').on('click', qrDownload);
$('#qr-copy-img-btn').on('click', qrCopyImage);

// Enter key in textarea generates QR (Shift+Enter = new line)
$('#qr-input').on('keydown', function(e) {
  if (e.key === 'Enter' && !e.shiftKey) {
    e.preventDefault();
    qrGenerate();
  }
});


// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// GLOBAL KEYBOARD
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
$(document).on('keydown',function(e){
  const activePage=$('.page.active').attr('id');
  if(e.code==='Space'){
    if(activePage==='page-coin'){e.preventDefault();doFlip();}
    else if(activePage==='page-pigment'){e.preventDefault();pigGenerate();}
    else if(activePage==='page-pwd'){e.preventDefault();pwdGenerate();}
  }
  if(activePage==='page-rps'&&!rpsS.busy){const m={r:'rock',p:'paper',s:'scissors'};const k=m[e.key.toLowerCase()];if(k)rpsPlay(k);}
  if(activePage==='page-pwd'&&e.ctrlKey&&e.key==='c'&&pwdCurrent){pwdCopyToClipboard();}
});

});
</script>
</body>
</html>