import axios from "axios";

const candidates = {
    namespaced: true,
    state: {
        candidates: null,
        last_candidates: null,
    },
    mutations: {
        getAll(state, payload) {
            state.candidates = payload;
        },
        getLastCandidates(state, payload) {
            state.last_candidates = payload;
        },
    },
    actions: {
        async getAll({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/candidate/" + payload,
            })
                .then((res) => {
                    console.log("getAllCandidates", res.data);
                    commit("getAll", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getLastCandidates({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/candidate/" + payload,
            })
                .then((res) => {
                    commit("getLastCandidates", res.data);
                    console.log("getLastCandidate", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default candidates;
