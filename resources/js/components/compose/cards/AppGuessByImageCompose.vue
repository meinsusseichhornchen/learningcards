<template>
    <transition-group>
        <fieldset
                v-show="steps.current === 2"
                name="fieldset-answers"
                class="multi-step-form__fieldset"
                key="fieldset-2"
        >
            <app-multiple-text-input
                :values="form['answers[]']"
                :name="`answer`"
                :column_name="`content`"
                :content="`card.answers`"
                :rules="['required', 'max:30']"
                :errors="errors"
                @changedIndexedInput="validateIndexedInput"
                @removedIndexedInput="removeIndexedInput"
            >
            </app-multiple-text-input>
        </fieldset>

        <fieldset
            v-show="steps.current === 3"
            name="fieldset-image"
            class="multi-step-form__fieldset"
            key="fieldset-3"
        >
            <app-multiple-file-input
                :files="form['image']"
                :name="`image`"
                :caveat="`caveat.file.image`"
                :rules="['mimes:jpg\,jpeg\,gif\,png\,bmp']"
                @fileSelected="validateSelectedImage"
                :errors="errors"
            >
            </app-multiple-file-input>
        </fieldset>
    </transition-group>
</template>

<script>
    import validatorMixin from '../../../mixins/validator';

    import AppMultipleTextInput from "../../inputs/AppMultipleTextInput";
    import AppSingleFileInput from "../../inputs/AppSingleFileInput";
    import AppMultiStepFormNavigation from "../../navigators/AppMultiStepFormNavigation";
    import AppMultipleFileInput from "../../inputs/AppMultipleFileInput";

    export default {
        name: "AppGuessByImage",

        components: {
            AppMultipleFileInput,
            AppMultiStepFormNavigation,
            AppSingleFileInput,
            AppMultipleTextInput,
        },

        mixins: [
            validatorMixin,
        ],

        props: {
            form: {
                required: false,
                type: Object,
            },
            errors: {
                required: false,
                type: Object,
            },
            steps: {
                required: false,
                type: Object,
            }
        },

        methods: {

            validateIndexedInput: function ( value, name, rules, index ) {
                this.$emit('changedIndexedInput', {
                    [name]: value,
                }, name, rules, index);
            },

            validateSelectedImage: function( image, name, rules ) {
                this.$emit('imageSelected', image, name, rules);
            },

            removeIndexedInput: function( name ) {
                this.$emit('removedIndexedInput', {
                    fieldName: name
                })
            },

        },

        mounted() {
            this.$emit('mounted', {
                current: this.steps.current
            })
        },
    }
</script>

<style scoped>

</style>