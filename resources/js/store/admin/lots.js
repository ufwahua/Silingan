import axios from "axios";

const lots = {
    namespaced: true,
    state: {
        lots: null,
        filteredLots: null,
    },
    mutations: {
        getAll(state, payload) {
            state.lots = payload;
        },
        getBlockLots(state, payload) {
            state.filteredLots = payload;
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
        async getBlockLots({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/lot/" + payload,
            })
                .then((res) => {
                    console.log("filteredlots", res.data);
                    commit("getBlockLots", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                    commit("getBlockLots", null);
                });
        },
    },
    getters: {},
};
export default lots;
