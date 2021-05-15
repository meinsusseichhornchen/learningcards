import axios from 'axios';

export default {
    namespaced: true,

    state: {
        tags: [],
    },

    getters: {
        tags (state) {
            return state.tags;
        }
    },

    mutations: {
        PUSH_TAGS (state, data) {
            Vue.set(state.tags, state.tags.length, data);
        },

        SET_TAGS (state, data) {
            Vue.set(state, 'tags', data);
        }
    },

    actions: {
        async getTags({ commit, dispatch }) {
            let response = await axios.get('/api/tags');

            dispatch('setTags', response.data);
        },

        setTags({ commit }, payload) {
            commit('SET_TAGS', payload);
        },

        push({ commit }, payload) {
            commit('PUSH_TAGS', payload)
        }
    }
}