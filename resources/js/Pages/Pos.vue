<template>
    <di class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <input type="text" class=" form-control" placeholder="ຄົ້ນຫາ...">
                </div>

            </div>

            <perfect-scrollbar>
                <div style="height:66vh;"> 
                <div class="row m-1">
                    <div class="col-md-3" v-for="item in StoreData.data" :key="item">
                        <div class="card mb-3 cursor-pointer">
                            <span class="number-list">10</span>
                            <img class="card-img-top img-pos" v-if="item.image" :src="url + '/assets/img/'+item.image">
                            <img class="card-img-top img-pos" v-else :src="url + '/assets/img/no_img.jpg'">
                            <div class="card-body p-1 text-center">
                                <h5 class="card-title m-0">{{item.name}}</h5>
                                <p class="card-text">
                                13.000 kip
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </perfect-scrollbar>

        </div>
        <div class="col-md-4" >
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                            <label for="customer_name">ຊື່ລູກຄ້າ:</label>
                            <input type="text" class=" form-control" id="customer_name" placeholder=".....">
                            <label for="customer_tel">ເບີໂທ:</label>
                            <input type="text" class=" form-control" id="customer_tel" placeholder=".....">
                    </div>
                    <hr>
                    <div class="p-3">
                        <div class=" d-flex justify-content-between fs-4 fw-bold text-info" >
                            <span>ລວມຍອດເງິນ:</span>
                            <span>120.000 ກີບ</span>
                        </div>
                      <button class="btn btn-success fw-bold w-100 fs-5 ">ຊຳລ່ະເງິນ</button>
                    </div>

                 
                    <perfect-scrollbar class="mb-3">
                        <div style="height: 40vh;">
                        <div class="table-responsive text-nowrap mb-3" >
                            <table class="table border">
                            <thead>
                                <tr>
                                <th>ລາຍລະອຽດ</th>
                                <th>ລາຄາ</th>
                                <th>ລາຄາລວມ</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="list in 20" :key="item">
                                        <td>ເຫັດຫອມ</td>
                                        <td>10.000</td>
                                        <td>10.000</td>
                                    </tr>
                            </tbody>

                            </table>
                        </div>
                </div>
                </perfect-scrollbar>
       
                    
                </div>
            </div>
        </div>
        <!-- {{ StorData }} -->
    </di>
</template>

<script>
import { useStore } from '../Store/auth'
export default {
    setup(){
        const store = useStore();
        return { store }
    },
    name: 'Minipos14Pos',

    data() {
        return {
            url: window.location.origin,
            Sort:'desc',
            PerPage: '30',
            Search:'',
            StoreData: [],
            ListOrder:[]
        };
    },

    mounted() {
        
    },

    methods: {
        GetStore(page){
            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`, { headers:{ Authorization:"Bearer "+ this.store.get_token } }).then((res)=>{

                    this.StoreData = res.data

                }).catch((error)=>{
                    console.log(error)
                    if(error){
                        if(error.response.status == 401){
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem("web_token")
                            localStorage.removeItem("web_user")
                            this.$router.push("/login")

                        }
                    }
                });
        }
    },
    created(){
            this.GetStore()
        } 
        
    }
</script>

<style  scoped>

/* .ps {
  height: 400px;
} */

.img-pos{
    object-fit: cover;
    width: 100%;
    height: 110px;
    object-position: center;
}
.number-list{
    position: absolute;
    background: blue;
    color: white;
    padding: 5px;
    right: 0px;
    border-radius: 0px 10px 0px 10px;
}

</style>