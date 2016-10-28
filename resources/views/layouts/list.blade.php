@yield('content_above_list')

<div class="row">
  <div class="col-md-{{ $left_section_col }}">
  <div class="table-responsive">
  <table class="table table-condensed">
  @yield('content_list')
  </table>
  </div>
  </div>
  <div class="col-md-{{ 12 - $left_section_col }}">
    @yield('content_list_right')
  </div>
</div>
