@extends($layout)

@prepend('content')
<div id="role-new">
<form-ajax action = "{{ urlTenant('roles/new') }}" method="POST" redirect-on-complete="{{ urlTenant('roles') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsText('name', trans('role.name')) }}
    {{ Form::bsText('display_name', trans('role.display_name')) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('roles') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#role-new",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
