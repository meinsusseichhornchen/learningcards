import $_ from 'lodash';

export default {
    namespaced: true,

    state: {
        errors: {}
    },

    getters: {
        errors (state) {
            return state.errors
        }
    },

    mutations: {
        SET_ERROR (state, params) {
            Vue.set(state.errors, params.fieldName, params.error);
        },

        /**
         * @return {boolean}
         */
        HAS_ERRORS (state) {
            return Object.keys(state.errors).length > 0;
        },

        SET_ERRORS (state, errors) {
            state.errors = errors;
        },

        PULL_ERROR (state, params) {
            if (state.errors[params.fieldName] !== undefined) {
                Vue.delete(state.errors, params.fieldName);
            }
        }
    },

    actions: {
        hasErrors({ commit}) {
            commit('HAS_ERRORS');
        },
        pushErrors ({ commit, dispatch }, errors) {
            $_.forEach(errors, (value, key) => {
                dispatch('setError', {
                    value: value,
                    key: key
                })
            })
        },
        pullErrors ({ commit, dispatch }, rules) {
            $_.forEach(rules, (value, key) => {
                dispatch('pullError', {
                    fieldName: key
                })
            })
        },
        pullError({ commit }, fieldName) {
            commit('PULL_ERROR', fieldName)
        },
        setErrors ({ commit }, errors) {
            commit('SET_ERRORS', errors);
        },
        setError({ commit }, { value, key }) {
            commit('SET_ERROR', {
                error: value,
                fieldName: key
            });
        }
    }
}