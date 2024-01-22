<template>
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">
    <div v-if="ShowForm">
        <div class="text-end">
            <button class="btn btn-info me-2" :disabled="CheckFrom" @click="SaveStore()" >ບັນທຶກ</button>
            <button class="btn btn-danger" @click="CancelStore()">ຍົກເລີກ</button>
        </div>
        {{ FormStore }}
        <div class="row">
                <div class="col-md-3">Image</div>
                <div class="col-md-9">
                        <div class="mb-2">
                            <label for="product_name" class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
                            <input type="text" class="form-control" v-model="FormStore.name" id="product_name" placeholder="..." >
                        </div>
                        <div class="mb-2">
                            <label for="product_amount" class="form-label fs-6">ຈຳນວນ:</label>
                            <input type="text" class="form-control" v-model="FormStore.amount" id="product_amount" placeholder="..." >
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                <label for="product_price_buy" class="form-label fs-6">ລາຄາຊື້:</label>
                                <input type="text" class="form-control" v-model="FormStore.price_buy" id="product_price_buy" placeholder="..." >
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="product_price_sell" class="form-label fs-6">ລາຄາຂາຍ: </label>
                                    <input type="text" class="form-control" v-model="FormStore.price_sell" id="product_price_sell" placeholder="..." >
                                </div>
                            </div>
                        </div>
                </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!ShowForm" >
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex justify-items-center">
                <div class="d-flex justify-items-center me-2">
                    <i class='bx bx-sort-up fs-3'></i>
                </div>
                <select class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class=" form-control me-2" placeholder="ຄົ້ນຫາ...">
                <button class="btn btn-primary" @click="AddStore()"><i class='bx bx-user-plus me-2 fs-5'></i> ເພີ່ມຂໍ້ມູນ</button>
            </div>
        </div> 
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData" :key="list.id">
            <td> {{ list.id }} </td>
            <td>-</td>
            <td> {{ list.name  }} </td>
            <td> {{ list.price_buy }} </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class='bx bx-copy-alt me-1'></i> ກ໋ອບປີ້</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> ລຶບຂໍ້ມູນ</a>
                </div>
              </div>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>


  </div>
</div>
</template>

<script>
import { useStore } from '../Store/auth'
import axios from 'axios'
export default {
    name: 'Minipos14Store',
    setup(){
        const store = useStore();
        return { store }
    },
    data() {
        return {
          ShowForm:false,
          FormType:true,
          FormStore:{
            name:'',
            image:'',
            amount:'',
            price_buy:'',
            price_sell:'',
          },
          StoreData:[],
        };
    },
    computed:{
        CheckFrom(){
                if(this.FormStore.name=='' || this.FormStore.amount=='' || this.FormStore.price_buy=='' || this.FormStore.price_sell==''){
                    return true;
                }else {
                    return false;
                }
        }
    },

    mounted() {
        
    },

    methods: {
        AddStore(){

            this.FormStore.name = '';
            this.FormStore.amount = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';

            this.ShowForm = true;
            this.FormType = true;
        },
        CancelStore(){
            this.ShowForm = false;
        },
        SaveStore(){
            // ກວດປະເພດ ຟອມ FormType = true ເປັນການເພີ່ມຂໍ້ມູນ, FormType = false ເປັນການອັບເດດຂໍ້ມູນ
            if(this.FormStore){
                // ເພີ່ມຂໍ້ມູນ
                axios.post('api/store/add', this.FormStore, { headers:{ "Content-Type":"multipart/form-data", Authorization:"Bearer "+ this.store.get_token } }).then((res)=>{
                    
                    if(res.data.success){
                        this.ShowForm = false
                    }

                    // console.log(res)
                }).catch((error)=>{
                    console.log(error)
                })

            } else {
                // ອັບເດດຂໍ້ມູນ

            }
        },
        GetStore(){
            axios.get('api/store', { headers:{ Authorization:"Bearer "+ this.store.get_token } }).then((res)=>{

                    this.StoreData = res.data;

                }).catch((error)=>{
                    console.log(error)
                });
        }

    },
    created(){
        this.GetStore();
    }
};
</script>

<style lang="scss" scoped>

</style>