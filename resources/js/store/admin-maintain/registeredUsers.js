import axios from "axios";

const registeredUsers = {
    namespaced: true,
    state: {
        registeredUsers: null,
    },
    mutations: {
        getAll(state, payload) {
            state.registeredUsers = payload;
        },
        push(state, payload) {
            state.registeredUsers.push(payload);
        },
        delete(state, payload) {
            const index = state.registeredUsers.findIndex(function (obj) {
                return obj.id === payload;
            });
            if (index !== -1) state.registeredUsers.splice(index, 1);
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/device-condition/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async push({ commit }, payload) {
            await commit("push", payload);
        },
        async delete({ commit }, payload) {
            await commit("delete", payload);
        },
    },
    getters: {},
};
export default registeredUsers;
