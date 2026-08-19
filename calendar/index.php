<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kalender Nusantara — Jawa · Cina · Hijriah</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="calendar" defer></script>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- ============================================================
       KONVERSI SOLAR → LUNAR CINA (lunarInfo tabel 1900–2100)
  ============================================================ -->
  <script>
  const lunarInfo = [
    0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,
    0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,
    0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,
    0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,
    0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,
    0x06ca0,0x0b550,0x15355,0x04da0,0x0a5d0,0x14573,0x052b0,0x0a9a8,0x0e950,0x06aa0,
    0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,
    0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b6a0,0x195a6,
    0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,
    0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06aa0,0x0a6b6,0x056a0,0x02b60,0x09177,
    0x025d0,0x092d0,0x0cab5,0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,
    0x15176,0x052b0,0x0f92f,0x0e950,0x06c20,0x0ada0,0x0ab60,
    0x093b5,0x04b60,0x0aae0,0x0a570,0x05260,0x0e930,0x0d950,
    0x1d554,0x056a0,0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,
    0x0d252,0x0d558,0x0b540,0x0b6a0,0x195a6,0x095b0,0x049b0,
    0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,
    0x09570,0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06aa0,
    0x0a6b6,0x056a0,0x02b60,0x09177,0x025d0,0x092d0,0x0cab5,
    0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,
    0x15176,0x052b0,0x0f92f,0x0e950,0x06c20,0x0ada0,
    0x0ab61,0x093b0,0x04b60,0x0aae0,0x0a570,0x05260,0x0e933,0x0d950,0x1d557,0x056a0,
    0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d252,0x0d558,0x0b540,0x0b6a0,0x195a6,
    0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,
    0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06aa0,0x0a6b6,0x056a0,0x02b60,0x09177,
    0x025d0,0x092d0,0x0cab5,0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,
    0x15176,0x052b0,0x0f92f,0x0e950,0x06c20,0x0ada0,0x0ab61,0x093b0,0x04b60,0x0aae0,
    0x0a570,0x05260,0x0e933,0x0d950,0x1d557,0x056a0,0x096d0,0x04dd5,0x04ad0,0x0a4d0,
    0x0d4d4,0x0d252,0x0d558,0x0b540,0x0b6a0,0x195a6,0x095b0,0x049b0,0x0a974,0x0a4b0
  ];
  const lunarMonthName = [
    '正月 Zhēngyuè','二月 Èryuè','三月 Sānyuè','四月 Sìyuè',
    '五月 Wǔyuè','六月 Liùyuè','七月 Qīyuè','八月 Bāyuè',
    '九月 Jiǔyuè','十月 Shíyuè','十一月 Shíyīyuè','十二月 Shíèryuè'
  ];
  const lunarDayName = [
    '初一','初二','初三','初四','初五','初六','初七','初八','初九','初十',
    '十一','十二','十三','十四','十五','十六','十七','十八','十九','二十',
    '廿一','廿二','廿三','廿四','廿五','廿六','廿七','廿八','廿九','三十'
  ];
  function lunarYearDays(y){let s=29*12;for(let i=0x8000;i>0x8;i>>=1)if((lunarInfo[y]&i)!==0)s++;return s+leapDays(y);}
  function leapMonth(y){return lunarInfo[y]&0xf;}
  function leapDays(y){if(leapMonth(y))return(lunarInfo[y]&0x10000)?30:29;return 0;}
  function monthDays(y,m){return(lunarInfo[y]&(0x10000>>m))?30:29;}
  function daysBetween(y1,m1,d1,y2,m2,d2){return Math.round((Date.UTC(y2,m2-1,d2)-Date.UTC(y1,m1-1,d1))/86400000);}
  function solar2lunar(sY,sM,sD){
    const off=daysBetween(1900,1,31,sY,sM,sD);
    let lY,lM,lD,temp=0,i;
    for(i=0;i<lunarInfo.length&&temp<=off;i++)temp+=lunarYearDays(i);
    if(temp>off){i--;temp-=lunarYearDays(i);}
    lY=i+1900;
    let leap=leapMonth(i),ilm=false;
    temp=off-temp;
    for(let m=1;m<=12&&temp>=0;m++){
      if(leap>0&&m===(leap+1)&&!ilm){--m;ilm=true;temp-=leapDays(i);}else temp-=monthDays(i,m);
      if(ilm&&m===(leap+1))ilm=false;
      if(temp>=0)lM=m;
    }
    lM=lM||1; lD=temp+monthDays(i,lM)+1;
    const ti=((lY-4)%10+10)%10, di=((lY-4)%12+12)%12;
    return{lYear:lY,lMonth:lM,lDay:lD,isLeap:lM===leap,
      monthName:lunarMonthName[lM-1],dayName:lunarDayName[lD-1]||String(lD),
      lunarShioIdx:di};
  }
  window.SolarLunar={solar2lunar};
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Noto+Serif:ital,wght@0,400;0,600;1,400&family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>

  <script>
    tailwind.config={theme:{extend:{colors:{
      batik:{50:'#f0faf5',100:'#d6f2e4',200:'#aae3c8',300:'#72ccab',400:'#3fb08b',500:'#1e9470',600:'#127558',700:'#0e5d46',800:'#0d4a38',900:'#0b3d2e'},
      kraton:{50:'#fdf8ee',100:'#f9efd3',200:'#f2dba5',300:'#e9c06e',400:'#dfa040',500:'#d4852a',600:'#ba6720',700:'#994e1e',800:'#7c3f1e',900:'#66341c'},
      parang:{dark:'#0a2818',mid:'#0f3d26',light:'#164d30'}
    },fontFamily:{display:['"Cinzel Decorative"','serif'],serif:['"Noto Serif"','serif'],sans:['"Noto Sans"','sans-serif']}}}}
  </script>

  <style>
    body{background-color:#0a2818;background-image:radial-gradient(ellipse at 20% 10%,rgba(30,148,112,.15) 0%,transparent 55%),radial-gradient(ellipse at 80% 90%,rgba(212,133,42,.10) 0%,transparent 50%);min-height:100vh;}
    .ornament-border{border:1px solid rgba(30,148,112,.3);box-shadow:0 0 0 3px rgba(30,148,112,.08),inset 0 0 30px rgba(0,0,0,.3);}
    .cal-cell{cursor:pointer;transition:all .18s ease;border-radius:8px;position:relative;overflow:hidden;}
    .cal-cell:hover{background:rgba(30,148,112,.25);transform:translateY(-1px);box-shadow:0 4px 12px rgba(30,148,112,.3);}
    .cal-cell.today{background:linear-gradient(135deg,#1e9470,#127558);box-shadow:0 0 0 2px #3fb08b,0 4px 16px rgba(30,148,112,.5);}
    .cal-cell.selected{background:rgba(212,133,42,.25);box-shadow:0 0 0 2px #d4852a,0 4px 16px rgba(212,133,42,.4);}
    .cal-cell.other-month{opacity:.3;}
    .pasaran-legi{color:#fcd34d;}.pasaran-pahing{color:#f87171;}.pasaran-pon{color:#60a5fa;}.pasaran-wage{color:#34d399;}.pasaran-kliwon{color:#e879f9;}
    @keyframes fadeSlideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
    .sidebar-content{animation:fadeSlideIn .3s ease forwards;}
    .info-card{background:rgba(255,255,255,.04);border:1px solid rgba(30,148,112,.2);border-radius:12px;padding:14px 16px;margin-bottom:10px;transition:border-color .2s;}
    .info-card:hover{border-color:rgba(30,148,112,.5);}
    .info-card .card-label{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#3fb08b;margin-bottom:6px;font-family:'Noto Sans',sans-serif;font-weight:600;}
    .info-card .card-main{font-size:18px;font-weight:600;color:#f0faf5;font-family:'Noto Serif',serif;}
    .info-card .card-sub{font-size:12px;color:#72ccab;margin-top:3px;font-family:'Noto Sans',sans-serif;}
    .spinner{width:28px;height:28px;border:3px solid rgba(30,148,112,.2);border-top-color:#1e9470;border-radius:50%;animation:spin .7s linear infinite;margin:20px auto;}
    @keyframes spin{to{transform:rotate(360deg)}}
    ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(30,148,112,.4);border-radius:4px}
    .header-line{height:2px;background:linear-gradient(90deg,transparent,#1e9470 30%,#d4852a 70%,transparent);}
    .day-header-sun{color:#f87171;}.day-header-sat{color:#60a5fa;}
    .badge-pill{display:inline-block;padding:2px 10px;border-radius:999px;font-size:11px;font-weight:500;}
    /* Jawa */
    .wuku-badge{background:rgba(139,92,246,.2);border:1px solid rgba(139,92,246,.35);color:#c4b5fd;}
    .pranata-badge{background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.30);color:#fcd34d;}
    .jawa-grid{display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-top:8px;}
    .jawa-mini{background:rgba(255,255,255,.03);border:1px solid rgba(30,148,112,.15);border-radius:8px;padding:8px 10px;}
    .jawa-mini-label{font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#3fb08b;font-weight:600;margin-bottom:3px;}
    .jawa-mini-val{font-size:13px;font-weight:600;color:#f0faf5;font-family:'Noto Serif',serif;}
    .jawa-mini-sub{font-size:10px;color:#72ccab;margin-top:1px;}
    /* Cina */
    .pillar-box{background:rgba(0,0,0,.28);border:1px solid rgba(220,38,38,.28);border-radius:10px;padding:9px 6px;text-align:center;}
    .pillar-label{font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#f87171;font-weight:600;margin-bottom:4px;font-family:'Noto Sans',sans-serif;}
    .pillar-hz{font-size:24px;font-weight:700;color:#fef2f2;letter-spacing:1px;line-height:1;}
    .pillar-pinyin{font-size:10px;color:#fca5a5;margin-top:2px;font-family:'Noto Sans',sans-serif;}
    .pillar-elem{font-size:10px;margin-top:4px;font-family:'Noto Sans',sans-serif;font-weight:600;}
    .elem-wood{color:#86efac;}.elem-fire{color:#fca5a5;}.elem-earth{color:#fde68a;}.elem-metal{color:#e2e8f0;}.elem-water{color:#93c5fd;}
    .shichen-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:3px;margin-top:6px;}
    .shichen-cell{background:rgba(0,0,0,.3);border:1px solid rgba(220,38,38,.15);border-radius:6px;padding:5px 2px;text-align:center;}
    .shichen-cell.active{border-color:rgba(220,38,38,.8);background:rgba(220,38,38,.2);}
    .sc-stem{font-size:11px;color:#fca5a5;display:block;}
    .sc-branch{font-size:16px;font-weight:700;color:#fef2f2;display:block;line-height:1.1;}
    .sc-time{font-size:8px;color:#9ca3af;display:block;margin-top:1px;}
    .solar-term-box{background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.28);border-radius:8px;padding:8px 10px;margin-top:6px;}
    .cn-divider{height:1px;background:linear-gradient(90deg,transparent,rgba(220,38,38,.3),transparent);margin:10px 0;}
    .cn-section-label{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#f87171;font-weight:600;margin-bottom:6px;font-family:'Noto Sans',sans-serif;}
    .cn-mini{background:rgba(0,0,0,.2);border:1px solid rgba(220,38,38,.18);border-radius:8px;padding:8px 10px;}
    .cn-mini-label{font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#f87171;font-weight:600;margin-bottom:3px;}
    .cn-mini-val{font-size:14px;font-weight:700;color:#fef2f2;font-family:'Noto Serif',serif;}
    .cn-mini-sub{font-size:10px;color:#fca5a5;margin-top:1px;}
  </style>
<link rel="stylesheet" href="/assets/theme.css">
<link rel="stylesheet" href="/assets/miniapp-restyle.css">
<script>(function(){var s=localStorage.getItem("rebornian.theme");var d=matchMedia("(prefers-color-scheme: dark)").matches;document.documentElement.setAttribute("data-theme",s||(d?"dark":"light"));})();</script>
</head>

<body class="font-sans text-gray-100 py-6 px-4">

<header class="max-w-7xl mx-auto mb-6 text-center">
  <h1 class="font-display text-2xl md:text-3xl text-batik-200 tracking-widest mb-1">Kalender Nusantara</h1>
  <p class="text-kraton-300 text-sm tracking-widest uppercase font-sans font-light">Masehi &nbsp;·&nbsp; Hijriah &nbsp;·&nbsp; Cina &nbsp;·&nbsp; Jawa</p>
  <div class="header-line mt-3 max-w-md mx-auto"></div>
  <nav style="margin-top:14px;display:inline-flex;gap:6px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:999px;padding:4px;">
    <span style="padding:6px 16px;border-radius:999px;background:rgba(200,153,62,.2);color:#e2b96a;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">Kalender</span>
    <a href="agecalc.php" style="padding:6px 16px;border-radius:999px;color:rgba(255,255,255,.6);font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#e2b96a'" onmouseout="this.style.color='rgba(255,255,255,.6)'">Kalkulator Usia</a>
  </nav>
</header>

<main class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-5">

  <section class="lg:w-[60%] ornament-border rounded-2xl p-5 bg-parang-mid/60 backdrop-blur">
    <div class="flex items-center justify-between mb-5">
      <button id="btn-prev" class="w-9 h-9 rounded-full bg-batik-700/60 hover:bg-batik-600 text-batik-200 flex items-center justify-center transition-all hover:scale-110 border border-batik-600/40">&#9664;</button>
      <div class="text-center">
        <div id="display-month-year"  class="font-serif text-xl text-batik-100 font-semibold tracking-wide"></div>
        <div id="display-hijri-month" class="text-xs text-kraton-300 mt-0.5 font-sans"></div>
      </div>
      <button id="btn-next" class="w-9 h-9 rounded-full bg-batik-700/60 hover:bg-batik-600 text-batik-200 flex items-center justify-center transition-all hover:scale-110 border border-batik-600/40">&#9654;</button>
    </div>
    <div class="flex justify-center mb-4">
      <button id="btn-today" class="px-4 py-1.5 rounded-full text-xs font-sans font-semibold tracking-widest uppercase bg-batik-600/50 hover:bg-batik-500 border border-batik-500/40 text-batik-100 transition-all">◎ Hari Ini</button>
    </div>
    <div id="day-headers" class="grid grid-cols-7 mb-2 text-center"></div>
    <div id="cal-grid"    class="grid grid-cols-7 gap-1"></div>
    <div class="mt-5 pt-4 border-t border-batik-800/60 flex flex-wrap gap-x-4 gap-y-1 justify-center text-xs font-sans">
      <span class="pasaran-legi font-semibold">⬤ Legi</span><span class="pasaran-pahing font-semibold">⬤ Pahing</span>
      <span class="pasaran-pon font-semibold">⬤ Pon</span><span class="pasaran-wage font-semibold">⬤ Wage</span>
      <span class="pasaran-kliwon font-semibold">⬤ Kliwon</span>
    </div>
  </section>

  <aside class="lg:w-[40%] ornament-border rounded-2xl p-5 bg-parang-mid/60 backdrop-blur overflow-y-auto max-h-[80vh] lg:max-h-none">
    <div id="sidebar-placeholder" class="flex flex-col items-center justify-center h-full min-h-[200px] text-batik-400">
      <div class="text-4xl mb-3">🗓</div>
      <p class="font-serif text-sm italic text-center">Klik sebuah tanggal untuk<br>melihat informasi lengkap</p>
    </div>
    <div id="sidebar-loading" class="hidden"><div class="spinner"></div><p class="text-center text-batik-400 text-xs mt-2 font-sans">Memuat data...</p></div>
    <div id="sidebar-content" class="hidden sidebar-content"></div>
  </aside>

</main>

<footer class="max-w-7xl mx-auto mt-6 text-center text-xs text-batik-700 font-sans">
  Hijriah via <span class="text-batik-500">Aladhan API</span> &nbsp;·&nbsp;
  Cina via <span class="text-batik-500">solarlunar + Ganzhi / Jié Qì engine</span> &nbsp;·&nbsp;
  Jawa via <span class="text-batik-500">Sultan Agung (Kurup Asapon)</span>
</footer>

<script>
$(function(){

/* ============================================================
   DATA — KALENDER JAWA
============================================================ */
const NAMA_HARI=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const SAPTAWARA=[
  {jawa:'Ahad',   skt:'Radite',   makna:'Meneng (diam)'         },
  {jawa:'Senen',  skt:'Soma',     makna:'Maju'                  },
  {jawa:'Seloso', skt:'Hanggara', makna:'Mundur'                },
  {jawa:'Rebo',   skt:'Budha',    makna:'Mangiwa (belok kiri)'  },
  {jawa:'Kemis',  skt:'Respati',  makna:'Manengen (belok kanan)'},
  {jawa:'Jemuah', skt:'Sukra',    makna:'Munggah (naik)'        },
  {jawa:'Setu',   skt:'Tumpak',   makna:'Temurun (turun)'       },
];
const PASARAN_DATA={
  'Legi':  {cls:'pasaran-legi',   makna:'Manis',  patrap:'Mungkur (berbalik)'},
  'Pahing':{cls:'pasaran-pahing', makna:'Pahit',  patrap:'Madep (menghadap)' },
  'Pon':   {cls:'pasaran-pon',    makna:'Petak',  patrap:'Sare (tidur)'      },
  'Wage':  {cls:'pasaran-wage',   makna:'Cemeng', patrap:'Lenggah (duduk)'   },
  'Kliwon':{cls:'pasaran-kliwon', makna:'Asih',   patrap:'Jumeneng (berdiri)'},
};
const PASARAN=['Legi','Pahing','Pon','Wage','Kliwon'];
const NEPTU_HARI={Ahad:5,Senen:4,Seloso:3,Rebo:7,Kemis:8,Jemuah:6,Setu:9};
const NEPTU_PASARAN={Legi:5,Pahing:9,Pon:7,Wage:4,Kliwon:8};
const SASI_JAWA=['Sura','Sapar','Mulud','Bakda Mulud','Jumadilawal','Jumadilakir','Rejeb','Ruwah','Pasa','Sawal','Sela','Besar'];
const SASI_MAKNA=['Rijal','Wiwit','Kanda','Ambuka','Wiwara','Rahsa','Purwa','Dumadi','Madya','Wujud','Wusana','Kosong'];
const SASI_WARANA=['Warana','Wadana','Wijangga','Wiyana','Widada','Widarpa','Wilapa','Wahana','Wanana','Wurana','Wujana','Wujala'];
// =============================================
// DATA HIJRIAH LENGKAP
// Sumber: Wikipedia Islamic Calendar + hijri-calendar.com
// =============================================

// Terjemahan nama bulan (Indonesia)
const BULAN_HIJRI_ID={'Muharram':'Muharram','Safar':'Safar','Rabi al-awwal':"Rabi'ul Awal",'Rabi al-thani':"Rabi'ul Akhir",'Jumada al-awwal':'Jumadil Awal','Jumada al-thani':'Jumadil Akhir','Rajab':'Rajab',"Sha'ban":"Sya'ban",'Ramadan':'Ramadan','Shawwal':'Syawal',"Dhu al-Qi'dah":'Dzulkaidah','Dhu al-Hijjah':'Dzulhijjah'};

// Data lengkap 12 bulan Hijriah
// sacred: bulan haram (dilarang berperang) — Muharram(1), Rajab(7), Dzulqaidah(11), Dzulhijjah(12)
// Sumber: Wikipedia Islamic Calendar, Surah At-Tawbah 9:36
const BULAN_HIJRI_DATA = [
  { no:1,  ar:'مُحَرَّم',    en:'Muharram',       id:"Muharram",        meaning:'Yang Diharamkan',        sacred:true,  days:30, note:'Bulan pertama & suci. 10 Muharram = Hari Asyura.' },
  { no:2,  ar:'صَفَر',       en:'Safar',           id:'Safar',           meaning:'Kosong/Perjalanan',      sacred:false, days:29, note:'Nama dari kebiasaan Arab meninggalkan rumah.' },
  { no:3,  ar:'رَبِيع ٱلْأَوَّل', en:'Rabi al-awwal', id:"Rabi'ul Awal",   meaning:'Musim Semi Pertama',     sacred:false, days:30, note:'12 Rabi\'ul Awal = Maulid Nabi Muhammad ﷺ.' },
  { no:4,  ar:'رَبِيع ٱلثَّانِي', en:'Rabi al-thani', id:"Rabi'ul Akhir",  meaning:'Musim Semi Kedua',       sacred:false, days:29, note:'Juga disebut Rabi\' al-Akhir.' },
  { no:5,  ar:'جُمَادَىٰ ٱلْأُولَىٰ', en:'Jumada al-awwal', id:'Jumadil Awal', meaning:'Musim Kering Pertama', sacred:false, days:30, note:'Nama dari kata Arab untuk tanah membeku.' },
  { no:6,  ar:'جُمَادَىٰ ٱلثَّانِيَة', en:'Jumada al-thani', id:'Jumadil Akhir', meaning:'Musim Kering Kedua', sacred:false, days:29, note:'Juga disebut Jumada al-Akhirah.' },
  { no:7,  ar:'رَجَب',       en:'Rajab',           id:'Rajab',           meaning:'Yang Dimuliakan',         sacred:true,  days:30, note:'Bulan suci. 27 Rajab = Isra\' Mi\'raj.' },
  { no:8,  ar:'شَعْبَان',    en:"Sha'ban",         id:"Sya'ban",         meaning:'Terpencar/Berpencar',     sacred:false, days:29, note:'15 Sya\'ban = Nisfu Sya\'ban (malam pengampunan).' },
  { no:9,  ar:'رَمَضَان',    en:'Ramadan',         id:'Ramadan',         meaning:'Sangat Panas/Membakar',   sacred:false, days:30, note:'Bulan puasa wajib. Malam Lailatul Qadar di 10 hari terakhir.' },
  { no:10, ar:'شَوَّال',     en:'Shawwal',         id:'Syawal',          meaning:'Terangkat/Meningkat',     sacred:false, days:29, note:'1 Syawal = Idul Fitri (Lebaran).' },
  { no:11, ar:'ذُو ٱلْقَعْدَة', en:"Dhu al-Qi'dah",  id:'Dzulqaidah',     meaning:'Bulan Duduk/Istirahat',  sacred:true,  days:30, note:'Bulan suci. Persiapan haji.' },
  { no:12, ar:'ذُو ٱلْحِجَّة', en:'Dhu al-Hijjah',  id:'Dzulhijjah',     meaning:'Bulan Haji',              sacred:true,  days:29, note:'Bulan suci. 8-13 = Haji. 10 Dzulhijjah = Idul Adha.' },
];

// Hari dalam seminggu Islam (Sumber: Wikipedia Islamic Calendar)
// Hari Islam dimulai dari matahari terbenam; nama hari diurutkan dari Ahad (Minggu)
const HARI_ISLAM = [
  { no:1, ar:'ٱلْأَحَد',    en:'al-Ahad',    id:'Ahad (Minggu)',  meaning:'Yang Satu (Esa)' },
  { no:2, ar:'الاِثْنَيْن', en:'al-Ithnayn', id:'Isnain (Senin)', meaning:'Yang Kedua' },
  { no:3, ar:'ٱلثُّلَاثَاء',en:'ath-Thulatha', id:"Tsulasa' (Selasa)", meaning:'Yang Ketiga' },
  { no:4, ar:'ٱلْأَرْبِعَاء',en:"al-Arbi'a", id:"Arba'a (Rabu)",  meaning:'Yang Keempat' },
  { no:5, ar:'ٱلْخَمِيس',  en:'al-Khamis',  id:'Khamis (Kamis)', meaning:'Yang Kelima' },
  { no:6, ar:'ٱلْجُمْعَة', en:"al-Jum'ah",  id:"Jum'ah (Jumat)", meaning:'Hari Berkumpul' },
  { no:7, ar:'ٱلسَّبْت',   en:'as-Sabt',    id:'Sabt (Sabtu)',   meaning:'Istirahat/Shabbat' },
];

// Hari-hari istimewa Islam: [bulanNo, hariNo/range, nama, keterangan, ikon]
const HARI_ISTIMEWA_ISLAM = [
  { bulan:1,  hari:1,  nama:'Tahun Baru Islam',        ket:'Awal Muharram 1 AH — Hijrah Nabi ﷺ ke Madinah', ikon:'🌙' },
  { bulan:1,  hari:10, nama:'Hari Asyura',              ket:"Puasa sunnah. Nabi Musa AS diselamatkan dari Fir'aun.", ikon:'⭐' },
  { bulan:3,  hari:12, nama:'Maulid Nabi ﷺ',           ket:'Hari lahir Nabi Muhammad ﷺ di Mekkah (570 M).', ikon:'🌟' },
  { bulan:7,  hari:27, nama:"Isra' Mi'raj",             ket:'Perjalanan malam Nabi ﷺ dari Mekkah ke Baitul Maqdis & Sidratul Muntaha.', ikon:'✨' },
  { bulan:8,  hari:15, nama:"Nisfu Sya'ban",            ket:"Malam pengampunan dosa. Catatan amal setahun diangkat.", ikon:'🌕' },
  { bulan:9,  hari:1,  nama:'Awal Ramadan',             ket:'Mulai puasa wajib sebulan penuh (saum/shiyam).', ikon:'🌙' },
  { bulan:9,  hari:17, nama:'Nuzulul Quran',            ket:'Peringatan turunnya Al-Quran pertama kali di Gua Hira.', ikon:'📖' },
  { bulan:9,  hari:21, nama:'Malam Lailatul Qadar',     ket:'Malam lebih baik dari 1000 bulan. Kemungkinan di malam ganjil terakhir Ramadan.', ikon:'💫' },
  { bulan:9,  hari:23, nama:'Malam Lailatul Qadar',     ket:'Malam ganjil akhir Ramadan — kemungkinan Lailatul Qadar.', ikon:'💫' },
  { bulan:9,  hari:25, nama:'Malam Lailatul Qadar',     ket:'Malam ganjil akhir Ramadan — kemungkinan Lailatul Qadar.', ikon:'💫' },
  { bulan:9,  hari:27, nama:'Malam Lailatul Qadar',     ket:'Malam paling umum disebut sebagai Lailatul Qadar.', ikon:'💫' },
  { bulan:9,  hari:29, nama:'Malam Lailatul Qadar',     ket:'Malam ganjil terakhir Ramadan — kemungkinan Lailatul Qadar.', ikon:'💫' },
  { bulan:10, hari:1,  nama:'Idul Fitri (Lebaran)',     ket:"Hari Raya setelah sebulan puasa. Salat Id, zakat fitrah, silaturahmi.", ikon:'🎉' },
  { bulan:11, hari:8,  nama:'Tarwiyah (awal Haji)',     ket:'Jemaah haji berangkat dari Mekkah menuju Mina.', ikon:'🕋' },
  { bulan:12, hari:9,  nama:'Hari Arafah',              ket:'Wukuf di Padang Arafah — puncak ibadah haji. Puasa sunnah bagi non-haji.', ikon:'🌄' },
  { bulan:12, hari:10, nama:'Idul Adha (Qurban)',       ket:"Hari Raya Kurban. Peringatan kesediaan Nabi Ibrahim AS menyembelih putranya.", ikon:'🐑' },
  { bulan:12, hari:11, nama:'Hari Tasyrik',             ket:'Hari-hari tasyrik (11-13 Dzulhijjah). Larangan berpuasa.', ikon:'🌙' },
  { bulan:12, hari:12, nama:'Hari Tasyrik',             ket:'Hari-hari tasyrik (11-13 Dzulhijjah). Larangan berpuasa.', ikon:'🌙' },
  { bulan:12, hari:13, nama:'Hari Tasyrik (Terakhir)',  ket:'Akhir hari-hari tasyrik. Akhir Nafar Tsani dalam haji.', ikon:'🌙' },
];

// Deskripsi fase bulan berdasarkan tanggal Hijri
// Kalender Hijri: bulan baru = tanggal 1 (hilal), purnama = tanggal 14-15
function getFaseQamar(hDay) {
  if      (hDay === 1)              return { ikon:'🌑', nama:'Hilal (Bulan Baru)',    ket:'Awal bulan — hilal mulai terlihat setelah matahari terbenam.' };
  else if (hDay <= 6)               return { ikon:'🌒', nama:'Bulan Sabit Muda',      ket:'Cahaya bulan makin bertambah (hilal berkembang).' };
  else if (hDay <= 9)               return { ikon:'🌓', nama:'Bulan Separuh Awal',    ket:"Bulan setengah — disebut 'al-Badr al-Awwal' dalam tradisi Islam." };
  else if (hDay <= 13)              return { ikon:'🌔', nama:'Bulan Cembung Awal',    ket:'Mendekati purnama.' };
  else if (hDay === 14)             return { ikon:'🌕', nama:'Purnama Sidhi',         ket:"Tanggal 14 — malam purnama pertama, disebut 'Purnama Sidhi' dalam Jawa." };
  else if (hDay === 15)             return { ikon:'🌕', nama:'Purnama (al-Badr)',     ket:"Bulan purnama penuh (البدر). Dalam tradisi Islam, malam yang sangat mulia." };
  else if (hDay <= 19)              return { ikon:'🌖', nama:'Bulan Cembung Akhir',   ket:'Cahaya bulan mulai berkurang.' };
  else if (hDay <= 22)              return { ikon:'🌗', nama:'Bulan Separuh Akhir',   ket:"Disebut 'Panglong' dalam tradisi Jawa." };
  else if (hDay <= 27)              return { ikon:'🌘', nama:'Bulan Sabit Tua',       ket:'Bulan semakin menipis mendekati akhir bulan.' };
  else                              return { ikon:'🌑', nama:'Muḥāq (Akhir Bulan)',   ket:'Bulan hampir tidak terlihat — akhir siklus lunar.' };
}

// Cari hari istimewa dari data
function getHariIstimewa(hMonth, hDay) {
  return HARI_ISTIMEWA_ISLAM.filter(h => h.bulan === hMonth && h.hari === hDay);
}

// Posisi dalam bulan
function getPosisiBulan(hDay) {
  if (hDay <= 10) return 'Awal Bulan (العشر الأول)';
  if (hDay <= 20) return 'Pertengahan Bulan (العشر الأوسط)';
  return 'Akhir Bulan (العشر الأخير)';
}

// Helper: bangun info Hijri lengkap dari data API
function buildHijriLengkap(hijri) {
  const hDay   = parseInt(hijri.day);
  const hMonth = parseInt(hijri.month.number);
  const hYear  = parseInt(hijri.year);
  const bulanData = BULAN_HIJRI_DATA[hMonth - 1];
  const fase   = getFaseQamar(hDay);
  const istimewa = getHariIstimewa(hMonth, hDay);
  const posisi = getPosisiBulan(hDay);
  // Hari Islam (API mengembalikan weekday.en)
  const hariIslamData = HARI_ISLAM.find(h => h.en.toLowerCase().includes(
    (hijri.weekday.en||'').toLowerCase().replace('al-','').substring(0,4)
  )) || null;
  return { hDay, hMonth, hYear, bulanData, fase, istimewa, posisi, hariIslamData };
}
const WARSA_JAWA=['Alip','Ehe','Jimawal','Je','Dal','Be','Wawu','Jimakir'];
const WARSA_MOD_MAP={3:0,4:1,5:2,6:3,7:4,0:5,1:6,2:7};
const WARSA_MAKNA={Alip:'Purwana — ada-ada (mulai berniat)',Ehe:'Karyana — tumandang (melakukan)',Jimawal:'Anama — gawé (pekerjaan)',Je:'Lalana — lelakon (proses/nasib)',Dal:'Ngawana — urip (hidup)',Be:'Pawaka — bola-bali (selalu kembali)',Wawu:'Wasana — marang (arah)',Jimakir:'Swasana — suwung (kosong)'};
const WINDU_JAWA=['Adi','Kuntara','Sangara','Sancaya'];
const KURUP_LIST=[
  {nama:"Alif Jam'iyah Légi",          mulai:1555,akhir:1674,catatan:'1 Sura Alip = Jumat Légi'},
  {nama:'Alif Kamsiyah Kliwon',        mulai:1675,akhir:1748,catatan:'1 Sura Alip = Kamis Kliwon'},
  {nama:"Alif Arba'iyah Wagé (Aboge)", mulai:1749,akhir:1866,catatan:'1 Sura Alip = Rabu Wagé'},
  {nama:'Alif Selasa Pon (Asapon)',     mulai:1867,akhir:1986,catatan:'1 Sura Alip = Selasa Pon'},
];
const WUKU=['Sinta','Landep','Wukir','Kurantil','Tolu','Gumbreg','Warigalit','Warigagung','Julungwangi','Sungsang','Galungan','Kuningan','Langkir','Mandasia','Julungpujut','Pahang','Kuruwelut','Marakeh','Tambir','Medangkungan','Maktal','Wuye','Manahil','Prangbakat','Bala','Wugu','Wayang','Kulawu','Dukut','Watugunung'];
const WUKU_REF=Date.UTC(2023,8,10);
const PRANATA_MANGSA=[
  {no:1, nama:'Kasa (Kartika)',    mulai:[6,22], akhir:[8,1],   hari:41,simbol:'🌱',alam:'Pohon-pohon mulai kering'},
  {no:2, nama:'Karo (Pusa)',       mulai:[8,2],  akhir:[8,25],  hari:25,simbol:'🌿',alam:'Daun-daun mulai berguguran'},
  {no:3, nama:'Katelu (Manggala)', mulai:[8,26], akhir:[9,18],  hari:24,simbol:'🌾',alam:'Kemarau puncak'},
  {no:4, nama:'Kapat (Wrespati)',  mulai:[9,19], akhir:[10,13], hari:25,simbol:'🍂',alam:'Mulai ada angin perubahan'},
  {no:5, nama:'Kalima (Manggala)',mulai:[10,14],akhir:[11,9],  hari:27,simbol:'🌧',alam:'Mulai turun hujan'},
  {no:6, nama:'Kanem (Naya)',      mulai:[11,10],akhir:[12,22], hari:43,simbol:'💧',alam:'Puncak musim hujan'},
  {no:7, nama:'Kapitu (Palguna)',  mulai:[12,23],akhir:[2,3],   hari:43,simbol:'🌊',alam:'Banyak ombak besar'},
  {no:8, nama:'Kawolu (Begu)',     mulai:[2,4],  akhir:[2,28],  hari:26,simbol:'🌱',alam:'Benih padi mulai tumbuh'},
  {no:9, nama:'Kasanga (Basanta)', mulai:[3,1],  akhir:[3,25],  hari:25,simbol:'🌸',alam:'Musim semi, padi mekar'},
  {no:10,nama:'Kasepuluh (Jita)',  mulai:[3,26], akhir:[4,18],  hari:24,simbol:'☀️',alam:'Padi menguning'},
  {no:11,nama:'Dhesta (Srawana)',  mulai:[4,19], akhir:[5,11],  hari:23,simbol:'🌞',alam:'Panen padi'},
  {no:12,nama:'Sadha (Bhadra)',    mulai:[5,12], akhir:[6,21],  hari:41,simbol:'🌤',alam:'Persiapan musim tanam baru'},
];

/* ============================================================
   DATA — KALENDER CINA
   Sumber: Wikipedia Chinese calendar + chinesecalendaronline.com
============================================================ */

// Heavenly Stems 天干 Tiāngān
// elem: 0=Kayu, 1=Api, 2=Tanah, 3=Logam, 4=Air | yin: 0=Yang, 1=Yin
const TIAN_GAN=[
  {hz:'甲',py:'Jiǎ', elem:0,yin:0},{hz:'乙',py:'Yǐ',   elem:0,yin:1},
  {hz:'丙',py:'Bǐng',elem:1,yin:0},{hz:'丁',py:'Dīng', elem:1,yin:1},
  {hz:'戊',py:'Wù',  elem:2,yin:0},{hz:'己',py:'Jǐ',   elem:2,yin:1},
  {hz:'庚',py:'Gēng',elem:3,yin:0},{hz:'辛',py:'Xīn',  elem:3,yin:1},
  {hz:'壬',py:'Rén', elem:4,yin:0},{hz:'癸',py:'Guǐ',  elem:4,yin:1},
];

// Earthly Branches 地支 Dìzhī
// elem: 0=Kayu, 1=Api, 2=Tanah, 3=Logam, 4=Air
const DI_ZHI=[
  {hz:'子',py:'Zǐ',   shio:'Tikus 🐀', elem:4},  //  0
  {hz:'丑',py:'Chǒu', shio:'Kerbau 🐂',elem:2},  //  1
  {hz:'寅',py:'Yín',  shio:'Macan 🐯', elem:0},  //  2
  {hz:'卯',py:'Mǎo',  shio:'Kelinci 🐇',elem:0}, //  3
  {hz:'辰',py:'Chén', shio:'Naga 🐲',  elem:2},  //  4
  {hz:'巳',py:'Sì',   shio:'Ular 🐍',  elem:1},  //  5
  {hz:'午',py:'Wǔ',   shio:'Kuda 🐴',  elem:1},  //  6
  {hz:'未',py:'Wèi',  shio:'Kambing 🐏',elem:2}, //  7
  {hz:'申',py:'Shēn', shio:'Monyet 🐒',elem:3},  //  8
  {hz:'酉',py:'Yǒu',  shio:'Ayam 🐓',  elem:3},  //  9
  {hz:'戌',py:'Xū',   shio:'Anjing 🐕',elem:2},  // 10
  {hz:'亥',py:'Hài',  shio:'Babi 🐖',  elem:4},  // 11
];

// Wu Xing 五行 Five Elements
const WU_XING=[
  {hz:'木',py:'Mù',  id_:'Kayu', cls:'elem-wood' },
  {hz:'火',py:'Huǒ', id_:'Api',  cls:'elem-fire' },
  {hz:'土',py:'Tǔ',  id_:'Tanah',cls:'elem-earth'},
  {hz:'金',py:'Jīn', id_:'Logam',cls:'elem-metal'},
  {hz:'水',py:'Shuǐ',id_:'Air',  cls:'elem-water'},
];

// 12 Shi Chen 時辰 start times (index 0 = 子時 23:00)
const SC_TIMES=['23:00','01:00','03:00','05:00','07:00','09:00','11:00','13:00','15:00','17:00','19:00','21:00'];

// 24 Solar Terms 二十四節氣
// [month, day, hanzi, pinyin, Indonesian, type(0=节气,1=中气)]
const JIEQI=[
  [1, 6, '小寒','Xiǎo Hán',   'Dingin Ringan',       0],
  [1,20, '大寒','Dà Hán',     'Dingin Besar',        1],
  [2, 4, '立春','Lì Chūn',    'Awal Musim Semi',     0],
  [2,19, '雨水','Yǔ Shuǐ',   'Hujan Air',           1],
  [3, 6, '惊蛰','Jīng Zhé',   'Serangga Bangkit',    0],
  [3,21, '春分','Chūn Fēn',   'Ekuinoks Musim Semi', 1],
  [4, 5, '清明','Qīng Míng',  'Langit Cerah & Terang',0],
  [4,20, '谷雨','Gǔ Yǔ',     'Hujan Padi',          1],
  [5, 6, '立夏','Lì Xià',     'Awal Musim Panas',    0],
  [5,21, '小满','Xiǎo Mǎn',  'Tunas Padi',          1],
  [6, 6, '芒种','Máng Zhǒng', 'Masa Tanam Padi',     0],
  [6,21, '夏至','Xià Zhì',    'Titik Balik Panas',   1],
  [7, 7, '小暑','Xiǎo Shǔ',  'Panas Ringan',        0],
  [7,23, '大暑','Dà Shǔ',    'Panas Besar',         1],
  [8, 7, '立秋','Lì Qiū',     'Awal Musim Gugur',    0],
  [8,23, '处暑','Chǔ Shǔ',   'Akhir Panas',         1],
  [9, 8, '白露','Bái Lù',     'Embun Putih',         0],
  [9,23, '秋分','Qiū Fēn',    'Ekuinoks Gugur',      1],
  [10,8, '寒露','Hán Lù',     'Embun Dingin',        0],
  [10,23,'霜降','Shuāng Jiàng','Turun Embun Beku',   1],
  [11,7, '立冬','Lì Dōng',    'Awal Musim Dingin',   0],
  [11,22,'小雪','Xiǎo Xuě',   'Salju Ringan',        1],
  [12,7, '大雪','Dà Xuě',     'Salju Besar',         0],
  [12,22,'冬至','Dōng Zhì',   'Titik Balik Dingin',  1],
];

// Month pillar transitions: [calMonth, calDay, branchIdx]
// Each major 节气 (jiéqì) starts a new Bazi month
const MONTH_TRANS=[
  [1, 6,1],[2,4,2],[3,6,3],[4,5,4],[5,6,5],[6,6,6],
  [7,7,7],[8,7,8],[9,8,9],[10,8,10],[11,7,11],[12,7,0]
];

// Evil/Sha 煞方 direction by day branch index
// 寅(2)午(6)戌(10)→北, 申(8)子(0)辰(4)→南, 亥(11)卯(3)未(7)→西, 巳(5)酉(9)丑(1)→东
const SHA_DIR={0:'南 Selatan',1:'东 Timur',2:'北 Utara',3:'西 Barat',4:'南 Selatan',5:'东 Timur',6:'北 Utara',7:'西 Barat',8:'南 Selatan',9:'东 Timur',10:'北 Utara',11:'西 Barat'};

// Day Ganzhi reference — verified against chinesecalendaronline.com:
// 17 March 2026 = 庚寅 Gēng Yín = index 26 in 60-cycle ✓
const DAY_GZ_REF = Date.UTC(2026,2,17);
const DAY_GZ_REF_IDX = 26;

/* ============================================================
   HELPER — CINA
============================================================ */

function buildGZ(s,b){
  const tg=TIAN_GAN[s], dz=DI_ZHI[b];
  return {hz:tg.hz+dz.hz, py:tg.py+' '+dz.py, tg, dz, wx:WU_XING[tg.elem], stemIdx:s, branchIdx:b};
}

function getDayGZ(y,m,d){
  const diff=Math.round((Date.UTC(y,m-1,d)-DAY_GZ_REF)/86400000);
  const idx=((DAY_GZ_REF_IDX+diff)%60+60)%60;
  return buildGZ(idx%10, idx%12);
}

// Month Ganzhi: month changes at major 节气 (not at lunar new month)
// Verified: 2026 丙年 stem=2, Mǎo month branch=3 → stem=(2%5)*2+2+(3-2)=7=辛 → 辛卯 ✓
function getMonthGZ(y,m,d){
  let gy=y;
  if(m<2||(m===2&&d<4)) gy=y-1; // before Li Chun → previous solar year
  const yearStem=((gy-4)%10+10)%10;
  let branch=0;
  for(const[tm,td,bi] of MONTH_TRANS) if(m>tm||(m===tm&&d>=td)) branch=bi;
  const yinStem=((yearStem%5)*2+2)%10;
  const stemIdx=(yinStem+((branch-2+12)%12))%10;
  return buildGZ(stemIdx,branch);
}

// Year Ganzhi for Bazi pillar — year changes at Li Chun (~Feb 4)
// Verified: 2026 after Feb 4 = 丙午 Bǐng Wǔ ✓ (chinesecalendaronline.com Mar 17 2026)
function getYearGZ(y,m,d){
  let gy=y;
  if(m<2||(m===2&&d<4)) gy=y-1;
  return buildGZ(((gy-4)%10+10)%10, ((gy-4)%12+12)%12);
}

// Current 节气 / Solar Term
function getCurrentJieqi(m,d){
  let cur=JIEQI[JIEQI.length-1];
  for(const t of JIEQI) if(m>t[0]||(m===t[0]&&d>=t[1])) cur=t;
  return cur;
}

// 12 Shi Chen with their ganzhi
// Zi-hour stem rule: (dayStemIdx%5)*2
// Verified: 庚(6) day → ziStem=(6%5)*2=2=丙 → 子時=丙子 ✓
function getShiChen(dayStemIdx){
  const ziStem=(dayStemIdx%5)*2;
  return Array.from({length:12},(_,i)=>({
    stem: TIAN_GAN[(ziStem+i)%10],
    branch: DI_ZHI[i],
    time: SC_TIMES[i],
  }));
}

// Yellow Emperor year 黃帝紀年 (epoch 2698 BCE = year 1 → 2026 CE = 4724)
function getHuangdiYear(y,m,d){
  let gy=y; if(m<2||(m===2&&d<4)) gy=y-1;
  return gy+2697;
}

// Clash: day branch +6
function getClash(b){ return DI_ZHI[(b+6)%12]; }

// Pillar HTML card
function pillarCard(labelCn,labelId,gz){
  const yy=gz.tg.yin?'阴 Yīn':'阳 Yáng';
  return `<div class="pillar-box">
    <div class="pillar-label">${labelCn}<br>${labelId}</div>
    <div class="pillar-hz">${gz.hz}</div>
    <div class="pillar-pinyin">${gz.py}</div>
    <div class="pillar-elem ${gz.wx.cls}">${gz.wx.hz} ${gz.wx.id_}</div>
    <div style="font-size:9px;color:#9ca3af;margin-top:2px;font-family:'Noto Sans',sans-serif">${yy}</div>
  </div>`;
}

function getKalenderCina(y,m,d){
  try{
    const lunar=window.SolarLunar.solar2lunar(y,m,d);
    const yearGZ  =getYearGZ(y,m,d);
    const monthGZ =getMonthGZ(y,m,d);
    const dayGZ   =getDayGZ(y,m,d);
    const jieqi   =getCurrentJieqi(m,d);
    const shiChen =getShiChen(dayGZ.stemIdx);
    const clash   =getClash(dayGZ.branchIdx);
    const sha     =SHA_DIR[dayGZ.branchIdx];
    const huangdi =getHuangdiYear(y,m,d);
    return{
      lYear:lunar.lYear,lMonth:lunar.lMonth,lDay:lunar.lDay,
      isLeap:lunar.isLeap,monthName:lunar.monthName,dayName:lunar.dayName,
      lunarShio:DI_ZHI[lunar.lunarShioIdx].shio,
      yearGZ,monthGZ,dayGZ,jieqi,shiChen,clash,sha,huangdi
    };
  }catch(e){console.warn(e);return null;}
}

/* ============================================================
   HELPER — KALENDER JAWA
============================================================ */
function getPasaran(y,m,d){const diff=Math.round((new Date(y,m-1,d)-new Date(1972,0,1))/86400000);return PASARAN[((3+diff)%5+5)%5];}
function getSaptawara(y,m,d){return SAPTAWARA[new Date(y,m-1,d).getDay()];}
function getWarsa(jy){return WARSA_JAWA[WARSA_MOD_MAP[jy%8]];}
function getWindu(jy){return WINDU_JAWA[Math.floor(Math.abs(jy-1867)/8)%4];}
function getKurup(jy){for(const k of KURUP_LIST)if(jy>=k.mulai&&jy<=k.akhir)return k;return{nama:'Kurup baru (setelah Asapon)',mulai:1987,akhir:'?',catatan:''};}
function getWuku(y,m,d){const pos=((Math.round((Date.UTC(y,m-1,d)-WUKU_REF)/86400000))%210+210)%210;return{nama:WUKU[Math.floor(pos/7)],nomor:Math.floor(pos/7)+1,hariKe:pos%7+1};}
function getPranataMangsa(m,d){
  for(const pm of PRANATA_MANGSA){
    const[sm,sd]=pm.mulai,[em,ed]=pm.akhir;
    if(sm<=em){if((m>sm||(m===sm&&d>=sd))&&(m<em||(m===em&&d<=ed)))return pm;}
    else{if((m>sm||(m===sm&&d>=sd))||(m<em||(m===em&&d<=ed)))return pm;}
  }return null;
}
function getKalenderJawa(y,m,d,hijriData){
  if(!hijriData)return null;
  const hYear=parseInt(hijriData.year),hMonth=parseInt(hijriData.month.number),hDay=parseInt(hijriData.day);
  const jy=hYear+512,sw=getSaptawara(y,m,d),pasaran=getPasaran(y,m,d),pasData=PASARAN_DATA[pasaran];
  return{year:jy,sasi:SASI_JAWA[hMonth-1],day:hDay,sasiMakna:SASI_MAKNA[hMonth-1],sasiWarana:SASI_WARANA[hMonth-1],
    sw,pasaran,pasData,neptu:NEPTU_HARI[sw.jawa]+NEPTU_PASARAN[pasaran],
    warsa:getWarsa(jy),warsaMakna:WARSA_MAKNA[getWarsa(jy)],windu:getWindu(jy),kurup:getKurup(jy),
    wuku:getWuku(y,m,d),pranata:getPranataMangsa(m,d),weton:`${sw.jawa} ${pasaran}`};
}

/* ============================================================
   HIJRIAH FETCH
============================================================ */
const hijriCache={};
function fetchHijri(dd,mm,yyyy){
  const key=`${dd}-${mm}-${yyyy}`;
  if(hijriCache[key])return Promise.resolve(hijriCache[key]);
  return $.getJSON(`https://api.aladhan.com/v1/gToH/${String(dd).padStart(2,'0')}-${String(mm).padStart(2,'0')}-${yyyy}`)
    .then(r=>{if(r.code===200){hijriCache[key]=r.data.hijri;return r.data.hijri;}return null;}).fail(()=>null);
}
function fetchHijriForMonthTitle(y,m){
  fetchHijri(1,m+1,y).then(h=>{
    if(!h)return;
    fetchHijri(new Date(y,m+1,0).getDate(),m+1,y).then(hE=>{
      let txt;
      if(hE&&hE.month.ar!==h.month.ar){
        // spans two months
        const bd1=BULAN_HIJRI_DATA[parseInt(h.month.number)-1];
        const bd2=BULAN_HIJRI_DATA[parseInt(hE.month.number)-1];
        const s1=bd1?.sacred?'☪':'', s2=bd2?.sacred?'☪':'';
        txt=`${s1} ${h.month.en} – ${s2} ${hE.month.en} ${hE.year} H`.trim();
      }else{
        const bd=BULAN_HIJRI_DATA[parseInt(h.month.number)-1];
        const sacMark=bd?.sacred?' ☪':'';
        txt=`${h.month.en}${sacMark} ${h.year} H`;
      }
      $('#display-hijri-month').text(txt);
    });
  });
}

/* ============================================================
   RENDER KALENDER
============================================================ */
const today=new Date();
let curYear=today.getFullYear(),curMonth=today.getMonth(),selectedDate=null;

function renderCalendar(){
  const $grid=$('#cal-grid'),$headers=$('#day-headers');
  $grid.empty();$headers.empty();
  $('#display-month-year').text(new Date(curYear,curMonth).toLocaleString('id-ID',{month:'long'})+' '+curYear);
  fetchHijriForMonthTitle(curYear,curMonth);
  ['Sen','Sel','Rab','Kam','Jum','Sab','Min'].forEach((d,i)=>{
    $headers.append(`<div class="text-center text-xs font-semibold tracking-widest py-1 ${i===5?'day-header-sat':i===6?'day-header-sun':''}">${d}</div>`);
  });
  const firstDay=new Date(curYear,curMonth,1).getDay();
  const startOffset=firstDay===0?6:firstDay-1;
  const dim=new Date(curYear,curMonth+1,0).getDate(),dip=new Date(curYear,curMonth,0).getDate();
  const totalCells=Math.ceil((startOffset+dim)/7)*7;
  for(let i=0;i<totalCells;i++){
    let d,m,y,isOther=false;
    if(i<startOffset){d=dip-startOffset+i+1;m=curMonth===0?11:curMonth-1;y=curMonth===0?curYear-1:curYear;isOther=true;}
    else if(i>=startOffset+dim){d=i-startOffset-dim+1;m=curMonth===11?0:curMonth+1;y=curMonth===11?curYear+1:curYear;isOther=true;}
    else{d=i-startOffset+1;m=curMonth;y=curYear;}
    const isTdy=d===today.getDate()&&m===today.getMonth()&&y===today.getFullYear();
    const isSel=selectedDate&&d===selectedDate.d&&m===selectedDate.m&&y===selectedDate.y;
    const pas=getPasaran(y,m+1,d);
    const col=i%7;
    let cc='cal-cell py-1.5 px-1 min-h-[52px] flex flex-col items-center justify-start';
    if(isTdy)cc+=' today';if(isSel)cc+=' selected';if(isOther)cc+=' other-month';
    let nc='text-sm font-serif font-semibold leading-tight';
    if(col===6)nc+=' text-red-400';else if(col===5)nc+=' text-blue-400';else if(!isOther)nc+=' text-batik-100';
    const $c=$(`<div class="${cc}" data-d="${d}" data-m="${m}" data-y="${y}"><span class="${nc}">${d}</span><span class="text-[9px] leading-none mt-0.5 ${PASARAN_DATA[pas]?.cls||''} font-semibold">${pas.slice(0,3)}</span></div>`);
    $c.on('click',function(){selectedDate={d,m,y};renderCalendar();showDateInfo(d,m,y);});
    $grid.append($c);
  }
}

/* ============================================================
   SIDEBAR
============================================================ */
function showDateInfo(d,m,y){
  $('#sidebar-placeholder').addClass('hidden');
  $('#sidebar-content').addClass('hidden');
  $('#sidebar-loading').removeClass('hidden');

  fetchHijri(d,m+1,y).then(hijri=>{
    const cina=getKalenderCina(y,m+1,d);
    const jawa=getKalenderJawa(y,m+1,d,hijri);
    const dateObj=new Date(y,m,d);
    const namaHari=NAMA_HARI[dateObj.getDay()];

    let html=`
      <div class="mb-4">
        <p class="text-xs text-batik-400 uppercase tracking-widest font-sans mb-1">Tanggal Dipilih</p>
        <h2 class="font-display text-lg text-kraton-300 leading-tight">
          ${namaHari}, ${d} ${dateObj.toLocaleString('id-ID',{month:'long'})} ${y}
        </h2>
      </div>
      <div class="header-line mb-4"></div>`;

    /* MASEHI */
    html+=`<div class="info-card">
      <div class="card-label">📅 Masehi (Gregorian)</div>
      <div class="card-main">${d} ${dateObj.toLocaleString('id-ID',{month:'long'})} ${y}</div>
      <div class="card-sub">${namaHari}</div>
    </div>`;

    /* ============================================================
       HIJRIAH LENGKAP
       Sumber: Wikipedia Islamic Calendar + hijri-calendar.com
    ============================================================ */
    if(hijri){
      const hl = buildHijriLengkap(hijri);
      const bd = hl.bulanData;
      const sacredBadge = bd.sacred
        ? `<span style="display:inline-block;padding:1px 8px;border-radius:999px;font-size:10px;font-weight:600;background:rgba(234,179,8,.15);border:1px solid rgba(234,179,8,.3);color:#fde047">☪ بُحرُمٌ Bulan Haram</span>`
        : '';
      const istimewaBadges = hl.istimewa.map(hi =>
        `<div style="background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.28);border-radius:8px;padding:7px 10px;margin-top:5px">
          <div style="font-size:13px;font-weight:700;color:#fde68a">${hi.ikon} ${hi.nama}</div>
          <div style="font-size:10px;color:#d97706;margin-top:2px;line-height:1.4">${hi.ket}</div>
        </div>`
      ).join('');

      // Hari Islam match dari API weekday.en (format "al-Ahad", "al-Ithnayn", dll.)
      const wdEn = (hijri.weekday.en||'').toLowerCase();
      const hariData = HARI_ISLAM.find(h => wdEn.includes(h.en.toLowerCase().replace('al-','').replace('ath-','').replace('as-','').substring(0,4)));

      html+=`<div class="info-card" style="border-color:rgba(234,179,8,.25)">
        <div class="card-label" style="color:#fbbf24">☪️ Hijriah (التقويم الهجري)</div>

        <!-- Tanggal utama -->
        <div class="card-main" style="color:#fef9c3">${hl.hDay} ${bd.ar}</div>
        <div style="font-size:15px;font-weight:600;color:#fde68a;font-family:'Noto Serif',serif;margin-top:1px">
          ${bd.id} ${hl.hYear} H
        </div>
        <div style="font-size:11px;color:#d97706;margin-top:4px;font-family:'Noto Sans',sans-serif">
          Anno Hegirae ${hl.hYear} AH &nbsp;·&nbsp; Bulan ke-${hl.hMonth}/12
        </div>

        <!-- Badge sacred + posisi -->
        <div style="margin-top:6px;display:flex;flex-wrap:wrap;gap:4px;align-items:center">
          ${sacredBadge}
          <span style="display:inline-block;padding:1px 8px;border-radius:999px;font-size:10px;font-weight:600;background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.2);color:#fbbf24">${hl.posisi}</span>
        </div>

        <!-- Divider -->
        <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(234,179,8,.3),transparent);margin:10px 0"></div>

        <!-- Hari Islam + makna -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:5px;margin-bottom:8px">
          <div style="background:rgba(0,0,0,.2);border:1px solid rgba(234,179,8,.15);border-radius:8px;padding:8px 10px">
            <div style="font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#fbbf24;font-weight:600;margin-bottom:3px">Hari Islam</div>
            <div style="font-size:16px;font-weight:700;color:#fef9c3;font-family:'Noto Serif',serif">${hijri.weekday.ar}</div>
            <div style="font-size:10px;color:#d97706;margin-top:1px">${hijri.weekday.en}</div>
            ${hariData ? `<div style="font-size:10px;color:#92400e;margin-top:2px;font-style:italic">"${hariData.meaning}"</div>` : ''}
          </div>
          <div style="background:rgba(0,0,0,.2);border:1px solid rgba(234,179,8,.15);border-radius:8px;padding:8px 10px">
            <div style="font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#fbbf24;font-weight:600;margin-bottom:3px">Fase Bulan</div>
            <div style="font-size:22px;line-height:1">${hl.fase.ikon}</div>
            <div style="font-size:11px;font-weight:600;color:#fef9c3;margin-top:2px">${hl.fase.nama}</div>
            <div style="font-size:9px;color:#92400e;margin-top:1px;line-height:1.3">${hl.fase.ket}</div>
          </div>
        </div>

        <!-- Info Bulan -->
        <div style="background:rgba(0,0,0,.2);border:1px solid rgba(234,179,8,.15);border-radius:8px;padding:9px 10px;margin-bottom:6px">
          <div style="font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#fbbf24;font-weight:600;margin-bottom:4px">Info Bulan · معلومات الشهر</div>
          <div style="display:flex;align-items:baseline;gap:8px;flex-wrap:wrap;margin-bottom:4px">
            <span style="font-size:20px;font-weight:700;color:#fef9c3;font-family:'Noto Serif',serif">${bd.ar}</span>
            <span>
              <span style="font-size:12px;font-weight:600;color:#fde68a">${bd.id}</span>
              <span style="font-size:10px;color:#d97706;margin-left:4px">"${bd.meaning}"</span>
            </span>
          </div>
          <div style="font-size:10px;color:#92400e;line-height:1.5">${bd.note}</div>
          <div style="font-size:9px;color:#78350f;margin-top:3px">Normalnya ${bd.days} hari · Urutan ke-${bd.no} dari 12 bulan</div>
        </div>

        <!-- Hari Istimewa -->
        ${istimewaBadges}

        <!-- Catatan kaki -->
        <div style="font-size:9px;color:#78350f;margin-top:8px;font-family:'Noto Sans',sans-serif;line-height:1.5">
          ⓘ Tahun Hijriah = ±354–355 hari lunar · Mundur ±11 hari/tahun Gregorian · Siklus 33 tahun solar = 34 tahun Hijriah
        </div>
        <div style="font-size:9px;color:#78350f;margin-top:2px;font-family:'Noto Sans',sans-serif">
          Bulan Haram (حرام): Muharram, Rajab, Dzulqaidah, Dzulhijjah — 4 bulan dimuliakan (QS. At-Tawbah 9:36)
        </div>
      </div>`;
    }else{
      html+=`<div class="info-card"><div class="card-label">☪️ Hijriah</div><div class="card-sub text-red-400">Gagal memuat data</div></div>`;
    }

    /* ============================================================
       CINA LENGKAP
    ============================================================ */
    if(cina){
      const{lYear,lMonth,lDay,isLeap,monthName,dayName,lunarShio,
            yearGZ,monthGZ,dayGZ,jieqi,shiChen,clash,sha,huangdi}=cina;

      // Active Shi Chen: index = floor((hour+1)/2) % 12
      const isToday2=(d===today.getDate()&&m===today.getMonth()&&y===today.getFullYear());
      const nowH=new Date().getHours();
      const scActiveIdx=isToday2?Math.floor((nowH+1)/2)%12:-1;

      const leapBadge=isLeap?`<span class="badge-pill bg-yellow-900/50 text-yellow-300 text-[10px] ml-1">閏 Rùn — Kabisat</span>`:'';
      const jqColor=jieqi[5]===0?'#86efac':'#fde68a';
      const jqTypeLabel=jieqi[5]===0?'节气 Jiéqì':'中气 Zhōngqì';

      html+=`<div class="info-card" style="border-color:rgba(220,38,38,.3)">
        <div class="card-label" style="color:#f87171">🐉 Cina (農曆 Nónglì)</div>

        <!-- Tanggal Lunar -->
        <div class="card-main">${dayName} ${monthName}${leapBadge}</div>
        <div class="card-sub">Hari ke-${lDay} · Bulan ke-${lMonth} · Tahun Lunar ${lYear}</div>
        <div style="margin-top:6px;display:flex;flex-wrap:wrap;gap:4px">
          <span class="badge-pill" style="background:rgba(220,38,38,.2);border:1px solid rgba(220,38,38,.3);color:#fca5a5;font-size:11px">🐾 ${lunarShio}</span>
          <span class="badge-pill" style="background:rgba(100,116,139,.2);border:1px solid rgba(100,116,139,.3);color:#cbd5e1;font-size:11px">黃帝 ${huangdi}</span>
        </div>

        <div class="cn-divider"></div>

        <!-- 三柱 Three Pillars -->
        <div class="cn-section-label">三柱 Sān Zhù — Tiga Pilar Bazi</div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px">
          ${pillarCard('年柱','Tahun',yearGZ)}
          ${pillarCard('月柱','Bulan',monthGZ)}
          ${pillarCard('日柱','Hari', dayGZ)}
        </div>
        <div style="font-size:9px;color:#6b7280;margin-top:4px;font-family:'Noto Sans',sans-serif;line-height:1.4">
          年柱: berubah di 立春 Lì Chūn (~4 Feb) &nbsp;·&nbsp; 月柱: berubah di 节气 Jiéqì
        </div>

        <div class="cn-divider"></div>

        <!-- Clash & Sha -->
        <div class="cn-section-label">Pengaruh Hari</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:5px;margin-bottom:8px">
          <div class="cn-mini">
            <div class="cn-mini-label">沖 Chōng — Clash</div>
            <div class="cn-mini-val">${clash.hz} ${clash.py}</div>
            <div class="cn-mini-sub">${clash.shio}</div>
          </div>
          <div class="cn-mini">
            <div class="cn-mini-label">煞 Shā — Arah Sial</div>
            <div class="cn-mini-val">${sha.split(' ')[0]}</div>
            <div class="cn-mini-sub">${sha.split(' ')[1]||''}</div>
          </div>
        </div>

        <!-- 节气 Solar Term -->
        <div class="solar-term-box">
          <div style="font-size:9px;letter-spacing:.1em;text-transform:uppercase;color:#fbbf24;font-weight:600;margin-bottom:5px;font-family:'Noto Sans',sans-serif">
            ☀️ 節氣 Jiéqì — Suku Waktu Solar
          </div>
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <span style="font-size:26px;font-weight:700;color:#fef9c3;letter-spacing:3px;line-height:1">${jieqi[2]}</span>
            <div>
              <div style="font-size:14px;font-weight:700;color:#fde68a">${jieqi[3]}</div>
              <div style="font-size:11px;color:#d97706;margin-top:1px">${jieqi[4]}</div>
            </div>
            <span class="badge-pill" style="background:rgba(0,0,0,.3);border:1px solid rgba(251,191,36,.3);color:${jqColor};font-size:9px">${jqTypeLabel}</span>
          </div>
          <div style="font-size:9px;color:#92400e;margin-top:4px">Mulai sekitar: ${String(jieqi[0]).padStart(2,'0')} / ${String(jieqi[1]).padStart(2,'0')}</div>
        </div>

        <div class="cn-divider"></div>

        <!-- 十二時辰 12 Shi Chen -->
        <div class="cn-section-label">十二時辰 Shí Èr Shí Chén</div>
        <div class="shichen-grid">
          ${shiChen.map((sc,i)=>{
            const active=i===scActiveIdx;
            return`<div class="shichen-cell${active?' active':''}" title="${sc.branch.py} ${sc.time}">
              <span class="sc-stem">${sc.stem.hz}</span>
              <span class="sc-branch">${sc.branch.hz}</span>
              <span class="sc-time">${sc.time}</span>
            </div>`;
          }).join('')}
        </div>
        <div style="font-size:9px;color:#6b7280;margin-top:5px;font-family:'Noto Sans',sans-serif">
          ${isToday2?'⬛ = Shi Chen aktif · ':''}Atas = 天干 Tiāngān · Bawah = 地支 Dìzhī · Tiap slot = 2 jam
        </div>
      </div>`;
    }

    /* ============================================================
       JAWA LENGKAP
    ============================================================ */
    if(jawa){
      const pc=jawa.pasData?.cls||'';
      html+=`<div class="info-card">
        <div class="card-label">🏯 Kalender Jawa</div>
        <div class="card-main">${jawa.day} ${jawa.sasi} ${jawa.year} AJ</div>
        <div class="card-sub"><em>${jawa.sasiWarana}</em> — "${jawa.sasiMakna}"</div>
        <div class="mt-3 p-2.5 rounded-lg bg-black/20 border border-batik-800/50">
          <div class="text-[10px] uppercase tracking-widest text-batik-400 mb-1.5 font-sans font-semibold">Weton</div>
          <div class="flex items-baseline gap-2 flex-wrap">
            <span class="font-serif text-lg font-bold text-kraton-200">${jawa.weton}</span>
            <span class="badge-pill bg-kraton-900/50 border border-kraton-700/40 text-kraton-200 text-xs">Neptu <strong>${jawa.neptu}</strong></span>
          </div>
          <div class="mt-2 jawa-grid">
            <div class="jawa-mini"><div class="jawa-mini-label">Saptawara</div><div class="jawa-mini-val">${jawa.sw.jawa}</div><div class="jawa-mini-sub">${jawa.sw.skt} · ${jawa.sw.makna}</div></div>
            <div class="jawa-mini"><div class="jawa-mini-label">Pancawara</div><div class="jawa-mini-val ${pc}">${jawa.pasaran}</div><div class="jawa-mini-sub">${jawa.pasData?.makna} · ${jawa.pasData?.patrap}</div></div>
          </div>
        </div>
        <div class="mt-2 p-2.5 rounded-lg bg-black/20 border border-batik-800/50">
          <div class="text-[10px] uppercase tracking-widest text-batik-400 mb-1.5 font-sans font-semibold">Warsa & Windu</div>
          <div class="jawa-grid">
            <div class="jawa-mini"><div class="jawa-mini-label">Warsa</div><div class="jawa-mini-val text-kraton-200">${jawa.warsa}</div><div class="jawa-mini-sub">${jawa.warsaMakna}</div></div>
            <div class="jawa-mini"><div class="jawa-mini-label">Windu</div><div class="jawa-mini-val">${jawa.windu}</div><div class="jawa-mini-sub">Siklus 8-tahun</div></div>
          </div>
          <div class="mt-1.5 text-[10px] text-batik-500">Kurup: <span class="text-batik-400">${jawa.kurup.nama}</span> · ${jawa.kurup.mulai}–${jawa.kurup.akhir} AJ</div>
        </div>
        <div class="mt-2 p-2.5 rounded-lg bg-black/20 border border-batik-800/50">
          <div class="text-[10px] uppercase tracking-widest text-batik-400 mb-1.5 font-sans font-semibold">Wuku (Pawukon)</div>
          <div class="flex items-center gap-2 flex-wrap">
            <span class="badge-pill wuku-badge font-serif font-bold px-3 py-0.5 text-sm">Wuku ${jawa.wuku.nama}</span>
            <span class="text-[11px] text-batik-400">ke-${jawa.wuku.nomor}/30 · hari ${jawa.wuku.hariKe}</span>
          </div>
        </div>
        ${jawa.pranata?`<div class="mt-2 p-2.5 rounded-lg bg-black/20 border border-batik-800/50">
          <div class="text-[10px] uppercase tracking-widest text-batik-400 mb-1.5 font-sans font-semibold">Pranata Mangsa</div>
          <div class="flex items-center gap-2 flex-wrap">
            <span class="badge-pill pranata-badge font-serif font-bold">${jawa.pranata.simbol} ${jawa.pranata.nama}</span>
            <span class="text-[11px] text-batik-400">Mangsa ke-${jawa.pranata.no} (${jawa.pranata.hari} hari)</span>
          </div>
          <div class="text-[11px] text-batik-400 mt-1 italic">"${jawa.pranata.alam}"</div>
        </div>`:''}
        <div class="mt-1.5 text-[10px] text-batik-600">AJ = Anno Javanico · Kalender Sultan Agung (1555 AJ / 1633 M)</div>
      </div>`;
    }

    $('#sidebar-loading').addClass('hidden');
    $('#sidebar-content').removeClass('hidden').html(html);

  }).fail(()=>{
    $('#sidebar-loading').addClass('hidden');
    $('#sidebar-content').removeClass('hidden').html(`<div class="text-red-400 text-center py-6 text-sm">⚠️ Gagal mengambil data.<br>Periksa koneksi internet.</div>`);
  });
}

/* ============================================================
   EVENT HANDLERS & INIT
============================================================ */
$('#btn-prev').on('click',()=>{if(--curMonth<0){curMonth=11;curYear--;}renderCalendar();});
$('#btn-next').on('click',()=>{if(++curMonth>11){curMonth=0;curYear++;}renderCalendar();});
$('#btn-today').on('click',()=>{
  curYear=today.getFullYear();curMonth=today.getMonth();
  selectedDate={d:today.getDate(),m:today.getMonth(),y:today.getFullYear()};
  renderCalendar();showDateInfo(today.getDate(),today.getMonth(),today.getFullYear());
});

selectedDate={d:today.getDate(),m:today.getMonth(),y:today.getFullYear()};
renderCalendar();
showDateInfo(today.getDate(),today.getMonth(),today.getFullYear());

});
</script>
</body>
</html>