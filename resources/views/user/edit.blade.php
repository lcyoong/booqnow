@extends($layout)

@prepend('content')
<div id="role-edit">
<form-ajax action = "{{ urlTenant('users/update') }}" method="POST" redirect-on-completex="{{ urlTenant('users') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('id', $user->id) }}
  <div class="row">
    {{ Form::bsText('name', trans('user.name'), $user->name) }}
    {{ Form::bsText('email', trans('user.email'), $user->email) }}
    {{ Form::bsSelect('role', trans('user.role'), $roles, !empty($user->roles->first()) ? $user->roles->first()->id : '') }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('users') }}" class="btn-sm"></redirect-btn>
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
