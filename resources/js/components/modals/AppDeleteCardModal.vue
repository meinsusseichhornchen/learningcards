<template>
    <app-modal :name="name" @beforeOpen="test">
        <template v-slot:footer="params">
            <div class="flex justify-end">
                <button class="modal-primary-btn" @click.prevent="decline">
                    {{ 'components/inputs.buttons.modal.decline' | trans }}
                </button>

                <button class="modal-primary-btn" @click.prevent="destroy(params.params.card)">
                    {{ 'components/inputs.buttons.modal.sure' | trans }}
                </button>
            </div>
        </template>
    </app-modal>
</template>

<script>
    import { mapActions } from 'vuex';

    import AppModal from './AppModal'

    export default {
        name: "AppDeleteCardModal",

        components: AppModal,

        data() {
            return {
                card: {},
            }
        },

        props: {
            name: {
                required: true,
                type: String,
            }
        },

        methods: {
            ...mapActions({
                deleteCard: 'card/deleteCard',
            }),

            decline: function() {
                this.$modal.hide('delete-card');
            },

            test: function(done) {
                console.log(done);
            },

            destroy: async function( card ) {
                let cards = await this.deleteCard(card.id);
                this.$emit('cardDestroyed', cards);
                this.$modal.hide('delete-card');
            }
        },
    }
</script>

<style scoped>

</style>