import axios from "axios";

const ExpenseType = {
    namespaced: true,
    state: {
        ExpenseType: null,
    },
    mutations: {
        getAll(state, payload) {
            state.ExpenseType = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            await axios({
                    method: "get",
                    url: "/api/expense_type/",
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
export default ExpenseType;