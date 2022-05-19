import axios from "axios";

const Collection = {
    namespaced: true,
    state: {
        Collection: null,
        block_lot_collections: null,
        association_dues_payments: null,
    },
    mutations: {
        getAll(state, payload) {
            state.Collection = payload;
        },
        getCollectionBlockLot(state, payload) {
            state.block_lot_collections = payload;
        },
        getAllCollection(state, payload) {
            state.association_dues_payments = payload;
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
        async getCollectionBlockLot({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/collection/block-lot/" + payload,
            })
                .then((res) => {
                    commit("getCollectionBlockLot", res.data);
                    console.log("collection block lot ", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getAllCollection({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/collection/association-dues/",
            })
                .then((res) => {
                    commit("getAllCollection", res.data);
                    console.log("getAllCollectiont ", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default Collection;
