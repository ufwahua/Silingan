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
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/post/",
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
export default posts;
