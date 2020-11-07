<template>
  <div id="user-login">
    <div id="containerbar" class="containerbar authenticate-bg">
      <!-- Start Container -->
      <div class="container">
        <div class="auth-box login-box">
          <!-- Start row -->
          <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-6 col-lg-5">
              <div class="form-head">
                <img
                  src="../assets/images/logo.png"
                  class="front-logo"
                  alt="logo"
                />
              </div>
              <!-- Start Auth Box -->
              <div class="auth-box-right">
                <div class="card">
                  <div class="card-body">
                    <form @submit.prevent="login">
                      <h3 class="text-primary">Login to your account</h3>
                      <span class="text-secondary font-13">
                        Securely login to your dashboard</span
                      >
                      <div class="form-over">
                        <div class="form-group">
                          <label class="black" for="email">Email</label>
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
                          <label class="black" for="username">Password</label>
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
                            cursor: loading ? 'not-allowed' : 'pointer',
                          }"
                        >
                          {{ loginPlaceholder }}
                        </button>

                        <br />
                        <div class="form-row mb-3">
                          <div class="col-sm-6 black">
                            <p>
                              Don't have a account?
                              <router-link :to="{ name: 'register' }"
                                >Register</router-link
                              >
                            </p>
                          </div>
                          <div class="col-sm-6">
                            <div class="forgot-psw">
                              <router-link
                                :to="{ name: 'forgotpass' }"
                                class="font-14"
                                >Forgot Password?</router-link
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="login-or">
                      <h6 class="text-muted">OR</h6>
                    </div>
                    <div class="social-login text-center">
                      <button
                        type="submit"
                        class="btn btn-primary-rgba font-18"
                      >
                        <i class="mdi mdi-facebook mr-2"></i>Facebook
                      </button>
                      <button type="submit" class="btn btn-danger-rgba font-18">
                        <i class="mdi mdi-google mr-2"></i>Google
                      </button>
                    </div>
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
    </div>
  </div>
</template>

<script>
import { validateLoginData } from "@/js/components/Utils/validator.js";
import { auth } from "@/mixins/auth.js";
import { mapGetters, mapActions } from "vuex";
import axios from "axios";
/* eslint-disable */
export default {
  name: "Home",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    login() {
      this.showLoader();
      let check = validateLoginData({
        email: this.email,
        password: this.password,
      });

      if (check.valid == false) {
        this.hideLoader();
        if (check.errors.email)
          return this.$toastr.e(check.errors.email, "Invalid credentials", {
            timeOut: 5000,
          });
        if (check.errors.password)
          return this.$toastr.e(check.errors.password, "Invalid credentials", {
            timeOut: 5000,
          });
      }

      let requestBody = { email: this.email, password: this.password };

      axios({
        url: "http://auth.wiseminds.cc/login",
        method: "POST",
        data: requestBody,
        headers: {
          apikey: "erTg465G86h,=7ebY&5j",
          Accept: "application/json",
          "Content-Type": "application/json",
        },
      })
        .then((data) => {
          this.hideLoader();
          this.set_user_token_ac(data.token);
          return this.$toastr.s("Logged in", "Success");
        })
        .catch((err) => {
          this.hideLoader();
          try {
            return this.$toastr.e(err.response.data.error.message, "Error");
          } catch (e) {
            return this.$toastr.e(
              "An error occured please try again later or check your network connection",
              "Error"
            );
          }
        });
    },
    ...mapActions(["set_user_detail_ac", "set_user_token_ac"]),
  },
  computed: {
    ...mapGetters(["get_user_detail", "get_user_token"]),
  },
  mixins: [auth],
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

.authenticate-bg {
  background: url(../assets/images/authentication/background.jpg);
  background-size: cover;
  background-position: center;
  min-height: 100% !important;
}
</style>
