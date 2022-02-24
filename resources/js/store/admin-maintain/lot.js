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
    },
    getters: {},
};
export default lot;
