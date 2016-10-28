@extends('layouts.master')

@if($tenant)
  @section('navbar')
    @include('partials.navbar')
  @endsection
@endif

@push('content')
<div class="clearfix">
  <div class="pull-left"><h3>{{ $page_title or '' }}</h3></div>
  @if(isset($new_path))
  <div class="pull-right">
    <a href="{{ $new_path }}"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> @lang('form.new')</button></a>
  </div>
  @endif
</div>
@endpush
