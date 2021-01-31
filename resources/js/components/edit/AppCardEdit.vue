<template>
    <form :action="action" class="one-step-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" :value="csrf">

        <component
            :is="cardTypeComponent"
            :form="form"
            :card="card"
            :errors="errors"
            @changedIndexedInput="validateInputFromGroup"
            @removedIndexedInput="pullError"
            @imageSelected="validateFile"
        >
        </component>

        <app-one-step-form-navigation
            :errors="errors"
            :previous="links.previous_page"
            :content="{
                back: 'components/form-navigation.back',
                submit: 'components/form-navigation.update'
            }"
            @readyToBeSubmitted="submit()"
        >
        </app-one-step-form-navigation>

    </form>
</template>

<script>
    // Mixins
    import validatorMixin from "../../mixins/validator";

    // Stores
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    //Components
    import AppBaseButton from "../inputs/AppBaseButton";
    import AppGuessByImageEdit from "./cards/AppGuessByImageEdit";
    import AppOneStepFormNavigation from "../navigators/AppOneStepFormNavigation";

    export default {
        name: "AppCardEdit",

        components: {
            AppGuessByImageEdit,
            AppOneStepFormNavigation,
            AppBaseButton,
        },

        data() {
            return {
                form: {}
            }
        },

        computed: {
            ...mapGetters({
                errors: 'error/errors'
            }),
            cardTypeComponent: function() {
                return `App${this.$_.last(this.card.cardable_type.split('\\'))}Edit`;
            }
        },

        mixins : [
            validatorMixin,
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
            links: {
                required: true,
                type: Object,
            },
            card: {
                required: true,
                type: Object,
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
    }
</script>

<style scoped>

</style>