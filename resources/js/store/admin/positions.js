import axios from "axios";

const positions = {
    namespaced: true,
    state: {
        positions: null,
    },
    mutations: {
        getAll(state, payload) {
            state.positions = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/position/",
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
export default positions;
