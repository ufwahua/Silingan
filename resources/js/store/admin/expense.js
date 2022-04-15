import axios from "axios";

const Expense = {
    namespaced: true,
    state: {
        Expense: null,
    },
    mutations: {
        getAll(state, payload) {
            state.Expense = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/expense/",
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
export default Expense;