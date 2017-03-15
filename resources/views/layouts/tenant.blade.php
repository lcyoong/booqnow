@extends('layouts.master')

@if($tenant)
  @section('navbar')
    @include('partials.navbar')
  @endsection
@endif

@prepend('content')
<div class="clearfix" id="tenant-header">
  <div class="pull-left"><h3>{{ $page_title or '' }}</h3></div>
  @if(isset($new_path))
  <div class="pull-right">
    <a href="{{ $new_path }}" {{ $new_path_attr or ''}}><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> @lang('form.new')</button></a>
  </div>
  @endif
</div>
@endprepend

@prepend('scripts')
<script>
new Vue({
  el: '#tenant-header',
});
</script>
@endprepend
