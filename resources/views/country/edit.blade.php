@extends($layout)

@prepend('content')
<div id="role-edit">
<form-ajax action = "{{ urlTenant('countries/update') }}" method="POST" redirect-on-completex="{{ urlTenant('countries') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('id', $id) }}
  <h3>{{ $country->coun_name }}</h3>
  <div class="row">
    {{ Form::bsSelect('coun_active', trans('country.coun_active'), [0, 1], $country->coun_active) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('countries') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#role-edit",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
