module.exports = {
  data: {
    waiting: false,
  },

  methods: {

    startWait: function () {
      this.waiting = true
    },

    endWait: function () {
      this.waiting = false
    }

  }
}
