import axios from "axios";

const CollectionType = {
    namespaced: true,
    state: {
        CollectionType: null,
    },
    mutations: {
        getAll(state, payload) {
            state.CollectionType = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/collection_type/",
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
export default CollectionType;