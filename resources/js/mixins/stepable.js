const stepableMixin = {
    data() {
        return {
            steps: {
                total: 0,
                current: 0,
                failed: 0,
            }
        }
    },

    methods: {
        initSteps: function(options = {}) {
            let form = !options.form ? this.$el : options.form;

            this.setFormStepsByFieldset(form);

            let step = this.steps.total > 0 && !options.current ? 1 : options.current;

            this.setStep(step);
        },

        setFormStepsByFieldset: function(formElement = null) {
            if (!formElement) {
                this.steps.total = this.$el.getElementsByTagName('fieldset').length;
                return;
            }

            this.steps.total = formElement.getElementsByTagName('fieldset').length;
        },

        /* Checks whether the current step of the form is the first one or not */
        isFirstStep: function() {
          return this.steps.current === 1;
        },

        /* Checks whether the current step of the form is the last one or not */
        isLastStep: function() {
            return this.steps.current === this.steps.total
        },

        /* Resets the flag that shows in which step the form has failed recently to 0 */
        removeStepFailed: function() {
            if (this.steps.failed === this.steps.current && this.steps.failed > 0) {
                this.steps.failed = 0;
            }
        },

        /* Sets the flag that shows in which step the form has failed recently to the current
         * step the user is on.
         */
        stepFailed: function() {
            this.steps.failed = this.steps.current;
        },

        /* Sets the step the user is on currently */
        setStep: function(step) {
            this.steps.current = step;
        },

        stepUp: function() {
            if (!this.isLastStep()) {
                this.steps.current++;
            }
        },

        stepDown: function() {
            this.steps.current--;
        },
    },
}

export default stepableMixin;