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
        push(state, payload) {
            state.block.push(payload);
        },
        delete(state, payload) {
            const index = state.block.findIndex(function (obj) {
                return obj.id === payload;
            });
            if (index !== -1) state.block.splice(index, 1);
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
        async push({ commit }, payload) {
            await commit("push", payload);
        },
        async delete({ commit }, payload) {
            await commit("delete", payload);
        },
    },
    getters: {},
};
export default block;
