require('./bootstrap');

import { createApp } from 'vue'
import AppComponent from './app.vue'
import router from './router'
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

createApp({
    components: {
        AppComponent
    }
})
.use(router)
.use(VueSweetalert2)
.mount('#app');