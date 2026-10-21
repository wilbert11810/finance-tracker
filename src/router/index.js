import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import Expenses from "../components/Expenses.vue";
import About from "../components/About.vue";
import Login from "../components/Login.vue";
import SignUp from "../components/Signup.vue";
import News from "../components/News.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/expenses", component: Expenses },
  { path: "/about", component: About },
  { path: "/signin", component: Login },
  { path: "/signup", component: SignUp },
  { path: "/news", component: News },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
