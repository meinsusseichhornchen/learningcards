<template>
    <form :action="action" class="multi-step-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="__token" :value="csrf">

        <component
            :is="cardTypeComponent"
        >

        </component>

        <app-form-navigation
            v-if="isFirstStep()"
            :steps="steps"
            :errors="errors"
            @movedForward="setStep(++steps.current)"
            @stepFailed="stepFailed"
        >
        </app-form-navigation>
        <app-form-navigation
            v-else
            :steps="steps"
            :errors="errors"
            @movedForward="isFirstStep() ? submit() : stepUp()"
            @movedBackward="stepDown"
            @stepFailed="stepFailed"
        >
        </app-form-navigation>
    </form>
</template>

<script>
    // Mixins
    import validatorMixin from "../../mixins/validator";
    import stepableMixin from "../../mixins/stepable";

    // Stores
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    //Components
    import AppBaseButton from "../inputs/AppBaseButton";
    import AppFormNavigation from "../navigators/AppFormNavigation";
    import AppGuessByImageEdit from "./cards/AppGuessByImageEdit";

    export default {
        name: "AppCardEdit",

        components: {
            AppFormNavigation,
            AppGuessByImageEdit,
            AppBaseButton
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
                return `App${this.$_.last(this.$_.head(this.card.data).cardable_type.split('\\'))}Edit`;
            }
        },

        mixins : [
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
            },
            card: {
                required: true,
                type: Object,
            }
        },

        methods: {
            submit() {
                this.$el.submit();
            }
        },

        created() {
            console.log(this.cardTypeComponent)
        }
    }
</script>

<style scoped>

</style>