<template>
    <a href="#"
       class="bg-transparent hover:bg-cultured
       text-cultured hover:text-white text-center
       py-2 px-4 w-full block mt-3 mx-1
       border border-cultured hover:border-transparent rounded">
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
            loadMore (page) {
                eventHub.$emit(this.for + '.loadMore', page)
            }
        }
    }
</script>

<style scoped>

</style>