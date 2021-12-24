import Vue from 'vue'
import VueRouter from "vue-router";
import Welcome from "./components/Welcome.vue";
import ChatContainer from "./components/Chat/container.vue";
import AdminContainer from "./components/Admin/container.vue";

function adminGuard(to, from, next) {
    var user = JSON.parse(localStorage.getItem('user'));
    if (user.name != "Admin" || user.name != "Support") {
        next("/");
    } else {
        next();
    }
}

Vue.use(VueRouter);
export default new VueRouter({
    mode: "history",
    hash: false,
    routes: [
        { path: "/", component: Welcome },
        { path: "/chat", component: ChatContainer },
        { path: "/admin", component: AdminContainer/* , beforeEnter: adminGuard */ },
    ],

});
