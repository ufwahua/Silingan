import axios from "axios";

const posts = {
    namespaced: true,
    state: {
        posts: null,
    },
    mutations: {
        getAll(state, payload) {
            state.posts = payload;
        },
    },
    actions: {
        async getTimeLine({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/" + id,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("posts", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getMarketPlace({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/market_place/" + id,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("posts", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default posts;
