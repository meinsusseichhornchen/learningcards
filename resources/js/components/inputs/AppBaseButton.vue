<template>
    <a v-if="href">
        <button
            :class="'ci-skin-' + skin"
            :type="type"
            :disabled="disabled"
        >
            {{ content | trans }}
        </button>
    </a>

    <button v-else
        :class="'ci-skin-' + skin"
        :type="type"
        @click.prevent="onPress"
        :disabled="disabled"
    >
        {{ content | trans }}
    </button>
</template>

<script>


    export default {
        name: "AppBaseButton",

        props: {
            skin: {
                required: false,
                type: String,
                default: 'action',
            },
            type: {
                required: false,
                type: String,
                default: 'button',
            },
            href: {
                required: false,
                type: String,
            },
            disabled: {
                required: false,
                type: Boolean,
                default: false,
            },
            content: {
                required: false,
                type: String,
            }
        },

        methods: {
            onPress: function( ev ) {
                this.$emit('pressed');
            }
        }
    }
</script>

<style scoped>

</style>