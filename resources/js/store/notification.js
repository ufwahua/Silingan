import axios from "axios";

const notifications = {
    namespaced: true,
    state: {
        notifications: null,
        specific_notifications: null,
    },
    mutations: {
        getAll(state, payload) {
            state.notifications = payload;
        },
        getSpecific(state, payload) {
            state.specific_notifications = payload;
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
        async getSpecific({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/notification/" + payload,
            })
                .then((res) => {
                    commit("getSpecific", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default notifications;
