export default {
    namespaced: true,

    state: {
        answers: {
            data: []
        }
    },

    getters: {
        answers (state) {
            return state.answers;
        }
    },

    mutations: {
        PUSH_ANSWER (state, answer) {
            state.answers.data.push(answer);
        }
    },

    actions: {
        pushAnswer({ commit }, answer) {
            commit('PUSH_ANSWER', answer)
        }
    }
}