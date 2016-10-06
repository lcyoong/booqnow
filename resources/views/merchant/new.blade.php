@extends('layouts.common')

@section('content_common')

{{ Form::open(['url' => 'merchants/new', 'v-ajax', 'class' => 'form-horizontal']) }}
{{ Form::bsHText('mer_name', 'Name', '', 1, 8) }}
{{ Form::bsHSelect('mer_country', 'Country', $countries, '', 1, 8) }}
{{ Form::submit('Sign', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

@endsection
