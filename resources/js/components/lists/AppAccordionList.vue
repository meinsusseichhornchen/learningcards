<template>
        <ul
            v-if="items"
            class="accordion-list"
        >
            <app-accordion-list-score
                v-for="score in items.data"
                :key="score.id"
                :score="score"
            />
        </ul>
</template>

<script>
    import AppAccordionListScore from "./AppAccordionListScore";

    export default {
        components: {
            AppAccordionListScore,
        },

        data () {
            return {
                page: 1,
            }
        },

        props: {
            items: {
                required: false,
                type: Object,
            },
            meta: {
                required: false,
                type: Object,
            },
            links: {
                required: false,
                links: Object,
            }
        },
    }
</script>
