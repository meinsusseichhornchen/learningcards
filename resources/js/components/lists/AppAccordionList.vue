<template>
    <div v-if="scores" class="container accordion-list mb-6">
        <app-paginator for="scores" :links="scores.links" :pagination="scores.meta"></app-paginator>
        <dl>
            <app-accordion-list-score v-for="score in scores.data" :key="score.id" :score="score" />
        </dl>
    </div>
</template>

<script>
    import AppAccordionListScore from "./AppAccordionListScore";
    import AppPaginator from '../paginators/AppPaginator';

    import eventHub from '../../events';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            AppAccordionListScore,
            AppPaginator
        },

        data () {
            return {
                page: 1,
            }
        },

        computed: {
            ...mapGetters({
                scores: 'score/scores',
            })
        },

        props: {
            meta: {
                required: false,
                type: Object,
            },
            links: {
                required: false,
                links: Object,
            }
        },

        methods: {
            ...mapActions({
                getScores: 'score/getScores'
            }),

            loadScores (pageNumber) {
                this.page = pageNumber;
                this.getScores(pageNumber)
            }
        },

        mounted () {
            this.loadScores(this.page);
            eventHub.$on('scores.switched-page', this.loadScores)
        }
    }
</script>
