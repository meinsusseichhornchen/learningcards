<template>
    <div
        v-if="file"
        class="w-full h-64 border-8 border-transparent overflow-hidden relative">
        <img v-if="isFile()"
             :src="dataUrl"
             :alt="file.name"
             class="ci-multiple-file__preview-image"
        />
        <img v-else
            :src="file.url"
            :alt="file.name"
            class="ci-multiple-file__preview-image"
        />
        <span class="ci-multiple-file__close-btn" @click.prevent="$emit('selectedImageToRemove', index)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </span>
    </div>
</template>

<script>
    export default {
        name: "AppImagePreview",

        data() {
            return {
                dataUrl: null,
            }
        },

        props: {
            file: {
                required: false,
                type: [Object, File],
            },
            index: {
                required: false,
                type: Number,
            }
        },

        methods: {
            createImg: function() {
                if (this.isFile()) {
                    const reader = new FileReader();

                    reader.addEventListener('load', () => {
                        this.dataUrl = reader.result;
                    }, false);

                    reader.readAsDataURL(this.file)
                }
            },

            isFile: function() {
                return this.file instanceof File;
            }
        },

        created() {
            this.createImg()
        },

        updated() {
            this.createImg();
        }
    }
</script>

<style scoped>

</style>