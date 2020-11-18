
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
//引入element-ui
import ElementUI from 'element-ui'
import "element-ui/lib/theme-chalk/index.css"
Vue.use(ElementUI)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('menu_header', require('./components/index/nav/menu'));
Vue.component('example', require('./components/Example.vue'));
Vue.component('readme', require('./components/Readme.vue'));
//注册vue组件
Vue.component('publish_essay', require('./components/index/short/publish_essay'));
Vue.component('essay_list', require('./components/index/short/essay_list'));
Vue.component('essay_index_prop', require('./components/index/short/essay_index_prop'));
Vue.component('essay_stat', require('./components/index/short/essay_stat'));
Vue.component('upload_img', require('./components/index/file/upload_img_temp'));
Vue.component('file_index', require('./components/index/file/file_index'));
//组件prop测试
const app = new Vue({
    el: '#app',
});
