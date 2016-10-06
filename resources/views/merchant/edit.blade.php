@extends('layouts.common')

@section('content_common')

{{ Form::open(['url' => 'merchants/update', 'v-ajax', 'class' => 'form-horizontal']) }}
{{ Form::hidden('mer_id', $merchant->mer_id) }}
{{ Form::bsHText('mer_name', trans('merchant.mer_name'), $merchant->mer_name, 1, 8) }}
{{ Form::bsHSelect('mer_country', trans('merchant.mer_country'), $countries, $merchant->mer_country, 1, 8) }}

@foreach(config('merchant.setting') as $setting)
{{ Form::bsHText($setting, '', array_get($mer_setting, $setting), 1, 8) }}
@endforeach

{{ Form::submit('Sign', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
@endsection
