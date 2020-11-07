<template>
  <div>
<Navbar/>    
     <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Hello, <span style="font-size:130%">{{get_user_name | capitalize}}</span></h4>
                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
<Footer/>
  </div>
</template>

<script>
import { dashboard } from "@/js/mixins/dashboard.js";
import Navbar from "@/js/components/navbar";
import Footer from "@/js/components/footer";
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
  name: "Dashboard",
  data() {
    return {};
  },
  mixins: [dashboard],
  computed: {
    ...mapGetters(["get_user_detail", "get_user_name","get_user_role", "get_user_token"]),
  },
  components:{
    Navbar,Footer
  }
};
</script>

<style scoped>
.contentbar {
  margin: 0 30px 0 30px;
}
