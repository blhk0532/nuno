@php
    $user = filament()->auth()->user();
@endphp
<style>
   .fi-page-header-main-ctn{
       padding: 0rem !important;
   }
   .fi-avatar.fi-circular.fi-size-lg.fi-user-avatar {
         width: 46px;
         height: 46px;
   }
</style>
<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <x-filament-panels::avatar.user
            size="lg"
            :user="$user"
            loading="lazy"
        />

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                 {{ filament()->getUserName($user) }}
            </h2>

            <p class="fi-account-widget-user-name text-sm">
                Active now...
            </p>
        </div>

        <form
            action="{{ filament()->getLogoutUrl() }}"
            method="post"
            class="fi-account-widget-logout-form"
        >
            @csrf

            <x-filament::button
                color="gray"
                :icon="\Filament\Support\Icons\Heroicon::ArrowLeftEndOnRectangle"
                :icon-alias="\Filament\View\PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON"
                labeled-from="sm"
                tag="button"
                type="submit"
            >
                {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
