<template>
<a href="#" @click.prevent="ajaxPost">
<slot></slot>
</a>
</template>

<script>
  export default {
    created() {
    },

    data() {
      return {
        items: []
      }
    },

    methods: {
      ajaxPost: function(e) {
        var el = e.target;

        var formData = new FormData(el);

        console.log(el);

        this
          .$http.post(this.postTo, formData)
          .then(this.onComplete.bind(this))
          .catch(this.onError.bind(this));
      },

      onComplete: function(response) {

        util.onCompleteNotify(response);

        if (this.reloadOnComplete) {
          location.reload();
        } else if (this.redirectOnComplete !== undefined) {
          window.location = this.redirectOnComplete;
        }

      },

      onError: function(response) {
        console.log(response);
        util.onErrorNotify(response);
      },
    },

    ready() {
        console.log('Addon list component ready.')
    },

    props: ['reloadOnComplete', 'redirectOnComplete', 'postTo']

  }
</script>
