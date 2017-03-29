@extends($layout)

@prepend('content')
<div id="user-new">
<form-ajax action = "{{ urlTenant('users/new') }}" method="POST" redirect-on-complete="{{ urlTenant('users') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsText('name', trans('user.name')) }}
    {{ Form::bsText('email', trans('user.email')) }}
    {{ Form::bsSelect('role', trans('user.role'), $roles) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('users') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#user-new",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
