<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">CredPal</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <router-link to="/dashboard" class="nav-item nav-link active">
                    <span>Dashboard</span>
                </router-link>
                <router-link
                    v-if="get_user_role == 1"
                    to="/approve"
                    class="nav-item nav-link active"
                >
                    <span>Approve ID</span>
                </router-link>
                <router-link
                    v-if="get_user_role == 2"
                    to="/transfer"
                    class="nav-item nav-link active"
                >
                    <span>Transfer Fund</span>
                </router-link>
                <router-link
                    v-if="get_user_role == 2"
                    to="/profile"
                    class="nav-item nav-link active"
                >
                    <span>Update Profile</span>
                </router-link>
                <a href="#" @click="logout" class="nav-item nav-link">Logout</a>
            </div>
        </div>
    </nav>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
/* eslint-disable */
export default {
    data() {
        return {};
    },
    computed: {
        ...mapGetters(["get_user_role"])
    },
    methods: {
        logout() {
            this.set_user_token_ac(null);
            this.$router.push("/login");
            return this.$toastr.s("Logout out successfully", "Success");
        },
        ...mapActions(["set_user_token_ac"])
    }
};
</script>
