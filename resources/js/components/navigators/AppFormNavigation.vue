<template>
    <div class="multi-step-form-navigation flex justify-center">
        <button v-if="steps.current > 1"
                @click.prevent="prevStep()"
                class="form-navigation__prev-btn"
        >
            {{ content.prev | trans }}
        </button>

        <button v-if="steps.current <= steps.total"
                :disabled="(hasErrors() && steps.failed === steps.current) || disabled"
                @click.prevent="nextStep()"
                class="form-navigation__next-btn"
        >
            {{ content.next | trans }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "AppFormNavigation",

        props: {
            steps: {
                required: false,
                type: Object,
            },
            errors: {
                required: false,
                type: Object
            },
            disabled: {
                required: false,
                type: Boolean,
                default: false
            },
            content: {
                required: false,
                type: Object,
                default: function() {
                    return {
                        prev: 'components/form-navigation.previous',
                        next: 'components/form-navigation.next'
                    }
                }
            }
        },

        methods: {
            hasErrors: function() {
                return Object.keys(this.errors).length > 0;
            },

            nextStep: function() {
                if (!this.hasErrors() || this.steps.failed > this.steps.current) {
                    this.$emit('movedForward')
                }
            },

            prevStep: function() {
                this.$emit('movedBackward')
            },
        },

        watch: {
            errors: function() {
                if (this.hasErrors()) {
                    this.$emit('stepFailed');
                }
            }
        }
    }
</script>

<style scoped>

</style>