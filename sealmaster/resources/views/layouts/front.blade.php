<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>ТОО СИЛМАСТЕР | @yield('title', 'Производство манжет и уплотнений в Караганде')</title>
  <meta name="keywords" content="@yield('keywords')">
  <meta name="description" content="@yield('description')">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="index, follow"/>

  <!-- Favicons -->
  <link href="/favicon.ico" rel="icon">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#358AEF">

  <!-- styles -->
  @stack('styles')
  @vite(['resources/css/main.scss', 'resources/js/main.js'])
</head>

<body class="d-flex flex-column h-100">
  @include('front.header')
  <main>
    @yield('content')
  </main>
  <aside class="container mb-5">
    @yield('aside')
  </aside>

  @include('front.footer')
  @stack('scripts')
</body>
</html>
