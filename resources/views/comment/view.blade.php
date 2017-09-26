@extends($layout)

@prepend('content')
<div id="comment-new">
  <form-ajax action = "{{ urlTenant('comments') }}" call-on-complete = "submitNew" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="refresh">
    <div class="form-group">
      {{ Form::textarea('com_content', '', ['class' => 'form-control', '@keyup.enter' => 'submitNew', 'v-model' => 'newItem', 'rows'=>5]) }}
    </div>
    {{ Form::hidden('com_model_id', $id) }}
    {{ Form::hidden('com_model_type', $type) }}
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  </form-ajax>
  <br/>
  <ul class="list-group">
    <li class="list-group-item" v-for="item in items">
      <span class="label label-default">@{{ item.created_at }} by @{{ item.creator.name }}</span> @{{ item.com_content }}
    </li>
  </ul>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({
  el: "#comment-new",

  mixins: [mixForm],

  data: {
    items: [],
    url: '{{ urlTenant("api/v1/comments/$type/$id") }}',
    newItem: ''
  },

  created: function () {
    console.log('ready')
    this.getList()
  },

  methods: {
    refresh: function (e) {
      // this.items.unshift({com_content: this.newItem, created_at: moment(), created_by: 1 })
      this.getList()
      this.newItem = ''
    },

    getList: function () {
      this.$http.get(this.url)
          .then(function (response) {
            var data = JSON.parse(response.data)
            this.items = data
          });
    }
  }

})
</script>
@endprepend
