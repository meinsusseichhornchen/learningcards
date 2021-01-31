<template>
    <div class="container-md m-4">
        <div class="ci-multiple-file"
             :class="[
                hasFiles() ? 'file--uploaded' : ''
            ]"
        >
            <app-file-preview
                v-for="(file, key) in files"
                :index="key"
                :name="name"
                :file="file"
                :key="'preview-' + key"
                @selectedFileToRemove="removeIndexedFile"
            />

            <app-input-file-button
                :multiple="true"
                :name="name + '[]'"
                :files="files"
                @fileSizeExceeded="setException('exception.PostTooLargeException')"
                @fileSelected="validateSelectedFile"
                @selectedFiles="handleSelectedFiles"
            />
        </div>

        <span
            v-if="errors.hasOwnProperty(name)"
            class="input__error"
        >
            {{ $_.head(errors[this.name][0])}}
        </span>

        <span
            v-else-if="exceptions.length > 0"
            class="input__error"
        >
            {{ exceptions[0] }}
        </span>

        <span v-else
              class="input__info"
        >
            {{ caveat | trans }}
        </span>
    </div>
</template>

<script>
    import AppInputFileButton from './AppInputFileButton';
    import AppFilePreview from "./AppFilePreview";

    export default {
        name: "AppMultipleFileInput",
        components: {
            AppFilePreview,
            AppInputFileButton,
        },

        data() {
            return {
                exceptions: [],
            }
        },

        props: {
            name: {
                required: false,
                default: 'image[]',
                type: String,
            },
            files: {
                required: false,
                default: function() {
                    return []
                },
                type: Array,
            },
            caveat: {
                required: false,
                type: String,
            },
            rules: {
                required: false,
                default: function() {
                    return [];
                },
                type: Array,
            },
            column_name: {
                required: false,
                type: String,
            },
            errors: {
                required: false,
                type: Object,
            }
        },

        methods: {
            hasFiles: function() {
                return this.files.length > 0;
            },

            hasColumnName: function() {
                return typeof this.column_name !== 'undefined';
            },

            pushFile: function(file) {
                if (this.hasColumnName()) {
                    this.$set(this.files, this.files.length, {
                        [this.column_name]: file
                    });

/*                    this.files.push({
                        [this.column_name]: file,
                    });*/

                    return;
                }

                /*this.files.push(file);*/
                this.$set(this.files, this.files.length, file);
            },

/*            removeIndexedImage: function(index) {
                this.$delete(this.files, index);
                this.$emit('removedIndexedImage', this.files)
            },*/

            removeIndexedFile: function(index) {
                this.$delete(this.files, index);
                this.$emit('removedIndexedImage', this.files)
            },

            clearExceptions: function() {
                this.exceptions = [];
            },

            handleSelectedFiles: function( files ) {
                this.clearExceptions();
                this.$emit('filesSelected', files, this.name, {
                    [this.name]: this.rules
                })
            },

            validateSelectedFile: function( file ) {
                this.clearExceptions();
                this.$emit('fileSelected', file, this.name, {
                    [this.name]: this.rules
                })
            },

            setException: function( exception ) {
                this.exceptions.push(this.$trans(exception));
            },

            setFiles: function(files) {
                this.$_.forEach(files, (file, index) => {
                    this.pushFile(file)
                });
            },
        },
    }
</script>

<style scoped>

</style>