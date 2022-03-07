import axios from "axios";

const candidates = {
    namespaced: true,
    state: {
        candidates: null,
    },
    mutations: {
        getAll(state, payload) {
            state.candidates = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/candidate/",
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
export default candidates;
