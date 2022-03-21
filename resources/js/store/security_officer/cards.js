import axios from "axios";

const cards = {
    namespaced: true,
    state: {
        cards: null,
    },
    mutations: {
        getAll(state, payload) {
            state.cards = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/card/",
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
export default cards;
