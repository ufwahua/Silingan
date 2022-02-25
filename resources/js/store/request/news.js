import axios from "axios";

const news = {
    namespaced: true,
    state: {
        news: null,
    },
    mutations: {
        getAll(state, payload) {
            state.news = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            const apiKey = "211413c68a3048feb5a299e93eb4988d";
            var xhr = new XMLHttpRequest();
            var news = [];
            await xhr.open(
                "GET",
                "https://newsapi.org/v2/top-headlines?country=ph&apiKey=" +
                    apiKey
            );
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    // readyState 4 - the request is done.
                    if (xhr.status === 200) {
                        // status 200 is a successful return.
                        news = JSON.parse(xhr.responseText);
                        commit("getAll", news.articles);
                    } else {
                        console.log("Error: " + xhr.status);
                    }
                }
            };
            xhr.send(null);
        },
    },

    getters: {},
};
export default news;
