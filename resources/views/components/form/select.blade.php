<div class="col-md-{{ $col }}">
  <div class="form-group">
      {{ Form::label($name, $label, ['class' => 'control-label']) }}
      <div>
      {{ Form::select($name, $list, $value, array_merge(['class' => 'form-control'], $attributes?: [])) }}
      </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('.select2').select2();
});
</script>
