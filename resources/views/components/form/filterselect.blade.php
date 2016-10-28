<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::select($name, $list, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }}
  </div>
</div>
