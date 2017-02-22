Vue.directive('post', {
  params: ['postto', 'successreload'],

  bind: function() {
    this.el.addEventListener('click', this.onClick.bind(this));
  },

  onClick: function(e) {
    e.preventDefault();

    $(this.el).prop('disabled', true);

    var formData = new FormData(this.el);

    this.vm
      .$http['post'](this.params.postto, formData)
      .then(this.onComplete.bind(this))
      .catch(this.onError.bind(this));

  },

  onComplete: function(response) {
    booqnow.onCompleteNotify(response, this.el);

    if (this.params.successreload) {
      $.notify("Refreshing your page... Please wait", {
        position: "bottom right",
        className: "info"
      });

      setTimeout(function () { location.reload(); }, 2000);

    }
  },

  onError: function(response) {
    onErrorNotify(response, this.el);
  },
})
