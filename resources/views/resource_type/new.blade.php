@extends($layout)

@push('content')
  {{ Form::open(['url' => urlTenant('resource_types/new'), 'v-ajax']) }}
  <div class="row">
    {{ Form::bsText('rty_name', trans('resource_type.rty_name')) }}
    {{ Form::bsText('rty_price', trans('resource_type.rty_price')) }}
  </div>
  {{ Form::submit(trans('form.add'), ['class' => 'btn btn-primary']) }}
  {{ Form::close() }}
@endpush
