<template>
    <div class="container">
        <transition-group>
            <app-text-input
                v-for="(value, key) in values" :key="`input-` + key"
                v-model="hasColumnName() ? values[key][column_name] : values[key]"
                :index="key"
                :skin="skin"
                :name="name"
                :rules="rules"
                :content="content"
                :errors="getErrorsFromIndexedInput(key)"
                @changedIndexedInput="validateIndexedInput"
                @removedIndexedInput="pullIndexedInput"
            >
            </app-text-input>
        </transition-group>
        <button :class="`input__add-btn`"
                class="rounded-full bg-hiro-lighter"
                @click.prevent="addNewInput"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>
</template>

<script>
    import AppTextInput from "./AppTextInput";

    export default {
        name: "AppMultipleTextInput",
        components: {
            AppTextInput,
        },

        props: {
            values: {
                required: true,
                default: function() {
                    return [];
                },
                type: Array,
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
                default: 'names[]',
                type: String,
            },
            column_name: {
                required: false,
                type: String,
            },
            content: {
                required: false,
                type: String,
            },
            errors: {
                required: false,
                type: Object,
            }
        },

        methods: {
            init: function() {
                if (this.values.length === 0) {
                    this.pushValue();
                }
            },

            addNewInput: function( ev ) {
                this.pushValue();
            },

            hasColumnName: function() {
                return typeof this.column_name !== 'undefined';
            },

            getRulesFromIndexedInput: function( index ) {

                if (this.hasColumnName()) {
                    return {
                        [this.name + '.' + index + '.' + this.column_name]: this.rules,
                    }
                }

                return {
                    [this.name + '.' +  index]: this.rules
                }
            },

            getErrorsFromIndexedInput: function( index ) {
                if (this.hasColumnName()) {
                    if (this.errors.hasOwnProperty(this.name + '.' + index + '.' + this.column_name)) {
                        return this.errors[this.name + '.' + index + '.' + this.column_name];
                    }
                }

                if (this.errors.hasOwnProperty(this.name + '.' + index)) {
                    return this.errors[this.name + '.' + index];
                }

                return [];
            },

            pushValue: function( value = '' ) {
                if (this.hasColumnName()) {
                    value = {
                        [this.column_name]: value
                    }
                }

                this.values.push(value);
            },

            pullValue: function( index ) {
                this.values.splice(index, 1);
            },

            setValue: function( value, index ) {
                if (this.hasColumnName()) {
                    this.$set(this.values, index, {
                        [this.column_name]: value
                    });

                    return;
                }

                this.$set(this.values, index, value);
            },

            pullIndexedInput: function( index ) {
                this.pullValue(index);
                this.$emit('removedIndexedInput',
                    this.hasColumnName() ?
                        this.name + '.' + index + '.' + this.column_name
                        : this.name + '.' + index)
            },

            validateIndexedInput: function( value, index ) {
                this.setValue(value, index);
                this.$emit('changedIndexedInput', this.values, this.name, this.getRulesFromIndexedInput(index), index)
            },
        },

        beforeMount() {
            this.init();
        },
    }
</script>

<style scoped>

</style>