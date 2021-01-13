<template>
    <div
        v-if="file"
        class="w-full h-64 border-8 border-transparent overflow-hidden relative"
    >
        <span
            v-if="isFile()"
            class="ci-multiple-file__preview-audio"
        >
            <div class="ci-multiple-file__preview-audio">
                <div v-if="isPlaying()" class="ci-multiple-file__preview-audio__controls">
                    <span @click.prevent="pauseSample">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    </span>
                </div>

                <div v-else class="ci-multiple-file__preview-audio__controls">
                    <span @click.prevent="playSample">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </span>
                </div>

                <span class="ci-multiple-file__close-btn" @click.prevent="$emit('selectedAudioToRemove', index)">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </span>

                <ul>
                    <li>{{ file.name }}</li>
                    <li>{{ $filesize(file.size) }}</li>
                </ul>

            </div>

            <audio
                :id="id"
                :type="file.type"
            >
            </audio>
        </span>
    </div>
</template>

<script>
    export default {
        name: "AppAudioPreview",

        data() {
            return {
                sample: {},
                playing: false,
            }
        },

        props: {
            file: {
                required: false,
                type: [Object, File],
            },
            index: {
                required: true,
                type: Number,
            },
            name: {
                required: false,
                type: String,
            },
        },

        computed: {
            sound: function() {
                return this.$el.querySelector('#' + this.id)
            },
            id: function() {
                return this.name ? this.name + '-' + this.index :
                    'audio-' + this.index;
            }
        },

        methods: {
            isFile: function() {
                return this.file instanceof File;
            },

            isPlaying: function() {
                return this.playing;
            },

            createAudio: function() {
                // Creates a URL that points the original file uploaded.
                this.sound.src = URL.createObjectURL(this.file);

                // Revoke the BLOBURI when is not needed
                this.sound.onend = function( ev ) {
                    URL.revokeObjectURL(this.src);
                }

                this.sample = new Audio(this.sound.src);

                this.sample.onended = () => {
                    console.log('ended')
                    this.playing = false;
                }
            },

            playSample: function( ev ) {
                console.log(ev.target);
                this.sample.play();
                this.playing = true;
            },

            pauseSample: function( ev ) {
                this.sample.pause();
                this.playing = false;
            },
        },

        mounted() {
            this.createAudio()
        },

        updated() {
            this.createAudio();
        }
    }
</script>

<style scoped>

</style>