@extends($layout)

@prepend('content')
<div id="permission-edit">
<form-ajax action = "{{ urlTenant('permissions/update') }}" method="POST" redirect-on-complete="{{ urlTenant('permissions') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('id', $permission->id) }}
  <div class="row">
    {{ Form::bsText('name', trans('role.name'), $permission->name) }}
    {{ Form::bsText('display_name', trans('role.display_name'), $permission->display_name) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('permissions') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#permission-edit",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
