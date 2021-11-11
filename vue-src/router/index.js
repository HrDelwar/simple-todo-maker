import Todos from "../components/Todos";
import {createRouter, createWebHashHistory} from "vue-router";
import AddTodo from "../components/AddTodo";
import Shortcode from "../components/Shortcode";


const routes = [
    {path: '/', name: 'Shortcode', component: Shortcode},
    {path: '/todos', name: 'Todos', component: Todos},
    {path: '/add-todo', name: 'AddTodo', component: AddTodo},
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router;