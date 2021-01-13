<template>
    <ul v-if="pagination" class="paginator flex justify-center">
        <li
            v-if="links.prev !== null" class="float-left">
            <a @click.prevent="switchPage(pagination.current_page - 1)"
               class="flex justify-center items-center w-10 h-10 paginator__prev-page" href="#">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </a>
        </li>
        <li v-for="page in pagination.total"
            class="mx-1 paginator__item"
            :class="links.next === null && page === pagination.total ? 'clearfix' : 'float-left'"
        >
            <a @click.prevent="switchPage(page)"
               class="w-10 h-10 flex items-center justify-center text-white paginator__item-link"
               :class="page === pagination.current_page ? 'active' : ''"
               href="#">{{ page }}
            </a>
        </li>
        <li
            v-if="links.next !== null" class="clearfix">
            <a @click.prevent="switchPage(pagination.current_page + 1)"
               class="flex justify-center items-center w-10 h-10 paginator__next-page" href="#">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </a>
        </li>
    </ul>
</template>

<script>
    import eventHub from '../../events';

    export default {
        name: "AppPaginator",

        props: {
            pagination: {
                required: false,
                type: Object,
            },
            links: {
                required: false,
                type: Object,
            },
            for: {
                type: String,
                default: 'default',
            }
        },

        methods: {
            switchPage (page) {
                eventHub.$emit(this.for + '.switched-page', page)
            },
        },

        mounted () {

        }
    }
</script>

<style scoped>

</style>