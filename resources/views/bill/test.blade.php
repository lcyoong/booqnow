@extends($layout)

@section('content_above_list')
@include('bill.filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('bill.bil_id')</th>
    <th>@lang('bill.bil_customer')</th>
    <th>@lang('bill.bil_date')</th>
    <th>{{ trans('bill.total') }}</th>
    <th>{{ trans('bill.outstanding') }}</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  <!-- <component is="list-table"></component> -->
  <tr v-for="item in items" is="list-table" :item="item"></tr>
</tbody>

<!-- <list-table api="api/v1/bills"></list-table> -->
<!-- <child msg="hee"></child> -->
<!-- <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('customers') }}"></redirect-btn> -->
<!-- <div id="example">
  <my-component></my-component>
</div> -->
@endsection

<template id="template-list-table">
  <!-- <tr v-for="item in items"> -->
  <tr>
    <td>@{{ item.bil_id }}</td>
    <td>@{{ item.customer.full_name }}</td>
    <td>@{{ item.bil_date }}</td>
    <td>@{{ item.total_amount }}</td>
    <td>@{{ item.outstanding }}</td>
    <td>
      <a href="bills/@{{ item.bil_id }}" v-modal><i class="fa fa-eye"></i></a>
      <a href="bills/@{{ item.bil_id }}/print" target=_blank><i class="fa fa-print"></i></a>
    </td>
  </tr>
</template>

@push('content')
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
@endpush

@push('scripts')
<script>

Vue.component('list-table', {
    template: '#template-list-table',
    props: ['item', 'api'],
    ready: function() {
      console.log(this.api)
    }
})

// Vue.component('list-table', {
//     template: '#template-list-table',
//     props: ['items', 'api'],
//     ready: function () {
//         console.log('List table component ready.');
//         console.log(this.api);
//         this.fetchStories();
//     },
//     methods: {
//       fetchStories: function (page_url) {
//           let vm = this;
//           page_url = page_url || this.api
//           this.$http.get(page_url)
//               .then(function (response) {
//                 console.log(response.data);
//                 this.items = response.data.data;
//                 // vm.makePagination(response.data);
//                 // vm.$set('items', response.data.data);
//               });
//       },
//
//     },
// });
//

new Vue({
  el: 'body',
  data: {
      items: [],
      pagination: {},
      api_url: '',
  },
  ready: function () {
      this.fetchStories()
      console.log('ready')
  },
  methods: {
      fetchStories: function (page_url) {
          let vm = this;
          page_url = page_url || 'api/v1/bills'
          this.$http.get(page_url)
              .then(function (response) {
                console.log(response.data);
                vm.makePagination(response.data);
                vm.$set('items', response.data.data);
              });
      },
      makePagination: function(data){
          let pagination = {
              current_page: data.current_page,
              last_page: data.last_page,
              next_page_url: data.next_page_url,
              prev_page_url: data.prev_page_url
          }
          this.$set('pagination', pagination)
      }
  }
});

</script>
@endpush
