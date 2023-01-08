import axios from 'axios';

export default {

    //args ---->>> per_page , page
    getProducts(args){

        return axios.post(`/api/getProducts`,args);

    },

    //args ---->>> name , description , price , id_category , image
    create(args){

        return axios.post(`/api/addProduct`,args);

    },

    //args ---->>> id , name , description , price , id_category , image
    update(args){

        return axios.post(`/api/updateProduct`,args);

    },

    //args ---->>> id
    delete(args){

        return axios.post(`/api/deleteProduct`,args);

    },

}