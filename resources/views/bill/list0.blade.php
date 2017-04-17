@extends($layout)

@section('content_above_list')
@include('bill.filter')
@endsection

@section('content_list')
<div id="container">
<list-table api="api/v1/bills" template="#template-list-table"></list-table>
</div>
@endsection

<template id="template-list-table">
  <table class="table table-condensed">
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
      <tr v-for="item in items">
      <td>@{{ item.bil_id }}</td>
      <td>@{{ item.customer.full_name }}</td>
      <td>@{{ item.bil_date }}</td>
      <td>@{{ item.total_amount }}</td>
      <td>@{{ item.outstanding }}</td>
      <td>
        <a v-modal :href="'bills/' + item.bil_id"><i class="fa fa-eye"></i></a>
        <a v-modal :href="'trail/bills/' + item.bil_id"><i class="fa fa-history"></i></a>
      </td>
      </tr>
    </tbody>
  </table>
</template>

@push('content')
@include('layouts.list')
@endpush

@push('scripts')
<script>
var myMixin = {
  created: function () {
    console.log('created')
    console.log(this.template)
  },

  mounted: function () {
    console.log('ready')
    console.log(this.template)
    this.fetchStories()
  },

  methods: {
      fetchStories: function (page_url) {
          let vm = this;
          page_url = page_url || this.api
          this.$http.get(page_url)
              .then(function (response) {
                console.log(response.data);
                vm.makePagination(response.data);
                // vm.$set('items', response.data.data);
                this.items = response.data.data;
                this.total = response.data.total;
              });
      },
      makePagination: function(data){
          let pagination = {
              current_page: data.current_page,
              last_page: data.last_page,
              next_page_url: data.next_page_url,
              prev_page_url: data.prev_page_url
          }
          // this.$set('pagination', pagination)
      }
  }
}

Vue.component('list-table', {
    template: '#template-list-table',
    props: ['api'],
    data: function () {
      return {
        items: [],
        total: 0,
      }
    },
    methods: {
      viewUrl: function (item) {
        return "bills/" + item;
      }
    },
    mixins: [myMixin]
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
  el: '#container',
  components: {
    // VPaginator: VuePaginator
  },
});

</script>
@endpush
