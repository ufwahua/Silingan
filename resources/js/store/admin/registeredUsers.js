import axios from "axios";

const registeredUsers = {
    namespaced: true,
    state: {
        registeredUsers: null,
    },
    mutations: {
        getAll(state, payload) {
            state.registeredUsers = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                method: "get",
                url: "/api/user/",
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
export default registeredUsers;
