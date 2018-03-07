
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var vexForbiddenAlert
import 'vex-js/dist/css/vex.css'
import 'vex-js/dist/css/vex-theme-os.css'
import vex from 'vex-js'
vex.registerPlugin(require('vex-dialog'))
vex.defaultOptions.className = 'vex-theme-os'

Vue.component('create-post', require('./components/CreatePost.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('operations', require('./components/Operations.vue'));


// Registering Vex Dialog as Vue mixin
// so that it'll be accessible across all
// vue Components.
Vue.mixin({
  data: function () {
    return {
      vex: vex
    }
  }
})

// Interceptors to show dialogs when something goes wrong
// in the API requests.
axios.interceptors.response.use(undefined, err => {
  let res = err.response
  if (res.status === 401) {
    location.href = '/login'
  }

  if (res.status === 403) {
    if (typeof vexForbiddenAlert === 'undefined') {
      vexForbiddenAlert = vex.dialog.alert({
        message: "You're not allowed to do this.",
        callback: function () {
          vexForbiddenAlert = undefined
        }
      })
    }
  }

  if (res.status === 500) {
    if (typeof vexForbiddenAlert === 'undefined') {
      vexForbiddenAlert = vex.dialog.alert({
        message: "Something went wrong!",
        callback: function () {
          vexForbiddenAlert = undefined
        }
      })
    }
  }
})

const app = new Vue({
    el: '#app'
});
