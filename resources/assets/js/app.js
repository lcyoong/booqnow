/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('moment');
// require("imports?moment=moment");
require('fullcalendar');
require('fullcalendar-scheduler');
require('./notify');
require('bootstrap-datepicker');
require('select2'); //require('./select2');
require('./booqnow');
// require('vue2-autocomplete-js');
window.util = require('./utilities');

// window.VuePaginator = require('vuejs-paginator');
// window.common = require('./booqnow');

// Vue.directive('ajax', require('./directives/ajax.js'));
require('./directives/modal.js');

window.mixForm = require('./mixins/form.js');
// require('./directives/post.js');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('pick-merchant', require('./components/Merchants.vue'));
Vue.component('redirect-btn', require('./components/RedirectButton.vue'));
// Vue.component('autocomplete', require('./components/vue-autocomplete.vue'));
Vue.component('autocomplete', require('./components/AutoComplete.vue'));
Vue.component('addon-list', require('./components/AddonList.vue'));
Vue.component('form-ajax', require('./components/AjaxForm.vue'));
Vue.component('post-ajax', require('./components/AjaxPost.vue'));
Vue.component('vue-select', require('./components/Select2.vue'));
// Vue.component('autocomplete', require('./components/vue-autocomplete.vue'));
//

// Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': Laravel.csrfToken
    }
});


/**
 * Display modal
 * @param  {[type]} path [description]
 * @return {[type]}      [description]
 */
// function showModal(path)
// {
//   $('#basicModal').find('.modal-content').html('');
//   $('#basicModal').modal('show');
//   $('#basicModal').find('.modal-content').load(path);
// }

// Vue.directive('post', {
//   params: ['postto', 'successreload'],
//
//   bind: function() {
//     this.el.addEventListener('click', this.onClick.bind(this));
//   },
//
//   onClick: function(e) {
//     e.preventDefault();
//
//     $(this.el).prop('disabled', true);
//
//     var formData = new FormData(this.el);
//
//     this.vm
//       .$http['post'](this.params.postto, formData)
//       .then(this.onComplete.bind(this))
//       .catch(this.onError.bind(this));
//
//   },
//
//   onComplete: function(response) {
//     onCompleteNotify(response, this.el);
//
//     if (this.params.successreload) {
//       $.notify("Refreshing your page... Please wait", {
//         position: "bottom right",
//         className: "info"
//       });
//
//       setTimeout(function () { location.reload(); }, 2000);
//
//     }
//   },
//
//   onError: function(response) {
//     onErrorNotify(response, this.el);
//   },
// })

// Vue.directive('redirect', {
//   params: ['redirectto'],
//
//   bind: function() {
//     this.el.addEventListener('click', this.onClick.bind(this));
//   },
//
//   onClick: function(e) {
//     e.preventDefault();
//
//     $(this.el).prop('disabled', true);
//
//     window.location = this.params.redirectto;
//   },
// })

/**
 * Modal custom directive
 */
// Vue.directive('modal', {
//
//   bind: function(el, binding, vnode) {
//     // el.addEventListener('click', this.onClick.bind(el));
//     el.addEventListener('click', function (e) {
//
//       e.preventDefault()
//
//       showModal(this.href)
//     });
//   },
//
//   onClick: function(e) {
//
//     e.preventDefault()
//
//     showModal(this.href)
//   },
// })

// var vm = new Vue({
//     el: '#app',
//
//     created: function () {
//       $.notify("Hello World Mom");
//       // alert(test.isJson('sss'));
//       // test.run();
//       // $.notify('Hi', {
//       //   position: "bottom right",
//       //   className: "success"
//       // });
//     },
//     //
//     // data: {
//     //
//     //   disabled: false,
//     //   data: [],
//     //
//     // },
// });

// var vm = new Vue({
//   el: '#app',
//
//   created: function () {
//     console.log('#app vue ready');
//   }
// })
