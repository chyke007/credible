const state = {
    user_detail: [],
    user_token: null,
    user_role: 2
};

const mutations = {
    set_user_detail(state, value) {
        state.user_detail = value;
    },
    set_user_role(state, value) {
        state.user_role = value;
    },
    set_user_token(state, value) {
        state.user_token = value;
    }
};

const actions = {
    set_user_detail_ac: ({ commit }, value) => {
        commit("set_user_detail", value);
    },
    set_user_role_ac: ({ commit }, value) => {
        commit("set_user_role", value);
    },
    set_user_token_ac: ({ commit }, value) => {
        commit("set_user_token", value);
    }
};

const getters = {
    get_user_token: state => {
        return state.user_token;
    },
    get_user_role: state => {
        return state.user_role;
    },
    get_user_detail: state => {
        return state.user_detail;
    },
    get_user_name: state => {
        return `${state.user_detail.first_name} ${state.user_detail.last_name}`;
    },
    get_user_referral: state => {
        return state.user_detail.referral_code;
    },
    get_user_progress: state => {
        return state.user_detail.valid == 1 ? false : true;
    }
};

export default {
    state,
    mutations,
    actions,
    getters
};
