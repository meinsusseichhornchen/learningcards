<template>
    <li class="card-list__item w-full sm:w-2/4 md:w-2/6">
        <a
            :href="card.links.edit"
            class="absolute block top-0 w-full h-100"
        >
            <p class="card-list__content">
                <span>
                    {{ answers }}
                </span>
            </p>
        </a>
        <span class="card-list__del-btn" @click.prevent="openDeleteCardModal">
            <svg class="w-6 h-6 p-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </span>
    </li>
</template>

<script>
    export default {
        name: "AppCardListAnswer",

        computed: {
            answers: function() {
                let answers = '';

                this.card.answers.forEach((answer, i) => {
                    answers += answer.content;
                    answers += i < this.card.answers.length - 1 ? ` /\xa0` : ''
                })

                return answers;
            }
        },

        props: {
            card: {
                required: false,
                type: Object,
            }
        },

        methods: {
            openDeleteCardModal( ev ) {
                this.$modal.show('delete-card', { card: this.card })
            }
        },

        mounted() {
            console.log(this.answers);
        }
    }
</script>

<style scoped>

</style>