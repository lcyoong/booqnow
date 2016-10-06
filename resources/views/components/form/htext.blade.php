<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label col-xs-' . $col1]) }}
    <div class="col-xs-{{ $col2 }}">
      {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }}
    </div>
</div>
