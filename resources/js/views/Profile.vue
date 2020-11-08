<template>
    <div>
        <Navbar />
        <!-- Start Breadcrumbbar -->
        <div class="container breadcrumbbar">
            <!-- My Profile Start -->
            <div
                class="row no-gutters align-items-center justify-content-center"
            >
                <div class="col-lg-6 col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="profilebox pt-4 text-center">
                                <ul class="list-inline">
                                    <li
                                        v-if="p_img"
                                        title="Click to change avatar"
                                        class="list-inline-item"
                                        @click="
                                            editPics
                                                ? (editPics = false)
                                                : (editPics = true)
                                        "
                                    >
                                        <img
                                            :src="'/storage/' + p_img"
                                            class="img-fluid pics"
                                            alt="profile"
                                        />
                                    </li>
                                    <li v-if="editPics" class="list-block">
                                        <el-upload
                                            action="/"
                                            list-type="picture-card"
                                            :on-change="updateImageList"
                                            :on-remove="handleRemove"
                                            :auto-upload="false"
                                            :limit="1"
                                        >
                                            <i
                                                class="el-icon-plus avatar-uploader-icon"
                                            ></i>
                                        </el-upload>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                Edit Profile Informations
                            </h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateProfile">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">First Name</label>
                                        <input
                                            v-model="fname"
                                            type="text"
                                            class="form-control"
                                            id="username"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="usermobile"
                                            >Last Name</label
                                        >
                                        <input
                                            v-model="sname"
                                            type="text"
                                            class="form-control"
                                            id="usermobile"
                                        />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        Email: {{ email }}
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Bank Name</label>
                                        <select
                                            v-if="banks"
                                            v-model="bank"
                                            id="bankname"
                                            class="select2-single form-control select2-hidden-accessible"
                                            data-select2-id="1"
                                            tabindex="-1"
                                            aria-hidden="true"
                                        >
                                            <option
                                                v-for="index in banks"
                                                :key="index"
                                                :value="index"
                                                data-select2-id="1"
                                                >{{ index }}</option
                                            >
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="accountname"
                                            >Account Name</label
                                        >
                                        <input
                                            v-model="accountName"
                                            type="text"
                                            class="form-control"
                                            id="accountname"
                                        />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="accountnumber"
                                            >Account Number</label
                                        >
                                        <input
                                            type="text"
                                            v-model="accountNumber"
                                            class="form-control"
                                            id="accountnumber"
                                        />
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    :disabled="loading"
                                    class="btn green font-16"
                                    :style="{
                                        cursor: loading
                                            ? 'not-allowed'
                                            : 'pointer'
                                    }"
                                >
                                    <i class="feather icon-save mr-2"></i
                                    >{{ profilePlaceholder }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- My Profile End -->
        </div>
        <!-- End Breadcrumbbar -->
        <Footer />
    </div>
</template>

<script>
import { validateProfileData } from "@/js/components/Utils/validator.js";
import { dashboard } from "@/js/mixins/dashboard.js";
import Navbar from "@/js/components/navbar";
import Footer from "@/js/components/footer";
import Progress from "@/js/components/progress";
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
    name: "Dashboard",
    data() {
        return {
            fname: "",
            sname: "",
            email: "",
            image: false,
            p_img: false,
            editPics: true,
            bank: "",
            banks: [
                "Access Bank",
                "Citibank",
                "Diamond Bank",
                "Ecobank Nigeria",
                "Fidelity Bank Nigeria",
                "First Bank of Nigeria",
                "First City Monument Bank",
                "Guaranty Trust Bank",
                "Heritage Bank Plc",
                "Jaiz Bank",
                "Keystone Bank Limited",
                "Providus Bank Plc",
                "Stanbic IBTC Bank Nigeria Limited",
                "Sterling Bank",
                "Union Bank of Nigeria",
                "United Bank for Africa",
                "Unity Bank Plc",
                "Wema Bank",
                "Zenith Bank"
            ],
            accountNumber: "",
            accountName: ""
        };
    },
    beforeMount() {
        this.loadProfile();
    },
    mixins: [dashboard],
    methods: {
        updateImageList(file) {
            this.image = true;
            this.imageList = [file.raw];
        },
        handleRemove() {
            this.image = false;
            this.imageList = [];
        },
        async loadProfile() {
            this.fname = this.get_user_detail.first_name
                ? this.get_user_detail.first_name
                : "";
            this.sname = this.get_user_detail.last_name
                ? this.get_user_detail.last_name
                : "";
            this.email = this.get_user_detail.email
                ? this.get_user_detail.email
                : "";
            this.p_img = this.get_user_detail.identity
                ? this.get_user_detail.identity
                : "";
            this.editPics = this.get_user_detail.identity ? false : true;
            this.bank = this.get_user_detail.bank
                ? this.get_user_detail.bank
                : "";
            this.accountNumber = this.get_user_detail.accountNumber
                ? this.get_user_detail.accountNumber
                : "";
            this.accountName = this.get_user_detail.accountName
                ? this.get_user_detail.accountName
                : "";
        },

        async updateProfile() {
            this.image = this.image ? this.imageList[0] : false;

            let check = validateProfileData({
                fname: this.fname,
                sname: this.sname,
                accountNumber: this.accountNumber,
                accountName: this.accountName,
                bank: this.bank
            });
            if (check.valid == false) {
                if (check.errors.bank)
                    return this.$toastr.e(
                        check.errors.bank,
                        "Invalid credentials",
                        { timeOut: 5000 }
                    );
                if (check.errors.accountName)
                    return this.$toastr.e(
                        check.errors.accountName,
                        "Invalid credentials",
                        { timeOut: 5000 }
                    );
                if (check.errors.accountNumber)
                    return this.$toastr.e(
                        check.errors.accountNumber,
                        "Invalid credentials",
                        { timeOut: 5000 }
                    );

                if (check.errors.first_name)
                    return this.$toastr.e(
                        check.errors.first_name,
                        "Invalid credentials",
                        { timeOut: 5000 }
                    );
                if (check.errors.last_name)
                    return this.$toastr.e(
                        check.errors.last_name,
                        "Invalid credentials",
                        { timeOut: 5000 }
                    );
            }
            this.showLoader();

            let formData = new FormData();
            formData.append("first_name", this.fname);
            formData.append("last_name", this.sname);
            formData.append("accountName", this.accountName);
            formData.append("accountNumber", this.accountNumber);
            formData.append("bank", this.bank);
            this.image ? formData.append("identity", this.image) : "";

            let res = await this.loadData(this.PROFILEURL, formData, "POST");
            this.hideLoader();
            if (!res) return;

            this.set_user_detail_ac({
                first_name: res.data.user.first_name,
                last_name: res.data.user.last_name,
                bank: res.data.user.bank,
                accountName: res.data.user.accountName,
                accountNumber: res.data.user.accountNumber,
                identity: res.data.user.identity,
                valid: res.data.user.valid,
                wallet: res.data.user.wallet
            });
            this.p_img = res.data.user.identity;
            this.$toastr.s("Profile updated successfully", "Success");
        },
        ...mapActions([
            "set_user_role_ac",
            "set_user_detail_ac",
            "set_user_token_ac"
        ])
    },
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
