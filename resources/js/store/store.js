import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import registeredUsers from "./admin-maintain/registeredUsers";
import blocks from "./admin-maintain/blocks";
import lots from "./admin-maintain/lots";
import news from "./request/news";
import posts from "./request/post";
export default createStore({
    state: {
        users: null,
        userLogged: null,
    },

    mutations: {
        getUserLogged(state, payload) {
            state.userLogged = payload;
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
        blocks,
        lots,
        news,
        posts,
    },
    plugins: [createPersistedState()],
});
