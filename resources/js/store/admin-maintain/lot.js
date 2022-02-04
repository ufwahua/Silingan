import axios from "axios";

const lot = {
    namespaced: true,
    state: {
        lot: null,
        filteredLots: null,
    },
    mutations: {
        getAll(state, payload) {
            state.lot = payload;
        },
        getBlockLots(state, payload) {
            state.filteredLots = payload;
        },
        push(state, payload) {
            state.lot.push(payload);
        },
        delete(state, payload) {
            const index = state.lot.findIndex(function (obj) {
                return obj.id === payload;
            });
            if (index !== -1) state.lot.splice(index, 1);
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/lot/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getBlockLots({ commit, state }, payload) {
            await axios({
                method: "get",
                url: "/api/lot/" + payload,
            })
                .then((res) => {
                    console.log(res.data);
                    commit("getBlockLots", res.data);
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
export default lot;
