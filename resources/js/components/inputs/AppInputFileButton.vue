<template>
    <span :class="[
        multiple ? 'ci-multiple-file__btn' : 'ci-file__btn'
    ]">
        <input
                type="file"
                :name="name"
                :id="id"
                class="input__field"
                @change="uploadSelectedFile"
        >
        <label :for="id" class="input__label">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                </path>
            </svg>
            <span class="input__label-content">
                {{ content | trans }}
            </span>
        </label>
    </span>
</template>

<script>
    export default {
        name: "AppInputFileButton",

        data() {
            return {
                //files: [],
                selectedFile: {},
            }
        },

        props: {
            multiple: {
                required: false,
                default: false,
                type: Boolean,
            },
            name: {
                required: false,
                default: 'image',
                type: String,
            },
            content: {
                required: false,
                default: `components/inputs.file.label.default`,
                type: String,
            },
            rules: {
                required: false,
                default: function() {
                    return [];
                },
                type: Array,
            },
            files: {
                required: false,
                default: function() {
                    return []
                },
                type: Array,
            }
        },

        computed: {
            id: function() {
                return this.name.replace(/\W/gm, '') + '-inputFile';
            },

            inputElement: function() {
                return this.$el.querySelector('.input__field');
            }
        },

        methods: {
            uploadSelectedFile: function( ev ) {
                this.selectedFile = ev.target.files[0] || ev.dataTransfer.files[0];

                if (this.fileExceed()) {
                    this.$emit('fileSizeExceeded');
                    return;
                }

                this.$emit('fileSelected', this.selectedFile)
            },

            fileExceed: function(file = null) {
                if (file) {
                    return file.size > 1024 * 1024;
                }

                return this.selectedFile.size > 1024 * 1024;
            },

/*            uploadSelectedFiles: function( ev ) {
                let loadedFiles = ev.target.files || ev.dataTransfer.files;

                if (!loadedFiles.length) return;

                for (let i = 0; i < loadedFiles.length; i++) {
                    if (this.exceed(loadedFiles[i])) {
                        this.$emit('fileSizeExceeded');
                        return;
                    }
                }

                this.$emit('selectedFiles', loadedFiles)
            },*/
        },

        watch: {
            files: function() {
                this.inputElement.files = new FileListItems(this.files);
            }
        }
    }
</script>

<style scoped>

</style>