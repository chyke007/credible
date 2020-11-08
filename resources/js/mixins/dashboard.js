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
            PROFILEURL: `${appUrl}/user/`
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
            this.profilePlaceholder = "Loading ... Please wait.";
        },
        hideLoader() {
            this.loading = false;
            this.profilePlaceholder = "UPDATE";
        },
        formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
            try {
                decimalCount = Math.abs(decimalCount);
                decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                const negativeSign = amount < 0 ? "-" : "";

                let i = parseInt(
                    (amount = Math.abs(Number(amount) || 0).toFixed(
                        decimalCount
                    ))
                ).toString();
                let j = i.length > 3 ? i.length % 3 : 0;

                return (
                    negativeSign +
                    (j ? i.substr(0, j) + thousands : "") +
                    i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
                    (decimalCount
                        ? decimal +
                          Math.abs(amount - i)
                              .toFixed(decimalCount)
                              .slice(2)
                        : "")
                );
            } catch (e) {
                //console.log(e)
            }
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
                this.hideLoader();

                if (err.response.status == 402) {
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
