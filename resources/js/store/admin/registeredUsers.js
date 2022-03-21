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

        getResidents(state) {
            let temp = state.registeredUsers.filter(function (e) {
                return e.role.toUpperCase() === "RESIDENT";
            });
            state.residents = temp;
        },
        getOfficers(state) {
            let temp = state.registeredUsers.filter(function (e) {
                return e.role.toUpperCase() === "OFFICER";
            });
            state.officers = temp;
        },
        getAdmins(state) {
            let temp = state.registeredUsers.filter(function (e) {
                return e.role.toUpperCase() === "ADMIN";
            });
            state.admins = temp;
        },
        getSecurityOfficers(state) {
            let temp = state.registeredUsers.filter(function (e) {
                return e.role.toUpperCase() === "SECURITY_OFFICER";
            });
            state.security_officers = temp;
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
                    console.log(res.data);
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
