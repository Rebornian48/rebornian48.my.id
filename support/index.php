<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dukung Rebornian48</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="/analytics.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/brand.css">
<script>
(function(){
  const s = localStorage.getItem('rebornian.theme');
  const d = matchMedia('(prefers-color-scheme: dark)').matches;
  document.documentElement.setAttribute('data-theme', s || (d ? 'dark' : 'light'));
})();
tailwind.config = {
  corePlugins: { preflight: false },
  theme: {
    extend: {
      fontFamily: {
        display: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'monospace'],
      }
    }
  }
}
</script>
<style>
/* support — waktukita design system */
* { box-sizing: border-box; }
html, body { margin: 0; }
body {
  background:
    radial-gradient(1200px 500px at 90% -10%, var(--bg-2), transparent 60%),
    radial-gradient(900px 400px at -10% 110%, var(--bg-2), transparent 60%),
    var(--bg);
  color: var(--text);
  font-family: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
  line-height: 1.5;
  overflow-x: hidden;
  transition: background-color .5s ease, color .5s ease;
}

.top-bar {
  width: 100%;
  height: 3px;
  background: linear-gradient(90deg, var(--accent) 0%, var(--highlight) 55%, transparent 100%);
}

/* Reveal animation */
.reveal { opacity: 0; transform: translateY(20px); transition: opacity .7s cubic-bezier(0.16,1,0.3,1), transform .7s cubic-bezier(0.16,1,0.3,1); }
.reveal.show { opacity: 1; transform: translateY(0); }

/* Avatar */
.avatar-outer {
  width: 108px; height: 108px;
  border-radius: 50%;
  padding: 3px;
  background: linear-gradient(135deg, var(--accent) 0%, #a77bff 50%, var(--accent) 100%);
}
.avatar-inner {
  width: 100%; height: 100%;
  border-radius: 50%;
  overflow: hidden;
  background: var(--surface);
  display: block;
}
.avatar-inner img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* Eyebrow tag */
.eyebrow {
  font-family: "JetBrains Mono", monospace;
  font-size: 11px; font-weight: 700;
  color: var(--muted);
  letter-spacing: .18em;
  text-transform: uppercase;
}

.headline {
  font-family: "Plus Jakarta Sans", sans-serif;
  font-weight: 800;
  font-size: clamp(2.2rem, 7vw, 3.2rem);
  color: var(--text);
  line-height: 1.02;
  letter-spacing: -0.035em;
  margin: 8px 0 0;
}
.headline .accent { color: var(--accent); }

.lead {
  color: var(--text-soft);
  font-size: 15px;
  line-height: 1.7;
  max-width: 26rem;
  margin: 0 auto;
}
.lead b { color: var(--text); font-weight: 700; }

/* Ornament */
.hr-ornament {
  display: flex; align-items: center; gap: 16px;
  width: 100%;
}
.hr-ornament::before, .hr-ornament::after {
  content: ''; flex: 1; height: 1px;
  background: var(--border);
}
.hr-label {
  font-family: "JetBrains Mono", monospace;
  font-size: 10px; font-weight: 700;
  color: var(--muted);
  letter-spacing: .25em;
  text-transform: uppercase;
  white-space: nowrap;
}

/* Support link cards */
.support-link {
  background: var(--surface);
  border: 1px solid var(--border-strong);
  border-radius: 16px;
  padding: 16px 20px;
  display: flex; align-items: center;
  gap: 16px;
  text-decoration: none;
  color: inherit;
  box-shadow: 3px 3px 0 var(--border-strong);
  transition: transform .12s, box-shadow .12s, background .15s;
}
.support-link:hover {
  transform: translate(-2px, -2px);
  box-shadow: 5px 5px 0 var(--border-strong);
}
.support-link:active {
  transform: translate(1px, 1px);
  box-shadow: 2px 2px 0 var(--border-strong);
}
.link-title {
  font-family: "Plus Jakarta Sans", sans-serif;
  font-weight: 800;
  font-size: 15px;
  line-height: 1.2;
  color: var(--text);
  letter-spacing: -0.01em;
}
.link-url {
  font-family: "JetBrains Mono", monospace;
  font-size: 11px;
  color: var(--muted);
  margin-top: 3px;
  letter-spacing: .04em;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.icon-wrap {
  width: 48px; height: 48px;
  border-radius: 12px;
  display: grid; place-items: center;
  flex-shrink: 0;
  background: var(--surface-2);
  border: 1px solid var(--border);
  transition: transform .15s;
}
.icon-wrap img { width: 28px; height: 28px; object-fit: contain; }
.support-link:hover .icon-wrap { transform: scale(1.06); }

.arrow-icon {
  flex-shrink: 0;
  width: 18px; height: 18px;
  color: var(--muted);
  transition: color .2s, transform .2s;
}
.support-link:hover .arrow-icon { color: var(--accent); transform: translateX(3px); }

/* Ad banner */
.ad-banner {
  display: block;
  text-align: center;
  border-radius: 14px;
  overflow: hidden;
  background: var(--highlight-soft);
  border: 1px dashed var(--border-strong);
  padding: 14px 20px;
  text-decoration: none;
  color: var(--text);
  transition: background .15s, border-color .15s;
}
.ad-banner:hover {
  background: var(--accent-soft);
  border-color: var(--accent);
}
.ad-label {
  font-family: "Plus Jakarta Sans", sans-serif;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-soft);
}

/* Thanks card */
.thanks-card {
  background: var(--surface);
  border: 1px solid var(--border-strong);
  border-radius: 20px;
  padding: 32px;
  text-align: center;
  width: 100%;
  box-shadow: var(--pop);
}
.thanks-quote {
  font-family: "Plus Jakarta Sans", sans-serif;
  color: var(--text);
  font-size: 1.15rem;
  font-weight: 700;
  line-height: 1.55;
  letter-spacing: -0.01em;
}
.thanks-quote em {
  background: linear-gradient(180deg, transparent 60%, var(--highlight) 60%);
  padding: 0 4px;
  border-radius: 4px;
  font-style: normal;
  color: var(--text);
}
.top-line {
  width: 48px; height: 3px;
  background: var(--accent);
  border-radius: 2px;
  margin: 22px auto 0;
}

/* Footer */
.footer-line {
  width: 32px; height: 1px;
  background: var(--border);
  margin: 0 auto 20px;
}
.footer-text {
  font-family: "JetBrains Mono", monospace;
  font-size: 10px;
  font-weight: 600;
  color: var(--muted);
  letter-spacing: .15em;
}

.text-accent { color: var(--accent); }
.text-muted { color: var(--muted); }

::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--surface-2); }
::-webkit-scrollbar-thumb { background: var(--border-strong); border-radius: 3px; opacity: .4; }

