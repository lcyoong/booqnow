Vue.directive('modal', {

  bind: function(el, binding, vnode) {

    el.addEventListener('click', function (e) {

      e.preventDefault()

      util.showModal(this.href)
    });

  }  
})
