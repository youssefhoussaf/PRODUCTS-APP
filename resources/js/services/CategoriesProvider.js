import axios from 'axios';

export default {

    getAll(){

        return axios.get(`/api/getAllCategories`);

    },

    //args ---->>> per_page , page
    getCategories(args){

        return axios.get(`/api/getCategories?per_page=${args.per_page}&page=${args.page}`);

    },

    //args ---->>> name , category_parent
    create(args){
        return axios.post(`/api/addCategory`,args);

    },

    //args ---->>> id , name , category_parent
    update(args){

        return axios.post(`/api/updateCategory`,args);

    },

    //args ---->>> id
    delete(args){

        return axios.post(`/api/deleteCategory`,args);

    },

}