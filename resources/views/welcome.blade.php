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
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#050505] text-[#1b1b18] dark:text-[#F7F7F7] min-h-screen">
        <div class="mx-auto flex min-h-screen max-w-7xl flex-col px-6 py-8 lg:px-10 lg:py-12">
            <header class="flex items-center justify-between gap-4 pb-8">
                <a href="/" class="inline-flex items-center gap-3 text-xl font-semibold tracking-tight text-[#1b1b18] dark:text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-3xl bg-[#f53003] text-white shadow-[0_20px_40px_-24px_rgba(245,48,3,0.9)]">G</span>
                    <span>GyanSwipe</span>
                </a>
                @if (Route::has('login'))
                    <nav class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full border border-[#1b1b18] bg-white px-4 py-2 text-sm font-medium text-[#1b1b18] transition hover:bg-[#1b1b18] hover:text-white dark:border-[#444444] dark:bg-[#111111] dark:text-[#F7F7F7] dark:hover:bg-[#f53003]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-medium text-[#1b1b18] transition hover:text-[#f53003] dark:text-[#F7F7F7]">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full border border-[#1b1b18] bg-white px-4 py-2 text-sm font-medium text-[#1b1b18] transition hover:bg-[#1b1b18] hover:text-white dark:border-[#444444] dark:bg-[#111111] dark:text-[#F7F7F7] dark:hover:bg-[#f53003]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="grid flex-1 items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="space-y-8">
                    <div class="max-w-2xl space-y-5">
                        <p class="inline-flex items-center gap-2 rounded-full bg-[#fff1ef] px-4 py-2 text-sm font-semibold text-[#f53003] dark:bg-[#320b0c] dark:text-[#ffb5ae]">
                            Social media learning reimagined
                        </p>
                        <h1 class="text-5xl font-semibold tracking-tight text-[#1b1b18] dark:text-white sm:text-6xl">
                            GyanSwipe brings learning to your feed.
                        </h1>
                        <p class="text-base leading-8 text-[#575657] dark:text-[#d1d1d1]">
                            Swipe through micro-lessons, join active learner communities, and keep knowledge within reach. GyanSwipe is built for curiosity, speed, and social learning on Android.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <a href="https://example.com/GyanSwipe.apk" target="_blank" rel="noreferrer noopener" class="inline-flex items-center justify-center rounded-full bg-[#f53003] px-8 py-4 text-base font-semibold text-white shadow-[0_20px_40px_-24px_rgba(245,48,3,0.9)] transition hover:-translate-y-0.5 hover:bg-[#d02502]">
                            Download APK
                        </a>
                        <span class="text-sm text-[#6a6a67] dark:text-[#bdbdbd]">Install directly on Android devices with one click.</span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-[#e6e2de] bg-white px-5 py-6 shadow-sm dark:border-[#2f2f2f] dark:bg-[#111111]">
                            <p class="text-sm font-semibold text-[#f53003]">Swipe-powered lessons</p>
                            <p class="mt-3 text-sm text-[#575657] dark:text-[#c4c4c4]">Short bursts of knowledge designed for fast retention.</p>
                        </div>
                        <div class="rounded-3xl border border-[#e6e2de] bg-white px-5 py-6 shadow-sm dark:border-[#2f2f2f] dark:bg-[#111111]">
                            <p class="text-sm font-semibold text-[#f53003]">Community feed</p>
                            <p class="mt-3 text-sm text-[#575657] dark:text-[#c4c4c4]">Discover trending insights and collaborate with learners worldwide.</p>
                        </div>
                        <div class="rounded-3xl border border-[#e6e2de] bg-white px-5 py-6 shadow-sm dark:border-[#2f2f2f] dark:bg-[#111111]">
                            <p class="text-sm font-semibold text-[#f53003]">Personalized path</p>
                            <p class="mt-3 text-sm text-[#575657] dark:text-[#c4c4c4]">Get recommendations that match your interests and goals.</p>
                        </div>
                    </div>
                </section>

                <section class="relative flex justify-center">
                    <div class="pointer-events-none absolute -left-10 top-14 h-40 w-40 rounded-full bg-[#fcd3cf]/70 blur-3xl"></div>
                    <div class="pointer-events-none absolute -right-10 bottom-16 h-32 w-32 rounded-full bg-[#ffd8b9]/60 blur-3xl"></div>

                    <div class="relative w-full max-w-[420px] overflow-hidden rounded-[2rem] border border-[#e8e4e0] bg-white shadow-[0_40px_120px_-60px_rgba(0,0,0,0.18)] dark:border-[#222222] dark:bg-[#111111]">
                        <div class="bg-gradient-to-br from-[#5b3bff] via-[#f53003] to-[#ff8b4d] px-6 py-5 text-white">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold uppercase tracking-[0.18em]">GyanSwipe</span>
                                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-medium">Beta</span>
                            </div>
                            <div class="mt-4 text-sm text-white/90">Social learning feed</div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="rounded-[1.75rem] bg-[#f7f6f2] p-5 dark:bg-[#111419]">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm font-semibold text-[#1b1b18] dark:text-[#f7f7f7]">Daily discovery</span>
                                    <span class="text-xs text-[#7a7a77] dark:text-[#8f8f8f]">New</span>
                                </div>
                                <div class="space-y-3">
                                    <div class="rounded-3xl bg-white p-4 shadow-sm dark:bg-[#16171c]">
                                        <p class="text-sm font-semibold text-[#1b1b18] dark:text-white">Memory hacks</p>
                                        <p class="mt-2 text-xs text-[#6b6b68] dark:text-[#9b9b9b]">Swipe through quick learning tips shared by the community.</p>
                                    </div>
                                    <div class="rounded-3xl bg-white p-4 shadow-sm dark:bg-[#16171c]">
                                        <p class="text-sm font-semibold text-[#1b1b18] dark:text-white">Flashcard streak</p>
                                        <p class="mt-2 text-xs text-[#6b6b68] dark:text-[#9b9b9b]">Build momentum with daily review sessions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-3xl border border-[#e6e2de] bg-white p-4 text-center dark:border-[#2f2f2f] dark:bg-[#111111]">
                                    <p class="text-3xl font-semibold text-[#1b1b18] dark:text-white">4.9</p>
                                    <p class="mt-2 text-xs uppercase tracking-[0.2em] text-[#7a7a77] dark:text-[#8f8f8f]">Rating</p>
                                </div>
                                <div class="rounded-3xl border border-[#e6e2de] bg-white p-4 text-center dark:border-[#2f2f2f] dark:bg-[#111111]">
                                    <p class="text-3xl font-semibold text-[#1b1b18] dark:text-white">120K+</p>
                                    <p class="mt-2 text-xs uppercase tracking-[0.2em] text-[#7a7a77] dark:text-[#8f8f8f]">Active learners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
