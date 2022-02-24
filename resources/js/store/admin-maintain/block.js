import axios from "axios";

const block = {
    namespaced: true,
    state: {
        block: null,
    },
    mutations: {
        getAll(state, payload) {
            state.block = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/block/",
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
export default block;
