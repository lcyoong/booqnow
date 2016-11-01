
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// require('./moment/moment');
require('./fullcalendar');
require('./fullcalendar-scheduler');
require('./notify');
require('./bootstrap-datepicker');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('sample', require('./components/Example.vue'));
Vue.component('pick-merchant', require('./components/Merchants.vue'));
Vue.component('redirect-btn', require('./components/RedirectButton.vue'));
Vue.component('autocomplete', require('./components/vue-autocomplete.vue'));
// Vue.component('autocomplete', require('./components/vue-autocomplete.vue'));

// Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': Laravel.csrfToken
    }
});

Vue.directive('ajax', {

  params: ['goto', 'gotonext', 'hidecompletemessage', 'successreload'],

  bind: function() {
    console.log(this.params);

    this.el.addEventListener('submit', this.onSubmit.bind(this));

    $('#basicModal').on('hidden.bs.modal', this.onUnload.bind(this));
  },

  onUnload: function(e) {
    // e.preventDefault();
    console.log('unload ' + this.params.gotonext);

    if (this.params.gotonext) {
      showModal(this.params.gotonext);
    }

  },

  onSubmit: function(e) {
    e.preventDefault();

    $('input[type="submit"]').prop('disabled', true);

    var formData = new FormData(this.el);

    this.vm
      .$http['post'](this.el.action, formData)
      .then(this.onComplete.bind(this))
      .catch(this.onError.bind(this));
  },

  onComplete: function(response) {
    onCompleteNotify(response, 'input[type="submit"]');

    if (this.params.gotonext) {

      showModal(this.params.gotonext);

    } else if (this.params.goto) {

      setTimeout(function () { window.location = this.params.goto; }, 3000);

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

Vue.directive('modal', {

  bind: function() {
    this.el.addEventListener('click', this.onClick.bind(this));
  },

  onClick: function(e) {
    e.preventDefault();
    showModal(this.el.href);
  },

  onComplete: function() {
    onCompleteNotify(response, this.el);
  },

  onError: function(response) {
    alert(response.data.message);
  },
})

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
    onCompleteNotify(response, this.el);

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

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function onCompleteNotify(response, el) {

  $(el).prop('disabled', false);

  if (response.data.message) {
    $.notify(response.data.message, {
      position: "bottom right",
      className: "success"
    });
  } else {
    $.notify("Completed without message.", {
      position: "bottom right",
      className: "info"
    });
  }

}

function onErrorNotify(response, el) {

  $(el).prop('disabled', false);

  if (isJson(response.data.message)) {

    var json = $.parseJSON(response.data.message);

    $.each(json, function(key, value) {

      $.notify(value, {
        position: "bottom right",
        className: "error"
      });
    });
  } else {
    $.notify(response.data.message, {
      position: "bottom right",
      className: "error"
    });
  }
}

function showModal(path)
{
  $('#basicModal').find('.modal-content').html('');
  $('#basicModal').modal('show');
  $('#basicModal').find('.modal-content').load(path);
}

const app = new Vue({
    el: 'body',
    ready: function () {
    },
    methods: {
    }
});
