<template>
  <div>
    <Navbar />
    <!-- Start Breadcrumbbar -->
    <div class="breadcrumbbar">
      <div class="card">
        <div class="card-body">
          <h4 class="page-title">
            Hello,
            <span style="font-size: 130%">{{
              get_user_name | capitalize
            }}</span>
          </h4>
        </div>
      </div>

      <div class="row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a
              class="list-group-item list-group-item-action"
              id="list-settings-list"
              data-toggle="list"
              href="#list-settings"
              role="tab"
              aria-controls="settings"
              >All Transfers</a
            >
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="list-settings"
              role="tabpanel"
              aria-labelledby="list-settings-list"
            >
              <h1><b>All Transfers</b></h1>
              <br />
              <datatable
                :data="transfers"
                :columns="columns"
                :actions="actions"
              ></datatable>
            </div>
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
import { formatMoney } from "@/js/components/Utils/helpers.js";
import { mapGetters, mapActions } from "vuex";
import moment from "moment";
/* eslint-disable */
export default {
  name: "Dashboard",
  data() {
    return {
      amount: null,
      future: null,
      transfers: [],
      columns: [
        { name: "user_id", th: "User Id" },
        {
          name: "amount",
          th: "Amount(N)",
          render(row, cell, index) {
            return `N${formatMoney(row.amount)}`;
          },
        },
        { name: "mode", th: "Mode" },
        {
          name: "status",
          th: "Status",
          render(row, cell, index) {
            let code = "badge-success";
            let statusText = "completed";
            if (row.status == "pending") {
              code = "badge-warning";
              statusText = "pending";
            } else if (row.status == "completed") {
              code = "badge-success";
              statusText = "completed";
            } else if (row.status == "failed") {
              code = "badge-danger";
              statusText = "failed";
            }
            return `<span class="badge badge-pill ${code}">${statusText}</span>`;
          },
        },

        {
          name: "transfer_time",
          th: "Planned time",
          render(row, cell, index) {
            return moment(row.transfer_time).format("DD-MM-YYYY: h:mm:ss");
          },
        },
        {
          name: "createdAt",
          th: "Initialize time",
          render(row, cell, index) {
            return moment(row.createdAt).format("DD-MM-YYYY: h:mm:ss");
          },
        },
        {
          name: "updatedAt",
          th: "Transferred at",
          render(row, cell, index) {
            if (row.status == "pending" || row.status == "failed") {
              return "----";
            }
            return moment(row.updatedAt).format("DD-MM-YYYY: h:mm:ss");
          },
        },
      ],

      actions: [],
    };
  },
  mixins: [dashboard],
  beforeMount() {
    this.getTransfers();
  },
  methods: {
    async getTransfers() {
      let res = await this.loadData(`${this.TRANSFERURL}`, {}, "GET");
      if (!res) return;
      this.transfers = res.data.transfer;
    },

    ...mapActions(["set_user_detail_ac"]),
  },
  computed: {
    ...mapGetters([
      "get_user_detail",
      "get_user_name",
      "get_user_role",
      "get_user_token",
      "get_user_progress",
    ]),
  },
  components: {
    Navbar,
    Footer,
    Progress,
  },
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
.card-overview {
  border-radius: 15px;
  margin: 10px;
  width: 90%;
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
