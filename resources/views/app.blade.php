<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.cdnfonts.com/css/open-sans" rel="stylesheet">

    @vite(['resources/js/app.ts', 'resources/css/app.scss'])
    @inertiaHead
</head>
<body>

    @inertia

</body>
</html>
