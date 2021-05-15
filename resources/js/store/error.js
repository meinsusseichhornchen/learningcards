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

        UNSET_ERROR (state, params) {
            Vue.delete(state.errors, params.fieldName);
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
        has({ commit}) {
            commit('HAS_ERRORS');
        },
        push ({ commit, dispatch }, errors) {
            console.log(errors);
            $_.forEach(errors, (value, key) => {
                dispatch('set', {
                    value: value,
                    key: key
                })
            })
        },
        pullErrors ({ commit, dispatch }, rules) {
            $_.forEach(rules, (value, key) => {
                dispatch('pull', {
                    fieldName: key
                })
            })
        },
        pull({ commit }, fieldName) {
            commit('PULL_ERROR', fieldName)
        },
        unset({ commit }, key) {
            commit('UNSET_ERROR', {
                fieldName: key
            })
        },
        setErrors ({ commit }, errors) {
            commit('SET_ERRORS', errors);
        },
        set({ commit }, { value, key }) {
            commit('SET_ERROR', {
                error: value,
                fieldName: key
            });
        }
    }
}