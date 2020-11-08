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
      <Progress v-if="get_user_progress" />

      <div class="row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a
              class="list-group-item list-group-item-action active"
              id="list-home-list"
              data-toggle="list"
              href="#list-home"
              role="tab"
              aria-controls="home"
              >View Wallet</a
            >
            <a
              class="list-group-item list-group-item-action"
              id="list-profile-list"
              data-toggle="list"
              href="#list-profile"
              role="tab"
              aria-controls="profile"
              >Instant Transfer</a
            >
            <a
              class="list-group-item list-group-item-action"
              id="list-messages-list"
              data-toggle="list"
              href="#list-messages"
              role="tab"
              aria-controls="messages"
              >Future Transfer</a
            >
            <a
              class="list-group-item list-group-item-action"
              id="list-settings-list"
              data-toggle="list"
              href="#list-settings"
              role="tab"
              aria-controls="settings"
              >My Transfer</a
            >
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="list-home"
              role="tabpanel"
              aria-labelledby="list-home-list"
            >
              <h1><b> My wallet</b></h1>
              <br />
              <div class="card card-overview m-b-30">
                <div class="card-body overview">
                  <img src="@/js/assets/images/wallet.svg" class="coin" /><span
                    ><p class="title">Wallet Balance</p>
                    <p class="money">
                      N{{ formatMoney(get_user_detail.wallet) }}
                    </p></span
                  >
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="list-profile"
              role="tabpanel"
              aria-labelledby="list-profile-list"
            >
              <h1><b> Initiate transfer</b></h1>
              <br />
              <form class="form" @submit.prevent="instantTransfer">
                <label class="my-1 mr-2" for="inlineFormCustomSelectPref"
                  >Choose Amount</label
                >
                <select
                  v-model="amount"
                  id="amount"
                  class="select2-single form-control select2-hidden-accessible"
                  data-select2-id="1"
                  tabindex="-1"
                  aria-hidden="true"
                >
                  <option
                    v-for="(item, index) in amounts"
                    :key="index"
                    :label="item"
                    :value="item"
                    data-select2-id="1"
                  >
                    {{ item }}
                  </option>
                </select>

                <br />
                <button
                  type="submit"
                  :disabled="loading"
                  class="btn btn-primary my-1"
                  :style="{
                    cursor: loading ? 'not-allowed' : 'pointer',
                  }"
                >
                  {{ instantTransferPlaceholder }}
                </button>
              </form>
            </div>
            <div
              class="tab-pane fade"
              id="list-messages"
              role="tabpanel"
              aria-labelledby="list-messages-list"
            >
              <h1><b> Set a Future transfer date</b></h1>
              <br />
              <form class="form" @submit.prevent="futureTransfer">
                <label class="my-1 mr-2" for="future">Future Date:</label>
                <input
                  type="datetime-local"
                  id="future"
                  name="future"
                  v-model="future"
                  class="select2-single form-control select2-hidden-accessible"
                />
                <br />
                <label class="my-1 mr-2" for="amount">Choose Amount</label>
                <select
                  v-model="amount"
                  id="amount"
                  class="select2-single form-control select2-hidden-accessible"
                  data-select2-id="1"
                  tabindex="-1"
                  aria-hidden="true"
                >
                  <option
                    v-for="(item, index) in amounts"
                    :key="index"
                    :label="item"
                    :value="item"
                    data-select2-id="1"
                  >
                    {{ item }}
                  </option>
                </select>

                <br />
                <button
                  type="submit"
                  :disabled="loading"
                  class="btn btn-primary my-1"
                  :style="{
                    cursor: loading ? 'not-allowed' : 'pointer',
                  }"
                >
                  {{ futureTransferPlaceholder }}
                </button>
              </form>
            </div>
            <div
              class="tab-pane fade"
              id="list-settings"
              role="tabpanel"
              aria-labelledby="list-settings-list"
            >
              <h1><b>Your Transfers</b></h1>
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
      amounts: [
        "1000",
        "2000",
        "3000",
        "4000",
        "5000",
        "6000",
        "7000",
        "8000",
        "9000",
        "10000",
        "11000",
        "12000",
        "13000",
        "14000",
        "15000",
        "16000",
        "17000",
        "1800",
        "19000",
        "20000",
        "2100",
        "22000",
        "23000",
        "24000",
        "25000",
        "26000",
        "27000",
        "28000",
        "29000",
        "30000",
        "31000",
        "32000",
        "33000",
        "34000",
        "35000",
        "36000",
        "37000",
        "38000",
        "39000",
        "40000",
        "41000",
        "42000",
        "43000",
        "44000",
        "45000",
        "46000",
        "47000",
        "48000",
        "50000",
        "49000",
      ],
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
    async instantTransfer() {
      let confirmed = confirm(
        `Are you sure you want to transfer N${this.amount} to your bank account?`
      );
      if (!confirmed) return;

      let requestBody = {
        amount: this.amount,
        mode: "instant",
        transfer_time: Date.now(),
      };
      this.showLoader();
      let res = await this.loadData(`${this.TRANSFERURL}`, requestBody, "POST");
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
        wallet: res.data.user.wallet,
      });
      this.$toastr.s(
        "Amount has been successfully transferred to you bank account",
        "Success"
      );
      this.getTransfers();
    },
    async futureTransfer() {
      if (this.amount == null) {
        return;
      }
      let confirmed = confirm(
        `Are you sure you want to schedule N${this.amount} to be transferred to your bank account at the chosen date?`
      );
      if (!confirmed) return;

      if (moment(this.future).isBefore(moment().add(2, "minutes"), "minute")) {
        this.$toastr.e("Please select a time in the future", "Invalid");
        return;
      }
      let requestBody = {
        amount: this.amount,
        mode: "future",
        transfer_time: this.future,
      };
      this.showLoader();
      let res = await this.loadData(`${this.TRANSFERURL}`, requestBody, "POST");
      this.hideLoader();
      if (!res) return;

      this.$toastr.s(
        "Amount has been scheduled for transfer, kindly watch your transfer tab and wallet.",
        "Success"
      );
      this.getTransfers();
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
