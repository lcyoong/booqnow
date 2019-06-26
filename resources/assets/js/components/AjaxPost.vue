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

        //var formData = new FormData(el);

        console.log(el);

        this
          .$http.post(this.postTo)
          .then(this.onComplete.bind(this))
          .catch(this.onError.bind(this));
      },

      onComplete: function(response) {
        var data = JSON.parse(response.data)

        console.log(data)
        
        util.onCompleteNotify(response);

        this.$emit('endwait');

        this.$emit('completesuccess', data);

        if (this.reloadOnComplete) {
          location.reload();
        } else if (this.redirectOnComplete !== undefined) {
          window.location = this.redirectOnComplete;
        }

      },

      onError: function(response) {
        console.log(response);
        util.onErrorNotify(response);

        this.$emit('endwait');

        this.$emit('completeerror');
      },
    },

    ready() {
        console.log('Addon list component ready.')
    },

    props: ['reloadOnComplete', 'redirectOnComplete', 'postTo']

  }
</script>
