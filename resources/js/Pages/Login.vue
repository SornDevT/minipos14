<template>
    <div class=" d-flex justify-content-center">

    
    <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">

          <h4 class="mb-2">ສະບາຍດີ! 👋</h4>
          <p class="mb-4">ຍິນດີຕ້ອນຮັບ, ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

          
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌:</label>
              <input type="text"  class="form-control" id="email" placeholder="...." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control"  placeholder="············" >
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
           
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">ເຂົ້າສູ່ລະບົບ</button>
            </div>


          <p class="text-center">
            <span>ບໍ່ມີບັນຊີຜູ້ໃຊ້?</span>
            <router-link to="/register" >
              <span>ລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</template>

<script>
export default {
    name: 'Minipos14Login',

    data() {
        return {
           
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
};
</script>

<style lang="scss" scoped>

</style>