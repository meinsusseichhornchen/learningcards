<template>
    <span class="ci-text"
          :class="[
              `ci-skin-` + skin,
              value.length > 0 ? 'input--filled': ''
          ]">
        <input
                :value="value"
                type="text"
                :name="isIndexed() ? name + '[]' : name"
                @input="validateInput"
                class="input__field"
                :class="hasErrors() ? 'input--failed' : ''"
        >
        <label :for="name" class="input__label">
            <span
                v-if="errors.length <= 0"
                class="input__label-content"
            >
                    {{ content | trans }}
            </span>
            <span
                v-else
                class="input__label-content"
            >
                {{ errors[0] }}
            </span>
        </label>
        <button v-if="isIndexed() && index > 0"
                class="input__delete-btn"
                @click.prevent="removeIndexedInput"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </button>
    </span>
</template>

<script>
    import classie from 'desandro-classie';

    export default {
        name: "AppTextInput",

        props: {
            value: {
                required: true,
                default: '',
                type: String,
            },
            rules: {
                required: false,
                default: function() {
                    return [];
                },
                type: Array,
            },
            skin: {
                required: false,
                default: 'underline',
                type: String,
            },
            name: {
                required: false,
                default: 'name',
                type: String,
            },
            index: {
                required: false,
                type: Number,
            },
            content: {
                required: false,
                type: String,
            },
            errors: {
                required: false,
                default: function() {
                    return [];
                },
                type: Array,
            }
        },

        methods: {
            onInputFocus( ev ) {
                classie.add(ev.target.parentNode, 'input--filled');
            },

            onInputBlur( ev ) {
                if (!this.isInputFilled()) {
                    classie.remove(ev.target.parentNode, 'input--filled')
                }
            },

            isInputFilled() {
                return this.$el.querySelector('.input__field').value.trim() !== '';
            },

            validateInput( ev ) {
                this.$emit('changed', ev.target.value, this.name, {
                    [this.name]: this.rules,
                });

                if (this.index !== undefined) {
                    this.$emit('changedIndexedInput', ev.target.value, this.index)
                }
            },

            isIndexed() {
                return typeof this.index !== 'undefined'
            },

            removeIndexedInput() {
                this.$emit('removedIndexedInput', this.index)
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            }
        },
    }
</script>

<style scoped>

</style>