<template>
<ul id="example-1">
<li v-for="item in items">
  {{ item.rs_name }}
</li>
</ul>

</template>

<script>
    export default {
        created() {
          this.$http.get('addons/pop/' + this.book_id, function(data){
            console.log(data);
            this.items = data;
          })
        },

        data() {
          return {
            items: []
          }
        },

        ready() {
            console.log('Addon list component ready.')
        },

        props: ['book_id']

    }
</script>
