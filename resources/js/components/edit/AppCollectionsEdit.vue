<template>
    <form :action="action" class="multi-step-form" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <transition-group name="fade" mode="out-in">
            <fieldset v-show="steps.current === 1" name="fieldset-name" class="multi-step-form__fieldset" key="fieldset-1">
                <app-text-input
                        v-model="form.name"
                        :name="`name`"
                        :content="`collection.name`"
                        :rules="['required', 'max:30']"
                        :errors="errors.hasOwnProperty('name') ? errors.name : []"
                        @changed="validateInput"
                >
                </app-text-input>
            </fieldset>

            <fieldset v-show="steps.current === 2" name="fieldset-tags" class="multi-step-form__fieldset" key="fieldset-3">
                <app-pills-input
                        v-model="form.tags"
                        :values="form.tags"
                        :options="tags"
                        :name="`tags`"
                        :errors="errors.hasOwnProperty('tags') ? errors.tags : []"
                        @updateCheckedValues="updateTagPills"
                        @newPillCreated="pushCreatedTagPill"
                        @newPillFailed="displayTagPillsErrors"
                >
                </app-pills-input>
            </fieldset>

            <fieldset v-show="steps.current === 3" name="fieldset-description" class="multi-step-form__fieldset" key="fieldset-5">
                <app-text-area-plain
                        v-model="form.description"
                        :default="form.description"
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

        <app-multi-step-form-navigation v-if="!isLastStep()"
                :steps="steps"
                :errors="errors"
                @movedForward="stepUp"
                @movedBackward="stepDown"
        >
        </app-multi-step-form-navigation>
        <app-multi-step-form-navigation v-else
             :steps="steps"
             :errors="errors"
             :content="{
                    prev: 'components/form-navigation.previous',
                    next: 'components/form-navigation.update'
            }"
            @movedForward="submit"
            @movedBackward="stepDown"
        >
        </app-multi-step-form-navigation>
    </form>
</template>

<script>
    import axios from "axios";
    import validatorMixin from '../../mixins/validator';
    import stepableMixin from "../../mixins/stepable";
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    import AppTextInput from '../inputs/AppTextInput';
    import AppPillsInput from "../inputs/AppPillsInput";
    import AppOneStepFormNavigation from "../navigators/AppOneStepFormNavigation";

    export default {
        name: "AppCollectionsEdit",

        components: {
            AppOneStepFormNavigation,
            AppTextInput
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
            collection: {
                required: true,
                type: Object,
            }
        },

        data() {
            return {
                form: {
                    name: '',
                    tags: [],
                    description: '',
                },
                steps: {
                    current: 1,
                    total: 3
                }
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
                pushTags: 'tag/push',
                hasErrors: 'error/has',
                pushErrors: 'error/push',
                pullErrors: 'error/pullErrors',
                setErrors: 'error/setErrors',
                unsetError: 'error/unsetError',
                setError: 'error/set',
                pullError: 'error/pull',
            }),

            pushCreatedTagPill(payload, field) {
                this['push' + this.$_.upperFirst(field)](payload);
                this.unsetError(field);
            },

            updateTagPills(payload, field) {
                this.form[field] = payload;
                //this.validate([field]);
            },

            displayTagPillsErrors(payload, field) {
                if (payload.hasOwnProperty('name')) {
                    this.setError({
                        value: payload.name,
                        key: field
                    });

                    this.getTags();
                }
            },

            setValues: function() {
                this.$set(this.form, 'name', this.collection.name);

                if (Object.keys(this.collection.tags).length > 0) {
                    this.$_.forEach(this.collection.tags, (value, index) => {
                        if (!this.form.tags) {
                            this.$set(this.form, 'tags', []);
                        }

                        this.$set(this.form.tags, index, value.id);
                    });
                }

                this.$set(this.form, 'description', this.collection.description)
            },

            submit: function() {
                if (this.anyErrors()) {
                    return false;
                }

                this.$el.submit();
            },
        },

        async beforeMount() {
            this.getTags();
            this.setValues();
            console.log(this.collection.tags);
            console.log(this.form.tags);
        }
    }
</script>

<style scoped>

</style>