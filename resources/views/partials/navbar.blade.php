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
        @permitted('booking')
        <li><a href="{{ urlTenant('') }}">@lang('nav.frontdesk')</a></li>
        @endpermitted
        @permitted('booking')
        <li><a href="{{ urlTenant('bookings') }}">@lang('nav.appointments')</a></li>
        @endpermitted
        @permitted('bill')
        <li><a href="{{ urlTenant('bills') }}">@lang('nav.billing')</a></li>
        @endpermitted
        @permitted('report')
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.reports') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ urlTenant('reports/profitloss') }}">@lang('report.pnl_title')</a></li>
            <li><a href="{{ urlTenant('reports/occupancy_by_room') }}">@lang('report.monthly_occupancy_title')</a></li>
            <li><a href="{{ urlTenant('reports/occupancy_by_day') }}">@lang('report.daily_occupancy_title')</a></li>
            <li><a href="{{ urlTenant('reports/occupancy_by_national') }}">@lang('report.national_occupancy_title')</a></li>
            <li><a href="{{ urlTenant('reports/monthly_stat') }}">@lang('report.monthly_stat_title')</a></li>
            <li><a href="{{ urlTenant('reports/monthly_deposit') }}">@lang('report.monthly_deposit_title')</a></li>
            <li><a href="{{ urlTenant('reports/monthly_deposit_future') }}">@lang('report.monthly_deposit_by_future_title')</a></li>
            <li><a href="{{ urlTenant('reports/monthly_units_sold') }}">@lang('report.monthly_units_sold_title')</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ urlTenant('reports/daily_tour') }}">@lang('report.daily_tour_title')</a></li>
            <li><a href="{{ urlTenant('reports/daily_transfer') }}">@lang('report.daily_transfer_title')</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ urlTenant('reports/export_bills') }}">@lang('report.export_bills_title')</a></li>
            <li><a href="{{ urlTenant('reports/export_receipts') }}">@lang('report.export_receipts_title')</a></li>
          </ul>
        </li>
        @endpermitted
        @permitted('payment')
        <li><a href="{{ urlTenant('receipts') }}">@lang('nav.receipts')</a></li>
        @endpermitted
        @permitted('customer')
        <li><a href="{{ urlTenant('customers') }}">@lang('nav.customers')</a></li>
        @endpermitted
        @permitted('accounting')
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.accounting') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ urlTenant('expenses') }}">@lang('nav.expenses')</a></li>
            <li><a href="{{ urlTenant('expenses_category') }}">@lang('nav.expenses_category')</a></li>
          </ul>
        </li>
        @endpermitted
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.resources') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @permitted('resource')
            @foreach ($resource_types as $type)
            <li><a href="{{ urlTenant('resources/' . $type->rty_id) }}">{{ $type->rty_plural}}</a></li>
            @endforeach
            <li role="separator" class="divider"></li>
            <li><a href="{{ urlTenant('resource_sub_types') }}">@lang('nav.sub_types')</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ urlTenant('agents') }}">@lang('nav.agents')</a></li>
            <li><a href="{{ urlTenant('countries') }}">@lang('nav.countries')</a></li>
            @endpermitted
            <!-- <li><a href="{{ urlTenant('resource_types') }}">@lang('nav.resource_types')</a></li> -->
          </ul>
        </li>
        @permitted(['manage_user', 'manage_role', 'manage_permission'])
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('nav.access') <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @permitted('manage_user')
            <li><a href="{{ urlTenant('users') }}">@lang('nav.users')</a></li>
            @endpermitted
            @permitted('manage_role')
            <li><a href="{{ urlTenant('roles') }}">@lang('nav.roles')</a></li>
            @endpermitted
            @permitted('manage_permission')
            <li><a href="{{ urlTenant('permissions') }}">@lang('nav.permissions')</a></li>
            @endpermitted
          </ul>
        </li>
        @endpermitted
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
