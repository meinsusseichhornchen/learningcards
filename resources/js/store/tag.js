import axios from 'axios';

export default {
    namespaced: true,

    state: {
        tags: {
            data: [],
        },
    },

    getters: {
        tags (state) {
            return state.tags;
        }
    },

    mutations: {
        PUSH_TAGS (state, data) {
            state.tags.data = data;
        }
    },

    actions: {
        async getTags({ commit }) {
            let response = await axios.get('/api/tags');

            commit('PUSH_TAGS', response.data);
        }
    }
}