<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ urlTenant('dashboard') }}">@lang('nav.dashboard')</a></li>
        <li><a href="{{ urlTenant('') }}">@lang('nav.frontdesk')</a></li>
        <li><a href="{{ urlTenant('bookings') }}">@lang('nav.appointments')</a></li>
        <li><a href="{{ urlTenant('bills') }}">@lang('nav.billing')</a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.reports') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ urlTenant('reports/profitloss') }}">@lang('report.pnl')</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="{{ urlTenant('receipts') }}">@lang('nav.receipts')</a></li> -->
        <li><a href="{{ urlTenant('customers') }}">@lang('nav.customers')</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.resources') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @foreach ($resource_types as $type)
            <li><a href="{{ urlTenant('resources/' . $type->rty_id) }}">{{ $type->rty_plural}}</a></li>
            @endforeach
            <!-- <li><a href="{{ urlTenant('resource_types') }}">@lang('nav.resource_types')</a></li> -->
          </ul>
        </li>
        <!-- <li><a href="{{ urlTenant('invoices') }}">@lang('nav.setting')</a></li> -->
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
