const timeNow = {
    namespaced: true,
    state: {
        timeNow: null,
    },
    mutations: {
        getAll(state, payload) {
            state.timeNow = payload;
        },
    },
    actions: {
        async getAll({ commit }) {
            var xhr = new XMLHttpRequest();
            await xhr.open("GET", "http://worldtimeapi.org/api/ip");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    // readyState 4 - the request is done.
                    if (xhr.status === 200) {
                        // status 200 is a successful return.
                        commit("getAll", JSON.parse(xhr.responseText));
                    } else {
                        console.log("Error: " + xhr.status);
                        this.loading = false;
                    }
                }
            };
            xhr.send(null);
        },
    },

    getters: {},
};
export default timeNow;
