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
                        :options="tags.data"
                        :name="`tags`"
                        :errors="errors.hasOwnProperty('tags') ? errors.tags : []"
                >
                </app-pills-input>
            </fieldset>
        </transition-group>

        <app-form-navigation v-if="steps.current < steps.total"
                             :steps="steps"
                             :errors="errors"
        >
        </app-form-navigation>
        <app-form-navigation v-else
                             :steps="steps"
                             :errors="errors"
                             :content="{
                    prev: 'components/form-navigation.previous',
                    next: 'components/form-navigation.create'
                }"
                             @finish="submit"
        >
        </app-form-navigation>
    </form>
</template>

<script>
    import axios from "axios";
    import validatorMixin from '../../mixins/validator';
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    import AppTextInput from '../inputs/AppTextInput';
    import AppPillsInput from "../inputs/AppPillsInput";

    export default {
        name: "AppCollectionsEdit",

        components: {
            AppTextInput
        },

        computed: {
            ...mapGetters({
                tags: 'tag/tags',
                errors: 'collection/errors'
            }),
        },

        mixins: [
            validatorMixin
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

        methods: {
            ...mapActions({
                getTags: 'tag/getTags',
                hasErrors: 'collection/hasErrors'
            }),

            ...mapMutations({
                PUSH_TAGS: 'tag/PUSH_TAGS',
                SET_ERRORS: 'collection/SET_ERRORS',
                ADD_ERROR: 'collection/ADD_ERROR'
            }),

            setValues: function() {
                this.form.name = this.collection.data[0].name;

                if (Object.keys(this.collection.data[0].tags).length > 0) {
                    this.$_.forEach(this.collection.data[0].tags, (value) => {
                        this.form.tags.push(value.id)
                    });
                }
            },
        },

        beforeMount() {
            this.setValues();
            this.getTags();
        }
    }
</script>

<style scoped>

</style>