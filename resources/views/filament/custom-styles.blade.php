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

<script>
    (() => {
        const setLightThemeAsDefault = () => {
            try {
                const savedTheme = localStorage.getItem('theme')

                if (! savedTheme || savedTheme === 'system') {
                    localStorage.setItem('theme', 'light')
                    window.theme = 'light'
                    document.documentElement.classList.remove('dark')
                }
            } catch (error) {
                //
            }
        }

        const closeUserMenu = () => {
            if (! window.Alpine) {
                return
            }

            document.querySelectorAll('.fi-user-menu').forEach((menu) => {
                try {
                    window.Alpine.$data(menu)?.close?.()
                } catch (error) {
                    //
                }
            })
        }

        setLightThemeAsDefault()

        window.addEventListener('load', () => window.setTimeout(closeUserMenu, 50))
        document.addEventListener('livewire:navigated', () => window.setTimeout(closeUserMenu, 50))
        document.addEventListener('click', (event) => {
            if (event.target.closest('.fi-user-menu') || event.target.closest('.fi-dropdown-panel')) {
                return
            }

            closeUserMenu()
        })
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeUserMenu()
            }
        })
    })()
</script>

<style>
    :root {
        --brand-green-950: #14210a;
        --brand-green-900: #233812;
        --brand-green-800: #2f5415;
        --brand-green-700: #3f7016;
        --brand-green-600: #5b8918;
        --brand-green-500: #6f9f1f;
        --brand-green-400: #8db83a;
        --brand-orange-700: #9a3f0d;
        --brand-orange-600: #c85310;
        --brand-orange-500: #e07116;
        --brand-orange-400: #f49a32;
        --brand-cream: #fff8ed;
        --brand-surface: #fffdf8;
        --brand-soft: #f5faef;
        --brand-border: rgba(91, 137, 24, 0.20);
        --brand-ink: #17210f;
        --brand-muted: #63705e;
        --brand-shadow: rgba(76, 103, 24, 0.14);
        --system-gold: #ffbd00;
        --system-yellow: #fff78a;
        --system-green: #3f7133;
        --system-green-dark: #1e3a20;
        --system-cream: #fff8c9;
        --system-surface: #fffdf0;
        --system-border: rgba(63, 113, 51, 0.24);
        --system-ink: #18301a;
        --system-muted: #61724f;
        --system-shadow: rgba(30, 58, 32, 0.16);
    }

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

    /* Notification badge */
    .fi-topbar-database-notifications-btn .fi-badge {
        background: var(--system-green-dark) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        min-width: 1.25rem !important;
        height: 1.25rem !important;
        padding: 0.125rem 0.375rem !important;
        font-size: 0.65rem !important;
        box-shadow: 0 2px 8px rgba(30, 58, 32, 0.24) !important;
        border: 2px solid var(--system-gold) !important;
        border-radius: 9999px !important;
        animation: none;
    }

    /* Dark mode */
    .dark .fi-topbar-database-notifications-btn .fi-badge {
        border-color: var(--system-gold) !important;
        box-shadow: 0 2px 8px rgba(30, 58, 32, 0.28) !important;
    }

    body.fi-body-has-navigation {
        background: #f8faf7 !important;
    }

    body.fi-body-has-navigation .fi-layout {
        background: #f8faf7 !important;
    }

    body.fi-body-has-navigation .fi-main-ctn,
    body.fi-body-has-navigation .fi-main {
        background: transparent !important;
    }

    body.fi-body-has-navigation .fi-main {
        color: var(--system-ink) !important;
    }

    body.fi-body-has-navigation .fi-page {
        background: transparent !important;
        border-radius: 8px;
        padding: 0.5rem;
    }

    body.fi-body-has-navigation .fi-topbar {
        background: #ffffff !important;
        border-bottom: 1px solid rgba(63, 113, 51, 0.18) !important;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.90) inset, 0 10px 28px rgba(30, 58, 32, 0.07) !important;
        backdrop-filter: blur(14px);
        position: relative;
    }

    body.fi-body-has-navigation .fi-topbar::after {
        background: var(--system-gold);
        bottom: 0;
        content: '';
        height: 3px;
        left: 0;
        position: absolute;
        right: 0;
    }

    body.fi-body-has-navigation .fi-sidebar {
        background: var(--system-green-dark) !important;
        border-right: 1px solid rgba(255, 247, 138, 0.26) !important;
        box-shadow: 12px 0 34px rgba(30, 58, 32, 0.20) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-nav {
        background: transparent !important;
    }

    body.fi-body-has-navigation .fi-sidebar-header {
        background: #ffffff !important;
        border-bottom: 1px solid rgba(30, 58, 32, 0.20) !important;
        box-shadow: 0 10px 24px rgba(30, 58, 32, 0.12) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-group-label,
    body.fi-body-has-navigation .fi-sidebar-group-collapse-btn {
        color: rgba(255, 248, 201, 0.72) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item-btn {
        color: rgba(255, 253, 240, 0.86) !important;
        transition: background 160ms ease, color 160ms ease, transform 160ms ease !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item-icon,
    body.fi-body-has-navigation .fi-sidebar-item-label {
        color: inherit !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item.fi-active .fi-sidebar-item-btn,
    body.fi-body-has-navigation .fi-sidebar-item-has-active-child-items > .fi-sidebar-item-btn {
        background: var(--system-yellow) !important;
        box-shadow: inset 4px 0 0 var(--system-gold);
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    body.fi-body-has-navigation .fi-sidebar-item.fi-active .fi-sidebar-item-label,
    body.fi-body-has-navigation .fi-sidebar-item-has-active-child-items > .fi-sidebar-item-btn .fi-sidebar-item-icon,
    body.fi-body-has-navigation .fi-sidebar-item-has-active-child-items > .fi-sidebar-item-btn .fi-sidebar-item-label {
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item-btn:hover {
        background: rgba(255, 247, 138, 0.18) !important;
        color: #ffffff !important;
    }

    body.fi-body-has-navigation .fi-topbar-item-btn:hover {
        background: rgba(63, 113, 51, 0.14) !important;
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-sidebar-item-btn:hover {
        transform: translateX(3px);
    }

    body.fi-body-has-navigation .fi-topbar-item.fi-active .fi-topbar-item-btn {
        background: rgba(63, 113, 51, 0.16) !important;
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-topbar .fi-icon-btn,
    body.fi-body-has-navigation .fi-user-menu-trigger {
        background: rgba(255, 253, 240, 0.38) !important;
        border: 1px solid rgba(63, 113, 51, 0.22) !important;
        color: var(--system-green-dark) !important;
        transition: background 160ms ease, color 160ms ease, transform 160ms ease !important;
    }

    body.fi-body-has-navigation .fi-topbar .fi-icon-btn:hover,
    body.fi-body-has-navigation .fi-user-menu-trigger:hover {
        background: rgba(63, 113, 51, 0.18) !important;
        color: var(--system-green-dark) !important;
        transform: translateY(-1px);
    }

    body.fi-body-has-navigation .fi-user-avatar {
        border: 2px solid var(--system-yellow) !important;
        box-shadow: 0 0 0 3px rgba(63, 113, 51, 0.22), 0 8px 18px rgba(30, 58, 32, 0.18) !important;
    }

    body.fi-body-has-navigation .fi-section,
    body.fi-body-has-navigation .fi-card,
    body.fi-body-has-navigation .fi-ta-ctn,
    body.fi-body-has-navigation .fi-wi-stats-overview-stat {
        background: #ffffff !important;
        border: 1px solid rgba(63, 113, 51, 0.16) !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 28px rgba(30, 58, 32, 0.07), 0 1px 2px rgba(30, 58, 32, 0.04) !important;
        overflow: hidden;
    }

    body.fi-body-has-navigation .fi-section-content-ctn,
    body.fi-body-has-navigation .fi-section-content,
    body.fi-body-has-navigation .fi-ta-content-ctn,
    body.fi-body-has-navigation .fi-ta-content,
    body.fi-body-has-navigation .fi-wi-stats-overview-stat-content {
        background: #ffffff !important;
    }

    body.fi-body-has-navigation .fi-section::before,
    body.fi-body-has-navigation .fi-ta-ctn::before,
    body.fi-body-has-navigation .fi-wi-stats-overview-stat::before {
        background: var(--system-gold);
        content: '';
        display: block;
        height: 2px;
    }

    body.fi-body-has-navigation .fi-section-header,
    body.fi-body-has-navigation .fi-ta-header,
    body.fi-body-has-navigation .fi-ta-header-ctn {
        background: #ffffff !important;
        border-color: rgba(63, 113, 51, 0.12) !important;
    }

    body.fi-body-has-navigation .fi-header-heading,
    body.fi-body-has-navigation .fi-section-header-heading,
    body.fi-body-has-navigation .fi-ta-header-heading,
    body.fi-body-has-navigation .fi-wi-stats-overview-stat-value {
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-header-subheading,
    body.fi-body-has-navigation .fi-section-header-description,
    body.fi-body-has-navigation .fi-ta-header-description,
    body.fi-body-has-navigation .fi-wi-stats-overview-stat-label {
        color: var(--system-muted) !important;
    }

    body.fi-body-has-navigation .fi-ta-table thead,
    body.fi-body-has-navigation .fi-ta-table-head,
    body.fi-body-has-navigation .fi-ta-row.fi-ta-row-not-reorderable:nth-child(even),
    body.fi-body-has-navigation .fi-ta-summary-row {
        background: #fbfcf8 !important;
    }

    body.fi-body-has-navigation .fi-ta-row:hover,
    body.fi-body-has-navigation .fi-ta-record:hover {
        background: #f6faef !important;
    }

    body.fi-body-has-navigation .fi-ta-header-cell,
    body.fi-body-has-navigation .fi-ta-header-cell-label {
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-ta-cell,
    body.fi-body-has-navigation .fi-ta-text-item-label {
        color: var(--system-ink);
    }

    body.fi-body-has-navigation .fi-btn.fi-color-primary,
    body.fi-body-has-navigation .fi-btn-primary {
        background: var(--system-green) !important;
        box-shadow: 0 8px 18px rgba(30, 58, 32, 0.18) !important;
        color: #ffffff !important;
    }

    body.fi-body-has-navigation .fi-btn.fi-color-primary:hover,
    body.fi-body-has-navigation .fi-btn-primary:hover {
        background: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-link.fi-color-primary,
    body.fi-body-has-navigation .fi-ac-link-action.fi-color-primary,
    body.fi-body-has-navigation .fi-tabs-item.fi-active {
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-tabs-item.fi-active {
        background: rgba(255, 189, 0, 0.18) !important;
        box-shadow: inset 0 -2px 0 var(--system-green) !important;
    }

    body.fi-body-has-navigation .fi-input-wrp,
    body.fi-body-has-navigation .fi-select-input,
    body.fi-body-has-navigation .fi-textarea {
        background-color: rgba(255, 253, 240, 0.92) !important;
        border-color: rgba(63, 113, 51, 0.24) !important;
    }

    body.fi-body-has-navigation .fi-input-wrp:focus-within {
        border-color: var(--system-gold) !important;
        box-shadow: 0 0 0 4px rgba(255, 189, 0, 0.20) !important;
    }

    body.fi-body-has-navigation .fi-badge.fi-color-primary {
        background-color: rgba(255, 189, 0, 0.30) !important;
        color: var(--system-green-dark) !important;
        --tw-ring-color: rgba(63, 113, 51, 0.25) !important;
    }

    body.fi-body-has-navigation .fi-dropdown-panel {
        background: #ffffff !important;
        border: 1px solid var(--system-border) !important;
        box-shadow: 0 18px 45px rgba(30, 58, 32, 0.16) !important;
    }

    body.fi-body-has-navigation .fi-modal-window {
        background: #ffffff !important;
        border: 1px solid var(--system-border) !important;
        box-shadow: 0 18px 45px rgba(30, 58, 32, 0.16) !important;
    }

    body.fi-body-has-navigation .fi-modal-header {
        background: #ffffff !important;
        border-color: rgba(63, 113, 51, 0.18) !important;
    }

    body.fi-body-has-navigation .fi-dropdown-header {
        background: #ffffff !important;
        border-color: rgba(63, 113, 51, 0.12) !important;
    }

    body.fi-body-has-navigation .fi-dropdown-list-item:hover,
    body.fi-body-has-navigation .fi-no-notification {
        background: rgba(246, 250, 239, 0.82) !important;
    }

    body.fi-body-has-navigation .fi-theme-switcher {
        background: #ffffff !important;
    }

    body.fi-body-has-navigation .fi-theme-switcher-btn {
        background: #ffffff !important;
        color: #9ca3af !important;
    }

    body.fi-body-has-navigation .fi-theme-switcher-btn.fi-active {
        background: #f7faf5 !important;
        color: var(--system-green) !important;
        box-shadow: inset 0 0 0 1px rgba(63, 113, 51, 0.14) !important;
    }

    body.fi-body-has-navigation .fi-no-notification {
        border-left: 4px solid var(--system-green) !important;
    }

    body.fi-body-has-navigation .fi-dropdown-header,
    body.fi-body-has-navigation .fi-dropdown-list-item,
    body.fi-body-has-navigation .fi-modal-heading,
    body.fi-body-has-navigation .fi-no-notification-title {
        color: var(--system-green-dark) !important;
    }

    body.fi-body-has-navigation .fi-no-notification-date,
    body.fi-body-has-navigation .fi-no-notification-body,
    body.fi-body-has-navigation .fi-modal-description {
        color: var(--system-muted) !important;
    }

    body.fi-body-has-navigation .fi-topbar .fi-logo,
    body.fi-body-has-navigation .fi-sidebar-header .fi-logo {
        align-items: center;
        color: var(--system-green-dark) !important;
        display: inline-flex !important;
        font-size: 1.05rem !important;
        font-weight: 700 !important;
        gap: 0.6rem;
        letter-spacing: 0 !important;
        line-height: 1;
        white-space: nowrap;
    }

    body.fi-body-has-navigation .fi-topbar .fi-logo::before,
    body.fi-body-has-navigation .fi-sidebar-header .fi-logo::before {
        background: #ffffff url('{{ $brandLogo }}') center / 76% auto no-repeat;
        border: 1px solid rgba(63, 113, 51, 0.30);
        border-radius: 8px;
        box-shadow: 0 6px 16px rgba(30, 58, 32, 0.18);
        content: '';
        display: inline-block;
        flex: 0 0 auto;
        height: 2rem;
        width: 2rem;
    }

    .dark .fi-topbar .fi-logo,
    .dark .fi-sidebar-header .fi-logo,
    :root.dark .fi-topbar .fi-logo,
    :root.dark .fi-sidebar-header .fi-logo {
        color: #f8fafc !important;
    }

    .fi-simple-layout {
        min-height: 100vh;
        background:
            linear-gradient(135deg, rgba(111, 159, 31, 0.14), transparent 32%),
            linear-gradient(315deg, rgba(224, 113, 22, 0.10), transparent 28%),
            #faf8f2 !important;
        isolation: isolate;
        overflow: hidden;
        position: relative;
    }

    .fi-simple-layout::before {
        background-image:
            linear-gradient(rgba(47, 84, 21, 0.060) 1px, transparent 1px),
            linear-gradient(90deg, rgba(47, 84, 21, 0.060) 1px, transparent 1px);
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
        background: rgba(255, 253, 248, 0.95) !important;
        border: 1px solid rgba(91, 137, 24, 0.18) !important;
        border-radius: 8px !important;
        box-shadow: 0 22px 70px var(--brand-shadow), 0 1px 2px rgba(23, 33, 15, 0.04) !important;
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
        color: var(--brand-ink) !important;
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
        border: 1px solid rgba(224, 113, 22, 0.24);
        border-radius: 8px;
        box-shadow: 0 8px 22px rgba(200, 83, 16, 0.15);
        content: '';
        display: inline-block;
        grid-column: 1;
        grid-row: 1 / span 2;
        height: 3.35rem;
        width: 3.35rem;
    }

    .fi-simple-header .fi-logo::after {
        color: var(--brand-muted);
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
        color: var(--brand-ink) !important;
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
        color: var(--brand-ink) !important;
        font-weight: 600 !important;
    }

    .fi-simple-main .fi-input-wrp {
        background: #ffffff !important;
        border: 1px solid rgba(91, 137, 24, 0.28) !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 2px rgba(23, 33, 15, 0.04) !important;
        min-height: 2.85rem !important;
        transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease !important;
    }

    .fi-simple-main .fi-input-wrp:focus-within {
        border-color: var(--brand-orange-500) !important;
        box-shadow: 0 0 0 4px rgba(224, 113, 22, 0.13) !important;
    }

    .fi-simple-main .fi-input {
        color: var(--brand-ink) !important;
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
        background: linear-gradient(135deg, var(--brand-green-600), var(--brand-green-500)) !important;
        box-shadow: 0 10px 22px rgba(91, 137, 24, 0.22) !important;
    }

    .fi-simple-main .fi-btn.fi-color-primary:hover,
    .fi-simple-main .fi-btn-primary:hover {
        background: linear-gradient(135deg, var(--brand-green-700), var(--brand-green-600)) !important;
        transform: translateY(-1px);
    }

    .dark .fi-simple-layout,
    :root.dark .fi-simple-layout {
        background:
            linear-gradient(135deg, rgba(111, 159, 31, 0.12), transparent 34%),
            linear-gradient(315deg, rgba(224, 113, 22, 0.10), transparent 30%),
            #0c1208 !important;
    }

    .dark .fi-simple-layout::before,
    :root.dark .fi-simple-layout::before {
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
    }

    .dark .fi-simple-main,
    :root.dark .fi-simple-main {
        background: rgba(20, 33, 10, 0.94) !important;
        border-color: rgba(141, 184, 58, 0.26) !important;
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
        border-color: rgba(224, 113, 22, 0.26);
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
        background: rgba(29, 43, 16, 0.92) !important;
        border-color: rgba(141, 184, 58, 0.30) !important;
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
        border: 1px solid rgba(91, 137, 24, 0.18) !important;
        border-radius: 8px !important;
        box-shadow: 0 28px 90px rgba(76, 103, 24, 0.18) !important;
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
        background: linear-gradient(145deg, var(--brand-green-600) 0%, var(--brand-green-800) 44%, var(--brand-orange-700) 100%);
        color: #ffffff;
        display: flex;
        overflow: hidden;
        padding: 3rem;
        position: relative;
    }

    .system-login-panel::before {
        background: rgba(224, 113, 22, 0.18);
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
        background: linear-gradient(90deg, rgba(244, 154, 50, 0.36), rgba(141, 184, 58, 0.18));
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
        color: var(--brand-ink) !important;
        font-size: 1.42rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header .fi-logo::before {
        border-color: rgba(224, 113, 22, 0.32);
        box-shadow: 0 10px 24px rgba(200, 83, 16, 0.18);
        height: 3.5rem;
        width: 3.5rem;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header .fi-logo::after {
        color: var(--brand-muted);
        max-width: 20rem;
    }

    .fi-simple-main:has(.system-login-panel) .fi-simple-header-heading {
        color: var(--brand-ink) !important;
        font-size: 1.55rem !important;
        margin-top: 1.05rem !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-fo-field-wrp-label span,
    .fi-simple-main:has(.system-login-panel) .fi-checkbox-input + span {
        color: var(--brand-ink) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input-wrp {
        background: #ffffff !important;
        border-color: rgba(91, 137, 24, 0.28) !important;
        box-shadow: 0 1px 2px rgba(23, 33, 15, 0.04) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input-wrp:focus-within {
        border-color: var(--brand-orange-500) !important;
        box-shadow: 0 0 0 4px rgba(224, 113, 22, 0.14) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input {
        color: var(--brand-ink) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-input::placeholder {
        color: #94a3b8 !important;
    }

    .dark .fi-simple-layout:has(.system-login-panel),
    :root.dark .fi-simple-layout:has(.system-login-panel) {
        background:
            linear-gradient(135deg, rgba(111, 159, 31, 0.11), transparent 32%),
            linear-gradient(315deg, rgba(224, 113, 22, 0.08), transparent 28%),
            #ffffff !important;
    }

    .dark .fi-simple-layout:has(.system-login-panel)::before,
    :root.dark .fi-simple-layout:has(.system-login-panel)::before {
        background-image:
            linear-gradient(rgba(47, 84, 21, 0.050) 1px, transparent 1px),
            linear-gradient(90deg, rgba(47, 84, 21, 0.050) 1px, transparent 1px);
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
        color: var(--brand-ink) !important;
    }

    .dark .fi-simple-main:has(.system-login-panel) .fi-input::placeholder,
    :root.dark .fi-simple-main:has(.system-login-panel) .fi-input::placeholder,
    .dark .fi-simple-main:has(.system-login-panel) input::placeholder,
    :root.dark .fi-simple-main:has(.system-login-panel) input::placeholder {
        color: #94a3b8 !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-btn.fi-color-primary,
    .fi-simple-main:has(.system-login-panel) .fi-btn-primary {
        background: linear-gradient(135deg, var(--brand-orange-500) 0%, var(--brand-green-500) 100%) !important;
        box-shadow: 0 12px 24px rgba(200, 83, 16, 0.22) !important;
    }

    .fi-simple-main:has(.system-login-panel) .fi-btn.fi-color-primary:hover,
    .fi-simple-main:has(.system-login-panel) .fi-btn-primary:hover {
        background: linear-gradient(135deg, var(--brand-orange-600) 0%, var(--brand-green-700) 100%) !important;
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
