import axios from "axios";

const adminVehicles = {
    namespaced: true,
    state: {
        adminVehicles: null,
    },
    mutations: {
        getAll(state, payload) {
            state.adminVehicles = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/vehicle/",
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("admin vehicles", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default adminVehicles;
