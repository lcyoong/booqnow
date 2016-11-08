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
          $.getJSON('addons/pop/' + this.book_id, function(data) {
            this.items = data;
            console.log(data);
          }.bind(this))
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
