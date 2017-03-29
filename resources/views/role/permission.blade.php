@extends($layout)

@section('content_list')
<form-ajax action = "{{ urlTenant("roles/$id/permissions") }}" method="POST" @startwait="startWait" @endwait="endWait">
<table class="table table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('permission.id')</th>
      <th>@lang('permission.name')</th>
      <th>@lang('permission.display_name')</th>
      <th>@lang('form.actions')</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="permission in permissions">
      <td>@{{ permission.id }}</td>
      <td>@{{ permission.name }}</td>
      <td>@{{ permission.display_name }}</td>
      <td>
        <bootstrap-toggler :name="'toggled['+permission.id+']'" @input="toggled(permission)" v-model="permission.active" data-size="normal"/>
      </td>
    </tr>
  </tbody>
</table>
<div class="pull-right">{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary', ':disabled' => 'waiting']) }}</div>
</form-ajax>
@endsection

@prepend('content')
<div id="permission-list">
@include('layouts.list')
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#permission-list',

  mixins: [mixForm, mixResponse],

  data: {
    permissions: [],
    role_perms: [],
  },

  created: function () {
    this.getRolePermissions()
  },

  methods: {
    toggled: function(permission) {
      console.log(permission)
      // if (permission.active) {
      //   this.addPermission(permission.id)
      // } else {
      //   this.removePermission(permission.id)
      // }
    },

    getRolePermissions: function () {
      this.$http.get('{{ urlTenant("api/v1/role/$id/permissions") }}')
          .then(function (response) {
            console.log(response.data)
            this.permissions = response.data
          });
    },

    addPermission: function (id) {
      this.$http.post('{{ urlTenant("roles/$id/permissions/add") }}/' + id)
          .then(function (response) {
            console.log(response.data)
          });
    },

    removePermission: function (id) {
      console.log(id)
    },
  }

});

</script>
@endpush
