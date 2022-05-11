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
import collectionType from "./admin/collection_type";
import fund from "./admin/fund";
import collection from "./admin/collection";
import expense from "./admin/expense";
import expenseType from "./admin/expense_type";
//user
import news from "./user/news";
import posts from "./user/posts";
import userVehicles from "./user/vehicles";

//security officer
import cards from "./security_officer/cards";
import logs from "./security_officer/logs";

import notifications from "./notification";

export default createStore({
    state: {
        users: null,
        users_verified: null,
        verified_user_chat: null,
        filtered_resident: null,
        filtered_resident_block_lot: null,
        officers: null,
        residents: null,
        userLogged: null,
        chat_room: null,
        not_blocked_users: null,
        block_users: null,
        chats: null,
        chat_room_id: null,
        invoices: null,
        specific_invoices: null,
        block_lot_invoices: null,
    },

    //synchronous
    mutations: {
        getAllUsers(state, payload) {
            state.users = payload;
        },
        getUsersVerified(state, payload) {
            state.users_verified = payload;
        },
        filterResident(state, payload) {
            state.filtered_resident = payload;
        },
        filterResidentBlockLot(state, payload) {
            state.filtered_resident_block_lot = payload;
        },
        getOfficers(state, payload) {
            state.officers = payload;
        },
        getResidents(state, payload) {
            state.residents = payload;
        },
        getSearchUser(state, payload) {
            state.verified_user_chat = payload;
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
        getChatRoomId(state, payload) {
            state.chat_room_id = payload;
        },
        getAllInvoice(state, payload) {
            console.log("invoices payload", payload);
            state.invoices = payload;
        },
        getSpecificInvoices(state, payload) {
            console.log("specific invoices payload", payload);
            state.specific_invoices = payload;
        },
        getBlockLotInvoices(state, payload) {
            console.log("block lot invoices payload", payload);
            state.block_lot_invoices = payload;
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
        async getOfficers({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/officers",
            })
                .then((res) => {
                    commit("getOfficers", res.data);
                    console.log("officers", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getResidents({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/residents",
            })
                .then((res) => {
                    commit("getResidents", res.data);
                    console.log("residents", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async filterResident({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/user/filter-resident/" + payload,
            })
                .then((res) => {
                    commit("filterResident", res.data);
                    console.log("filter resident", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async filterResidentBlockLot({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/user/filter-resident/block-lot/" + payload,
            })
                .then((res) => {
                    commit("filterResidentBlockLot", res.data);
                    console.log("filter resident by block and lot", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getUsersVerified({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/user-verified",
            })
                .then((res) => {
                    commit("getUsersVerified", res.data);
                    commit("getSearchUser", res.data);
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
        async getAllInvoice({ commit }) {
            await axios({
                method: "get",
                url: "/api/invoice/",
            })
                .then((res) => {
                    commit("getAllInvoice", res.data);
                    console.log("all invoices", res.data);
                })
                .catch((err) => {
                    console.log(err.response);
                });
        },
        async getSpecificInvoices({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/invoice/" + payload,
            })
                .then((res) => {
                    commit("getSpecificInvoices", res.data);
                    console.log("specific invoice", res.data);
                })
                .catch((err) => {
                    console.log(err.response);
                });
        },
        async getBlockLotInvoices({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/invoice/block-lot/" + payload,
            })
                .then((res) => {
                    commit("getBlockLotInvoices", res.data);
                    console.log("block lot invoices", res.data);
                })
                .catch((err) => {
                    console.log(err.response);
                });
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
        notifications,
        expenseType,
    },

    plugins: [createPersistedState()],
});
