<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>{{ $page_title or config('myapp.title') }}</title>
    <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet">
    @yield('head_content')
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
  @include('partials.topbar')
  @yield('navbar')
  <div class="container-fluid">
    @yield('content')
    @stack('content')
  </div>
  <footer class="footer">
    <div class="container-fluid">
      {{config('app.name')}} &copy;
    </div>
  </footer>

  @include('partials.modal')
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset(elixir('js/app.js')) }}"></script>
  @stack('scripts')
</body>
</html>
