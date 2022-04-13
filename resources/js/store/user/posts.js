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
        async getMarketPlaceVerified({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/marketplace/verified/" + id,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("posts", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getMarketPlaceNotVerified({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/marketplace/not-verified/" + id,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("not verified", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default posts;
