import axios from "axios";

const userVehicles = {
    namespaced: true,
    state: {
        userVehicles: null,
    },
    mutations: {
        getAll(state, payload) {
            state.userVehicles = payload;
        },
    },
    actions: {
        async getAll({ commit }, payload) {
            await axios({
                method: "get",
                url: "/api/vehicle/" + payload,
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log("user vehicles", res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default userVehicles;
