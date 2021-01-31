<template>
    <div class="one-step-form-navigation flex justify-center">
        <button
            class="form-navigation__secondary-btm"
        >
            <a
                :href="previous">
                {{ content.back | trans }}
            </a>
        </button>

        <button
            type="submit"
            :disabled="(hasErrors() || disabled)"
            @click.prevent="beforeSubmit()"
            class="form-navigation__primary-btn"
        >
            {{ content.submit | trans }}
        </button>
    </div>
</template>

<script>

    export default {
        name: "AppOneStepFormNavigation",

        props: {
            errors: {
                required: false,
                type: Object
            },
            disabled: {
                required: false,
                type: Boolean,
                default: false
            },
            previous: {
                required: false,
                type: String,
                default: '#',
            },
            content: {
                required: false,
                type: Object,
                default: function() {
                    return {
                        back: 'components/form-navigation.previous',
                        submit: 'components/form-navigation.submit'
                    }
                }
            }
        },

        methods: {
            hasErrors: function() {
                return Object.keys(this.errors).length > 0;
            },

            beforeSubmit: function() {
                this.$emit('readyToBeSubmitted');
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