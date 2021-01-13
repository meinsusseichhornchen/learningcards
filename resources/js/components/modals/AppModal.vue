<template>
    <transition name="modal">
        <div class="modal" v-if="visible">
            <div class="modal-mask" @click.prevent="$modal.hide(name)"></div>
            <div class="modal-container">
                <a href="#" @click.prevent="$modal.hide(name)" class="modal-close-btn">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>

                <div class="modal-header">
                    <slot name="header">
                        <h2 class="modal-title">{{ 'components/modal.cards.delete.header' | trans }}</h2>
                    </slot>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        <p>{{ 'components/modal.cards.delete.body' | trans }}</p>
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer" :params="params">
                        <div class="flex justify-end">
                            <button class="modal-primary-btn">
                                {{ 'components/inputs.buttons.modal.decline' | trans }}
                            </button>

                            <button class="modal-primary-btn">
                                {{ 'components/inputs.buttons.modal.sure' | trans }}
                            </button>
                        </div>
                    </slot>
                </div>

            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "AppModal",

        data() {
            return {
                visible: false,
                params: {}
            }
        },

        props: {
            name: {
                required: true,
                type: String,
            }
        },

        methods: {
            hasBeforeOpenHook: function() {
                return this.$listeners['beforeOpen']
            }
        },

        beforeMount() {
            this.$modal.$event.$on('show', (modal, params) => {
                if (this.name === modal) {
                    this.params = params;

                    if (this.hasBeforeOpenHook) {
                        this.visible = true;
                        return;
                    }

                    this.$emit('beforeOpen', () => {
                        this.visible = true;
                    })
                }
            })

            this.$modal.$event.$on('hide', (modal) => {
                if (this.name === modal) {
                    this.visible = false;
                }
            })
        }

    }
</script>

<style scoped>

</style>