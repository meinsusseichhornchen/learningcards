import axios from 'axios';

export default {
    namespaced: true,

    state: {
        cards: {
            data: [],
            links: {},
            meta: {}
        },
        card_types: {
            data: []
        },
    },

    getters: {
        cards (state) {
            return state.cards;
        },
        card_types (state) {
            return state.card_types;
        },
    },

    mutations: {
        PUSH_CARDS (state, data) {
            state.cards.data = data.data;
            state.cards.links = data.links;
            state.cards.meta = data.meta;
        },

        SET_CARD_TYPES (state, data) {
            state.card_types.data = data;
        }
    },

    actions: {
        async deleteCard({ commit }, card) {
            return await axios.delete('/api/cards/' + card)
                .then((response) => {
                    return response.data;
                }).catch((err) => {
                    console.log(err.response);
                });
        },

        async getCards({ commit }, { collection, pageNumber } ) {
            let response = await axios.get('/api/collections/' + collection + '/cards/?page=' + pageNumber)
                .catch((err) => {
                    console.log(err.response);
                });

            console.log(response);
            commit('PUSH_CARDS', response.data);
        },

        setCards({ commit }, cards) {
            commit('PUSH_CARDS', cards);
        },

        async getCardTypes({ commit }) {
            let response = await axios.get('/api/cards/card-types')
                .catch((err) => {
                    console.log(err.response);
                });

            console.log(response);
            commit('SET_CARD_TYPES', response.data);
        }
    }
}