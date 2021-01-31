<template>
    <transition-group
            tag="div"
            class="container sm:w-1/2 lg:w-1/3"
    >
        <app-image-preview
                v-if="isImage()"
                :index="index"
                :file="file"
                :name="name ? name : ''"
                :key="'image-' + index"
                @selectedImageToRemove="$emit('selectedFileToRemove', index)"
        />

        <app-document-preview
                v-if="isDocument()"
                :index="index"
                :file="file"
                :name="name ? name : ''"
                :key="'document-' + index"
                @selectedDocumentToRemove="$emit('selectedFileToRemove', index)"
        />

        <app-audio-preview
            v-if="isAudio()"
            :index="index"
            :file="file"
            :name="name ? name : ''"
            :key="'audio-' + index"
            @selectedAudioToRemove="$emit('selectedFileToRemove', index)"
        />
    </transition-group>
</template>

<script>
    import AppAudioPreview from './AppAudioPreview';
    import AppDocumentPreview from './AppDocumentPreview';
    import AppImagePreview from "./AppImagePreview";

    export default {
        name: "AppFilePreview",

        components: {
            AppImagePreview,
            AppDocumentPreview,
            AppAudioPreview
        },

        data() {
            return {
                mime_types: {
                    image: [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/bmp',
                    ],
                    audio: [
                        'audio/mpeg',
                        'audio/ogg',
                        'audio/wav',
                    ],
                    document: [
                        'application/pdf',
                        'application/vnd.oasis.opendocument.text',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ]
                }
            }
        },

        props: {
            file: {
                required: false,
                type: [Object, File, Blob],
            },

            index: {
                required: false,
                type: Number,
            },

            name: {
                required: false,
                type: String,
            }
        },

        methods: {
            isFile: function() {
                return this.file instanceof File;
            },

            isBlob: function() {
                return this.file instanceof Blob;
            },

            isImage: function() {
                if (this.isFile()) {
                    return this.mime_types.image.indexOf(this.file.type) !== -1;
                }
            },

            isAudio: function() {
                if (this.isFile()) {
                    return this.mime_types.audio.indexOf(this.file.type) !== -1;
                }
            },

            isDocument: function() {
                if (this.isFile()) {
                    return this.mime_types.document.indexOf(this.file.type) !== -1;
                }
            },
        }
    }
</script>

<style scoped>

</style>