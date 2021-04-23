import Vue from "vue";
import App from "./App.vue";
import "tailwindcss/dist/tailwind.css";
import VueSVGIcon from 'vue-svgicon'

Vue.use(VueSVGIcon)

Vue.config.productionTip = false;

new Vue({
  render: h => h(App)
}).$mount("#app");
