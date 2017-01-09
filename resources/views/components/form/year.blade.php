<div class="col-md-{{ $col }}">
<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control datepicker'], $attributes?: [])) }}
</div>
</div>

<script>
$(function() {
  $('.datepicker').datepicker({
    format: " yyyy",
    viewMode: "years",
    minViewMode: "years"
  });
});
</script>

@push('scripts')
<script>
$(function() {
  $('.datepicker').datepicker({
    format: " yyyy",
    viewMode: "years",
    minViewMode: "years"
  });
});
</script>
@endpush
