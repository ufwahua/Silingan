import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

//admin
import blocks from "./admin/blocks";
import lots from "./admin/lots";
import announcements from "./admin/announcements";
import positions from "./admin/positions";
import emergency_contact_details from "./admin/emergency_contact_details";
import candidates from "./admin/candidates";
import timeNow from "./admin/timeNow";
import adminVehicles from "./admin/vehicles";
import collectionType from "./admin/collection_type"
import fund from "./admin/fund"
import collection from "./admin/collection"
import expense from "./admin/expense"
import expenseType from "./admin/expense_type"
//user
import news from "./user/news";
import posts from "./user/posts";
import userVehicles from "./user/vehicles";

//security officer
import cards from "./security_officer/cards";
import logs from "./security_officer/logs";

export default createStore({
    state: {
        users: null,
        userLogged: null,
        chat_room: null,
        not_blocked_users: null,
        block_users: null,
        chats: null,
    },

    //synchronous
    mutations: {
        getAllUsers(state, payload) {
            state.users = payload;
        },

        getUsersNotBlocked(state, payload) {
            state.not_blocked_users = payload;
        },
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
        async getAllUsers({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/user/",
                })
                .then((res) => {
                    commit("getAllUsers", res.data);
                    console.log("users", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },

        async getUsersNotBlocked({ commit }, payload) {
            await axios({
                    method: "get",
                    url: "/api/user/not-blocked/" + payload,
                })
                .then((res) => {
                    commit("getUsersNotBlocked", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getUserLogged({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/user-logged",
                })
                .then((res) => {
                    commit("getUserLogged", res.data[0]);
                })
                .catch((err) => {
                    commit("getUserLogged", null);
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
        userVehicles,
        adminVehicles,
        collectionType,
        fund,
        collection,
        expense,
        expenseType
    },

    plugins: [createPersistedState()],
});