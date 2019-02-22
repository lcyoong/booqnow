@extends($layout)

@push('content')
<div class="row">
    <div class="col-md-4">
    Hotel Guests
    <div class="row">
    {{ Form::bsSelect('rsty_type', trans('resource_sub_type.rsty_type'), $bookings, null, null, 12) }}
  </div>
    </div>
    <div class="col-md-8">
    Walk-in
    </div>
</div>
@endpush