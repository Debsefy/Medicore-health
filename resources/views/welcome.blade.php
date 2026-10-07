<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediCore General Hospital — Excellence in Healthcare</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary:      #1a6fc4;
      --primary-dark: #155fa0;
      --primary-light:#e8f2ff;
      --accent:       #e8f7f0;
      --green:        #1a9e6b;
      --red:          #e53e3e;
      --gold:         #c9a84c;
      --white:        #ffffff;
      --off-white:    #f7f9fc;
      --gray-100:     #f1f5f9;
      --gray-200:     #e2e8f0;
      --gray-400:     #94a3b8;
      --gray-500:     #64748b;
      --gray-600:     #475569;
      --gray-700:     #334155;
      --gray-800:     #1e293b;
      --gray-900:     #0f172a;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      color: var(--gray-700);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      background: #fff;
    }

    a { text-decoration: none; color: inherit; }
    img { display: block; max-width: 100%; }

    /* ════════════════════════════════
       TOP BAR
    ════════════════════════════════ */
    .top-bar {
      background: var(--primary-dark);
      color: rgba(255,255,255,.85);
      font-size: 12.5px;
      padding: 8px 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .top-bar-left { display: flex; align-items: center; gap: 24px; }
    .top-bar-right{ display: flex; align-items: center; gap: 16px; }

    .top-bar-item { display: flex; align-items: center; gap: 7px; }
    .top-bar-item i { font-size: 12px; color: #90cdf4; }

    .top-bar a {
      color: rgba(255,255,255,.85);
      transition: color .2s;
    }
    .top-bar a:hover { color: #fff; }

    .emergency-tag {
      background: var(--red);
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 30px;
      letter-spacing: .5px;
      animation: pulse-red 2s infinite;
    }

    @keyframes pulse-red {
      0%,100% { box-shadow: 0 0 0 0 rgba(229,62,62,.4); }
      50%      { box-shadow: 0 0 0 6px rgba(229,62,62,0); }
    }

    /* ════════════════════════════════
       NAVBAR
    ════════════════════════════════ */
    nav {
      position: sticky;
      top: 0; left: 0; right: 0;
      z-index: 200;
      background: #fff;
      border-bottom: 1px solid var(--gray-200);
      padding: 0 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 76px;
      box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }

    .nav-brand {
      display: flex; align-items: center; gap: 12px;
    }

    .nav-brand-icon {
      width: 48px; height: 48px;
      background: linear-gradient(135deg, var(--primary), #2d9cdb);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; color: #fff;
      box-shadow: 0 4px 12px rgba(26,111,196,.3);
    }

    .nav-brand-text .name {
      font-size: 17px; font-weight: 800;
      color: var(--gray-900); letter-spacing: -.4px;
    }
    .nav-brand-text .tagline {
      font-size: 11px; color: var(--gray-400);
      text-transform: uppercase; letter-spacing: 1px;
    }

    .nav-menu {
      display: flex; align-items: center; gap: 0;
      list-style: none;
    }

    .nav-menu a {
      display: block;
      padding: 0 18px;
      font-size: 14px; font-weight: 600;
      color: var(--gray-600);
      line-height: 76px;
      border-bottom: 3px solid transparent;
      transition: all .2s;
    }

    .nav-menu a:hover,
    .nav-menu a.active {
      color: var(--primary);
      border-bottom-color: var(--primary);
    }

    .nav-cta { display: flex; align-items: center; gap: 10px; }

    .btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 10px 22px;
      font-family: inherit;
      font-size: 14px; font-weight: 600;
      border: none; border-radius: 8px;
      cursor: pointer; transition: all .2s;
    }

    .btn:hover { transform: translateY(-1px); }

    .btn-primary {
      background: var(--primary); color: #fff;
      box-shadow: 0 2px 10px rgba(26,111,196,.3);
    }
    .btn-primary:hover { background: var(--primary-dark); box-shadow: 0 4px 16px rgba(26,111,196,.4); }

    .btn-outline-primary {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
    }
    .btn-outline-primary:hover { background: var(--primary); color: #fff; }

    .btn-white {
      background: #fff; color: var(--primary);
      box-shadow: 0 2px 12px rgba(0,0,0,.12);
    }
    .btn-white:hover { box-shadow: 0 4px 20px rgba(0,0,0,.18); }

    .btn-green { background: var(--green); color: #fff; box-shadow: 0 2px 10px rgba(26,158,107,.3); }
    .btn-green:hover { background: #158a5c; }

    .btn-lg { padding: 14px 32px; font-size: 15px; border-radius: 10px; }

    /* ════════════════════════════════
       HERO
    ════════════════════════════════ */
    .hero {
      position: relative;
      min-height: 88vh;
      display: flex; align-items: center;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute; inset: 0;
      background-image: url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=1600&q=80&fit=crop');
      background-size: cover;
      background-position: center 30%;
      background-repeat: no-repeat;
    }

    .hero-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(
        100deg,
        rgba(10, 30, 70, 0.90) 0%,
        rgba(10, 30, 70, 0.78) 45%,
        rgba(10, 30, 70, 0.30) 100%
      );
    }

    .hero-content {
      position: relative; z-index: 2;
      padding: 100px 5% 80px;
      max-width: 680px;
    }

    .hero-eyebrow {
      display: inline-flex; align-items: center; gap: 10px;
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.25);
      backdrop-filter: blur(8px);
      border-radius: 30px;
      padding: 7px 18px;
      font-size: 12.5px; font-weight: 600;
      color: rgba(255,255,255,.9);
      letter-spacing: .5px;
      text-transform: uppercase;
      margin-bottom: 24px;
    }

    .hero-eyebrow .dot {
      width: 8px; height: 8px;
      background: #4ade80;
      border-radius: 50%;
      animation: blink 2s infinite;
    }

    @keyframes blink {
      0%,100% { opacity: 1; }
      50%      { opacity: .3; }
    }

    .hero h1 {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(38px, 5.5vw, 62px);
      font-weight: 700;
      color: #fff;
      line-height: 1.12;
      letter-spacing: -.5px;
      margin-bottom: 22px;
    }

    .hero h1 span {
      color: #90cdf4;
      font-style: italic;
    }

    .hero-desc {
      font-size: 17px;
      color: rgba(255,255,255,.75);
      line-height: 1.8;
      margin-bottom: 38px;
      max-width: 520px;
    }

    .hero-actions {
      display: flex; align-items: center; gap: 14px;
      flex-wrap: wrap;
      margin-bottom: 50px;
    }

    .hero-trust {
      display: flex; align-items: center; gap: 28px;
      padding-top: 32px;
      border-top: 1px solid rgba(255,255,255,.15);
    }

    .hero-trust-item { text-align: center; }

    .trust-num {
      font-size: 30px; font-weight: 800;
      color: #fff; line-height: 1;
      letter-spacing: -1px;
    }

    .trust-lbl {
      font-size: 12px; color: rgba(255,255,255,.6);
      margin-top: 3px; font-weight: 500;
    }

    .trust-divider {
      width: 1px; height: 40px;
      background: rgba(255,255,255,.2);
    }

    /* Appointment Box on hero */
    .hero-appt-box {
      position: absolute;
      right: 5%; bottom: 80px;
      z-index: 2;
      background: #fff;
      border-radius: 16px;
      padding: 24px 28px;
      width: 340px;
      box-shadow: 0 20px 60px rgba(0,0,0,.25);
      animation: rise .6s ease forwards;
    }

    @keyframes rise {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .appt-box-title {
      font-size: 16px; font-weight: 800;
      color: var(--gray-900); margin-bottom: 4px;
    }
    .appt-box-sub {
      font-size: 12.5px; color: var(--gray-500); margin-bottom: 18px;
    }

    .appt-field { margin-bottom: 12px; }
    .appt-field label {
      display: block; font-size: 11.5px; font-weight: 700;
      color: var(--gray-500); text-transform: uppercase; letter-spacing: .5px;
      margin-bottom: 5px;
    }
    .appt-field select,
    .appt-field input {
      width: 100%; padding: 9px 12px;
      font-family: inherit; font-size: 13.5px;
      border: 1.5px solid var(--gray-200);
      border-radius: 8px; outline: none;
      color: var(--gray-800);
      transition: border-color .2s;
    }
    .appt-field select:focus,
    .appt-field input:focus { border-color: var(--primary); }

    /* ════════════════════════════════
       QUICK ACCESS RIBBON
    ════════════════════════════════ */
    .ribbon {
      background: var(--primary);
      padding: 0 5%;
      display: flex;
    }

    .ribbon-item {
      flex: 1; display: flex; align-items: center; gap: 14px;
      padding: 22px 0;
      border-right: 1px solid rgba(255,255,255,.12);
      cursor: pointer; transition: background .2s;
    }

    .ribbon-item:last-child { border-right: none; }
    .ribbon-item:hover { background: rgba(255,255,255,.08); }

    .ribbon-icon {
      width: 46px; height: 46px;
      background: rgba(255,255,255,.15);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px; color: #fff; flex-shrink: 0;
      margin-left: 16px;
    }

    .ribbon-text .label { font-size: 13.5px; font-weight: 700; color: #fff; }
    .ribbon-text .sub   { font-size: 12px; color: rgba(255,255,255,.6); }

    /* ════════════════════════════════
       SECTIONS COMMON
    ════════════════════════════════ */
    section { padding: 90px 5%; }

    .section-eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 12px; font-weight: 700;
      text-transform: uppercase; letter-spacing: 1.5px;
      color: var(--primary); margin-bottom: 12px;
    }

    .section-eyebrow::before {
      content: '';
      width: 28px; height: 2px;
      background: var(--primary);
      border-radius: 2px;
    }

    .section-title {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(28px, 4vw, 42px);
      font-weight: 700;
      color: var(--gray-900);
      line-height: 1.2;
      margin-bottom: 14px;
      letter-spacing: -.3px;
    }

    .section-subtitle {
      font-size: 16px; color: var(--gray-500);
      line-height: 1.75; max-width: 540px;
    }

    .text-center { text-align: center; }
    .text-center .section-subtitle { margin: 0 auto; }

    /* ════════════════════════════════
       ABOUT SECTION
    ════════════════════════════════ */
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
      margin-top: 0;
    }

    .about-image-wrap {
      position: relative;
    }

    .about-image-wrap img {
      width: 100%; height: 460px;
      object-fit: cover;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,.15);
    }

    .about-badge {
      position: absolute;
      bottom: 28px; left: -28px;
      background: #fff;
      border-radius: 14px;
      padding: 18px 22px;
      box-shadow: 0 8px 32px rgba(0,0,0,.15);
      display: flex; align-items: center; gap: 14px;
    }

    .about-badge-icon {
      width: 52px; height: 52px;
      background: linear-gradient(135deg, var(--primary), #2d9cdb);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; color: #fff;
    }

    .about-badge-num { font-size: 26px; font-weight: 800; color: var(--gray-900); line-height: 1; }
    .about-badge-lbl { font-size: 12px; color: var(--gray-500); margin-top: 2px; }

    .about-exp-tag {
      position: absolute;
      top: 28px; right: -20px;
      background: var(--green);
      color: #fff;
      border-radius: 12px;
      padding: 14px 18px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(26,158,107,.3);
    }

    .about-exp-tag .num { font-size: 32px; font-weight: 800; line-height: 1; }
    .about-exp-tag .lbl { font-size: 11px; font-weight: 600; letter-spacing: .5px; opacity: .9; }

    .about-points { display: flex; flex-direction: column; gap: 16px; margin: 28px 0; }

    .about-point {
      display: flex; align-items: flex-start; gap: 14px;
    }

    .point-icon {
      width: 44px; height: 44px; flex-shrink: 0;
      background: var(--primary-light);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; color: var(--primary);
    }

    .point-text h4 { font-size: 14px; font-weight: 700; color: var(--gray-900); margin-bottom: 2px; }
    .point-text p  { font-size: 13px; color: var(--gray-500); line-height: 1.6; }

    /* ════════════════════════════════
       DEPARTMENTS
    ════════════════════════════════ */
    .dept-bg { background: var(--off-white); }

    .dept-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 22px;
      margin-top: 52px;
    }

    .dept-card {
      background: #fff;
      border-radius: 16px;
      padding: 28px 22px;
      text-align: center;
      border: 1px solid var(--gray-200);
      transition: all .25s;
      cursor: pointer;
    }

    .dept-card:hover {
      border-color: var(--primary);
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(26,111,196,.1);
    }

    .dept-icon {
      width: 64px; height: 64px;
      border-radius: 18px;
      display: flex; align-items: center; justify-content: center;
      font-size: 26px; margin: 0 auto 16px;
      transition: transform .25s;
    }

    .dept-card:hover .dept-icon { transform: scale(1.1); }

    .dept-card h3 { font-size: 15px; font-weight: 700; color: var(--gray-900); margin-bottom: 6px; }
    .dept-card p  { font-size: 13px; color: var(--gray-500); line-height: 1.5; }

    .dept-link {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 13px; font-weight: 600;
      color: var(--primary);
      margin-top: 12px;
    }

    /* ════════════════════════════════
       STATS BANNER
    ════════════════════════════════ */
    .stats-banner {
      background: linear-gradient(135deg, var(--primary-dark) 0%, #1a6fc4 50%, #2d9cdb 100%);
      position: relative; overflow: hidden;
      padding: 70px 5%;
    }

    .stats-banner::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='28' fill='none' stroke='rgba(255,255,255,.04)' stroke-width='1'/%3E%3C/svg%3E");
      background-size: 120px 120px;
    }

    .stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0; position: relative;
    }

    .stat-box {
      text-align: center;
      padding: 20px 10px;
      border-right: 1px solid rgba(255,255,255,.15);
    }

    .stat-box:last-child { border-right: none; }

    .stat-icon { font-size: 28px; color: rgba(255,255,255,.5); margin-bottom: 10px; }
    .stat-num  { font-size: 46px; font-weight: 800; color: #fff; line-height: 1; letter-spacing: -2px; }
    .stat-plus { font-size: 28px; vertical-align: top; }
    .stat-lbl  { font-size: 14px; color: rgba(255,255,255,.7); font-weight: 500; margin-top: 6px; }

    /* ════════════════════════════════
       DOCTORS
    ════════════════════════════════ */
    .doctors-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-top: 52px;
    }

    .doctor-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--gray-200);
      transition: all .25s;
    }

    .doctor-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,.1);
      border-color: transparent;
    }

    .doctor-photo {
      height: 220px;
      position: relative; overflow: hidden;
    }

    .doctor-photo img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .4s;
    }

    .doctor-card:hover .doctor-photo img { transform: scale(1.06); }

    .doctor-specialty {
      position: absolute; bottom: 12px; left: 12px;
      background: var(--primary);
      color: #fff;
      font-size: 11px; font-weight: 700;
      padding: 4px 10px; border-radius: 20px;
      letter-spacing: .3px;
    }

    .doctor-info { padding: 18px; }
    .doctor-info h3 { font-size: 15px; font-weight: 700; color: var(--gray-900); margin-bottom: 3px; }
    .doctor-info .role { font-size: 12.5px; color: var(--gray-500); margin-bottom: 10px; }
    .doctor-info .exp  { font-size: 12px; color: var(--green); font-weight: 600; }

    .doctor-socials { display: flex; gap: 8px; margin-top: 12px; }
    .doc-social {
      width: 30px; height: 30px;
      background: var(--gray-100);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; color: var(--gray-500);
      transition: all .2s;
    }
    .doc-social:hover { background: var(--primary); color: #fff; }

    /* ════════════════════════════════
       WHY CHOOSE US
    ════════════════════════════════ */
    .why-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }

    .why-image img {
      width: 100%; height: 480px;
      object-fit: cover;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,.12);
    }

    .why-items { display: flex; flex-direction: column; gap: 22px; }

    .why-item {
      display: flex; gap: 16px;
      padding: 20px;
      background: #fff;
      border: 1px solid var(--gray-200);
      border-radius: 14px;
      transition: all .25s;
    }

    .why-item:hover {
      border-color: var(--primary);
      box-shadow: 0 4px 20px rgba(26,111,196,.08);
    }

    .why-icon {
      width: 50px; height: 50px; flex-shrink: 0;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px;
    }

    .why-item h4 { font-size: 15px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
    .why-item p  { font-size: 13px; color: var(--gray-500); line-height: 1.6; }

    /* ════════════════════════════════
       TESTIMONIALS
    ════════════════════════════════ */
    .testi-bg { background: var(--off-white); }

    .testi-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 52px;
    }

    .testi-card {
      background: #fff;
      border-radius: 16px;
      padding: 28px;
      border: 1px solid var(--gray-200);
      position: relative;
    }

    .quote-icon {
      font-size: 40px;
      color: var(--primary);
      opacity: .12;
      position: absolute;
      top: 16px; right: 20px;
      font-family: Georgia, serif;
      line-height: 1;
    }

    .testi-stars { color: #f59e0b; font-size: 14px; margin-bottom: 14px; }
    .testi-text  { font-size: 14px; color: var(--gray-600); line-height: 1.75; margin-bottom: 18px; font-style: italic; }

    .testi-author { display: flex; align-items: center; gap: 12px; }

    .testi-avatar {
      width: 44px; height: 44px;
      border-radius: 50%; object-fit: cover;
    }

    .testi-name { font-size: 14px; font-weight: 700; color: var(--gray-900); }
    .testi-role { font-size: 12px; color: var(--gray-500); }

    /* ════════════════════════════════
       EMERGENCY CTA STRIP
    ════════════════════════════════ */
    .emergency-strip {
      background: var(--red);
      padding: 28px 5%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
    }

    .emergency-strip-left {
      display: flex; align-items: center; gap: 18px;
    }

    .emerg-icon {
      width: 56px; height: 56px;
      background: rgba(255,255,255,.2);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 24px; color: #fff;
      animation: pulse-ring 2s infinite;
    }

    @keyframes pulse-ring {
      0%   { box-shadow: 0 0 0 0 rgba(255,255,255,.4); }
      70%  { box-shadow: 0 0 0 16px rgba(255,255,255,0); }
      100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
    }

    .emerg-text h3 { font-size: 20px; font-weight: 800; color: #fff; }
    .emerg-text p  { font-size: 14px; color: rgba(255,255,255,.8); }

    .emerg-number {
      font-size: 28px; font-weight: 800; color: #fff;
      display: flex; align-items: center; gap: 10px;
    }

    /* ════════════════════════════════
       FOOTER
    ════════════════════════════════ */
    .footer-main {
      background: var(--gray-900);
      padding: 70px 5% 40px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.5fr;
      gap: 48px;
      margin-bottom: 48px;
    }

    .footer-brand .logo {
      display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
    }

    .footer-brand .logo-icon {
      width: 40px; height: 40px;
      background: linear-gradient(135deg, var(--primary), #2d9cdb);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; color: #fff;
    }

    .footer-brand .logo-name {
      font-size: 18px; font-weight: 800; color: #fff;
    }

    .footer-brand p {
      font-size: 13.5px; color: var(--gray-400);
      line-height: 1.75; margin-bottom: 20px;
    }

    .footer-socials { display: flex; gap: 10px; }

    .f-social {
      width: 36px; height: 36px;
      background: rgba(255,255,255,.07);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; color: var(--gray-400);
      transition: all .2s;
    }

    .f-social:hover { background: var(--primary); color: #fff; }

    .footer-col h4 {
      font-size: 13px; font-weight: 700;
      text-transform: uppercase; letter-spacing: 1px;
      color: #fff; margin-bottom: 20px;
    }

    .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }

    .footer-links li a {
      font-size: 13.5px; color: var(--gray-400);
      transition: color .2s;
      display: flex; align-items: center; gap: 7px;
    }

    .footer-links li a::before {
      content: '→';
      font-size: 11px;
      opacity: 0;
      transition: opacity .2s;
    }

    .footer-links li a:hover { color: #fff; }
    .footer-links li a:hover::before { opacity: 1; }

    .footer-contact-item {
      display: flex; align-items: flex-start; gap: 12px;
      margin-bottom: 14px;
    }

    .footer-contact-item i {
      color: var(--primary); font-size: 14px;
      margin-top: 2px; flex-shrink: 0;
    }

    .footer-contact-item span {
      font-size: 13.5px; color: var(--gray-400); line-height: 1.5;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.07);
      padding-top: 28px;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 12px;
    }

    .footer-bottom p {
      font-size: 13px; color: var(--gray-500);
    }

    .footer-bottom-links {
      display: flex; gap: 20px; list-style: none;
    }

    .footer-bottom-links a {
      font-size: 13px; color: var(--gray-500);
      transition: color .2s;
    }

    .footer-bottom-links a:hover { color: #fff; }

    /* ════════════════════════════════
       RESPONSIVE
    ════════════════════════════════ */
    @media (max-width: 1100px) {
      .hero-appt-box { display: none; }
      .dept-grid, .doctors-grid { grid-template-columns: repeat(2, 1fr); }
      .footer-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .top-bar-left .top-bar-item:not(:first-child) { display: none; }
      .nav-menu { display: none; }
      .about-grid, .why-grid { grid-template-columns: 1fr; }
      .dept-grid, .doctors-grid, .testi-grid { grid-template-columns: 1fr; }
      .stats-row { grid-template-columns: repeat(2, 1fr); }
      .ribbon { flex-direction: column; }
      .ribbon-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,.1); }
      .footer-grid { grid-template-columns: 1fr; gap: 28px; }
      .about-badge { left: 12px; }
      .about-exp-tag { right: 12px; }
    }
  </style>
</head>
<body>

<!-- ── TOP BAR ─────────────────────────────── -->
<div class="top-bar">
  <div class="top-bar-left">
    <div class="top-bar-item">
      <i class="fas fa-clock"></i>
      <span>Mon–Fri: 8:00 AM – 8:00 PM &nbsp;|&nbsp; Sat–Sun: 9:00 AM – 5:00 PM</span>
    </div>
    <div class="top-bar-item">
      <i class="fas fa-map-marker-alt"></i>
      <span>14 Healthcare Avenue, Victoria Island, Lagos</span>
    </div>
  </div>
  <div class="top-bar-right">
    <span class="emergency-tag"><i class="fas fa-ambulance"></i> &nbsp;24/7 Emergency</span>
    <div class="top-bar-item">
      <i class="fas fa-phone"></i>
      <a href="tel:+2348001234567">+234 800 123 4567</a>
    </div>
  </div>
</div>

<!-- ── NAVBAR ──────────────────────────────── -->
<nav>
  <div class="nav-brand">
    <div class="nav-brand-icon"><i class="fas fa-hospital"></i></div>
    <div class="nav-brand-text">
      <div class="name">MediCore Hospital</div>
      <div class="tagline">Excellence in Healthcare</div>
    </div>
  </div>

  <ul class="nav-menu">
    <li><a href="#home" class="active">Home</a></li>
    <li><a href="#about">About Us</a></li>
    <li><a href="#departments">Departments</a></li>
    <li><a href="#doctors">Our Doctors</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>

  <div class="nav-cta">
    <a href="{{ route('login') }}" class="btn btn-outline-primary">
      <i class="fas fa-user-circle"></i> Staff Login
    </a>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
      <i class="fas fa-calendar-plus"></i> Book Appointment
    </a>
  </div>
</nav>

<!-- ── HERO ───────────────────────────────── -->
<section class="hero" id="home">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-eyebrow">
      <span class="dot"></span>
      Accredited Center of Medical Excellence
    </div>

    <h1>Your Health Is Our<br><span>Greatest Priority</span></h1>

    <p class="hero-desc">
      MediCore General Hospital provides world-class healthcare services with a team of over 120 specialist doctors, cutting-edge technology, and compassionate nursing care — available 24 hours a day.
    </p>

    <div class="hero-actions">
      <a href="{{ route('register') }}" class="btn btn-white btn-lg">
        <i class="fas fa-calendar-plus"></i> Book Appointment
      </a>
      <a href="#departments" class="btn btn-lg" style="background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.3);color:#fff;backdrop-filter:blur(8px);">
        <i class="fas fa-th-large"></i> Our Services
      </a>
    </div>

    <div class="hero-trust">
      <div class="hero-trust-item">
        <div class="trust-num">25+</div>
        <div class="trust-lbl">Years of Service</div>
      </div>
      <div class="trust-divider"></div>
      <div class="hero-trust-item">
        <div class="trust-num">120+</div>
        <div class="trust-lbl">Specialist Doctors</div>
      </div>
      <div class="trust-divider"></div>
      <div class="hero-trust-item">
        <div class="trust-num">50K+</div>
        <div class="trust-lbl">Patients Treated</div>
      </div>
      <div class="trust-divider"></div>
      <div class="hero-trust-item">
        <div class="trust-num">98%</div>
        <div class="trust-lbl">Patient Satisfaction</div>
      </div>
    </div>
  </div>

  <!-- Quick Appointment Box -->
  <div class="hero-appt-box">
    <div class="appt-box-title">Book an Appointment</div>
    <div class="appt-box-sub">Quick online booking — confirmed instantly</div>
    <div class="appt-field">
      <label>Department</label>
      <select>
        <option>— Select Department —</option>
        <option>Cardiology</option>
        <option>Neurology</option>
        <option>Pediatrics</option>
        <option>Gynecology</option>
        <option>Orthopedics</option>
        <option>General Practice</option>
      </select>
    </div>
    <div class="appt-field">
      <label>Preferred Date</label>
      <input type="date" min="{{ date('Y-m-d') }}">
    </div>
    <div class="appt-field">
      <label>Full Name</label>
      <input type="text" placeholder="Your full name">
    </div>
    <a href="{{ route('register') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:6px;border-radius:8px;">
      <i class="fas fa-arrow-right"></i> Continue Booking
    </a>
  </div>
</section>

<!-- ── QUICK ACCESS RIBBON ────────────────── -->
<div class="ribbon">
  <div class="ribbon-item">
    <div class="ribbon-icon"><i class="fas fa-ambulance"></i></div>
    <div class="ribbon-text">
      <div class="label">Emergency Care</div>
      <div class="sub">24/7 emergency response</div>
    </div>
  </div>
  <div class="ribbon-item">
    <div class="ribbon-icon"><i class="fas fa-calendar-check"></i></div>
    <div class="ribbon-text">
      <div class="label">Book Appointment</div>
      <div class="sub">Quick & easy scheduling</div>
    </div>
  </div>
  <div class="ribbon-item">
    <div class="ribbon-icon"><i class="fas fa-flask"></i></div>
    <div class="ribbon-text">
      <div class="label">Laboratory</div>
      <div class="sub">Fast accurate test results</div>
    </div>
  </div>
  <div class="ribbon-item">
    <div class="ribbon-icon"><i class="fas fa-pills"></i></div>
    <div class="ribbon-text">
      <div class="label">Pharmacy</div>
      <div class="sub">In-house dispensary</div>
    </div>
  </div>
</div>

<!-- ── ABOUT SECTION ──────────────────────── -->
<section id="about">
  <div class="about-grid">
    <div class="about-image-wrap">
      <img src="https://images.unsplash.com/photo-1551190822-a9333d879b1f?w=800&q=80&fit=crop" alt="Our Hospital">
      <div class="about-badge">
        <div class="about-badge-icon"><i class="fas fa-award"></i></div>
        <div>
          <div class="about-badge-num">ISO 9001</div>
          <div class="about-badge-lbl">Certified Hospital</div>
        </div>
      </div>
      <div class="about-exp-tag">
        <div class="num">25</div>
        <div class="lbl">Years of<br>Excellence</div>
      </div>
    </div>

    <div>
      <div class="section-eyebrow">About MediCore</div>
      <h2 class="section-title">Dedicated to Your Health & Well-Being</h2>
      <p style="font-size:15px;color:var(--gray-500);line-height:1.8;margin-bottom:24px;">
        Founded in 1999, MediCore General Hospital has grown into one of Nigeria's most trusted healthcare institutions. We combine advanced medical technology with genuine compassion to deliver exceptional patient outcomes across all specialties.
      </p>

      <div class="about-points">
        <div class="about-point">
          <div class="point-icon"><i class="fas fa-user-md"></i></div>
          <div class="point-text">
            <h4>Expert Medical Team</h4>
            <p>Over 120 board-certified specialists and consultants across 18 departments.</p>
          </div>
        </div>
        <div class="about-point">
          <div class="point-icon"><i class="fas fa-microscope"></i></div>
          <div class="point-text">
            <h4>Advanced Technology</h4>
            <p>State-of-the-art diagnostic equipment including MRI, CT scans, and digital X-ray.</p>
          </div>
        </div>
        <div class="about-point">
          <div class="point-icon"><i class="fas fa-heart"></i></div>
          <div class="point-text">
            <h4>Patient-Centered Care</h4>
            <p>Every treatment plan is personalised — your comfort and recovery are our mission.</p>
          </div>
        </div>
      </div>

      <div style="display:flex;gap:14px;flex-wrap:wrap;">
        <a href="#departments" class="btn btn-primary btn-lg">
          <i class="fas fa-th-large"></i> Our Departments
        </a>
        <a href="{{ route('register') }}" class="btn btn-lg" style="background:var(--primary-light);color:var(--primary);">
          <i class="fas fa-calendar-plus"></i> Book Appointment
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ── DEPARTMENTS ─────────────────────────── -->
<section class="dept-bg" id="departments">
  <div class="text-center">
    <div class="section-eyebrow">Departments</div>
    <h2 class="section-title">World-Class Medical Departments</h2>
    <p class="section-subtitle">From routine check-ups to complex surgeries, our departments are equipped to handle all your healthcare needs.</p>
  </div>

  <div class="dept-grid">
    @php
    $depts = [
      ['fa-heart','#fee2e2','#ef4444','Cardiology','Heart disease diagnosis, treatment, and cardiac surgery.'],
      ['fa-brain','#ede9fe','#7c3aed','Neurology','Brain, spine, and nervous system disorders.'],
      ['fa-baby','#fce7f3','#db2777','Pediatrics','Comprehensive care for infants, children and adolescents.'],
      ['fa-female','#e0f2fe','#0284c7','Gynecology','Women\'s reproductive health and obstetric care.'],
      ['fa-bone','#fef3c7','#d97706','Orthopedics','Bone, joint, and muscle conditions and surgery.'],
      ['fa-eye','#dcfce7','#16a34a','Ophthalmology','Eye care, vision correction, and eye surgery.'],
      ['fa-tooth','#f0fdf4','#15803d','Dentistry','General dentistry, orthodontics, and oral surgery.'],
      ['fa-lungs','#fff7ed','#ea580c','Pulmonology','Respiratory conditions, asthma, and lung disease.'],
    ];
    @endphp

    @foreach($depts as [$icon,$bg,$color,$name,$desc])
    <div class="dept-card">
      <div class="dept-icon" style="background:{{ $bg }};color:{{ $color }};">
        <i class="fas {{ $icon }}"></i>
      </div>
      <h3>{{ $name }}</h3>
      <p>{{ $desc }}</p>
      <span class="dept-link">Learn More <i class="fas fa-arrow-right" style="font-size:11px;"></i></span>
    </div>
    @endforeach
  </div>
</section>

<!-- ── STATS BANNER ───────────────────────── -->
<div class="stats-banner">
  <div class="stats-row">
    <div class="stat-box">
      <div class="stat-icon"><i class="fas fa-user-injured"></i></div>
      <div class="stat-num">50<span class="stat-plus">K</span>+</div>
      <div class="stat-lbl">Patients Treated</div>
    </div>
    <div class="stat-box">
      <div class="stat-icon"><i class="fas fa-user-md"></i></div>
      <div class="stat-num">120<span class="stat-plus">+</span></div>
      <div class="stat-lbl">Specialist Doctors</div>
    </div>
    <div class="stat-box">
      <div class="stat-icon"><i class="fas fa-procedures"></i></div>
      <div class="stat-num">8<span class="stat-plus">K</span>+</div>
      <div class="stat-lbl">Surgeries Performed</div>
    </div>
    <div class="stat-box">
      <div class="stat-icon"><i class="fas fa-star"></i></div>
      <div class="stat-num">98<span class="stat-plus">%</span></div>
      <div class="stat-lbl">Patient Satisfaction</div>
    </div>
  </div>
</div>

<!-- ── DOCTORS ────────────────────────────── -->
<section id="doctors">
  <div class="text-center">
    <div class="section-eyebrow">Our Specialists</div>
    <h2 class="section-title">Meet Our Expert Doctors</h2>
    <p class="section-subtitle">Our team of highly trained and compassionate specialists are committed to providing you with the best possible care.</p>
  </div>

  <div class="doctors-grid">
    @php
    $doctors = [
      ['https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&q=80&fit=crop&face','Dr. James Adeyemi','Chief Cardiologist','12 yrs experience','Cardiology'],
      ['https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=80&fit=crop&face','Dr. Amina Hassan','Senior Pediatrician','8 yrs experience','Pediatrics'],
      ['https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&q=80&fit=crop&face','Dr. Emmanuel Eze','Lead Neurologist','10 yrs experience','Neurology'],
      ['https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400&q=80&fit=crop&face','Dr. Fatima Bello','OB/GYN Consultant','9 yrs experience','Gynecology'],
    ];
    @endphp

    @foreach($doctors as [$photo,$name,$role,$exp,$spec])
    <div class="doctor-card">
      <div class="doctor-photo">
        <img src="{{ $photo }}" alt="{{ $name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($name) }}&size=400&background=1a6fc4&color=fff'">
        <span class="doctor-specialty">{{ $spec }}</span>
      </div>
      <div class="doctor-info">
        <h3>{{ $name }}</h3>
        <div class="role">{{ $role }}</div>
        <div class="exp"><i class="fas fa-check-circle"></i> {{ $exp }}</div>
        <div class="doctor-socials">
          <a href="#" class="doc-social"><i class="fas fa-calendar-plus"></i></a>
          <a href="#" class="doc-social"><i class="fas fa-envelope"></i></a>
          <a href="#" class="doc-social"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div style="text-align:center;margin-top:40px;">
    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
      <i class="fas fa-users"></i> View All Doctors
    </a>
  </div>
</section>

<!-- ── WHY CHOOSE US ──────────────────────── -->
<section style="background:var(--off-white);">
  <div class="why-grid">
    <div class="why-image">
      <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=800&q=80&fit=crop" alt="Modern Hospital Facility" onerror="this.src='https://images.unsplash.com/photo-1516549655169-df83a0774514?w=800&q=80&fit=crop'">
    </div>
    <div>
      <div class="section-eyebrow">Why Choose Us</div>
      <h2 class="section-title">A Hospital You Can Trust</h2>
      <p style="font-size:15px;color:var(--gray-500);line-height:1.8;margin-bottom:28px;">
        We don't just treat illness — we build lasting relationships with our patients and community, grounded in trust, transparency, and excellence.
      </p>

      <div class="why-items">
        <div class="why-item">
          <div class="why-icon" style="background:#dbeafe;color:#1a6fc4;"><i class="fas fa-clock"></i></div>
          <div>
            <h4>24/7 Emergency Services</h4>
            <p>Our emergency department is always open, with rapid response teams available around the clock.</p>
          </div>
        </div>
        <div class="why-item">
          <div class="why-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-shield-alt"></i></div>
          <div>
            <h4>Internationally Accredited</h4>
            <p>ISO 9001 certified with JCI accreditation — meeting the highest global standards in patient safety.</p>
          </div>
        </div>
        <div class="why-item">
          <div class="why-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-microscope"></i></div>
          <div>
            <h4>Advanced Diagnostics</h4>
            <p>Fully equipped lab, digital imaging, MRI, CT scans — with results available same day.</p>
          </div>
        </div>
        <div class="why-item">
          <div class="why-icon" style="background:#ede9fe;color:#7c3aed;"><i class="fas fa-hand-holding-heart"></i></div>
          <div>
            <h4>Affordable Quality Care</h4>
            <p>Flexible payment plans, HMO acceptance, and a dedicated financial counselling service.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ───────────────────────── -->
<section class="testi-bg" id="testimonials">
  <div class="text-center">
    <div class="section-eyebrow">Patient Stories</div>
    <h2 class="section-title">What Our Patients Say</h2>
    <p class="section-subtitle">Real stories from real patients — their trust and satisfaction drive everything we do.</p>
  </div>

  <div class="testi-grid">
    <div class="testi-card">
      <div class="quote-icon">"</div>
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"The level of care I received at MediCore was outstanding. The doctors were thorough, the nurses were kind, and I felt genuinely looked after throughout my entire stay."</p>
      <div class="testi-author">
        <img src="https://ui-avatars.com/api/?name=Chioma+Obi&background=1a6fc4&color=fff&size=80" class="testi-avatar" alt="">
        <div>
          <div class="testi-name">Chioma Obi</div>
          <div class="testi-role">Cardiac Patient, 2024</div>
        </div>
      </div>
    </div>

    <div class="testi-card">
      <div class="quote-icon">"</div>
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"My son was treated by Dr. Amina and the pediatrics team. They were exceptional — patient, professional, and very reassuring. We always come back to MediCore."</p>
      <div class="testi-author">
        <img src="https://ui-avatars.com/api/?name=Tunde+Bakare&background=10b981&color=fff&size=80" class="testi-avatar" alt="">
        <div>
          <div class="testi-name">Tunde Bakare</div>
          <div class="testi-role">Parent of Paediatric Patient</div>
        </div>
      </div>
    </div>

    <div class="testi-card">
      <div class="quote-icon">"</div>
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"After my surgery, the recovery support was incredible. The physiotherapy team and follow-up care gave me my life back. I cannot recommend MediCore highly enough."</p>
      <div class="testi-author">
        <img src="https://ui-avatars.com/api/?name=Ngozi+Eze&background=f59e0b&color=fff&size=80" class="testi-avatar" alt="">
        <div>
          <div class="testi-name">Ngozi Eze</div>
          <div class="testi-role">Orthopaedic Surgery Patient</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── EMERGENCY STRIP ─────────────────────── -->
<div class="emergency-strip">
  <div class="emergency-strip-left">
    <div class="emerg-icon"><i class="fas fa-ambulance"></i></div>
    <div class="emerg-text">
      <h3>Medical Emergency?</h3>
      <p>Our emergency team is ready 24 hours a day, 7 days a week.</p>
    </div>
  </div>
  <div class="emerg-number">
    <i class="fas fa-phone-volume"></i>
    <span>+234 800 123 4567</span>
  </div>
  <a href="{{ route('register') }}" class="btn btn-white btn-lg">
    <i class="fas fa-calendar-plus"></i> Book Appointment
  </a>
</div>

<!-- ── FOOTER ─────────────────────────────── -->
<footer class="footer-main" id="contact">
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">
        <div class="logo-icon"><i class="fas fa-hospital"></i></div>
        <div class="logo-name">MediCore Hospital</div>
      </div>
      <p>Providing world-class healthcare with compassion and excellence since 1999. Your health is our mission.</p>
      <div class="footer-socials">
        <a href="#" class="f-social"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="f-social"><i class="fab fa-twitter"></i></a>
        <a href="#" class="f-social"><i class="fab fa-instagram"></i></a>
        <a href="#" class="f-social"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="f-social"><i class="fab fa-youtube"></i></a>
      </div>
    </div>

    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul class="footer-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#departments">Departments</a></li>
        <li><a href="#doctors">Our Doctors</a></li>
        <li><a href="{{ route('login') }}">Patient Portal</a></li>
        <li><a href="{{ route('register') }}">Book Appointment</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Departments</h4>
      <ul class="footer-links">
        <li><a href="#">Cardiology</a></li>
        <li><a href="#">Neurology</a></li>
        <li><a href="#">Pediatrics</a></li>
        <li><a href="#">Gynecology</a></li>
        <li><a href="#">Orthopedics</a></li>
        <li><a href="#">Emergency</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Contact Us</h4>
      <div class="footer-contact-item">
        <i class="fas fa-map-marker-alt"></i>
        <span>14 Healthcare Avenue,<br>Victoria Island, Lagos, Nigeria</span>
      </div>
      <div class="footer-contact-item">
        <i class="fas fa-phone"></i>
        <span>+234 800 123 4567<br>+234 800 765 4321</span>
      </div>
      <div class="footer-contact-item">
        <i class="fas fa-envelope"></i>
        <span>info@medicorehospital.com<br>appointments@medicorehospital.com</span>
      </div>
      <div class="footer-contact-item">
        <i class="fas fa-clock"></i>
        <span>Mon–Fri: 8:00 AM – 8:00 PM<br>Emergency: 24 / 7</span>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© {{ date('Y') }} MediCore General Hospital. All rights reserved.</p>
    <ul class="footer-bottom-links">
      <li><a href="#">Privacy Policy</a></li>
      <li><a href="#">Terms of Use</a></li>
      <li><a href="{{ route('login') }}">Staff Portal</a></li>
    </ul>
  </div>
</footer>

<script>
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Active nav on scroll
  const sections = document.querySelectorAll('section[id], div[id]');
  const navLinks  = document.querySelectorAll('.nav-menu a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(s => {
      if (window.scrollY >= s.offsetTop - 100) current = s.id;
    });
    navLinks.forEach(a => {
      a.classList.toggle('active', a.getAttribute('href') === '#' + current);
    });
  });

  // Counter animation
  const nums = document.querySelectorAll('.trust-num, .stat-num');
  const io   = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el     = entry.target;
      const full   = el.textContent;
      const digits = parseInt(full.replace(/\D/g, ''));
      if (!digits) return;
      const suffix = full.replace(/[\d]/g, '');
      let cur = 0;
      const step = Math.max(1, Math.floor(digits / 50));
      const t = setInterval(() => {
        cur = Math.min(cur + step, digits);
        el.innerHTML = cur + suffix;
        if (cur >= digits) clearInterval(t);
      }, 30);
      io.unobserve(el);
    });
  }, { threshold: 0.5 });
  nums.forEach(n => io.observe(n));
</script>

</body>
</html>
