/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default
require('./bootstrap')
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * All the different Vue Apps for pages
 */
Vue.component('chat-app', require('./components/ChatApp/ChatApp.vue').default)
Vue.component('posts-app', require('./components/PostsApp/PostsApp.vue').default)
Vue.component('post', require('./components/PostsApp/Post.vue').default)
Vue.component('posts-component', require('./components/PostsApp/PostsComponent.vue').default)
Vue.component('show-single-post', require('./components/PostsApp/ShowSinglePost.vue').default)
Vue.component('profile-page', require('./components/ProfileApp/ProfilePage.vue').default)
Vue.component('modal', require('./components/Modal/Modal.vue').default)
Vue.component('navbar', require('./components/Navbar/Navbar.vue').default)
Vue.component('users-page', require('./components/UsersApp/UsersPage.vue').default)
Vue.component('register-login-modal', require('./components/RegisterLoginModal/RegisterLoginModal.vue').default)
Vue.component('about-us-page', require('./components/AboutUsPage/AboutUs.vue').default)



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
})
const navbar = new Vue({
    el: '#navbar',
})

