<template>
    <div>
        <Navbar />
        <div class="container breadcrumbbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <br />
                    <h5 class="card-title">APPROVE IDENTITY</h5>
                    <br />

                    <datatable
                        :data="users"
                        :columns="columns"
                        :actions="actions"
                    ></datatable>
                </div>
                <!-- End col -->
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import { dashboard } from "@/js/mixins/dashboard.js";
import Navbar from "@/js/components/navbar";
import Footer from "@/js/components/footer";

import { formatMoney } from "@/js/components/Utils/helpers.js";
import { mapGetters, mapActions } from "vuex";
import moment from "moment";
/* eslint-disable */
export default {
    name: "Dashboard",
    data() {
        return {
            users: [],
            columns: [
                { name: "first_name", th: "First Name" },
                { name: "last_name", th: "Last Name" },
                { name: "referral_code", th: "Referral Code" },
                {
                    name: "wallet",
                    th: "Wallet(N)",
                    render(row, cell, index) {
                        return `N${formatMoney(row.wallet)}`;
                    }
                },
                {
                    name: "identity",
                    th: "ID",
                    render(row, cell, index) {
                        return `
                        <a href="/storage/${row.identity}" target="_blank">
                        <img src="/storage/${
                            row.identity
                        }" width="50px" height="50px" title=""/></a>`;
                    }
                },
                {
                    name: "status",
                    th: "Status",
                    render(row, cell, index) {
                        let code = "badge-warning";
                        let statusText = "pending";
                        if (row.valid == 1) {
                            code = "badge-success";
                            statusText = "approved";
                        } else if (row.valid == 0) {
                            code = "badge-danger";
                        }
                        return `<span class="badge badge-pill ${code}">${statusText}</span>`;
                    }
                },
                {
                    name: "updatedAt",
                    th: "Updated At",
                    render(row, cell, index) {
                        return moment(row.updatedAt).format("DD-MM-YYYY");
                    }
                }
            ],
            actions: [
                {
                    text: "Toggle Status",
                    color: "warning",
                    action: (row, index) => {
                        this.changeStatus(row.id, row.status);
                    }
                }
            ]
        };
    },
    beforeMount() {
        this.getPendingId();
    },
    methods: {
        async changeStatus(id, status) {
            let confirmed = confirm(
                "Are you sure you want to confirm users ID?"
            );
            if (!confirmed) return;

            let res = await this.loadData(
                `${this.PROFILEURL}${id}`,
                { status: "success" },
                "PUT"
            );
            if (!res) return;
            this.$toastr.s(res.data.message, "Success");
            this.getPendingId();
        },
        async getPendingId() {
            let res = await this.loadData(`${this.PROFILEURL}`, {}, "GET");
            if (!res) return;
            this.users = res.data.user;
        }
    },
    mixins: [dashboard],
    computed: {
        ...mapGetters([
            "get_user_detail",
            "get_user_name",
            "get_user_role",
            "get_user_progress",
            "get_user_token"
        ])
    },
    components: {
        Navbar,
        Footer
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
    color: black;
}
.card-footer {
    padding: 1rem 1.25rem !important;
    border-top: 0px !important;
}
</style>
