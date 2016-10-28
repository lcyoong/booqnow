<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::text($name, $value, array_merge(['class' => 'form-control', 'placeholder' => $label], $attributes?: [])) }}
  </div>
</div>
