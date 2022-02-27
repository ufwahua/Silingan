import axios from "axios";

const announcements = {
    namespaced: true,
    state: {
        announcements: null,
        example: null,
    },
    mutations: {
        getAll(state, payload) {
            state.announcements = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/announcement/",
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
export default announcements;
