import axios from "axios";

const logs = {
    namespaced: true,
    state: {
        logs: null,
    },
    mutations: {
        getAll(state, payload) {
            state.logs = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/log/",
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
export default logs;
