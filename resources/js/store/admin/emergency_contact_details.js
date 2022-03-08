import axios from "axios";

const emergency_contact_details = {
    namespaced: true,
    state: {
        emergency_contact_details: null,
        example: null,
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
                url: "/api/emergency_contact_detail/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                    //console.log(res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default emergency_contact_details;
