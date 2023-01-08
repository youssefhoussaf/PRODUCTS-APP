<template>
    <div id="ProdutsPage">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            
            <h2>Categories</h2>

            <hr>

            <div>

                <div class="row">
                    <div class="form-group col-6 mb-2">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" :class="errors.name ? 'is-invalid' : ''" v-model="form.name">
                        <div class="invalid-feedback">
                            {{ errors.name?.join('<br/>') }}
                        </div>
                    </div>
                    <div class="form-group col-6 mb-2">
                        <label>Category</label>
                        <select class="form-control" :class="errors.category_parent ? 'is-invalid' : ''" v-model="form.category_parent">
                            <option :value="null">Choose category</option>
                            <option v-for="c of categories" :key="c.id" :value="c.id">{{c.name}}</option>
                        </select>
                        <div class="invalid-feedback">
                            {{ errors.category_parent?.join('<br/>') }}
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
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Parent category</th>
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
                            <th>{{d.id}}</th>
                            <td>{{d.name}}</td>
                            <td>{{d.parent??'__'}}</td>
                            <td>
                                <button @click="edit(d)" class="btn p-0 m-0 me-2" title="Modifier"><i class="fas fa-edit text-success"></i></button>
                                <button @click="deleteCategory(d.id)" class="btn p-0 m-0 me-2" title="Supprimer"><i class="fas fa-trash text-danger"></i></button>
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
import CategoriesProvider from '../services/CategoriesProvider';
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
            form:{
                id: null,
                name: '',
                category_parent: null,
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
            CategoriesProvider.getCategories(
                {
                    per_page:this.pagination.per_page,
                    page:this.pagination.page
                })
                .then(response=>{
                    this.loader = false;
                    this.data = response.data.data.data; //Get categories
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
                category_parent: null,
            };
        },
        //Add or update a category
        save(){
            this.saveLoader = true;
            this.errors = {};
            //add
            if(this.form.id==null){
                CategoriesProvider.create(this.form)
                    .then(()=>{
                        this.saveLoader = false;
                        this.pagination.page = 1;
                        this.cancel();
                        this.loadData();
                        this.loadCategories();
                        this.DisplayToast('Category successfully added','success');
                    })
                    .catch((error)=>{
                        this.DisplayToast('Error','error');
                        this.saveLoader = false;
                        if(error.response.data.errors) this.errors = error.response.data.errors;
                    });
            }
            //update
            else{
                CategoriesProvider.update(this.form)
                    .then(()=>{
                        this.saveLoader = false;
                        this.pagination.page = 1;
                        this.cancel();
                        this.loadData();
                        this.loadCategories();
                        this.DisplayToast('category successfully updated','success');
                    })
                    .catch((error)=>{
                        this.DisplayToast('Error','error');
                        this.saveLoader = false;
                        if(error.response.data.errors) this.errors = error.response.data.errors;
                    });
            }
        },
        edit(category){
            this.form.id = category.id;
            this.form.name = category.name;
            this.form.category_parent = category.category_parent;
        },
        deleteCategory(id){
            this.$swal({
                title: 'Are you really want to delete this category?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    CategoriesProvider.delete({id})
                        .then(() => {
                            this.loadData();
                            this.loadCategories();
                            this.DisplayToast('category successfully deleted','success');
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

</style>