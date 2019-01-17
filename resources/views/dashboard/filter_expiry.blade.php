<div id="expiry-filter">
{{ Form::open(['url' => 'dashboard/onhold', 'method' => 'get']) }}
<div class="row">
{{ Form::bsDate('from_expiry_days', 'Expiry from', array_get($filter, 'from_expiry_days', today()), ['placeholder' => 'Expiry from']) }}
  {{ Form::bsDate('to_expiry_days', 'Expiry to', array_get($filter, 'to_expiry_days', today()), ['placeholder' => 'Expiry to']) }}

    <!-- <div class="col-md-3">
        <div class="form-group">
            <label>Expiring From</label>
            {{ Form::number('from_expiry_days', 0, ['class'=>'form-control', 'min' => -30, 'max' => 30]) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Expiring To</label>
            {{ Form::number('to_expiry_days', 0, ['class'=>'form-control', 'min' => -30, 'max' => 30]) }}
        </div>
    </div> -->
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ url('dashboard/onhold') }}" class="btn-sm"></redirect-btn>
{{ Form::close() }}
</div>