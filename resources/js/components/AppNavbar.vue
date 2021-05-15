<template>
    <nav
        class="main-nav"
        :class="collapsed ? 'main-nav--collapsed' : ''"
        :data-collapsed="collapsed"
    >
        <div class="relative">
            <button
                v-show="!collapsed"
                class="bg-gray absolute right-0 text-hiro py-2 mx-4"
                @click.prevent="collapse"
            >
                <svg
                    class="fill-current w-8 h-8"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            <button
                v-show="collapsed"
                class="bg-gray absolute right-0 text-hiro py-2 mx-4"
                @click.prevent="hide"
            >
                <svg
                    class="w-8 h-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="flex px-4">
            <h1 class="w-full text-center block border-b-2 border-corn mb-2">
                {{ 'components/navbar.collections' | trans }}
            </h1>
        </div>
        <transition name="slide-down">
            <ul v-show="collapsed">
                <li>
                    <a href="#" class="block w-full px-4 py-2">
                        {{ 'components/navbar.collections' | trans }}
                    </a>
                </li>

                <li>
                    <a href="#" class="block w-full px-4 py-2">
                        {{ 'components/navbar.profile' | trans }}
                    </a>
                </li>

                <li>
                    <a href="#" class="block w-full px-4 py-2">
                        {{ 'components/navbar.signout' | trans }}
                    </a>
                </li>
            </ul>
        </transition>
    </nav>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "AppNavbar",

        data() {
            return {
                collapsed: false,
                ratio: .75,
            }
        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
                authenticated: 'auth/authenticated'
            })
        },

        computed: {
            collapsedListItemsHeight: function() {
                let navHeight = this.$el.scrollHeight;
                return(navHeight * this.$el.querySelector('ul').querySelectorAll('li').length * this.ratio) + navHeight + 'px';
            }
        },

        methods: {
            ...mapActions({
                isAuthenticated: 'auth/isAuthenticated',
                me: 'auth/me',
            }),

            collapse(ev) {
                this.collapsed = true;
                this.$el.style.height = this.collapsedListItemsHeight;
            },

            hide(ev) {
                this.collapsed = false;
                this.$el.style.height = null;
            },
        },

        async beforeMount() {
            await this.me();
        },

        mounted () {
            console.log(this.collapsedListItemsHeight);
        }
    }
</script>

<style scoped>

</style>