<template>
    <span class="ci-textarea" :class="`ci-skin-` + skin">
        <textarea
                :name="name"
                :id="name"
                @focus="onInputFocus"
                @blur="onInputBlur"
                class="input__field"
                :class="errors.length > 0 ? 'input--failed' : ''"
                v-model="inputValue"
                @input="validate"
        >
            {{ value }}
        </textarea>
        <label :for="name" class="input__label">
            <span v-if="errors.length <= 0" class="input__label-content">{{ content | trans }}</span>
            <span v-else class="input__label-content">{{ errors[0] }}</span>
        </label>
        <span v-if="max_length" class="input__word-counter">{{ currentLength + '/' + max_length }}</span>
    </span>
</template>

<script>
    import classie from "desandro-classie";

    export default {
        name: "AppTextAreaPlain",

        data() {
            return {
                value: '',
            }
        },

        props: {
            default: {
                required: false,
                type: String,
            },
            rules: {
                required: false,
                default: [],
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
            content: {
                required: false,
                type: String,
            },
            errors: {
                required: false,
                type: Array,
            },
            max_length: {
                required: false,
                type: Number,
            }
        },

        computed: {
            inputValue: {
                get() {
                    return this.value;
                },

                set(newValue) {
                    this.value = newValue;

                    this.$nextTick(() => {
                        if (this.max_length !== undefined) {
                            this.value = newValue.substr(0, this.max_length - 1)
                        }
                    })
                }
            },
            currentLength: function() {
                return this.value.length;
            }
        },

        methods: {
            validate: function ( ev ) {
                this.$emit('changed', ev.target.value, this.name, {
                    [this.name]: this.rules,
                })
            },
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

            hasMaximumLength: function () {
                return this.max_length !== undefined && this.currentLength >= this.max_length;
            },
        },

        mounted() {
            if (this.isInputFilled()) {
                classie.add(this.$el, 'input--filled');
            }
        },
    }
</script>

<style scoped>

</style>