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
                                    src="@/js/assets/images/logo.png"
                                    class=" front-logo"
                                    alt="logo"
                                />
                            </div>
                            <!-- Start Auth Box -->
                            <div class="auth-box-right">
                                <div class="card">
                                    <div class="card-body">
                                        <form
                                            v-if="user"
                                            @submit.prevent="login"
                                        >
                                            <h4 class="text-primary my-4">
                                                Welcome back!
                                                {{ user.name | capitalize }}
                                            </h4>
                                            <p class="text-secondary mb-4">
                                                Enter password to access your
                                                account
                                            </p>
                                            <div class="user-logo mb-4">
                                                <li
                                                    v-if="p_img"
                                                    class="list-inline-item"
                                                >
                                                    <img
                                                        src="@/js/assets/images/placeholder/users/profile.svg"
                                                        class="img-fluid rounded-circle"
                                                        alt="profile"
                                                    />
                                                </li>
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    v-model="password"
                                                    type="password"
                                                    class="form-control"
                                                    id="password"
                                                    placeholder="Password"
                                                    required=""
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
                                                {{ loginPlaceholder }}
                                            </button>
                                            <p class="mb-0 mt-3 white">
                                                Not You? Go to
                                                <a href="#" @click="removeUser"
                                                    >Log in</a
                                                >
                                            </p>
                                            <br /><br /><br /><br />
                                        </form>

                                        <form v-else @submit.prevent="login">
                                            <h3 class="text-primary">
                                                Login to your account
                                            </h3>
                                            <span
                                                class="text-secondary font-13"
                                            >
                                                Securely login to your
                                                dashboard</span
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
                                                    {{ loginPlaceholder }}
                                                </button>

                                                <br />
                                                <div class="form-row mb-3">
                                                    <div
                                                        class="col-sm-6"
                                                        style="color: black"
                                                    >
                                                        <p class="account">
                                                            Don't have an
                                                            account?
                                                            <router-link
                                                                :to="{
                                                                    name:
                                                                        'register'
                                                                }"
                                                                class="black"
                                                                >Register</router-link
                                                            >
                                                        </p>
                                                    </div>
                                                </div>
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
import { validateLoginData } from "@/js/components/Utils/validator.js";
import { auth } from "@/js/mixins/auth.js";
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
            p_img: true
        };
    },
    methods: {
        removeUser() {
            this.set_user_detail_ac([]);
            this.set_user_role_ac(null);
        },
        async login() {
            if (this.user) {
                this.email = this.user.email;
            }
            let check = validateLoginData({
                email: this.email,
                password: this.password
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
                if (check.errors.password)
                    return this.$toastr.e(
                        check.errors.password,
                        "Invalid credentials",
                        {
                            timeOut: 5000
                        }
                    );
            }

            this.showLoader();
            let requestBody = { email: this.email, password: this.password };

            let res = await this.loadData(this.LOGINURL, requestBody, "POST");
            this.hideLoader();
            if (!res) return;
            this.set_user_token_ac(res.data.token);
            this.set_user_role_ac(res.data.user.role_id);

            this.set_user_detail_ac({
                first_name: res.data.user.first_name,
                last_name: res.data.user.last_name,
                referral_code: res.data.user.referral_code,
                email: res.data.user.email,
                identity: res.data.user.identity,
                valid: res.data.user.valid,
                wallet: res.data.user.wallet,
                accountNumber: res.data.user.accountNumber,
                accountName: res.data.user.accountName,
                bank: res.data.user.bank
            });
            this.$router.push("/dashboard");
            return this.$toastr.s("Logged in", "Success");
        },
        ...mapActions([
            "set_user_role_ac",
            "set_user_detail_ac",
            "set_user_token_ac"
        ])
    },
    computed: {
        user() {
            if (this.get_user_detail.first_name) {
                return {
                    ...this.get_user_detail,
                    name: this.get_user_name
                };
            } else {
                return false;
            }
        },
        ...mapGetters([
            "get_user_detail",
            "get_user_name",
            "get_user_role",
            "get_user_token"
        ])
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
