import { createStore } from "vuex";
import registeredUsers from "./admin-maintain/registeredUsers";
import block from "./admin-maintain/block";
import lot from "./admin-maintain/lot";
import news from "./news-api/news";
export default createStore({
    state: {
        user: null,
    },

    mutations: {
        getUser(state, payload) {
            state.user = payload;
        },
    },
    actions: {
        getUser({ commit }, payload) {
            commit("getUser", payload);
        },
    },
    getters: {},
    modules: {
        registeredUsers,
        block,
        lot,
        news,
    },
});
