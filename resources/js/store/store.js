import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import registeredUsers from "./admin/registeredUsers";
//admin
import blocks from "./admin/blocks";
import lots from "./admin/lots";
import announcements from "./admin/announcements";
import positions from "./admin/positions";
import emergency_contact_details from "./admin/emergency_contact_details";

//user
import news from "./user/news";
import posts from "./user/post";

export default createStore({
    state: {
        users: null,
        userLogged: null,
        chat_room: null,
    },

    //synchronous
    mutations: {
        getUserLogged(state, payload) {
            state.userLogged = payload;
        },
        getChatRoom(state, payload) {
            state.chat_room = payload;
        },
        logout(state, payload) {
            state.userLogged = payload;
        },
    },

    actions: {
        async getUserLogged({ commit }, payload) {
            await commit("getUserLogged", payload);
        },
        async getChatRoom({ commit }, payload) {
            await commit("getChatRoom", payload);
        },
        async logout({ commit }, payload) {
            await commit("logout", payload);
        },
    },
    getters: {},
    modules: {
        registeredUsers,
        blocks,
        lots,
        news,
        posts,
        announcements,
        positions,
        emergency_contact_details,
    },

    plugins: [createPersistedState()],
});
