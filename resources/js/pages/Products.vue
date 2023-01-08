<template>
    <div id="ProdutsPage">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            
            <h2>Products</h2>

            <hr>

            <div>

                <div class="form-group mb-4">
                    <label>Image</label>
                    <div v-if="form.image==null" class="upload_box">
                        <span>Choose image <i class="fas fa-upload"></i></span>
                        <input type="file" @change="uploadImage" name="image" accept="image/*" class="form-control-file">
                    </div>
                    <div v-else class="image_box">
                        <div class="remove_img" @click="form.image=null"><i class="fas fa-close"></i></div>
                        <img :src="'/storage/'+form.image">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6 mb-2">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" :class="errors.name ? 'is-invalid' : ''" v-model="form.name">
                        <div class="invalid-feedback">
                            {{ errors.name?.join('<br/>') }}
                        </div>
                    </div>
                    <div class="form-group col-6 mb-2">
                        <label>Price</label>
                        <input type="number" class="form-control" placeholder="Enter price" :class="errors.price ? 'is-invalid' : ''" v-model="form.price">
                        <div class="invalid-feedback">
                            {{ errors.price?.join('<br/>') }}
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-6 mb-4">
                        <label>Description</label>
                        <textarea class="form-control" :class="errors.description ? 'is-invalid' : ''" rows="3" v-model="form.description"></textarea>
                        <div class="invalid-feedback">
                            {{ errors.description?.join('<br/>') }}
                        </div>
                    </div>

                    <div class="form-group col-6 mb-2">
                        <label>Category</label>
                        <select class="form-control" :class="errors.id_category ? 'is-invalid' : ''" v-model="form.id_category">
                            <option :value="null">Choose category</option>
                            <option v-for="c of categories" :key="c.id" :value="c.id">{{c.name}}</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ errors.id_category?.join('<br/>') }}
                        </div>
                    </div>
                </div>

                <div class="mb-2" style="display: flex;align-items: center;">
                    <button :disabled="saveLoader" class="btn btn-primary mx-2" @click="save">Save</button>
                    <button :disabled="saveLoader" class="btn btn-secondary mx-2" @click="cancel">Cancel</button>

                    <div v-if="saveLoader" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

            </div>

            <hr>

            <h5>filters :</h5>

            <div class="row">
                <div class="form-group col-4 mb-2">
                    <label>Category</label>
                    <select class="form-control" v-model="filters.category">
                        <option :value="null">All</option>
                        <option v-for="c of categories" :key="c.id" :value="c.id">{{c.name}}</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <button class="btn btn-primary mx-2" @click="loadData">Aplly filter</button>
            </div>

            <hr>

            <div class="table-responsive mt-4">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        <select class="form-select" style="padding: 0px 35px 0px 5px; width: fit-content;"
                                v-model="pagination.per_page" @change="pagination.page=1;loadData();">

                            <option :value="20">20</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                            <option :value="250">250</option>
                            <option :value="500">500</option>

                        </select>
                    </div>
                </div>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th class="sortable" scope="col" @click="sortBy('id')">
                                <div>
                                    <span v-if="sort.column=='id'">
                                        <i v-if="sort.order=='DESC'" class="fas fa-arrow-up"></i>
                                        <i v-else class="fas fa-arrow-down"></i>
                                    </span>
                                    # 
                                </div>
                            </th>
                            <th class="sortable" scope="col" @click="sortBy('name')">
                                <div>
                                    <span v-if="sort.column=='name'">
                                        <i v-if="sort.order=='DESC'" class="fas fa-arrow-up"></i>
                                        <i v-else class="fas fa-arrow-down"></i>
                                    </span>
                                    Name
                                </div>
                            </th>
                            <th scope="col">Description</th>
                            <th class="sortable" scope="col" @click="sortBy('price')">
                                <div>
                                    <span v-if="sort.column=='price'">
                                        <i v-if="sort.order=='DESC'" class="fas fa-arrow-up"></i>
                                        <i v-else class="fas fa-arrow-down"></i>
                                    </span>
                                    Price
                                </div>
                                
                            </th>
                            <th scope="col">Category</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loader">
                            <td style="text-align: center;" colspan="7">
                                <div class="spinner-border" role="status">
                                </div>
                            </td>
                        </tr>
                        <tr v-for="d of data" :key="d.id">
                            <td><img width="50" :src="d.image?('/storage/'+d.image):'/img/no-image-icon.png'"></td>
                            <th>{{d.id}}</th>
                            <td>{{d.name}}</td>
                            <td>{{d.description}}</td>
                            <td>{{d.price}}</td>
                            <td>{{d.category}}</td>
                            <td>{{toDate(d.created_at)}}</td>
                            <td>
                                <button @click="edit(d)" class="btn p-0 m-0 me-2" title="Modifier"><i class="fas fa-edit text-success"></i></button>
                                <button @click="deleteProduct(d.id)" class="btn p-0 m-0 me-2" title="Supprimer"><i class="fas fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mb-2" style="justify-content: right;">
                Page: 
                <button type="button" class="btn btn-primary btn-sm mx-2" style="width: fit-content" 
                    :disabled="pagination.page==1" @click="paginatePrev">
                    Prev.
                </button>

                <select class="form-select" style="padding: 0px 35px 0px 5px; width: fit-content;" v-model="pagination.page" @change="loadData()" >
                    <option v-for="i in pagination.last_page" :key="i" :value="i">
                        {{ i }}
                    </option>
                </select>

                <button type="button" class="btn btn-primary btn-sm mx-2" style="width: fit-content" 
                    :disabled="pagination.page==pagination.last_page" @click="paginateNext">
                    Next
                </button>
            </div>

        </div>
    </div>
