<template>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ default }} <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li v-for="merchant in list"><a href="/{{ merchant.mer_id }}">{{ merchant.mer_name }}</a></li>
    </ul>
  </li>
</template>

<script>
    export default {
        created() {
          this.list = JSON.parse(this.list);
        },

        ready() {
            console.log('Merchant component ready.')
        },

        props: ['list', 'default']
    }
</script>
