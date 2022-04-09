import axios from "axios";

const cards = {
    namespaced: true,
    state: {
        cards: null,
        allCards:null,
    },
    mutations: {
        getAll(state, payload) {
            state.cards = payload;
        },
         getAllCards(state, payload) {
            state.allCards = payload;
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
        async getAllCards({ commit }) {
            await axios({
                method: "get",
                url: "/api/getAllCards/",
            })
                .then((res) => {
                    commit("getAllCards", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default cards;
