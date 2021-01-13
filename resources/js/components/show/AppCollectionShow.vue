<template>
    <app-card-list
        :collection="collection"
        :links="links"
    />
</template>

<script>
    import AppCardList from '../lists/AppCardList'
    import AppDeleteCardModal from "../modals/AppDeleteCardModal";

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "AppCollectionShow",

        components: {
            AppDeleteCardModal,
            AppCardList
        },

        props: {
            collection: {
                required: true,
                type: Number,
            },
            links: {
                required: false,
                type: Object,
            }
        },
    }
</script>

<style scoped>

</style>