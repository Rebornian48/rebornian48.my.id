/* rebornian48 shared brand bar — auto-inject
   Usage: <link rel="stylesheet" href="/assets/brand.css">
          <script src="/assets/brand.js" data-app="app-name" defer></script>
   - reads data-app from own script tag for app label
   - injects brand bar as first child of <body>
   - wires theme toggle to `rebornian.theme` localStorage + [data-theme] on <html>
*/
(function () {
  'use strict';

  // 1. init theme from localStorage (before render if not already set)
  const savedTheme = localStorage.getItem('rebornian.theme');
  if (!document.documentElement.hasAttribute('data-theme')) {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    document.documentElement.setAttribute('data-theme', savedTheme || (prefersDark ? 'dark' : 'light'));
  } else if (savedTheme) {
    // sync from other tabs / apps if user already toggled elsewhere
    document.documentElement.setAttribute('data-theme', savedTheme);
  }

  // 2. read app label from own script tag
  const selfScript = document.currentScript || document.querySelector('script[src*="brand.js"]');
  const appLabel = (selfScript && selfScript.dataset.app) || '';

  // 3. build brand bar
  const bar = document.createElement('nav');
  bar.className = 'r48-bar';
  bar.innerHTML =
    '<a class="r48-brand" href="/">' +
      '<span class="r48-logo">' +
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>' +
      '</span>' +
      '<span class="r48-name">rebornian48</span>' +
      (appLabel ? '<span class="r48-sep">/</span><span class="r48-app">' + appLabel + '</span>' : '') +
    '</a>' +
    '<div class="r48-mid">rebornian48.my.id</div>' +
    '<div class="r48-actions">' +
      '<div class="r48-toggle" role="group" aria-label="Ganti tema">' +
        '<button type="button" data-r48-theme="light" aria-label="Terang" title="Terang">' +
          '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>' +
        '</button>' +
        '<button type="button" data-r48-theme="dark" aria-label="Gelap" title="Gelap">' +
          '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>' +
        '</button>' +
      '</div>' +
      '<a class="r48-back" href="/">' +
        '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>' +
        'Tools' +
      '</a>' +
    '</div>';

  function insertBar() {
    if (!document.body) return;
    if (document.querySelector('.r48-bar')) return;
    document.body.insertBefore(bar, document.body.firstChild);
    wireToggle();
  }

  function wireToggle() {
    const btns = bar.querySelectorAll('[data-r48-theme]');
    function syncPressed() {
      const cur = document.documentElement.getAttribute('data-theme') || 'light';
      btns.forEach(b => b.setAttribute('aria-pressed', String(b.dataset.r48Theme === cur)));
    }
    syncPressed();

    btns.forEach(b => b.addEventListener('click', ev => {
      const t = b.dataset.r48Theme;
      if (document.documentElement.getAttribute('data-theme') === t) return;
      function apply() {
        document.documentElement.setAttribute('data-theme', t);
        localStorage.setItem('rebornian.theme', t);
        syncPressed();
        // notify app in case it needs to swap tiles etc
        window.dispatchEvent(new CustomEvent('r48:theme', { detail: { theme: t } }));
      }
      if (document.startViewTransition && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.style.setProperty('--tx', (ev.clientX / innerWidth * 100) + '%');
        document.documentElement.style.setProperty('--ty', (ev.clientY / innerHeight * 100) + '%');
        document.startViewTransition(apply);
      } else {
        document.documentElement.classList.add('theme-anim');
        setTimeout(() => document.documentElement.classList.remove('theme-anim'), 600);
        apply();
      }
    }));

    // cross-tab / cross-app sync
    window.addEventListener('storage', ev => {
      if (ev.key === 'rebornian.theme' && ev.newValue) {
        document.documentElement.setAttribute('data-theme', ev.newValue);
        syncPressed();
        window.dispatchEvent(new CustomEvent('r48:theme', { detail: { theme: ev.newValue } }));
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', insertBar);
  } else {
    insertBar();
  }
})();
