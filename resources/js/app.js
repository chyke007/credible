/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

//Route infromation for vue router
import Router from "@/js/router.js";

//component file
import App from "@/js/views/App";

window.Vue = require("vue");
//vuex
import Store from "./stores";

//ElementUI
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
Vue.use(ElementUI);

import VueToastr from "vue-toastr";
// use plugin
Vue.use(VueToastr, {
    /* OverWrite Plugin Options if you need */
});

const app = new Vue({
    el: "#app",
    router: Router,
    store: Store,
    render: h => h(App)
});

export default App;
