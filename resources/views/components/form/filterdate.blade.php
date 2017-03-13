<div class="col-md-{{ $col }}">
  <div class="form-group">
    <div class="input-group">
      {{ Form::text($name, $value, array_merge(['class' => 'form-control datepicker', 'placeholder' => $label], $attributes?: [])) }}
      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
    </div>      
  </div>
</div>
