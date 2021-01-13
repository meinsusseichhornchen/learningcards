import axios from 'axios';

export default {
    namespaced: true,

    state: {
        collections: {
            data: [],
        },
        errors: {},
    },

    getters: {
        collections (state) {
            return state.collections;
        },
        errors (state) {
            return state.errors;
        }
    },

    mutations: {
        SET_ERRORS(state, errors) {
            state.errors = errors;
        },
        ADD_ERROR(state, payload) {
            state.errors[payload.field] = payload.error
        },
    },

    actions: {
    }
}