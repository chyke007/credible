import axios from "axios";
import { appUrl, apiKey } from "./env";
import { mapActions, mapGetters } from "vuex";
/* eslint-disable */
export const dashboard = {
    data() {
        return {
            preVal: 0,
            loading: false,
            profilePlaceholder: "UPDATE",
            manualPlaceholder: "SUBSCRIBE USER",
            URL: `${appUrl}`,
            GETALLUSERS: `${appUrl}/user/all?perpage=1000&q=accountType:USER`
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
        //   reduce: function (value) {
        //     if (!value) return ''
        //     value = value.substring(19)
        //     return value
        //   }
    },
    methods: {
        showLoader() {
            this.loading = true;
        },
        hideLoader() {
            this.loading = false;
        },

        async loadData(url, requestBody, method) {
            let res = await axios({
                url: url,
                method: method,
                data: requestBody,
                headers: {
                    apikey: this.APIKEY,
                    Authorization: `Bearer ${this.get_user_token}`,
                    Accept: "application/json",
                    "Content-Type": "application/json"
                }
            }).catch(err => {
                if (err.response.data.error.code == 1017) {
                    this.set_user_token_ac(null);
                    this.$router.push("/login");
                    return this.$toastr.e(
                        err.response.data.error.message,
                        "Token Expired"
                    );
                }
                try {
                    return this.$toastr.e(
                        err.response.data.error.message,
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

        ...mapActions(["set_user_token_ac"])
    },
    computed: {
        ...mapGetters(["get_user_detail", "get_user_role", "get_user_token"])
    }
};
