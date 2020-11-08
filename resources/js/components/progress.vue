<template>
    <!-- Start Progress -->
    <div>
        <div v-if="get_user_detail.identity">
            <div class="progress">
                <div
                    class="progress-bar"
                    role="progressbar"
                    style="width: 80%"
                    aria-valuenow="80"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Your part is done.</h5>
                <p class="card-text">
                    We are in the process of verifying your ID.
                </p>
            </div>
        </div>
        <div v-else>
            <div class="progress">
                <div
                    class="progress-bar"
                    role="progressbar"
                    style="width: 50%"
                    aria-valuenow="50"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
            </div>
            <div class="card-body">
                <h5 class="card-title">You are almost done</h5>
                <p class="card-text">
                    Kindly provide a valid ID card to increase your transfer
                    limit from the benchmark of N50000.
                </p>

                <router-link to="/profile" class="btn btn-primary">
                    <span>Go Now</span>
                </router-link>
            </div>
        </div>

        <!-- End Progress -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters(["get_user_detail", "get_user_progress"])
    }
};
</script>
