<ul class="list-group">
  <li class="list-group-item list-group-item-info">
    <div style="font-weight: bold; font-size: 1.1em;"><i class="fa fa-user-circle-o"></i> Customer account</div>
    <div class="row">
      <div class="col-md-3"><i class="fa fa-user"></i> {{ $customer->full_name }}</div>
      <div class="col-md-3"><i class="fa fa-envelope-o"></i> {{ $customer->cus_email }}</div>
      <div class="col-md-3"><i class="fa fa-globe"></i> {{ array_get($countries, $customer->cus_country, 'N/A') }}</div>
      <div class="col-md-3"><i class="fa fa-phone"></i> {{ $customer->cus_contact1 }}</div>
    </div>
  </li>
</ul>
