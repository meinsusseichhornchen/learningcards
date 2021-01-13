import axios from "axios";

export default {
    namespaced: true,

    state: {
        scores: {
            data: [],
            links: {},
            meta: {}
        },
    },

    getters: {
        scores (state) {
            return state.scores;
        }
    },

    mutations: {
        PUSH_SCORES (state, data) {
            state.scores.data = data.data;
            state.scores.links = data.links;
            state.scores.meta = data.meta;
        }
    },

    actions: {
        async getScores ({ commit }, pageNumber) {
            let response = await axios.get('/api/scores?page=' + pageNumber);
            console.log(response);

            commit('PUSH_SCORES', response.data);
        }
    }
}