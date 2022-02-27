import axios from "axios";

const blocks = {
    namespaced: true,
    state: {
        blocks: null,
    },
    mutations: {
        getAll(state, payload) {
            state.blocks = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/block/",
            })
                .then((res) => {
                    console.log(res.data);
                    commit("getAll", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default blocks;
