import axios from "axios";

const registeredUsersFname = {
    namespaced: true,
    state: {
        registeredUsersFname: null,
    },
    mutations: {
        getAll(state, payload) {
            state.registeredUsersFname = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/index2",
            })
                .then((res) => {
                    commit("getAll", res.data);
                    console.log(res.data);
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
    getters: {},
};
export default registeredUsersFname;
