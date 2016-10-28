<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      {{ Form::textarea($name, $value, array_merge(['class' => 'form-control', 'rows' => 5], $attributes?: [])) }}
  </div>
</div>
