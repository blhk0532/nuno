   <style>
    .fi-modal-content{
        margin:1rem;
    }
    .fi-modal-heading{
            padding: 0px;
    margin: 0px;
    padding-left: 1rem;
    }
   </style>
   @php
    $siteName = db_config('manus.site_name', 'Default Site Name');
    @endphp
<div
    class="w-full"
    x-init="$nextTick(() => window.dispatchEvent(new Event('resize')))"
    x-on:calendar-resize.window="window.dispatchEvent(new Event('resize'))"
    x-on:open-modal.window="if ($event.detail && $event.detail.id === 'calendar-modal') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); setTimeout(() => window.dispatchEvent(new Event('resize')), 250); setTimeout(() => window.dispatchEvent(new Event('resize')), 400); }"
>


    <div class="manus-widget-wrapper m-1" id="manus-widget-wrapper">

   {!! $siteName !!}

    </div>
</div>
