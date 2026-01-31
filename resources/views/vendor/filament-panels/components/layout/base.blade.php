@props([
    'livewire' => null,
])

@php
    $renderHookScopes = $livewire?->getRenderHookScopes();
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class([
        'fi',
        'dark' => filament()->hasDarkModeForced(),
    ])
>
    <head>
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_START, scopes: $renderHookScopes) }}

        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        @php
            $title = trim(strip_tags($livewire?->getTitle() ?? ''));
            $brandName = trim(strip_tags(filament()->getBrandName()));
        @endphp

        <title>
            {{ filled($title) ? $title : null }}
            {{ filled($brandName) && filled($title) ? ' - ' : null }}
            {{ filled($brandName) ? $brandName : null }}
        </title>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_BEFORE, scopes: $renderHookScopes) }}

        <style>
            [x-cloak=''],
            [x-cloak='x-cloak'],
            [x-cloak='1'] {
                display: none !important;
            }

            [x-cloak='inline-flex'] {
                display: inline-flex !important;
            }

            @media (max-width: 1023px) {
                [x-cloak='-lg'] {
                    display: none !important;
                }
            }

            @media (min-width: 1024px) {
                [x-cloak='lg'] {
                    display: none !important;
                }
            }
        </style>

        @filamentStyles

        {{-- Preload Filament rich-editor to avoid Alpine/asset race that causes ReferenceErrors --><link rel="modulepreload" href="/js/filament/forms/components/rich-editor.js">

        {{ filament()->getTheme()->getHtml() }}
        {{ filament()->getFontHtml() }}
        {{ filament()->getMonoFontHtml() }}
        {{ filament()->getSerifFontHtml() }}

        <style>
            :root {
                --font-family: '{!! filament()->getFontFamily() !!}';
                --mono-font-family: '{!! filament()->getMonoFontFamily() !!}';
                --serif-font-family: '{!! filament()->getSerifFontFamily() !!}';
                --sidebar-width: {{ filament()->getSidebarWidth() }};
                --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
                --default-theme-mode: {{ filament()->getDefaultThemeMode()->value }};
            }
        </style>

        @stack('styles')

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_AFTER, scopes: $renderHookScopes) }}

        @if (! filament()->hasDarkMode())
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        @elseif (filament()->hasDarkModeForced())
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        @else
            <script>
                const loadDarkMode = () => {
                    window.theme = localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value)

                    if (
                        window.theme === 'dark' ||
                        (window.theme === 'system' &&
                            window.matchMedia('(prefers-color-scheme: dark)')
                                .matches)
                    ) {
                        document.documentElement.classList.add('dark')
                    }
                }

                loadDarkMode()

                document.addEventListener('livewire:navigated', loadDarkMode)
            </script>
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_END, scopes: $renderHookScopes) }}
    </head>

    <body
        {{
            $attributes
                ->merge($livewire?->getExtraBodyAttributes() ?? [], escape: false)
                ->class([
                    'fi-body',
                    'fi-panel-' . filament()->getId(),
                ])
        }}
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START, scopes: $renderHookScopes) }}

        {{ $slot }}

        @livewire(Filament\Livewire\Notifications::class)

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_BEFORE, scopes: $renderHookScopes) }}

        @filamentScripts(withCore: true)
        {{-- Ensure rich-editor Alpine trees are initialized if the module loads after Alpine (fixes hydration race) --><script>
            (function () {
                const selector = '[x-load-src*="rich-editor"], [x-data*="richEditorFormComponent("]';

                const reinit = () => {
                    try {
                        if (! window.Alpine || typeof window.richEditorFormComponent !== 'function') {
                            return;
                        }

                        document.querySelectorAll(selector).forEach((el) => {
                            try {
                                // Alpine marks initialized trees; avoid double-init
                                if (! el.__x) {
                                    window.Alpine.initTree(el);
                                }
                            } catch (err) {
                                // swallow — worst case the real script will initialize later
                                console.debug('rich-editor reinit error', err);
                            }
                        });

                        // give TipTap/ProseMirror a tick to mount then notify layout
                        setTimeout(() => window.dispatchEvent(new Event('resize')), 50);
                    } catch (err) {
                        console.error(err);
                    }
                };

                // If the script tag is present, attach to its load event
                Array.from(document.scripts).forEach((s) => {
                    if (s.src && s.src.includes('rich-editor')) {
                        s.addEventListener('load', reinit);
                    }
                });

                // Observe head for dynamically injected script tags (x-load uses this)
                new MutationObserver((records) => {
                    for (const r of records) {
                        for (const n of r.addedNodes) {
                            if (n.tagName === 'SCRIPT' && n.src && n.src.includes('rich-editor')) {
                                n.addEventListener('load', reinit);
                            }
                        }
                    }
                }).observe(document.head, { childList: true });

                // Also try to reinit when Filament/schema components signal they're ready
                window.addEventListener('schema-component-loaded', reinit);

                // Fallback: attempt reinit on DOMContentLoaded and after a short delay
                document.addEventListener('DOMContentLoaded', reinit);
                setTimeout(reinit, 250);
            })();
        </script>
        @if (filament()->hasBroadcasting() && config('filament.broadcasting.echo'))
            <script data-navigate-once>
                window.Echo = new window.EchoFactory(@js(config('filament.broadcasting.echo')))

                window.dispatchEvent(new CustomEvent('EchoLoaded'))
            </script>
        @endif

        @if (filament()->hasDarkMode() && (! filament()->hasDarkModeForced()))
            <script>
                loadDarkMode()
            </script>
        @endif

        @stack('scripts')

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_AFTER, scopes: $renderHookScopes) }}

        {{-- Global modal for user notes so the modal component owns Livewire state --}}
        <x-filament::modal id="user-notes-modal" class="user-notes-modal" slide-over width="4xl">
            <x-slot name="heading">
                Ateckningar
            </x-slot>
            @livewire(\App\Http\Livewire\UserNotesModal::class)
        </x-filament::modal>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END, scopes: $renderHookScopes) }}
    </body>
</html>
