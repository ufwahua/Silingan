import axios from "axios";

const Collection = {
    namespaced: true,
    state: {
        Collection: null,
    },
    mutations: {
        getAll(state, payload) {
            state.Collection = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/collection/",
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
export default Collection;