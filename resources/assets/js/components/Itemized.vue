<template>
<button @click="saveItem($event)">
<slot></slot>
</button>
</template>

<script>
  export default {
    created() {
      // console.log(this.item)
    },

    mixins: [mixResponse],

    methods: {
      saveItem: function(e) {

        var formData = this.item

        this
          .$http.post(this.action, formData)
          .then(this.onComplete.bind(this))
          .catch(this.onError.bind(this));
      },

    },

    props: ['reloadOnComplete', 'redirectOnComplete', 'goToNext', 'goToAppendData', 'processing', 'item', 'action']

  }
</script>
