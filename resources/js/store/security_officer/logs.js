import axios from "axios";

const logs = {
    namespaced: true,
    state: {
        logs: null,
        logs_masterlist: null,
        logs_specific: null,
    },
    mutations: {
        getAll(state, payload) {
            state.logs = payload;
            state.logs_masterlist = payload;
        },
        getSpecific(state, payload) {
            state.logs_specific = payload;
        },
        getLogMasterList(state, payload) {
            state.logs_masterlist = payload;
        },
        getLogs(state, payload) {
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
        async getSpecific({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/log/" + payload,
            })
                .then((res) => {
                    commit("getSpecific", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default logs;
