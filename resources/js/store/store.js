import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import registeredUsers from "./admin-maintain/registeredUsers";
import block from "./admin-maintain/block";
import lot from "./admin-maintain/lot";
import news from "./news-api/news";
export default createStore({
    state: {
        users: null,
        userLogged: null,
    },

    mutations: {
        getUserLogged(state, payload) {
            state.userLogged = payload;
            console.log(state.userLogged);
        },
    },
    actions: {
        getUserLogged({ commit }, payload) {
            commit("getUserLogged", payload);
        },
    },
    getters: {},
    modules: {
        registeredUsers,
        block,
        lot,
        news,
    },
    plugins: [createPersistedState()],
});
