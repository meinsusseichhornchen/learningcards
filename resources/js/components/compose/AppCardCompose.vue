<template>
    <form :action="action" class="multi-step-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" :value="csrf">
        <transition-group name="fade" mode="out-in">
            <fieldset
                    v-show="steps.current === 1"
                    name="fieldset-card-type"
                    class="multi-step-form__fieldset" key="fieldset-1"
            >
                <app-selector-input
                        :options="card_types.data"
                        :name="`cardable_type`"
                        :content="`Card Type`"
                        @selected="validateInput"
                >
                </app-selector-input>
            </fieldset>
        </transition-group>
        <component v-if="cardTypeComponent !== '' && steps.current > 1"
               :is="cardTypeComponent"
               :errors="errors"
               :form="form"
               :steps="steps"
               @changedIndexedInput="validateInputFromGroup"
               @removedIndexedInput="pullError"
               @imageSelected="validateFile"
               @mounted="initSteps"
        >
        </component>

        <app-form-navigation
            v-if="isFirstStep()"
            :steps="steps"
            :errors="errors"
            :content="{
                prev: 'components/form-navigation.previous',
                next: 'components/form-navigation.create'
            }"
            :disabled="!form.cardable_type"
            @movedForward="setStep(++steps.current)"
            @stepFailed="stepFailed"
        >
        </app-form-navigation>
        <app-form-navigation
            v-else
            :steps="steps"
            :errors="errors"
            @movedForward="form.cardable_type && isLastStep() ? submit() : stepUp()"
            @movedBackward="stepDown"
            @stepFailed="stepFailed"
        >
        </app-form-navigation>
    </form>
</template>

<script>
    import validatorMixin from "../../mixins/validator";
    import stepableMixin from "../../mixins/stepable";

    import { mapGetters, mapActions, mapMutations } from 'vuex';

    import AppSelectorInput from '../inputs/AppSelectorInput';
    import AppBaseButton from "../inputs/AppBaseButton";
    import AppFormNavigation from "../navigators/AppFormNavigation";
    import AppGuessByImage from "./cards/AppGuessByImage";

    export default {
        name: "AppCardCompose",

        components: {
            AppFormNavigation,
            AppSelectorInput,
            AppGuessByImage,
            AppBaseButton,
        },

        data() {
            return {
                pickedCardType: false,
                form: {},
            }
        },

        computed: {
            ...mapGetters({
                card_types: 'card/card_types',
                errors: 'error/errors'
            }),
            cardTypeComponent: function() {
                return this.form.cardable_type ? `App${this.form.cardable_type}` : '';
            }
        },

        mixins: [
            validatorMixin,
            stepableMixin,
        ],

        props: {
            action: {
                required: true,
                type: String,
            },
            csrf: {
                required: true,
                type: String,
            }
        },

        methods: {
            ...mapActions({
                getCardTypes: 'card/getCardTypes',
                pushErrors: 'error/pushErrors',
                pullErrors: 'error/pullErrors',
                setError: 'error/setError',
                pullError: 'error/pullError',
                setErrors: 'error/setErrors',
                hasErrors: 'error/hasErrors'
            }),

            submit() {
                this.$el.submit();
            }
        },

        beforeMount() {
            this.getCardTypes();
        },

        mounted() {
            this.initSteps();
        },
    }
</script>

<style scoped>

</style>