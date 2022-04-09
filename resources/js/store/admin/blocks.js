import axios from "axios";

const blocks = {
    namespaced: true,
    state: {
        blocks: null,
        example: null,
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
                    commit("getAll", res.data);
                    console.log("Test:"  + res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default blocks;
