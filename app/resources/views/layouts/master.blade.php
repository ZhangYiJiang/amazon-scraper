<!DOCTYPE html>
<html lang="en">
@stack('vars')
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $pageTitle }}</title>

  <link href='https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic|Roboto+Slab' rel='stylesheet' type='text/css'>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="{{ implode(' ', $bodyClass) }}">
@yield('header')

@yield('main')

<div class="overlay"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
@stack('scripts')
</body>
</html>