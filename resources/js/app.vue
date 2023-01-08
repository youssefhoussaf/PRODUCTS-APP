<template>

    <div class="header shadow-sm">
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4">Products App</span>
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <router-link tag="a" class="nav-link" to="/" exact>Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link tag="a" class="nav-link" to="/products" exact>Products</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link tag="a" class="nav-link" to="/categories" exact>Categories</router-link>
                    </li>
                </ul>
            </header>
        </div>
    </div>

    <main>
        <div class="container">
            <router-view />
        </div>
    </main>


</template>

<script>
import ProductsComponent from './pages/Products.vue'
import HomeComponent from './pages/Home.vue'
import 'bootstrap'

export default {
    components: {
        HomeComponent,
        ProductsComponent
    },
}
</script>

<style>

.header{
    background-color: #fff;
}

.router-link-exact-active{
    color: var(--bs-nav-pills-link-active-color) !important;
    background-color: var(--bs-nav-pills-link-active-bg) !important;
}

.colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}

.colored-toast.swal2-icon-error {
  background-color: #f27474 !important;
}

.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}

.colored-toast.swal2-icon-info {
  background-color: #3fc3ee !important;
}

.colored-toast.swal2-icon-question {
  background-color: #87adbd !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}

@import'~bootstrap/dist/css/bootstrap.css';

</style>