import axios from "axios";

const Fund = {
    namespaced: true,
    state: {
        Fund: null,
    },
    mutations: {
        getAll(state, payload) {
            state.Fund = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/fund/",
                })
                .then((res) => {
                    commit("getAll", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default Fund;