</template>

<script>
import ProductsProvider from '../services/ProductsProvider';
import CategoriesProvider from '../services/CategoriesProvider';
import UploadProvider from '../services/UploadProvider';
import moment from 'moment';

export default {
    data() {
        return {
            errors:{},
            data: [],
            categories: [],
            loader:false,
            saveLoader: false,
            pagination:{
                page: 1,
                per_page: 20,
                last_page: 1,
            },
            sort:{
                column: 'id',
                order: 'DESC'
            },
            filters:{
                category: null,
            },
            form:{
                id: null,
                name: '',
                description: '',
                price: '',
                id_category: null,
                image: null,
            }
        }
    },
    mounted() {
        this.loadData();
        this.loadCategories();
    },
    methods:{
        loadData(){
            this.loader = true;
            ProductsProvider.getProducts(
                {
                    per_page:this.pagination.per_page,
                    page:this.pagination.page,
                    sort:this.sort,
                    filters:this.filters,
                })
                .then(response=>{
                    this.loader = false;
                    this.data = response.data.data.data; //Get Products
                    this.pagination.last_page = response.data.data.last_page; //Get total pages number
                })
                .catch((error)=>{
                    this.DisplayToast('Error','error');
                    console.log(error);
                    this.loader = false;
                });
        },
        loadCategories(){
            CategoriesProvider.getAll()
                .then(response=>{
                    this.categories = response.data.data;
                })
                .catch((error)=>{
                    this.DisplayToast('Error','error');
                    console.log(error);
                    this.loader = false;
                });
        },
        toDate(date){
            return moment(date).format('DD MMM. YYYY HH:mm')
        },
        paginateNext(){
            this.pagination.page++;
            this.loadData();
        },
        paginatePrev(){
            this.pagination.page--;
            this.loadData();
        },
        cancel(){
            this.form={
                id: null,
                name: '',
                description: '',
                price: '',
                id_category: null,
                image: null,
            };
        },
        //upload Image to server
        uploadImage(e){
            UploadProvider.uploadImage({image: e.target.files[0]})
                .then(resp => {
                    this.form.image = resp.data.image;
                })
                .catch((error)=>{
                    this.DisplayToast('The image must be a file of type: png, jpg, jpeg.','error');
                });
        },
        //Add or update a product
        save(){
            this.saveLoader = true;
            this.errors = {};
            //add
            if(this.form.id==null){
                ProductsProvider.create(this.form)
                    .then(()=>{
                        this.saveLoader = false;
                        this.pagination.page = 1;
                        this.cancel();
                        this.loadData();
                        this.DisplayToast('Product successfully added','success');
                    })
                    .catch((error)=>{
                        this.DisplayToast('Error','error');
                        this.saveLoader = false;
                        if(error.response.data.errors) this.errors = error.response.data.errors;
                    });
            }
            //update
            else{
                ProductsProvider.update(this.form)
                    .then(()=>{
                        this.saveLoader = false;
                        this.pagination.page = 1;
                        this.cancel();
                        this.loadData();
                        this.DisplayToast('Product successfully updated','success');
                    })
                    .catch((error)=>{
                        this.DisplayToast('Error','error');
                        this.saveLoader = false;
                        if(error.response.data.errors) this.errors = error.response.data.errors;
                    });
            }
        },
        edit(product){
            this.form.id = product.id;
            this.form.name = product.name;
            this.form.price = product.price;
            this.form.description = product.description;
            this.form.id_category = product.id_category;
            this.form.image = product.image;
        },
        deleteProduct(id){
            this.$swal({
                title: 'Are you really want to delete this product?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    ProductsProvider.delete({id})
                        .then(() => {
                            this.loadData();
                            this.DisplayToast('Product successfully deleted','success');
                        })
                        .catch((error)=>{
                            this.DisplayToast('Error','error');
                        });
                }
            });
        },
        DisplayToast(text,icon){
            this.$swal({
                toast: true,
                position: 'top-right',
                text: text,
                icon: icon,
                iconColor: 'white',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                },
            });
        },
        sortBy(column){
            if(this.sort.column == column) this.sort.order = this.sort.order=='ASC'?'DESC':'ASC';
            else this.sort.order = 'ASC';
            this.sort.column = column;
            this.loadData();
        }
    }
}

</script>

<style>

.upload_box{
    background-color: #dbdbdb;
    border: 3px dashed #a4a0a0;
    color:#a4a0a0;
    width: 300px;
    height: 80px;
    position: relative;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 10px;
}

.upload_box input[type=file]{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 2;
    opacity: 0;
    cursor: pointer;
}

.image_box{
    width: 200px;
    height: 150px;
    position: relative;
    margin-top: 10px;
}

.image_box img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    border: 1px solid gray;
    border-radius: 10px;
}

.image_box .remove_img{
    position: absolute;
    right: 0;
    top: 0;
    background-color: red;
    color: white;
    border-radius: 50px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
}

.image_box .remove_img:hover{
    color: red;
    background-color: white;
}

.sortable div{
    display: flex;
    align-items: center;
    cursor: pointer;
}

</style>