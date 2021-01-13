<template>
    <div class="ci-file" :class="file ? 'file--uploaded' : ''">
        <input type="file" :name="name" :id="name" @change="previewFile" class="input__field">
        <label :for="name" class="input__label flex rounded-tl rounded-tr">
            <span class="input__label-content">{{ content | trans }}</span>
            <svg class="input__label-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
        </label>
        <span v-if="file" class="ci-file__preview border-2 border-hiro-lighter">
            <img :src="file" :alt="`components/inputs.file.alt.default` | trans" />
            <button class="ci-file__close-btn" @click="removeImage">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </button>
        </span>
    </div>
</template>

<script>
    import classie from 'desandro-classie';

    export default {
        name: "AppSingleFileInput",

        data() {
            return {
                file: '',
            }
        },

        props: {
            name: {
                required: false,
                default: 'file',
                type: String,
            },
            content: {
                required: false,
                type: String,
                default: `components/inputs.file.label.default`
            },
            rules: {
                required: false,
                type: Array,
            }
        },

        methods: {
            previewFile: function( ev ) {
                var files = ev.target.files || ev.dataTransfer.files;

                if (!files.length) {
                   return;
                }

                this.createImage(files[0]);
                this.$emit('uploadedFile', ev.target.files[0] || ev.dataTransfer.files, this.name, {
                    value: ev.target.files[0] || ev.dataTransfer.files[0],
                    rules: this.rules,
                })
            },
            createImage: function(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (ev) => {
                    vm.file = ev.target.result;
                };

                reader.readAsDataURL(file);
            },
            removeImage: function() {
                this.file = '';
            }
        }
    }
</script>

<style scoped>

</style>