@extends($layout)

@prepend('content')
<div id="role-edit">
  <form-ajax action="{{ urlTenant('users/update') }}" method="POST" redirect-on-completex="{{ urlTenant('users') }}"
    @startwait="startWait" @endwait="endWait">
    {{ Form::hidden('id', $user->id) }}
    <div class="row">
      {{ Form::bsText('name', trans('user.name'), $user->name) }}
      {{ Form::bsText('email', trans('user.email'), $user->email) }}
      {{ Form::bsSelect('role', trans('user.role'), $roles, !empty($user->roles->first()) ? $user->roles->first()->id :
      '') }}
      <div class="col-md-3">
        <div class="form-group">
          {{ Form::label('Status') }}
          <div>
            <bootstrap-toggler name="status" v-model="status" data-size="normal"/>
            <!-- {{ Form::checkbox('status', 1, null, ['v-model' => 'status']) }} <span>@{{ statusLabel }}</span> -->
          </div>
        </div>
      </div>
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
    <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('users') }}" class="btn-sm"></redirect-btn>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
  new Vue({

    el: "#role-edit",

    mixins: [mixForm],
    
    // created: function () {
    //   this.statusLabelUpdate()
    // },

    data: {
      status: {{ !empty($user->status) ? 'true' : 'false' }},
      // statusLabel: null, 
    },

    // watch: {
    //   status: function (val) {
    //     this.statusLabelUpdate()
    //   }
    // },

    // methods: {
    //   statusLabelUpdate: function () {
    //     if (this.status) {
    //       this.statusLabel = 'Active'
    //     } else {
    //       this.statusLabel = 'Not active'
    //     }

    //   }
    // }

  })
</script>
@endprepend