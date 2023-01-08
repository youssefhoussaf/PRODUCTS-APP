import axios from 'axios';

export default {

    //args ---->>> image
    uploadImage(args){

        let fd= new FormData();
        fd.append('image', args.image);

        return axios.post(`/api/uploadImage`,fd);

    },

}