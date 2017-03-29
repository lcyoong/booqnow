@extends($layout)

@prepend('content')
<div id="role-edit">
<form-ajax action = "{{ urlTenant('roles/update') }}" method="POST" redirect-on-complete="{{ urlTenant('roles') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('id', $role->id) }}
  <div class="row">
    {{ Form::bsText('name', trans('role.name'), $role->name) }}
    {{ Form::bsText('display_name', trans('role.display_name'), $role->display_name) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('roles') }}" class="btn-sm"></redirect-btn>
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
