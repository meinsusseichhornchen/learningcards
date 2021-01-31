<template>
    <form :action="action" class="multi-step-form" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <transition-group name="fade" mode="out-in">
            <fieldset v-show="steps.current === 1" name="fieldset-name" class="multi-step-form__fieldset" key="fieldset-1">
                <app-text-input
                        v-model="form['name']"
                        :name="`name`"
                        :content="`collection.name`"
                        :rules="['required', 'max:30']"
                        :errors="errors.hasOwnProperty('name') ? errors.name : []"
                        @changed="validateInput"
                >
                </app-text-input>
            </fieldset>

<!--            <fieldset v-if="steps.current === 2" name="fieldset-tag" class="multi-step-form__fieldset" key="fieldset-2">
                <app-selector-input
                        :options="tags.data"
                        :name="`tag`"
                        :content="`Tag`"
                        @validateChanges="validateChanges"
                >
                </app-selector-input>
            </fieldset>-->

            <fieldset v-show="steps.current === 2" name="fieldset-tags" class="multi-step-form__fieldset" key="fieldset-3">
                <app-pills-input
                        v-model="form['tags']"
                        :options="tags.data"
                        :name="`tags`"
                        :errors="errors.hasOwnProperty('tags') ? errors.tags : []"
                        @updateCheckedValues="updateTagPills"
                        @newPillCreated="pushCreatedTagPill"
                        @newPillFailed="displayTagPillsErrors"
                >
                </app-pills-input>
            </fieldset>

<!--            <fieldset v-if="steps.current === 3" name="fieldset-resource" class="multi-step-form__fieldset" key="fieldset-4">
                <app-single-file-input
                        v-model="form.resource"
                        :name="`resource`"
                        :rules="['mimes:jpeg\,bmp\,png\,gif']"
                        @uploadedFile="validateUploadedFile"
                >
                </app-single-file-input>
            </fieldset>-->

            <fieldset v-show="steps.current === 3" name="fieldset-description" class="multi-step-form__fieldset" key="fieldset-5">
                <app-text-area-plain
                        v-model="form['description']"
                        :name="`description`"
                        :rules="['max:150']"
                        :max_length="150"
                        :content="`collection.description`"
                        :errors="errors.hasOwnProperty('description') ? errors.description : []"
                        @changed="validateInput"
                >
                </app-text-area-plain>
            </fieldset>
        </transition-group>

        <app-form-navigation v-if="!isLastStep()"
                :steps="steps"
                :errors="errors"
                 @movedForward="stepUp"
                 @movedBackward="stepDown"
        >
        </app-form-navigation>
        <app-multi-step-form-navigation v-else
                :steps="steps"
                :errors="errors"
                :content="{
                    prev: 'components/form-navigation.previous',
                    next: 'components/form-navigation.create'
                }"
                 @movedForward="submit"
                 @movedBackward="stepDown"
        >
        </app-multi-step-form-navigation>
    </form>
</template>

<script>
    import axios from 'axios';
    import validatorMixin from '../../mixins/validator';
    import stepableMixin from "../../mixins/stepable";
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    import AppSelectorInput from "../inputs/AppSelectorInput";
    import AppTextInput from "../inputs/AppTextInput";
    import AppPillsInput from "../inputs/AppPillsInput";
    import AppSingleFileInput from "../inputs/AppSingleFileInput"
    import AppTextAreaPlain from "../inputs/AppTextAreaPlain";
    import AppMultiStepFormNavigation from "../navigators/AppMultiStepFormNavigation";

    export default {
        name: "AppCollectionCompose",

        components: {
            AppTextAreaPlain,
            AppSelectorInput,
            AppTextInput,
            AppPillsInput,
            AppSingleFileInput,
            AppMultiStepFormNavigation,
        },

        computed: {
            ...mapGetters({
                tags: 'tag/tags',
                errors: 'error/errors'
            }),
        },

        mixins: [
            validatorMixin,
            stepableMixin
        ],

        props: {
            action: {
                required: true,
                type: String,
            },
            csrf: {
                required: true,
                type: String,
            },
        },

        data() {
            return {
                form: {},
            }
        },

        watch: {
            errors(errors) {
                if (this.anyErrors()) {
                    this.stepFailed();
                }
            }
        },

        methods: {
            ...mapActions({
                getTags: 'tag/getTags',
                pushErrors: 'error/pushErrors',
                pullErrors: 'error/pullErrors',
                setError: 'error/setError',
                pullError: 'error/pullError',
                setErrors: 'error/setErrors'
            }),

            ...mapMutations({
                PUSH_TAGS: 'tag/PUSH_TAGS',
            }),

            displayTagPillsErrors(payload, field) {
                if (payload.hasOwnProperty('name')) {
                    this.ADD_ERROR({
                        field: field,
                        error: payload.name
                    });

                    this.getTags();
                }
            },

            pushCreatedTagPill(payload, field) {
                this['PUSH_' + field.toUpperCase()](payload);
                this.ADD_ERROR(field, [])
            },



            submit: function() {
                if (this.anyErrors()) {
                    return false;
                }

                this.$el.submit();
            },

            updateTagPills(payload, field) {
                this.form[field] = payload;
                this.validate([field]);
            },

/*            validateInput(payload, field, rules = {}) {
                this.form[field] = payload;
                this.validate(rules);
            },*/

            validateUploadedFile(payload, field, validation = {}) {
                this.form[field] = payload;
                this.validate([field], {
                    [field]: validation,
                });
            },
        },

        beforeMount() {
            this.getTags()
        },

        mounted() {
            this.initSteps();
        }
    }
</script>

<style scoped>

</style>