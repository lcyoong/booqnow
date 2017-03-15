<template>
<form @submit.prevent="ajaxPost">
<slot></slot>
</form>
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

        console.log(formData);

        this.$emit('startwait');

        this
          .$http.post(el.action, formData)
          .then(this.onComplete.bind(this))
          .catch(this.onError.bind(this));
      },

      onComplete: function(response) {

        util.onCompleteNotify(response);

        this.$emit('endwait');

        this.$emit('completesuccess', response.data);

        if (this.reloadOnComplete) {

          location.reload();

        } else if (this.redirectOnComplete !== undefined) {

          window.location = this.redirectOnComplete;

        } else if (this.goToNext !== undefined) {

          var next = this.goToNext

          if (this.goToAppendData !== undefined) {
            next = next + '/' + response.data.data;
          }

          util.showModal(next);
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
        console.log('Form component ready.')
    },

    props: ['reloadOnComplete', 'redirectOnComplete', 'goToNext', 'goToAppendData', 'processing']

  }
</script>
