@extends($layout)

@prepend('content')
<div id="bill-new">
  <form-ajax action = "{{ urlTenant("bills/new/walkin") }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess = "showBill">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        {{ Form::text('bil_customer_name', null, ['class' => 'form-control', 'placeholder' => trans('bill.bil_customer_name')]) }}
      </div>
      {{ Form::submit(trans('bill.walkin'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
    </div>
  </div>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue({
  el: '#bill-new',

  mixins: [mixForm],

  data: {
    new_bill: {},
    show_bill: false
  },

  methods: {
    showBill: function (value) {
      new_bill = value.data.bill
      window.location = '{{ urlTenant('bills') }}/' + new_bill.bil_id + '/edit'
    }
  }
});
</script>
@endprepend
