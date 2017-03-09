<div class="col-md-{{ $col }}">
<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    <div class="input-group">
      {{ Form::text($name, Carbon\Carbon::parse($value)->format('d-m-Y'), array_merge(['class' => 'form-control datepicker'], $attributes?: [])) }}
      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
    </div>
</div>
</div>
