@extends($layout)

@push('content')
<div id="add-pos">
<div class="row" style="padding: 10px 0px; font-size: 1em; position: sticky; top: 50px; z-index: 999; background-color: #cfcfcf; margin-bottom: 10px;">
    <div class="col-md-6 col-xs-12">Gingah (Maloney)</div>
    <div class="col-md-2 col-xs-4">Table 4</div>
    <div class="col-md-2 col-xs-4">Total: @{{ sum_amount }}</div>
    <div class="col-md-2 col-xs-4"><span class="label label-primary">Waiting 10 min</span></div>
</div>

<div class="row">
    <div class="col-md-6" style="height: 50vh; overflow-y: scroll;">
        <div v-for = "(resources, index) in groupResources">
          <div class="row">
            <div class="col-xs-12" style="padding: 5px 10px; background-color: #efefef;"><h5>@{{ !(index in sub_types) ? 'N/A' : sub_types[index] }}</h5></div>
          </div>
          <div class="row row-eq-height" v-for = "chunk in _.chunk(resources, 6)">
            <div v-for = "resource in chunk" class="col-xs-2" style="padding: 10px 3px; margin-right: 2px; margin-bottom: 2px; background: #fdfdfd; text-align: center; font-size: 0.8em;">
              <div style="">
                <a href="#!" @click="addItem(resource)">@{{ resource.text }}</a>
              </div>
            </div>
          </div>
        </div>


    </div>
    <div class="col-md-6" style="max-height: 40vh; overflow-y: scroll;">
    <ul class="list-group">
        <li class="list-group-item" v-for="item in items">
          <div class="row">
            <div class="col-xs-1">
            <a href="#"><span @click="removeItem(item)"><i class="fa fa-trash"></i></span></a>
            </div>
            <div class="col-xs-8">
                @{{ item.text }}
                <textarea style="font-size: 0.8em; border: 0px; width: 100%;" placeholder="Any remarks" rows="1"></textarea>
            </div>
            <div class="col-xs-3">
            <a href="#"><span @click="decrementItem(item)"><i class="fa fa-minus"></i></span></a>
              <span style="margin: 0px 15px;">@{{ item.unit }}</span>
              <a href="#"><span @click="incrementItem(item)"><i class="fa fa-plus"></i></span></a>
            </div>
            <!-- <div class="col-xs-3">@{{ item.price }}</div> -->
          </div>
          <input type="hidden" name="addon_id[]" :value="item.json">
        </li>
        </ul>

    </div>

</div>
</div>
@endpush

@prepend('scripts')
<script>
var app2 = new Vue({
    el: '#add-pos',

    mixins: [mixForm],

    data: {
      items: [],
      resources: [],
      sub_types: [],
      groupResources: [],
    },

    computed: {
      sum_amount: function () {

        var sum = 0

        for( var i = 0; i < this.items.length; i++ ){
          sum += parseFloat(this.items[i].price * this.items[i].unit)
        }

        return sum
      },

      chunkedResources () {
         return _.chunk(this.resources, 6)
       },

    },

    created: function () {

      this.getSubTypes()
      this.getResources()

    },

    methods: {
      /**
       * Get all the resources
       */
      getResources: function () {

        this.$http.get("{{ urlTenant("api/v1/resources/3/active/grouped") }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.groupResources = data
            });
      },

      getSubTypes: function () {

        this.$http.get("{{ urlTenant("api/v1/resources/sub_types/3") }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.sub_types = data
            });
      },

      /**
       * Add item
       */
      addItem: function(item) {

        var found = false

        for (var i = 0; i < this.items.length; i++) {
        	if (this.items[i].id === item.id) {
            temp = this.items[i]
            temp.unit ++
            Vue.set(this.items, i, temp)
            found = true
        	}
        }

        if (found === false) {

          item.unit = 1

          this.items.push(item)

        }

        item.json = JSON.stringify({rs_name: item.text, rs_pax: 1, rs_unit: item.unit, rs_price: item.price, rs_id: item.id})

      },

      /**
       * Remove item
       */
      removeItem: function(item) {

        var index = this.items.indexOf(item)

        this.items.splice(index, 1)
      },

      decrementItem: function(item) {

        var index = this.items.indexOf(item)

        if (item.unit > 1) {

          temp = this.items[index]

          json = JSON.parse(temp.json)

          temp.unit --

          json.rs_unit = temp.unit

          temp.json = JSON.stringify(json)

          Vue.set(this.items, index, temp)

        } else {

          this.removeItem(item)

        }

      },

      incrementItem: function(item) {

        var index = this.items.indexOf(item)

        temp = this.items[index]

        json = JSON.parse(temp.json)

        temp.unit ++

        json.rs_unit = temp.unit

        temp.json = JSON.stringify(json)

        Vue.set(this.items, index, temp)

      }

    }
});
</script>
@endprepend
