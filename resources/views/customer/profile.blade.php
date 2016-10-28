<h4>
  <div class="row">
    <div class="col-md-3"><i class="fa fa-user"></i> {{ $customer->full_name }}</div>
    <div class="col-md-3">{{ array_get($countries, $customer->cus_country, 'N/A'), trans('customer.cus_country') }}</div>
    <div class="col-md-3"><span class="label label-success">{{ showMoney($customer->ltv(), true) }}</span></div>
  </div>
</h4>
<!-- <div class="row">
  {{ Form::showField($customer->cus_email, trans('customer.cus_email')) }}
  {{ Form::showField(array_get($countries, $customer->cus_country, 'N/A'), trans('customer.cus_country')) }}
</div> -->
