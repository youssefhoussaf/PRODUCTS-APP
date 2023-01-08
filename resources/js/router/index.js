import { createRouter , createWebHistory } from 'vue-router';
import HomeComponent from "../pages/Home.vue"
import ProductsComponent from "../pages/Products.vue"
import CategoriesComponent from "../pages/Categories.vue"

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeComponent,
    },
    {
        path: '/products',
        name: 'Products',
        component: ProductsComponent,
    },
    {
        path: '/categories',
        name: 'Categories',
        component: CategoriesComponent,
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})