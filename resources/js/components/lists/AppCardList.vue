<template>
    <div v-if="cards.data">
        <app-delete-card-modal
                name="delete-card"
                @cardDestroyed="setCards"
        />

        <ul class="flex card-list" v-if="cards.data.length > 0">
            <li class="card-list__item">
                <a :href="links.create_card_collection !== undefined ? links.create_card_collection : '#'" class="card-list__add-btn">
                    <svg class="w-16 h-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Add Card</span>
                </a>
            </li>
            <app-card-list-answer
                    v-for="card in cards.data"
                    :key="card.id"
                    :card="card">
            </app-card-list-answer>
        </ul>

        <app-show-more-button
                for="cards"
                v-if="cards.data.length > 0 && page < cards.meta.last_page"
                @loadPaginatedCards="loadCards"
                :pagination="cards.meta">
        </app-show-more-button>
    </div>
</template>

<script>
    import AppCardListAnswer from "./AppCardListAnswer";
    import AppDeleteCardModal from "../modals/AppDeleteCardModal";
    import AppShowMoreButton from '../inputs/AppShowMoreButton';

    import eventHub from '../../events';
    import { mapActions, mapGetters } from "vuex";

    export default {
        name: "AppCardList",

        components: {
            AppShowMoreButton,
            AppDeleteCardModal,
            AppCardListAnswer
        },

        computed: {
            ...mapGetters({
                cards: 'card/cards'
            }),
        },

        data() {
            return {
                page: 1,
            }
        },

        props: {
            collection: {
                required: false,
                type: Number,
            },
            links: {
                required: false,
                type: Object,
            }
        },

        methods: {
            ...mapActions({
                getCards: 'card/getCards',
                setCards: 'card/setCards'
            }),

            loadCards (pageNumber) {
                if (this.cards.data.length > 0) {
                    if (pageNumber > this.cards.meta.last_page) {
                        return;
                    }
                }

                this.page = pageNumber;
                this.getCards({
                    collection: this.collection,
                    pageNumber: this.page,
                })
            },
        },

        async beforeMount() {
            await this.getCards({
                collection: this.collection,
                pageNumber: this.page,
            });
        },

        mounted() {
            eventHub.$on('cards.switched-page', this.loadCards);
        }
    }
</script>

<style scoped>

</style>