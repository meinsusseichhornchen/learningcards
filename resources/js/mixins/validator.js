import axios from "axios";

const validatorMixin = {
    data() {
        return {
            formData: {},
        }
    },
    methods: {
        validateInput: function(payload, field, rules = {}) {
            this.$set(this.form, field, payload);

            if (Object.keys(rules).length > 0) {
                this.validate(this.createValidatorObject(rules, {
                    [field]: payload
                }));
            }
        },

        anyErrors: function() {
            if (this.errors !== undefined) {
                return Object.keys(this.errors).length > 0;
            }

            return false;
        },

        validateInputFromGroup: function(payload, field, rules = {}, index) {
            if (!this.form[field]) {
                this.$set(this.form, field, []);
            }

            this.form[field][index] = payload;

            this.validate(this.createValidatorObject(rules, payload));
        },

        createValidatorObject: function(rules, values) {
            return {
                rules: rules,
                values: values
            }
        },

        validate: async function(validator, config = {}) {
            if (Object.keys(validator.rules).length > 0) {
                await axios.post('/api/validate', validator)
                    .then((response) => {
                        console.log(response);
                        this.pullErrors(validator.rules);

                        // Check if the form is stepable and has errors and then reset the flag
                        // that shows in which step the form has failed to zero.
                        if (this.steps && !this.hasErrors()) {
                            this.removeStepFailed();
                        }
                        /*                            this.errors = {};*/
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.pushErrors(err.response.data);
                        console.log(this.errors);
                    });

            }
        },

        pushValidatedFiles: function(files, fieldName) {
            if (this.form) {
                if (!this.form[fieldName]) {
                    Vue.set(this.form, fieldName, []);
                }

                files.forEach((file) => {
                    this.form[fieldName].push(file);
                })
            }
        },

        validateFiles: async function(validator) {
            await axios.post('/api/validate/files', validator, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    console.log(response.data);
                    let fieldName = response.data.fieldName;

                    // Remove corresponding error
                    this.pullError({
                        fieldName: fieldName.replace(/\W/g, '')
                    });

                    // Push all the validated files to the Form Object
                    this.pushValidatedFiles(response.data[fieldName], fieldName);

                })
                .catch((err) => {
                    console.log(err.response);
                    this.pushErrors(err.response.data);
                });
        },

        createValidatorRequest: function( data, rules, fieldName = null ) {
            let validator = {};

            // Is File
            if (data instanceof File) {
                validator = new FormData();
                buildFormData(validator, rules[fieldName], 'rules');

                // Has fieldName been specified
                if (fieldName) {
                    validator.append(fieldName, data);
                    validator.append('name', fieldName);
                }

                return validator;
            }

            return validator;
        },

        validateFile: async function( file, field, rules ) {
            let rq = this.createValidatorRequest(file, rules, field);

            await axios.post('/api/validate/file', rq, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {

                // Check if the field has been filled before. If not, sets the field with an empty array.
                if (!this.form[field]) {
                    this.$set(this.form, field, []);
                };

                // In case an error of this field is active clean it off
                this.pullError({
                    fieldName: field,
                });

                this.$set(this.form[field], this.form[field].length, file);
                this.formData = appendArray(new FormData(this.$el), this.form[field], field);
            }).catch((err) => {
                this.pushErrors(err.response.data);
            })
        },
    }
};

function appendArray(form_data, value, name){
    if(!value && name)
        form_data.append(name, '');
    else {
        if (typeof value == 'object') {
            for(const key in value){
                if(typeof value[key] == 'object' && !value[key] instanceof File) {
                    //appendArray(form_data, values[key], name + '[' + key + ']');
                    appendArray(form_data, value[key], name + '[]');
                } else {
                    //form_data.append(name + '[' + key + ']', values[key]);
                    form_data.append(name + '[]', value[key]);
                }
            }
        } else
            form_data.append(name, value);
    }

    return form_data;
}

function appendFile(formData, file, parentKey) {
    if (typeof formData.get(parentKey) === 'object') {
        for (const [key, value] in formData.get(parentKey)) {
            if (file !== value) {
                formData.append(parentKey, file);
            }
        }
    } else {
        if (file !== formData.get(parentKey)) {
            formData.append(parentKey, file);
        }
    }
}

function buildFormData(formData, data, parentKey) {
    if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
        Object.keys(data).forEach(key => {
            buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
        });
    } else {
        const value = data == null ? '' : data;

        formData.append(parentKey, value);
    }
}

export default validatorMixin;