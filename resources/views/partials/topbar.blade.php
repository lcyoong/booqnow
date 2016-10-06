<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{{ config('myapp.app_name') }}</a>
    </div>
    @if(auth()->check())
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        @if(config('myapp.multi_tenant'))
        <pick-merchant list="{{ json_encode($merchants) }}" default="@lang('nav.pick_merchant')"></pick-merchant>
        @else
        <li><a href="/"><i class="fa fa-dot-circle-o text-success"></i> {{ session('merchant')->mer_name }}</a></li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @include('partials.hello_user')
      </ul>
    </div><!--/.nav-collapse -->
    @endif
  </div>
</nav>
