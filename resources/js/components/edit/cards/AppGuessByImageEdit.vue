<template>
    <transition-group name="fade" mode="out-in">
        <fieldset
            name="fieldset-answers"
            class="one-step-form__fieldset"
            key="fieldset-1"
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
            name="fieldset-image"
            class="one-step-form__fieldset"
            key="fieldsset-2"
        >
            <app-multiple-file-input
                :name="'images'"
                :errors="errors"
                :files="form['images']"
                :caveat="`caveat.file.image`"
                :rules="['mimes:jpg\,jpeg\,gif\,png\,bmp']"
                @fileSelected="validateSelectedImage"
            >
            </app-multiple-file-input>
        </fieldset>
    </transition-group>
</template>

<script>
    import AppMultipleTextInput from "../../inputs/AppMultipleTextInput";
    import AppMultipleFileInput from "../../inputs/AppMultipleFileInput";


    export default {
        name: "AppGuessByImageEdit",

        components: {
            AppMultipleFileInput,
            AppMultipleTextInput
        },

        props: {
            form: {
                required: false,
                type: Object,
            },
            errors: {
                required: false,
                type: Object,
            },
            card: {
                required: true,
                type: Object,
            }
        },

        methods: {
            init: async function() {
                this.form['answers[]'] = this.card.answers;
                this.$set(this.form, 'images', await this.loadImages());
            },

            loadImages: async function() {
                let images = [];

                for (let i = 0; i < this.card.images.length; i++) {
                    await axios.get(this.card.images[i].path, {
                        responseType: 'blob'
                    }).then((response) => {
                        if (response.data instanceof Blob) {
                            let file = new File([response.data], 'hola.gif', {
                                 type: response.data.type,
                            });

                            images.push(file);
                        }
                    })
                }

                return images;
            },

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

        created() {
           this.init();
        }
    }
</script>

<style scoped>

</style>