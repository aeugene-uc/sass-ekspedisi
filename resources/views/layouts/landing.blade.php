<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield("title")</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
  <link rel="icon" href="{{ asset('images/logo-trans-white.png') }}" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <x-landing-navbar />
    @yield('content')
    <x-footer />
</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>