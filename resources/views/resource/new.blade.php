@extends($layout)

@push('content')
  {{ Form::open(['url' => urlTenant('resources/new'), 'v-ajax', 'goto' => urlTenant('resources')]) }}
  <div class="row">
    {{ Form::bsText('rs_name', trans('resource.rs_name')) }}
    {{ Form::bsText('rs_price', trans('resource.rs_price')) }}
  </div>
  <div class="row">
    {{ Form::bsTextarea('rs_description', trans('resource.rs_description')) }}
  </div>
  {{ Form::submit(trans('form.add'), ['class' => 'btn btn-primary']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources') }}"></redirect-btn>
  {{ Form::close() }}
@endpush
