import axios from "axios";

const registeredUsers = {
    namespaced: true,
    state: {
        registeredUsers: null,
        residents: null,
        officers: null,
        admins: null,
        security_officers: null,
    },
    mutations: {
        getAll(state, payload) {
            state.registeredUsers = payload;
        },

        getUsersNotBlocked(state, payload) {
            state.registeredUsers = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("registeredUsers", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getUsersNotBlocked({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/user/not_blocked/" + payload,
            })
                .then((res) => {
                    commit("getUsersNotBlocked", res.data);
                    console.log("registeredUsersNotBlocked", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getResidents({ commit }) {
            await commit("getResidents");
        },
        async getOfficers({ commit }) {
            await commit("getOfficers");
        },
        async getAdmins({ commit }) {
            await commit("getAdmins");
        },
        async getSecurityOfficers({ commit }) {
            await commit("getSecurityOfficers");
        },
    },
    getters: {},
};
export default registeredUsers;
