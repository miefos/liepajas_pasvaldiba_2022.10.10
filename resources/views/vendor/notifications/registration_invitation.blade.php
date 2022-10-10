@component('mail::message')
# @lang('Sveicināti!')

{{-- Intro Lines --}}
{{ $message }}

@isset($actionText)
@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent
@endisset

Ar sveicieniem,<br>
{{ config('app.name') }}

@isset($actionText)
@slot('subcopy')
@lang(
    "Ja neizdodas uzspiest uz \":actionText\" pogas, iekopējietjiet saiti zemāk savā pārlūkā\n",
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
