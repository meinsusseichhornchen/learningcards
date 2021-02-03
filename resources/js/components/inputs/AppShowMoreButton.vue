<template>
    <a href="#"
       class="bg-transparent hover:bg-hiro
       text-hiro hover:text-white text-center
       py-2 px-4 w-full block mt-3 mx-auto mt-2
       border border-hiro hover:border-transparent rounded show-more-btn"
    @click.prevent="loadMore"
    >
        {{ content | trans }}
    </a>
</template>

<script>
    import eventHub from '../../events';

    export default {
        name: "AppShowMoreButton",

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
            },
            content: {
                type: String,
                default: `components/inputs.buttons.show more`
            }
        },

        methods: {
            loadMore () {
                this.$emit('loadPaginated' + this.for.charAt(0).toUpperCase() + this.for.slice(1), ++this.pagination.current_page)
            }
        }
    }
</script>

<style scoped>

</style>