@extends($layout)

@prepend('content')
<div id="permission-new">
<form-ajax action = "{{ urlTenant('permissions/new') }}" method="POST" redirect-on-complete="{{ urlTenant('permissions') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsText('name', trans('permission.name')) }}
    {{ Form::bsText('display_name', trans('permission.display_name')) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('permissions') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#permission-new",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
