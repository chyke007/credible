import axios from "axios";
import { authUrl, appUrl, apiKey } from "./env";
import { mapActions } from "vuex";
export const auth = {
    data() {
        return {
            registerPlaceholder: "REGISTER",
            status: false,
            loginPlaceholder: "LOGIN",
            permission: "You do not have permission to carry out this task",
            expired: "Token expired, please log in again",
            unknown: "An unknown error occured, please try again later",
            loading: false,
            URL: `${appUrl}`,
            LOGINURL: `${authUrl}/login`,
            REGISTERURL: `${authUrl}/register`
        };
    },
    filters: {
        capitalize: function(value) {
            if (!value) return "";
            value = value.toString();
            return value.toUpperCase();
        },
        lowercase: function(value) {
            if (!value) return "";
            value = value.toString();
            return value.toLowerCase();
        }
    },
    methods: {
        async loadData(url, requestBody, method) {
            let res = await axios({
                url: url,
                method: method,
                data: requestBody,
                headers: {
                    Authorization: `Bearer ${this.get_user_token}`,
                    Accept: "application/json",
                    "Content-Type": "application/json"
                }
            }).catch(err => {
                this.hideLoader();

                if (err.response.status == 402) {
                    this.set_user_token_ac(null);
                    this.$router.push("/login");
                    return this.$toastr.e(
                        err.response.data.errors.message,
                        "Token Expired"
                    );
                } else if (err.response.status === 422) {
                    let error = err.response.data.errors;
                    if (error.email) {
                        return this.$toastr.e(
                            err.response.data.errors.email,
                            "Error"
                        );
                    } else if (error.first_name) {
                        return this.$toastr.e(
                            err.response.data.errors.first_name,
                            "Error"
                        );
                    } else if (error.last_name) {
                        return this.$toastr.e(
                            err.response.data.errors.last_name,
                            "Error"
                        );
                    } else if (error.password) {
                        return this.$toastr.e(
                            err.response.data.errors.password,
                            "Error"
                        );
                    }
                }
                try {
                    return this.$toastr.e(
                        err.response.data.errors.message,
                        "Error"
                    );
                } catch (e) {
                    return this.$toastr.e(
                        "An error occured please try again later or check your network connection",
                        "Error"
                    );
                }
            });

            return res.data;
        },
        showLoader() {
            this.registerPlaceholder = "Loading .... Please wait ...";
            this.loginPlaceholder = "Loading .... Please wait ...";
            this.loading = true;
        },
        hideLoader() {
            this.registerPlaceholder = "REGISTER";
            this.loginPlaceholder = "LOGIN";
            this.loading = false;
        },
        ...mapActions(["set_user_token_ac"])
    }
};
