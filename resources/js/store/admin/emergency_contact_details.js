import axios from "axios";

const emergency_contact_details = {
    namespaced: true,
    state: {
        emergency_contact_details: null,
    },
    mutations: {
        getAll(state, payload) {
            state.emergency_contact_details = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/emergency-contact-detail/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("emergency", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default emergency_contact_details;
