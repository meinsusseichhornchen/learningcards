<template>
    <span class="cs-select" :class="`cs-skin-` + skin">
        <div class="select__wrapper">
            <select v-model="selected"
                    @blur="deactivate"
                    @focus="activate"
                    @change="deactivate"
                    @mouseup="activate"
                    :name="name"
                    :value="value">
                <option value="" disabled>{{ 'components/inputs.options.default' | trans({ item: content}) }}</option>
                <option v-for="option in options" :value="option.value ? option.value : option.id">{{ option.name }}</option>
            </select>
            <svg class="select__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </span>
</template>

<script>
    import classie from 'desandro-classie';
    import BrowserDetect from '../../vendor/BrowserDetect'

    export default {
        name: "AppSelectorInput",

        data() {
            return {
                isFocused: false,
                selected: '',
            }
        },

        props: {
            value: {
                required: false,
                default: '',
                type: String,
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
            options: {
                required: false,
                type: Array,
            }
        },

        methods: {
            activate: function( ev ) {
                if (!classie.hasClass(ev.target, 'active')) {
                    if (ev.type === 'focus') {
                        classie.add(ev.target, 'active');
                        this.isFocused = true;
                    }

                    return this.isFocused;
                }

                if (ev.type === 'mouseup') {
                    if (!this.isFocused) {
                        classie.remove(ev.target, 'active');
                        ev.target.blur();
                        return this.isFocused;
                    }

                    this.isFocused = false;
                }
            },
            deactivate: function( ev ) {
                classie.remove(ev.target, 'active');

                if (ev.type === 'change') {
                    ev.target.blur();
                    this.handleChange(ev)
                }

                this.isFocused = false;
            },
            handleChange: function( ev ) {
                this.$emit('selected', ev.target.value, this.name)
            }
        },

        mounted() {
            BrowserDetect.init();
        }
    }
</script>

<style scoped>

</style>