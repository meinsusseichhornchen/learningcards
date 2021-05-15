<template>
    <div class="container mx-auto">
        <app-accordion-list
            :items="scores"
        >
        </app-accordion-list>
        <app-paginator
                for="scores"
                :links="scores.links"
                :pagination="scores.meta"
        >
        </app-paginator>
    </div>
</template>

<script>
    import AppAccordionList from '../components/lists/AppAccordionList';
    import AppPaginator from '../components/paginators/AppPaginator';

    import eventHub from "../events";
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "Home",
        components: {
            AppAccordionList,
            AppPaginator,
        },

        data () {
            return {
                page: 1,
            }
        },

        computed: {
            ...mapGetters({
                scores: "score/scores",
            })
        },

        props: {
            meta: {
                required: false,
                type: Object,
            },
            links: {
                required: false,
                type: Object,
            }
        },

        methods: {
            ...mapActions({
                getScores: 'score/getScores'
            }),

            loadScores (pageNumber) {
                this.page = pageNumber;
                this.getScores(pageNumber);
            }
        },

        mounted() {
            this.loadScores(this.page);
            eventHub.$on('scores.switched-page', this.loadScores);
        }
    }
</script>

<style scoped>

</style>