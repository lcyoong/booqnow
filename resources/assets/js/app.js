
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./fullcalendar');
require('./fullcalendar-scheduler');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('sample', require('./components/Example.vue'));
Vue.component('pick-merchant', require('./components/Merchants.vue'));
// Vue.component('autocomplete', require('./components/vue-autocomplete.vue'));

Vue.directive('ajax', {
  bind: function() {
    this.el.addEventListener('submit', this.onSubmit.bind(this));
  },

  data: { fdata: null },

  onSubmit: function(e) {
    e.preventDefault();

    var formData = new FormData(this.el);

    this.vm
      .$http['post'](this.el.action, formData)
      .then(this.onComplete.bind(this))
      .catch(this.onError.bind(this));
  },

  onComplete: function() {
    alert('Done');
  },

  onError: function(response) {
    alert(response.data.message);
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

  data: { fdata: null },

  onClick: function(e) {
    e.preventDefault();
    $('#basicModal').find('.modal-content').html('');
    $('#basicModal').modal('show');
    $('#basicModal').find('.modal-content').load(this.el.href);

  },

  onComplete: function() {
    alert('Done');
  },

  onError: function(response) {
    alert(response.data.message);
  },
})

const app = new Vue({
    el: 'body'
});
