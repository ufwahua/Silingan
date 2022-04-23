import axios from "axios";

const notifications = {
    namespaced: true,
    state: {
        notifications: null,
    },
    mutations: {
        getAll(state, payload) {
            state.notifications = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/notification/",
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
export default notifications;
