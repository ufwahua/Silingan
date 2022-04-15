import axios from "axios";

const emergency_contact_details = {
    namespaced: true,
    state: {
        emergency_contacts_all: null,
        emergency_contacts: null,
    },
    mutations: {
        getAll(state, payload) {
            state.emergency_contacts_all = payload;
        },
        getContacts(state, payload) {
            state.emergency_contacts = payload;
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
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        async getContacts({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/emergency-contact-detail/" + payload,
            })
                .then((res) => {
                    commit("getContacts", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default emergency_contact_details;
