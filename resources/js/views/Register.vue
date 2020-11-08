<template>
    <div id="user-login">
        <div id="containerbar" class="containerbar authenticate-bg">
            <!-- Start Container -->
            <div class="container">
                <div class="auth-box login-box">
                    <!-- Start row -->
                    <div
                        class="row no-gutters align-items-center justify-content-center"
                    >
                        <!-- Start col -->
                        <div class="col-md-6 col-lg-5">
                            <div class="form-head">
                                <img
                                    src="../assets/images/logo.png"
                                    class=" front-logo"
                                    alt="logo"
                                />
                            </div>
                            <!-- Start Auth Box -->
                            <div class="auth-box-right">
                                <div class="card">
                                    <div class="card-body">
                                        <form @submit.prevent="register">
                                            <h3 class="text-primary">
                                                Create an account
                                            </h3>
                                            <span
                                                class="text-secondary font-13"
                                            >
                                                Credpal</span
                                            >
                                            <div class="form-over">
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="email"
                                                        >Email</label
                                                    >
                                                    <input
                                                        v-model="email"
                                                        type="email"
                                                        class="form-control"
                                                        id="email"
                                                        placeholder="Enter Email here"
                                                        required
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="fname"
                                                        >First Name</label
                                                    >
                                                    <input
                                                        v-model="fname"
                                                        type="text"
                                                        class="form-control"
                                                        id="fname"
                                                        placeholder="Enter first name here"
                                                        required
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="sname"
                                                        >Last Name</label
                                                    >
                                                    <input
                                                        v-model="sname"
                                                        type="text"
                                                        class="form-control"
                                                        id="sname"
                                                        placeholder="Enter last name here"
                                                        required
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="sname"
                                                        >Referral code (Leave
                                                        blank if none)</label
                                                    >
                                                    <input
                                                        v-model="referral"
                                                        type="text"
                                                        class="form-control"
                                                        id="referral"
                                                        placeholder="Enter referral code here"
                                                        required
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="password"
                                                        >Password</label
                                                    >
                                                    <input
                                                        v-model="password"
                                                        type="password"
                                                        class="form-control"
                                                        id="password"
                                                        placeholder="Enter Password here"
                                                        required
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="black"
                                                        for="rpassword"
                                                        >Re-Type Password</label
                                                    >
                                                    <input
                                                        v-model="rpassword"
                                                        type="password"
                                                        class="form-control"
                                                        id="rpassword"
                                                        placeholder="Re-Type Password"
                                                        required
                                                    />
                                                </div>

                                                <button
                                                    type="submit"
                                                    :disabled="loading"
                                                    class="btn btn-success btn-lg btn-block font-18"
                                                    :style="{
                                                        cursor: loading
                                                            ? 'not-allowed'
                                                            : 'pointer'
                                                    }"
                                                >
                                                    {{ registerPlaceholder }}
                                                </button>
                                                <p class="mb-0 mt-3 black">
                                                    Already a member?
                                                    <router-link
                                                        :to="{ name: 'login' }"
                                                        >Log in</router-link
                                                    >
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Auth Box -->
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End row -->
                </div>
            </div>
            <!-- End Container -->
            <br /><br />
        </div>
    </div>
</template>

<script>
import { validateRegisterData } from "@/js/components/Utils/validator.js";
import { auth } from "@/js/mixins/auth.js";
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
    name: "Register",
    data() {
        return {
            email: "",
            fname: "",
            sname: "",
            password: "",
            rpassword: "",
            referral: ""
        };
    },

    methods: {
        async register() {
            let check = validateRegisterData({
                email: this.email,
                fname: this.fname,
                sname: this.sname,
                password: this.password,
                rpassword: this.rpassword
            });

            if (check.valid == false) {
                if (check.errors.email)
                    return this.$toastr.e(
                        check.errors.email,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.fname)
                    return this.$toastr.e(
                        check.errors.fname,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.sname)
                    return this.$toastr.e(
                        check.errors.sname,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.password)
                    return this.$toastr.e(
                        check.errors.password,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.rpassword)
                    return this.$toastr.e(
                        check.errors.rpassword,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.match)
                    return this.$toastr.e(
                        check.errors.match,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
                if (check.errors.pass_l)
                    return this.$toastr.e(
                        check.errors.pass_l,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
            }

            this.showLoader();
            let requestBody = {
                email: this.email,
                password: this.password,
                first_name: this.fname,
                last_name: this.sname,
                referral: this.referral
            };

            let res = await this.loadData(
                this.REGISTERURL,
                requestBody,
                "POST"
            );
            this.hideLoader();
            if (!res) return;

            this.$toastr.s("You can now log in", "Success");
            this.$router.push("/login");
        },
        ...mapActions(["set_user_detail_ac", "set_user_token_ac"])
    },
    computed: {
        ...mapGetters(["get_user_detail", "get_user_token"])
    },
    mixins: [auth]
};
</script>

<style scoped>
.form-head {
    display: flex;
    padding: 1%;
    margin: 20px auto;
    justify-content: center;
    align-items: center;
}

.front-logo {
    width: 20%;
    height: 20%;
}

.text-primary {
    font-weight: 700;
}
.form-over {
    margin: 40px;
}

label {
    color: #000;
    float: left;
}

.form-control {
    padding: 20px;
    border-radius: 10px;
}

.black {
    color: black;
    font-weight: 900;
}

.white {
    color: white;
}

.btn-primary-rgba {
    color: #fff;
}
.btn-danger-rgba {
    color: #fff;
}
.text-muted {
    color: #000 !important;
}
.account {
    text-align: left !important;
}
.auth-box .auth-box-right .card {
    text-align: center;
    border-radius: 25px;
    background: #eccb2f;
}
.btn-success {
    background-color: transparent;
}
.btn-success:hover {
    background-color: #0f4c2d;
}
.authenticate-bg {
    background: url(../assets/images/authentication/background.jpg);
    background-size: cover;
    background-position: center;
    min-height: 100% !important;
}
</style>