@media (prefers-reduced-motion: reduce) {
  * { transition: none !important; animation: none !important; }
  .reveal { opacity: 1; transform: none; }
}
</style>
</head>
<body>

<div class="top-bar"></div>

<main class="max-w-xl mx-auto px-6 py-12 md:py-16 flex flex-col items-center gap-10">

  <header class="flex flex-col items-center gap-6 reveal text-center">
    <div class="avatar-outer">
      <div class="avatar-inner">
        <img src="https://lh3.googleusercontent.com/a/ACg8ocJ5TNeTPpZcrM3b_pmwBWSGQQYzjOaofWzEa1Or4s1ZDoH2g0s8=s360-c-no"
             alt="Rebornian48"
             onerror="this.style.display='none';this.nextElementSibling.style.display='grid';" />
        <div style="display:none;width:100%;height:100%;place-items:center;background:var(--surface-2);">
          <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.6rem;font-weight:800;color:var(--text);letter-spacing:-.02em;">R48</span>
        </div>
      </div>
    </div>
    <div>
      <p class="eyebrow" style="margin-bottom:8px">Digital Creator</p>
      <h1 class="headline">
        Rebornian<span class="accent">48</span>
      </h1>
    </div>
    <p class="lead">
      Dukungan Anda sangat berarti untuk keberlanjutan konten dan karya digital ini.
      <b>Silakan pilih platform</b> yang paling nyaman bagi Anda.
    </p>
  </header>

  <div class="hr-ornament reveal">
    <span class="hr-label">Platform Dukungan</span>
  </div>

  <a href="https://www.profitablecpmratenetwork.com/egkrwam04?key=a80b31c92c15f8f0afacd8906addb1e2"
     target="_blank" rel="noopener noreferrer sponsored"
     class="ad-banner w-full reveal">
    <div class="flex items-center justify-center gap-3">
      <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
      </svg>
      <span class="ad-label">Penawaran Spesial — Lihat Selengkapnya</span>
      <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </div>
  </a>

  <div class="w-full flex flex-col gap-3" id="links-container">

    <a href="https://saweria.co/Rebornian48" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="0">
      <div class="icon-wrap">
        <img src="https://saweria.co/assets/img/saweria-icon.png" alt="Saweria"
             onerror="this.onerror=null;this.src='https://saweria.co/favicon.ico';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Saweria</div>
        <div class="link-url">saweria.co/Rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

    <a href="https://www.nihbuatjajan.com/rebornian48" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="50">
      <div class="icon-wrap">
        <img src="https://d4xyvrfd64gfm.cloudfront.net/buttons/default-cta.png" alt="Nih Buat Jajan" style="border-radius:6px;width:34px;height:auto;"
             onerror="this.onerror=null;this.parentElement.innerHTML='<svg width=&quot;26&quot; height=&quot;26&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;%23ff3b6b&quot; stroke-width=&quot;1.8&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot;><path d=&quot;M17 8h1a4 4 0 110 8h-1&quot;/><path d=&quot;M3 8h14v9a4 4 0 01-4 4H7a4 4 0 01-4-4V8z&quot;/><line x1=&quot;6&quot; y1=&quot;2&quot; x2=&quot;6&quot; y2=&quot;4&quot;/><line x1=&quot;10&quot; y1=&quot;2&quot; x2=&quot;10&quot; y2=&quot;4&quot;/><line x1=&quot;14&quot; y1=&quot;2&quot; x2=&quot;14&quot; y2=&quot;4&quot;/></svg>';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Nih Buat Jajan</div>
        <div class="link-url">nihbuatjajan.com/rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

    <a href="https://karyakarsa.com/rebornian48/" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="100">
      <div class="icon-wrap">
        <img src="https://karyakarsa.com/assets/karyakarsa/img/logo/logo-icon.png" alt="Karyakarsa"
             onerror="this.onerror=null;this.src='https://karyakarsa.com/favicon.ico';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Karyakarsa</div>
        <div class="link-url">karyakarsa.com/rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

    <a href="https://trakteer.id/rebornian48" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="150">
      <div class="icon-wrap">
        <img src="https://cdn.trakteer.id/images/mix/trakteer-icon.png" alt="Trakteer"
             onerror="this.onerror=null;this.src='https://trakteer.id/favicon.ico';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Trakteer</div>
        <div class="link-url">trakteer.id/rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

    <a href="https://www.profitablecpmratenetwork.com/egkrwam04?key=a80b31c92c15f8f0afacd8906addb1e2"
       target="_blank" rel="noopener noreferrer sponsored"
       class="ad-banner reveal" data-delay="180">
      <div class="flex items-center justify-center gap-3 py-1">
        <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--accent);"></span>
        <span class="ad-label">Konten Disponsori — Klik untuk Info Lebih Lanjut</span>
        <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--accent);"></span>
      </div>
    </a>

    <a href="https://sociabuzz.com/rebornian48" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="210">
      <div class="icon-wrap">
        <img src="https://storage.sociabuzz.com/storage/landingpage/img/sociabuzz-logo-icon.png" alt="Sociabuzz"
             onerror="this.onerror=null;this.src='https://sociabuzz.com/favicon.ico';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Sociabuzz</div>
        <div class="link-url">sociabuzz.com/rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

    <a href="https://tako.id/Rebornian48" target="_blank" rel="noopener noreferrer" class="support-link reveal" data-delay="260">
      <div class="icon-wrap">
        <img src="https://tako.id/icon.png" alt="Tako"
             onerror="this.onerror=null;this.src='https://tako.id/favicon.ico';" />
      </div>
      <div class="flex-1 min-w-0">
        <div class="link-title">Tako</div>
        <div class="link-url">tako.id/Rebornian48</div>
      </div>
      <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
    </a>

  </div>

  <div class="thanks-card reveal">
    <svg class="w-8 h-8 mx-auto mb-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
    </svg>
    <p class="thanks-quote">
      "Setiap dukungan, sekecil apapun,<br/><em>sangat berarti</em> untuk terus berkarya."
    </p>
    <div class="top-line"></div>
    <p class="eyebrow" style="margin-top:16px">Terima kasih banyak</p>
  </div>

  <a href="https://www.profitablecpmratenetwork.com/egkrwam04?key=a80b31c92c15f8f0afacd8906addb1e2"
     target="_blank" rel="noopener noreferrer sponsored"
     class="ad-banner w-full reveal">
    <div class="flex items-center justify-center gap-2 py-1">
      <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
              d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
      </svg>
      <span class="ad-label">Jelajahi Penawaran Menarik Lainnya</span>
    </div>
  </a>

  <footer class="reveal text-center pt-4">
    <div class="footer-line"></div>
    <p class="footer-text">
      &copy; <?php echo date('Y'); ?> Rebornian48 &middot; All rights reserved
    </p>
  </footer>

</main>

<script>
$(function(){
  function revealOnScroll(){
    $('.reveal:not(.show)').each(function(){
      const rect = this.getBoundingClientRect();
      if (rect.top < window.innerHeight - 40) {
        const delay = parseInt($(this).data('delay') || 0);
        const el = $(this);
        setTimeout(() => el.addClass('show'), delay);
      }
    });
  }
  $(window).on('scroll', revealOnScroll);
  $('.reveal').each(function(i){
    const el = $(this);
    const base = parseInt(el.data('delay') || 0);
    setTimeout(() => el.addClass('show'), 120 + i * 60 + base);
  });
});
</script>
<script src="/assets/brand.js" data-app="support" defer></script>
</body>
</html>
