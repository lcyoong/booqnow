<div id="edit-profile">
  <div v-if="!edit_profile">
    <ul class="list-group">
      <li class="list-group-item list-group-item">
        <div style="font-weight: bold; font-size: 1.1em; float: left"><i class="fa fa-user-circle-o"></i> Guest </div>
        <a href="#/" @click="enableEdit" style="float: right"><i class="fa fa-edit"></i></a>
        <div style="clear: both"></div>
        <div class="row">
          <div class="col-md-3"><i class="fa fa-user"></i> @{{ customer.full_name }}</div>
          <div class="col-md-3"><i class="fa fa-envelope-o"></i> @{{ customer.cus_email }}</div>
          <!-- <div class="col-md-3"><i class="fa fa-globe"></i> {{ array_get($countries, $customer->cus_country, 'N/A') }}</div> -->
          <div class="col-md-3"><i class="fa fa-globe"></i> @{{ customer.full_country }}</div>
          <div class="col-md-3"><i class="fa fa-phone"></i> @{{ customer.cus_contact1 }}</div>
        </div>
      </li>
    </ul>
  </div>
  <div v-else>
    <ul class="list-group">
      <li class="list-group-item list-group-item">
        @include('customer.edit_simple', ['customer' => $customer])
      </li>
    </ul>
  </div>
</div>

@prepend('scripts')
<script>
  new Vue({
    el: '#edit-profile',
    mixins: [mixForm],
    data: {
      edit_profile: 0,
      customer: {!! $customer !!},
    },
    methods: {
      enableEdit: function () {
        this.edit_profile = 1
      },
      profileSaved: function () {
        this.$http.get("{{ urlTenant("/api/v1/customers/" . $customer->cus_id) }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.customer = data
            });        
        this.edit_profile=0        
      }
    }
  });
</script>
@endprepend