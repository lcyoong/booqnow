<div class="col-md-{{ $col }}">
<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control datepicker'], $attributes?: [])) }}
</div>
</div>

<script>
$(function() {
    $('.datepicker').datepicker({
      format: '{{ config('myapp.js_date_format') }}',
    });
});
</script>

@push('scripts')
<script>
$(function() {
    $('.datepicker').datepicker({
      format: '{{ config('myapp.js_date_format') }}',
    });
});
</script>
@endpush
