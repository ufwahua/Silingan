import axios from "axios";

const posts = {
    namespaced: true,
    state: {
        posts_timeline: null,
        post_marketplace: null,
        post_marketplace_not_verified: null,
        specific_post: null,
    },
    mutations: {
        getTimelinePost(state, payload) {
            state.posts_timeline = payload;
        },
        getMarketplacePost(state, payload) {
            state.post_marketplace = payload;
        },
        getMarketplacePostNotVerified(state, payload) {
            state.post_marketplace_not_verified = payload;
        },
        getSpecificPost(state, payload) {
            state.specific_post = payload;
        },
    },
    actions: {
        async getTimeLine({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/" + id,
            })
                .then((res) => {
                    commit("getTimelinePost", res.data);
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
                    commit("getMarketplacePost", res.data);
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
                    commit("getMarketplacePostNotVerified", res.data);
                    console.log("not verified", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getSpecificPost({ commit }, id) {
            await axios({
                method: "get",
                url: "/api/post/specific-post/" + id,
            })
                .then((res) => {
                    commit("getSpecificPost", res.data[0]);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default posts;
