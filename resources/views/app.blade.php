<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.cdnfonts.com/css/open-sans" rel="stylesheet">

    @vite(['resources/css/app.scss', 'resources/js/app.ts'])
</head>
<body>
@php
    if ($user = auth()->user()) {
        $apiToken = $user->api_token;
    } else {
        $apiToken = request()->get('api_token', '');
    }
@endphp
<div id="app">
    <router-view api-token="{{ $apiToken }}"></router-view>
</div>
</body>
</html>
