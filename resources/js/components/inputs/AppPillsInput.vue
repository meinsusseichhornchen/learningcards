<template>
    <div class="ci-pills flex m-4">
        <transition-group tag="div" name="slide-left" class="ci-pills-inputs">
            <div v-for="(option, key) in options" :key="'input-' + key" class="ci-pills-item">
                <input class="ci-pills-item-input" type="checkbox" :id="$_.kebabCase(option.name)" :value="option.id" v-model="checked" :name="name + `[]`" @change="updateCheckedValues">
                <label class="input__label rounded" :for="$_.kebabCase(option.name)">{{ option.name }}</label>
            </div>
        </transition-group>
        <div class="ci-pills-add-form">
            <span class="ci-pills-add-form__group w-5/6">
                <input
                        type="text"
                        class="input__field"
                        :class="errors.length > 0 ? 'input--failed' : ''"
                        :name="inputName()"
                        @blur="onInputBlur"
                        @focus="onInputFocus"
                >
                <label :for="inputName()" class="input__label">
                    <span v-if="errors.length > 0" class="input__label-content">
                        {{ errors[0] }}
                    </span>
                    <span v-else class="input__label-content">
                        {{ content | trans({item: modelName() }) }}
                    </span>
                </label>
            </span>
            <button @click.prevent="addNewPill" class="ci-pills-add-form-btn rounded-full bg-hiro-lighter">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import classie from 'desandro-classie';
    import pluralize from 'pluralize';

    export default {
        name: "AppPillsInput",

        data() {
            return {
                checked: []
            }
        },

        props: {
            values: {
              required: false,
              default: function() { return [] },
              type: Array,
            },
            name: {
                required: false,
                default: '',
                type: String,
            },
            content: {
                required: false,
                default: 'components/inputs.pills.default',
                type: String,
            },
            errors: {
                required: false,
                type: Array,
            },
            options: {
                required: false,
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

            updateCheckedValues: function( ev ) {
                this.$emit('updateCheckedValues', this.$data.checked, this.name);
            },

            inputName: function() {
                return 'new-' + this.modelName();
            },

            modelName: function() {
                return pluralize.singular(this.name);
            },

            addNewPill: async function ( ev ) {
                await axios.post('/api/' + this.name + '/create', {
                    name: this.$el.querySelector('input[name=' + this.inputName() + ']').value
                })
                    .then((response) => {
                        if (response.data !== null) {
                            this.$emit('newPillCreated', response.data, this.name)
                        }
                    })
                    .catch((err) => {
/*                        console.log(err.response)*/
                        this.$emit('newPillFailed', err.response.data.errors, this.name);
                    });
            }
        }
    }
</script>

<style scoped>

</style>