@extends($layout)

@section('content_above_list')
@include('customer.filter')
@endsection

@section('content_list')
<div id="customer-list">
  <table class="table table-condensed table-hover table-striped">
    <thead>
      <tr>
        <th>@lang('customer.full_name')</th>
        <th>@lang('customer.cus_country')</th>
        <th>@lang('customer.cus_email')</th>
        <th>@lang('customer.cus_contact1')</th>
        <th>@lang('customer.cus_status')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer)
      <tr>
        <td>{{ $customer->full_name }}</td>
        <td>{{ $countries[$customer->cus_country] }}</td>
        <td>{{ $customer->cus_email }}</td>
        <td>{{ $customer->cus_contact1 }}</td>
        <td>{{ $customer->cus_status }}</td>
        <td>
          <a href="{{ url(sprintf('customers/%s/edit', $customer->cus_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
          <a v-modal href="{{ url(sprintf('trail/customers/%s', $customer->cus_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
          <!-- <a v-modal href="{{ url(sprintf('comments/customers/%s', $customer->cus_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a> -->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@prepend('content')
@include('layouts.list', ['count' => $customers->total()])
{{ $customers->appends(Request::input())->links() }}
@endprepend

@push('scripts')
<script>
new Vue({
  el: '#customer-list',
});
</script>
@endpush
