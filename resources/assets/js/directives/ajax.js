Vue.directive('ajax', {

  params: ['goto', 'gotonext', 'hidecompletemessage', 'successreload', 'gotoappenddata'],

  bind: function() {

    this.el.addEventListener('submit', this.onSubmit.bind(this));

    console.log('ajax directive bound');

    $('#basicModal').on('hidden.bs.modal', this.onUnload.bind(this));
  },

  onUnload: function(e) {

    e.preventDefault();

    // if (this.params.gotonext) {
    //   showModal(this.params.gotonext);
    // }

  },

  onSubmit: function(e) {
    e.preventDefault();

    $('input[type="submit"]').prop('disabled', true);

    var formData = new FormData(this.el);

    this.vm
      .$http.post(this.el.action, formData)
      .then(this.onComplete.bind(this))
      .catch(this.onError.bind(this));
  },

  onComplete: function(response) {

    onCompleteNotify(response, 'input[type="submit"]');

    if (this.params.gotonext) {

      if (this.params.gotoappenddata) {
        var data = JSON.parse(response.data)
        this.params.gotonext = this.params.gotonext + '/' + data.data;
      }

      showModal(this.params.gotonext);

    } else if (this.params.goto) {
      var goto = this.params.goto;

      setTimeout(function () { window.location = goto; }, 2000);

    } else if (this.params.successreload) {

      location.reload();

    }

  },

  onError: function(response) {
    onErrorNotify(response, 'input[type="submit"]');
  },

  getRequestType: function() {
    var method = this.el.querySelector('input[name="_method"]')

    return (method ? method.value : this.el.method).toLowerCase();
  }
})
