<? php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GyanSwipe</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @import 'tailwindcss';
            </style>
        @endif
        <style>
            :root {
                color-scheme: light dark;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            }
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            body {
                background: #FDFDFC;
                color: #1b1b18;
                min-height: 100vh;
            }
            @media (prefers-color-scheme: dark) {
                body {
                    background: #050505;
                    color: #F7F7F7;
                }
            }
            .page-shell {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
            }
            .page-inner {
                width: 100%;
                max-width: 1200px;
            }
            .site-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                margin-bottom: 2rem;
            }
            .brand {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 1.25rem;
                font-weight: 700;
                text-decoration: none;
                color: inherit;
            }
            .brand-badge {
                width: 44px;
                height: 44px;
                display: grid;
                place-items: center;
                border-radius: 1rem;
                background: #f53003;
                color: #fff;
                box-shadow: 0 20px 40px rgba(245, 48, 3, 0.42);
            }
            .nav-links {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                font-size: 0.95rem;
            }
            .nav-links a {
                border-radius: 999px;
                padding: 0.65rem 1.2rem;
                color: inherit;
                text-decoration: none;
                transition: all 0.2s ease;
                border: 1px solid transparent;
                background: rgba(255, 255, 255, 0.92);
            }
            @media (prefers-color-scheme: dark) {
                .nav-links a {
                    background: #111111;
                }
            }
            .nav-links a:hover {
                background: #1b1b18;
                color: #fff;
            }
            .hero-grid {
                display: grid;
                gap: 2.5rem;
                align-items: center;
                grid-template-columns: 1.1fr 0.9fr;
            }
            .hero-wrapper {
                display: flex;
                flex-direction: column;
                gap: 1.75rem;
            }
            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: #fff1ef;
                color: #f53003;
                border-radius: 999px;
                padding: 0.75rem 1rem;
                font-weight: 700;
                font-size: 0.95rem;
            }
            @media (prefers-color-scheme: dark) {
                .hero-badge {
                    background: #320b0c;
                    color: #ffb5ae;
                }
            }
            .hero-title {
                font-size: clamp(2.5rem, 4vw, 4.5rem);
                line-height: 1.03;
                margin: 0;
                font-weight: 800;
            }
            .hero-copy {
                line-height: 1.9;
                color: #575657;
                max-width: 44rem;
            }
            @media (prefers-color-scheme: dark) {
                .hero-copy {
                    color: #d1d1d1;
                }
            }
            .download-row {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 1rem;
            }
            .download-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 1rem 2rem;
                border-radius: 999px;
                background: #f53003;
                color: #fff;
                font-size: 1rem;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 20px 40px rgba(245, 48, 3, 0.42);
                transition: transform 0.2s ease, background 0.2s ease;
            }
            .download-btn:hover {
                transform: translateY(-2px);
                background: #d02502;
            }
            .download-note {
                color: #6a6a67;
            }
            @media (prefers-color-scheme: dark) {
                .download-note {
                    color: #bdbdbd;
                }
            }
            .features-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .feature-card {
                background: #fff;
                border: 1px solid #e6e2de;
                border-radius: 1.75rem;
                padding: 1.5rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }
            .feature-card p:first-child {
                margin: 0;
                font-weight: 700;
                color: #f53003;
                font-size: 0.95rem;
            }
            .feature-card p:last-child {
                margin-top: 0.75rem;
                color: #575657;
                font-size: 0.95rem;
                line-height: 1.65;
            }
            @media (prefers-color-scheme: dark) {
                .feature-card {
                    background: #111111;
                    border-color: #2f2f2f;
                }
                .feature-card p:last-child {
                    color: #c4c4c4;
                }
            }
            .visual-column {
                position: relative;
                display: flex;
                justify-content: center;
            }
            .visual-column::before {
                content: '';
                position: absolute;
                left: -3rem;
                top: 4rem;
                width: 10rem;
                height: 10rem;
                background: rgba(252, 211, 207, 0.7);
                border-radius: 50%;
                filter: blur(40px);
            }
            .visual-column::after {
                content: '';
                position: absolute;
                right: -3rem;
                bottom: 4rem;
                width: 8rem;
                height: 8rem;
                background: rgba(255, 216, 185, 0.6);
                border-radius: 50%;
                filter: blur(40px);
            }
            .visual-card {
                position: relative;
                width: 100%;
                max-width: 420px;
                background: #fff;
                border-radius: 2rem;
                border: 1px solid #e8e4e0;
                box-shadow: 0 40px 120px rgba(0, 0, 0, 0.18);
                overflow: hidden;
            }
            .visual-top {
                background: linear-gradient(135deg, #5b3bff 0%, #f53003 50%, #ff8b4d 100%);
                padding: 1.5rem;
                color: #fff;
            }
            .visual-top .top-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .visual-top .top-row span:first-child {
                text-transform: uppercase;
                letter-spacing: 0.18em;
                font-size: 0.78rem;
                font-weight: 700;
            }
            .visual-top .top-row span:last-child {
                background: rgba(255, 255, 255, 0.15);
                border-radius: 999px;
                padding: 0.5rem 0.75rem;
                font-size: 0.72rem;
                font-weight: 700;
            }
            .visual-top .subtitle {
                margin-top: 1rem;
                opacity: 0.92;
                font-size: 0.95rem;
            }
            .visual-body {
                padding: 1.5rem;
                display: grid;
                gap: 1rem;
                background: #f7f6f2;
            }
            @media (prefers-color-scheme: dark) {
                .visual-body {
                    background: #111419;
                }
            }
            .card-block {
                border-radius: 1.75rem;
                padding: 1.25rem;
                background: #fff;
            }
            @media (prefers-color-scheme: dark) {
                .card-block {
                    background: #16171c;
                }
            }
            .card-block .text-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                font-weight: 700;
                color: #1b1b18;
            }
            .card-block .text-row span:last-child {
                font-size: 0.75rem;
                color: #7a7a77;
            }
            .content-stack {
                display: grid;
                gap: 1rem;
            }
            .content-card {
                border-radius: 1.75rem;
                background: #fff;
                padding: 1rem;
                box-shadow: 0 10px 24px rgba(0,0,0,0.05);
            }
            .content-title {
                margin: 0;
                font-weight: 700;
                color: #1b1b18;
            }
            .content-copy {
                margin-top: 0.75rem;
                font-size: 0.85rem;
                line-height: 1.7;
                color: #6b6b68;
            }
            @media (prefers-color-scheme: dark) {
                .content-card {
                    background: #16171c;
                }
                .content-title {
                    color: #fff;
                }
                .content-copy {
                    color: #9b9b9b;
                }
            }
            .stat-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .stat-card {
                border-radius: 1.75rem;
                padding: 1.25rem;
                text-align: center;
                border: 1px solid #e6e2de;
                background: #fff;
            }
            @media (prefers-color-scheme: dark) {
                .stat-card {
                    background: #111111;
                    border-color: #2f2f2f;
                }
            }
            .stat-card h2 {
                margin: 0;
                font-size: 2rem;
                font-weight: 800;
            }
            .stat-card p {
                margin-top: 0.75rem;
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.18em;
                color: #7a7a77;
            }
            @media (max-width: 900px) {
                .hero-grid {
                    grid-template-columns: 1fr;
                }
                .features-grid {
                    grid-template-columns: 1fr;
                }
            }
            @media (max-width: 600px) {
                .download-row {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    </head>
    <body class="page-shell">
        <div class="page-inner">
            <header class="site-header">
                <a href="/" class="brand">
                    <span class="brand-badge">G</span>
                    <span>GyanSwipe</span>
                </a>
                @if (Route::has('login'))
                    <nav class="nav-links">
                        @auth
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="hero-grid">
                <section class="hero-wrapper">
                    <span class="hero-badge">Social media learning reimagined</span>
                    <h1 class="hero-title">GyanSwipe brings learning to your feed.</h1>
                    <p class="hero-copy">Swipe through micro-lessons, join active learner communities, and keep knowledge within reach. GyanSwipe is built for curiosity, speed, and social learning on Android.</p>

                    <div class="download-row">
                        <a href="{{ route('apk.download', ['filename' => 'GyanSwipe.apk']) }}" target="_blank" rel="noreferrer noopener" class="download-btn">Download APK</a>
                        <span class="download-note">Install directly on Android devices with one click.</span>
                    </div>

                    <div class="features-grid">
                        <article class="feature-card">
                            <p>Swipe-powered lessons</p>
                            <p>Short bursts of knowledge designed for fast retention.</p>
                        </article>
                        <article class="feature-card">
                            <p>Community feed</p>
                            <p>Discover trending insights and collaborate with learners worldwide.</p>
                        </article>
                        <article class="feature-card">
                            <p>Personalized path</p>
                            <p>Get recommendations that match your interests and goals.</p>
                        </article>
                    </div>
                </section>

                <section class="visual-column">
                    <div class="visual-card">
                        <div class="visual-top">
                            <div class="top-row">
                                <span>GyanSwipe</span>
                                <span>Beta</span>
                            </div>
                            <div class="subtitle">Social learning feed</div>
                        </div>
                        <div class="visual-body">
                            <div class="card-block">
                                <div class="text-row">
                                    <span>Daily discovery</span>
                                    <span>New</span>
                                </div>
                                <div class="content-stack">
                                    <div class="content-card">
                                        <p class="content-title">Memory hacks</p>
                                        <p class="content-copy">Swipe through quick learning tips shared by the community.</p>
                                    </div>
                                    <div class="content-card">
                                        <p class="content-title">Flashcard streak</p>
                                        <p class="content-copy">Build momentum with daily review sessions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-grid">
                                <div class="stat-card">
                                    <h2>4.9</h2>
                                    <p>Rating</p>
                                </div>
                                <div class="stat-card">
                                    <h2>120K+</h2>
                                    <p>Active learners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
