<template>
    <ul v-if="pagination" class="paginator flex justify-center">
        <li
            class="float-left">
            <a @click.prevent="switchPage(pagination.current_page - 1)"
               class="flex justify-center items-center w-10 h-10 paginator__prev-page" href="#">
                <span v-if="links.prev !== null">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </span>
            </a>
        </li>
        <li v-for="page in pagination.total"
            class="mx-1 paginator__item"
            :class="links.next === null && page === pagination.total ? 'clearfix' : 'float-left'"
        >
            <a @click.prevent="switchPage(page)"
               class="w-10 h-10 flex items-center justify-center paginator__item-link"
               :class="[page === pagination.current_page ? 'active' : '', 'text-' + text_color]"
               href="#">{{ page }}
            </a>
        </li>
        <li class="clearfix">
            <a @click.prevent="switchPage(pagination.current_page + 1)"
               class="flex justify-center items-center w-10 h-10 paginator__next-page" href="#">
                <span v-if="links.next !== null">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </span>
            </a>
        </li>
    </ul>
</template>

<script>
    import eventHub from '../../events';

    export default {
        name: "AppPaginator",

        props: {
            text_color: {
                default: 'black'
            },
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