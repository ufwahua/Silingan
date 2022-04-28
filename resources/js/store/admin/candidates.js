import axios from "axios";

const candidates = {
    namespaced: true,
    state: {
        current_candidates: null,
        last_candidates: null,
    },
    mutations: {
        getAll(state, payload) {
            state.current_candidates = payload;
        },
    },
    actions: {
        async getAll({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/candidate/" + payload,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log(res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default candidates;
