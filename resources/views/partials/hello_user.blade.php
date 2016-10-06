@if(auth()->check())
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.hello', ['name' => auth()->user()->name])<span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="/logout">@lang('nav.logout')</a></li>
    <li><a href="/settings/account">@lang('nav.settings')</a></li>
    <li><a href="/merchants">@lang('merchant.accounts')</a></li>
  </ul>
</li>
@endif
