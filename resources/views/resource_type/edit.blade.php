@extends('layouts.tenant')

@section('content_tenant')

{{ Form::open(['url' => urlTenant('resource_types/update'), 'v-ajax', 'class' => 'form-horizontal']) }}
{{ Form::hidden('rty_id', $resource_type->rty_id) }}
{{ Form::bsHText('rty_name', trans('resource_type.rty_name'), $resource_type->rty_name, 1, 8) }}
{{ Form::bsHText('rty_price', trans('resource_type.rty_price'), $resource_type->rty_price, 1, 8) }}
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
@endsection
