<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>{{ $page_title or config('myapp.title') }}</title>
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    @yield('head_content')
</head>
<body>
  @include('partials.topbar')
  @yield('navbar')
  <div class="container-fluid">
    @yield('content')
  </div>
  <footer class="footer">
    <div class="container-fluid">
      {{config('myapp.app_name')}} &copy;
    </div>
  </footer>

  @include('partials.modal')
  <script src="{{ elixir('js/app.js') }}"></script>
  @yield('script')
</body>
</html>
