import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import registeredUsers from "./admin/registeredUsers";

//admin
import blocks from "./admin/blocks";
import lots from "./admin/lots";
import announcements from "./admin/announcements";
import positions from "./admin/positions";
import emergency_contact_details from "./admin/emergency_contact_details";
import candidates from "./admin/candidates";
import timeNow from "./admin/timeNow";

//user
import news from "./user/news";
import posts from "./user/posts";

//security officer
import cards from "./security_officer/cards";
import logs from "./security_officer/logs";

export default createStore({
    state: {
        users: null,
        userLogged: null,
        chat_room: null,
        block_users: null,
        chats: null,
    },

    //synchronous
    mutations: {
        getUserLogged(state, payload) {
            state.userLogged = payload;
        },
        getBlockUsers(state, payload) {
            state.block_users = payload;
        },
        getChatRoom(state, payload) {
            state.chat_room = payload;
        },
        getChats(state, payload) {
            state.chats = payload;
        },
        logout(state, payload) {
            state.userLogged = payload;
        },
    },

    actions: {
        async getUserLogged({ commit }) {
            await axios({
                method: "get",
                url: "/api/user_logged",
            })
                .then((res) => {
                    commit("getUserLogged", res.data[0]);
                })
                .catch((err) => {
                    commit("getUserLogged", null);
                    console.log(err.response);
                });
        },
        async getBlockUsers({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/block_user/" + payload,
            })
                .then((res) => {
                    console.log("block users", res.data);
                    commit("getBlockUsers", res.data);
                })
                .catch((err) => {
                    commit("getBlockUsers", null);
                    console.log(err.response);
                });
        },
        async getChatRoom({ commit }, payload) {
            await commit("getChatRoom", payload);
        },
        async getChats({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/chat_room/" + id,
            })
                .then((res) => {
                    commit("getChats", res.data[0].chats);
                })
                .catch((err) => {
                    console.log(err.response);
                });
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
        candidates,
        timeNow,
        cards,
        logs,
    },

    plugins: [createPersistedState()],
});
