<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-mail</title>

    @if(app()->getLocale() == "ar")
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;500;700;900&display=swap" rel="stylesheet">
    <style type="text/css">
        * {
            font-family: Cairo !important;
        }
        p {
            text-align: right !important;
            direction: rtl !important;
        }
    </style>
    @endif
</head>
@if(app()->getLocale() == "ar")
<body style="background-color: #eeeeee;font-family: Cairo, Helvetica, Arial,sans-serif;text-align: right;">
@else
<body style="background-color: #eeeeee;font-family: Helvetica, Arial,sans-serif;">
@endif

    <div style="overflow:auto;line-height:2">
      <div style="margin:50px auto;max-width:600px;width:100%;padding:30px;border-raduis:15px;background-color:#ffffff">
        <div style="border-bottom:1px solid #eee">
          <a href="#" style="text-align: center;display: block;">
            <img src="{{ asset('assets/global/logo.png') }}" style="width:100%;max-width: 220px;">
          </a>
        </div>
        <p>{{ __('Bonjour') }},</p>
        {{-- Intro Lines --}}
        @foreach ($introLines as $line)
        <p>{!! $line !!}</p>
        @endforeach

        {{-- Action Button --}}
        @isset($actionText)
        <?php
            $color = match ($level) {
                'success', 'error' => $level,
                default => 'primary',
            };
        ?>
        <x-mail::button :url="$actionUrl" :color="$color">
        {{ $actionText }}
        </x-mail::button>
        @endisset

        @foreach ($outroLines as $line)
        <p>{!! $line !!}</p>
        @endforeach

        <p>
            {{ __('Cordialement') }},
            <br />
            {{ setting('config_ws_app_name') }}
        </p>
      </div>
    </div>
</body>
</html>
