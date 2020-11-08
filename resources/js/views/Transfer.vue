<template>
    <div>
        <Navbar />
        <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        Hello,
                        <span style="font-size:130%">{{
                            get_user_name | capitalize
                        }}</span>
                    </h4>
                </div>
            </div>
            <Progress v-if="get_user_progress" />

            <div class="col-lg-6 col-xl-4">
                <div class="card m-b-30">
                    <div class="card-body overview">
                        <img
                            src="@/js/assets/images/wallet.svg"
                            class="coin"
                        /><span
                            ><p class="title">
                                Wallet Balance
                            </p>
                            <p class="money">
                                N{{ formatMoney(get_user_detail.wallet) }}
                            </p></span
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- End Breadcrumbbar -->
        <Footer />
    </div>
</template>

<script>
import { dashboard } from "@/js/mixins/dashboard.js";
import Navbar from "@/js/components/navbar";
import Footer from "@/js/components/footer";
import Progress from "@/js/components/progress";
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
    name: "Dashboard",
    data() {
        return {};
    },
    mixins: [dashboard],
    computed: {
        ...mapGetters([
            "get_user_detail",
            "get_user_name",
            "get_user_role",
            "get_user_token",
            "get_user_progress"
        ])
    },
    components: {
        Navbar,
        Footer,
        Progress
    }
};
</script>

<style scoped>
.contentbar {
    margin: 0 30px 0 30px;
}
.breadcrumbbar {
    min-height: 70vh;
}

/*** cards */
.card {
    border-radius: 15px;
    box-shadow: 10px 0 20px rgb(230, 225, 225);
}

.card-header {
    color: white;
    background: #0f4c2d;
}
.card-footer {
    padding: 1rem 1.25rem !important;
    border-top: 0px !important;
}
.overview p.title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #000;
    padding-top: 15px;
    margin-bottom: 0 !important;
}

.overview p.money {
    font-size: 200%;
    font-weight: bolder;
    color: #eccb2f;
    line-height: 1 !important;
}
.overview img.coin {
    margin: 7px;
    width: 4rem;
    height: 4rem;
}

.overview {
    display: flex;
    flex-direction: row;
    overflow: hidden;
}
</style>
