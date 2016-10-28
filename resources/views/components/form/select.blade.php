<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      {{ Form::select($name, $list, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }}
  </div>
</div>
