@php
    $faviconPng = file_exists(public_path('favicon.png')) ? asset('favicon.png') : null;
    $faviconIco = asset('favicon.ico');
    $brandLogo = $faviconPng ?? $faviconIco;

    foreach (['images/logo.png', 'images/logo.jpg', 'images/logo.jpeg'] as $logoPath) {
        if (file_exists(public_path($logoPath))) {
            $brandLogo = asset($logoPath);
            break;
        }
    }
@endphp

<link rel="icon" type="image/png" href="{{ $faviconPng ?? $faviconIco }}">
<link rel="shortcut icon" href="{{ $faviconPng ?? $faviconIco }}">
<link rel="apple-touch-icon" href="{{ $faviconPng ?? $faviconIco }}">

<style>
    /* Posisikan badge lebih dekat ke icon lonceng */
    .fi-topbar-database-notifications-btn {
        position: relative !important;
    }

    .fi-topbar-database-notifications-btn .fi-icon-btn-badge-ctn {
        position: absolute !important;
        top: 5px !important;
        right: 5px !important;
        z-index: 10 !important;
    }

    /* Notification badge - warna merah menyala dengan glow effect */
    .fi-topbar-database-notifications-btn .fi-badge {
        background-color: #ef4444 !important; /* Merah menyala */
        color: white !important;
        font-weight: 700 !important;
        min-width: 1.25rem !important;
        height: 1.25rem !important;
        padding: 0.125rem 0.375rem !important;
        font-size: 0.65rem !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5), 0 0 12px rgba(239, 68, 68, 0.3) !important;
        border: 2px solid white !important;
        border-radius: 9999px !important;
        animation: pulse-red 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Dark mode */
    .dark .fi-topbar-database-notifications-btn .fi-badge {
        border-color: rgb(31 41 55) !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6), 0 0 15px rgba(239, 68, 68, 0.4) !important;
    }

    /* Animasi pulse */
    @keyframes pulse-red {
        0%, 100% {
            opacity: 1;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5), 0 0 12px rgba(239, 68, 68, 0.3);
        }
        50% {
            opacity: 0.9;
            transform: scale(1.08);
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.6), 0 0 18px rgba(239, 68, 68, 0.5);
        }
    }

    .fi-simple-layout {
        min-height: 100vh;
        background:
            linear-gradient(135deg, rgba(14, 165, 233, 0.14), transparent 32%),
            linear-gradient(315deg, rgba(22, 163, 74, 0.10), transparent 28%),
            #f6f8fb !important;
        isolation: isolate;
        overflow: hidden;
        position: relative;
    }

    .fi-simple-layout::before {
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(15, 23, 42, 0.055) 1px, transparent 1px);
        background-size: 42px 42px;
        content: '';
        inset: 0;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent 78%);
        pointer-events: none;
        position: absolute;
        z-index: -1;
    }

    .fi-simple-main-ctn {
        padding: 2rem 1.25rem !important;
    }

    .fi-simple-main {
        background: rgba(255, 255, 255, 0.94) !important;
        border: 1px solid rgba(148, 163, 184, 0.28) !important;
        border-radius: 8px !important;
        box-shadow: 0 22px 70px rgba(15, 23, 42, 0.13), 0 1px 2px rgba(15, 23, 42, 0.04) !important;
        max-width: 430px !important;
        padding: 2.25rem !important;
    }

    .fi-simple-page-content {
        gap: 0.45rem !important;
    }

    .fi-simple-header {
        align-items: center !important;
        margin-bottom: 0.2rem !important;
        text-align: center !important;
    }

    .fi-simple-header .fi-logo {
        align-items: center;
        color: #0f172a !important;
        column-gap: 0.85rem;
        display: inline-grid;
        font-size: 1.35rem !important;
        font-weight: 700 !important;
        grid-template-columns: auto minmax(0, 1fr);
        grid-template-rows: auto auto;
        justify-items: start;
        letter-spacing: 0 !important;
        line-height: 1.2;
        max-width: 100%;
        text-align: left !important;
    }

    .fi-simple-header .fi-logo::before {
        align-self: center;
        background: #ffffff url('{{ $brandLogo }}') center / 76% auto no-repeat;
        border: 1px solid rgba(14, 165, 233, 0.18);
        border-radius: 8px;
        box-shadow: 0 8px 22px rgba(14, 165, 233, 0.16);
        content: '';
        display: inline-block;
        grid-column: 1;
        grid-row: 1 / span 2;
        height: 3.35rem;
        width: 3.35rem;
    }

    .fi-simple-header .fi-logo::after {
        color: #64748b;
        content: 'Sistem pengecekan mesin dan maintenance operasional';
        display: block;
        font-size: 0.82rem;
        font-weight: 500;
        grid-column: 2;
        grid-row: 2;
        line-height: 1.45;
        max-width: 18rem;
        text-align: left;
    }

    .fi-simple-header-heading {
        align-self: stretch !important;
        color: #111827 !important;
        font-size: 1.55rem !important;
        font-weight: 700 !important;
        letter-spacing: 0 !important;
        line-height: 1.25 !important;
        margin-top: 1rem !important;
        margin-bottom: 0 !important;
        text-align: left !important;
        width: 100% !important;
    }

    .fi-simple-main form {
        gap: 1.15rem !important;
    }

    .fi-simple-main .fi-fo-field-wrp-label span,
    .fi-simple-main .fi-checkbox-input + span {
        color: #1f2937 !important;
        font-weight: 600 !important;
    }

    .fi-simple-main .fi-input-wrp {
        background: #ffffff !important;
        border: 1px solid rgba(148, 163, 184, 0.55) !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04) !important;
        min-height: 2.85rem !important;
        transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease !important;
    }

    .fi-simple-main .fi-input-wrp:focus-within {
        border-color: rgb(14, 165, 233) !important;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12) !important;
    }

    .fi-simple-main .fi-input {
        color: #111827 !important;
        font-size: 0.95rem !important;
    }

    .fi-simple-main .fi-input::placeholder {
        color: #9ca3af !important;
    }

    .fi-simple-main .fi-checkbox-input {
        border-radius: 5px !important;
    }

    .fi-simple-main .fi-btn,
    .fi-simple-main .fi-btn.fi-color-primary,
    .fi-simple-main .fi-btn-primary {
        border-radius: 8px !important;
        font-weight: 700 !important;
        min-height: 2.85rem !important;
    }

    .fi-simple-main .fi-btn.fi-color-primary,
    .fi-simple-main .fi-btn-primary {
        background: #0284c7 !important;
        box-shadow: 0 10px 22px rgba(2, 132, 199, 0.22) !important;
    }

    .fi-simple-main .fi-btn.fi-color-primary:hover,
    .fi-simple-main .fi-btn-primary:hover {
        background: #0369a1 !important;
        transform: translateY(-1px);
    }

    .dark .fi-simple-layout,
    :root.dark .fi-simple-layout {
        background:
            linear-gradient(135deg, rgba(14, 165, 233, 0.12), transparent 34%),
            linear-gradient(315deg, rgba(34, 197, 94, 0.08), transparent 30%),
            #090b10 !important;
    }

    .dark .fi-simple-layout::before,
    :root.dark .fi-simple-layout::before {
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
    }

    .dark .fi-simple-main,
    :root.dark .fi-simple-main {
        background: rgba(24, 24, 27, 0.94) !important;
        border-color: rgba(63, 63, 70, 0.82) !important;
        box-shadow: 0 22px 70px rgba(0, 0, 0, 0.35), 0 1px 0 rgba(255, 255, 255, 0.04) inset !important;
    }

    .dark .fi-simple-header .fi-logo,
    .dark .fi-simple-header-heading,
    :root.dark .fi-simple-header .fi-logo,
    :root.dark .fi-simple-header-heading {
        color: #f8fafc !important;
    }

    .dark .fi-simple-header .fi-logo::before,
    :root.dark .fi-simple-header .fi-logo::before {
        background-color: #ffffff;
        border-color: rgba(14, 165, 233, 0.24);
    }

    .dark .fi-simple-header .fi-logo::after,
    :root.dark .fi-simple-header .fi-logo::after {
        color: #a1a1aa;
    }

    .dark .fi-simple-main .fi-fo-field-wrp-label span,
    .dark .fi-simple-main .fi-checkbox-input + span,
    :root.dark .fi-simple-main .fi-fo-field-wrp-label span,
    :root.dark .fi-simple-main .fi-checkbox-input + span {
        color: #f3f4f6 !important;
    }

    .dark .fi-simple-main .fi-input-wrp,
    :root.dark .fi-simple-main .fi-input-wrp {
        background: rgba(39, 39, 42, 0.92) !important;
        border-color: rgba(82, 82, 91, 0.86) !important;
    }

    .dark .fi-simple-main .fi-input,
    :root.dark .fi-simple-main .fi-input {
        color: #f8fafc !important;
    }

    .dark .fi-simple-main .fi-input::placeholder,
    :root.dark .fi-simple-main .fi-input::placeholder {
        color: #71717a !important;
    }

    @media (max-width: 640px) {
        .fi-simple-main {
            padding: 1.6rem !important;
        }

        .fi-simple-header-heading {
            font-size: 1.35rem !important;
        }
    }

    .fi-simple-page:has(> .system-login-panel) {
        display: grid;
        grid-template-columns: minmax(280px, 0.92fr) minmax(360px, 1fr);
        min-height: 540px;
    }

    .fi-simple-main:has(.system-login-panel) {
        background: #ffffff !important;
        border: 1px solid rgba(148, 163, 184, 0.24) !important;
        border-radius: 8px !important;
        box-shadow: 0 28px 90px rgba(15, 23, 42, 0.18) !important;
        max-width: 920px !important;
        overflow: hidden !important;
        padding: 0 !important;
        width: min(920px, calc(100vw - 2rem)) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-page-content {
        background: #ffffff;
        gap: 0.55rem !important;
        justify-content: center;
        padding: 2.8rem 3rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-page-content > * {
        width: 100%;
    }

    .system-login-panel {
        align-items: center;
        background: linear-gradient(145deg, #5f9f1a 0%, #2f6f16 42%, #9a3f0d 100%);
        color: #ffffff;
        display: flex;
        overflow: hidden;
        padding: 3rem;
        position: relative;
    }

    .system-login-panel::before {
        background: rgba(249, 115, 22, 0.18);
        border-radius: 8px;
        content: '';
        height: 11rem;
        position: absolute;
        right: -5rem;
        top: 4rem;
        transform: rotate(45deg);
        width: 11rem;
    }

    .system-login-panel::after {
        background: linear-gradient(90deg, rgba(249, 115, 22, 0.35), rgba(132, 204, 22, 0.16));
        bottom: 2rem;
        content: '';
        height: 1px;
        left: 3rem;
        position: absolute;
        width: calc(100% - 6rem);
    }

    .system-login-panel__content {
        max-width: 19rem;
        position: relative;
        z-index: 1;
    }

    .system-login-panel__eyebrow {
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(254, 215, 170, 0.24);
        border-radius: 8px;
        color: #ffedd5;
        display: inline-flex;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0;
        line-height: 1;
        padding: 0.55rem 0.7rem;
    }

    .system-login-panel h2 {
        color: #fff7ed !important;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: 0;
        line-height: 1.18;
        margin: 1.45rem 0 1rem;
    }

    .system-login-panel p {
        color: rgba(255, 247, 237, 0.78);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header {
        margin-bottom: 0.4rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header .fi-logo {
        color: #111827 !important;
        font-size: 1.42rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header .fi-logo::before {
        border-color: rgba(249, 115, 22, 0.32);
        box-shadow: 0 10px 24px rgba(249, 115, 22, 0.18);
        height: 3.5rem;
        width: 3.5rem;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header .fi-logo::after {
        color: #64748b;
        max-width: 20rem;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header-heading {
        color: #111827 !important;
        font-size: 1.55rem !important;
        margin-top: 1.05rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-fo-field-wrp-label span,
    .fi-simple-main:has(.system-login-panel) .fi-checkbox-input + span {
        color: #374151 !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input-wrp {
        background: #ffffff !important;
        border-color: rgba(148, 163, 184, 0.55) !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input-wrp:focus-within {
        border-color: #f97316 !important;
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.14) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input {
        color: #111827 !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input::placeholder {
        color: #94a3b8 !important;
    }

    .dark .fi-simple-layout:has(.system-login-panel),
    :root.dark .fi-simple-layout:has(.system-login-panel) {
        background:
            linear-gradient(135deg, rgba(14, 165, 233, 0.10), transparent 32%),
            linear-gradient(315deg, rgba(22, 163, 74, 0.08), transparent 28%),
            #ffffff !important;
    }

    .dark .fi-simple-layout:has(.system-login-panel)::before,
    :root.dark .fi-simple-layout:has(.system-login-panel)::before {
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(15, 23, 42, 0.045) 1px, transparent 1px);
    }

    .dark .fi-simple-main:has(.system-login-panel),
    :root.dark .fi-simple-main:has(.system-login-panel),
    .dark .fi-simple-main:has(.system-login-panel) .fi-simple-page-content,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-simple-page-content {
        background: #ffffff !important;
    }

    .dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp,
    .dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp-content,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp-content,
    .dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp-content-ctn,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input-wrp-content-ctn,
    .dark .fi-simple-main:has(.system-login-panel) .fi-input,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input,
    .dark .fi-simple-main:has(.system-login-panel) input,
    :root.dark .fi-simple-main:has(.system-login-panel) input {
        background-color: #ffffff !important;
        color: #111827 !important;
    }

    .dark .fi-simple-main:has(.system-login-panel) .fi-input::placeholder,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input::placeholder,
    .dark .fi-simple-main:has(.system-login-panel) input::placeholder,
    :root.dark .fi-simple-main:has(.system-login-panel) input::placeholder {
        color: #94a3b8 !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-btn.fi-color-primary,
    .fi-simple-main:has(.system-login-panel) .fi-btn-primary {
        background: linear-gradient(135deg, #f97316 0%, #6a9f1f 100%) !important;
        box-shadow: 0 12px 24px rgba(249, 115, 22, 0.22) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-btn.fi-color-primary:hover,
    .fi-simple-main:has(.system-login-panel) .fi-btn-primary:hover {
        background: linear-gradient(135deg, #ea580c 0%, #4d7c0f 100%) !important;
    }

    @media (max-width: 820px) {
        .fi-simple-page:has(> .system-login-panel) {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .fi-simple-main:has(.system-login-panel) {
            width: min(440px, calc(100vw - 1.25rem)) !important;
        }

        .system-login-panel {
            min-height: 190px;
            padding: 2rem;
        }

        .system-login-panel__content {
            max-width: none;
        }

        .system-login-panel h2 {
            font-size: 1.55rem;
            margin: 1rem 0 0.65rem;
        }

        .fi-simple-main:has(.system-login-panel) .fi-simple-page-content {
            padding: 2rem 1.6rem !important;
        }
    }
</style>
