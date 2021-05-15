import axios from 'axios';

export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: null,
    },

    getters: {
        authenticated (state) {
            return state.authenticated;
        },

        user (state) {
            return state.user;
        }
    },

    mutations: {
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value;
        },

        SET_USER (state, data) {
            state.user = data;
        }
    },

    actions: {
        async me({ commit }) {
            let response = await axios.get(window.location.origin + '/api/user')
                .catch((err) => {
                    commit('SET_AUTHENTICATED', false)
                    commit('SET_USER', null)
                });

            console.log(response.data);
            commit('SET_AUTHENTICATED', true);
            commit('SET_USER', response.data);
        },
    }
}