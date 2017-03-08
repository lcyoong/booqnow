module.exports = {
  methods: {

    onComplete: function(response) {

      util.onCompleteNotify(response);

      this.$emit('endwait');

      this.$emit('completesuccess');

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

  }
}
