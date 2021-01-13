<template>
    <dt class="accordion-item relative bg-hiro-ligthest hover:bg-hiro transition-all">
        <a v-if="score.collection" href="#" @click.prevent="showPanel()" class="w-full p-4 relative text-white inline-block font-display">
            <span>{{ score.collection.name }}</span>
            <div v-if="score.collection" class="scoreboard flex w-full absolute md:justify-end flex top-0 left-0">
                <span class="p-4 text-white text-xs md:text-sm absolute md:relative bottom-0">{{ score.last_time_played }}</span>
                <div class="scoring flex absolute md:relative right-0">
                    <span class="py-2 p-4 flex justify-center items-center md:py-4 bg-green-500 text-white">{{ score.rights }}</span>
                    <span class="py-2 p-4 flex justify-center items-center md:py-4 bg-red-500 text-white">{{ score.wrongs }}</span>
                </div>
            </div>
        </a>
        <div class="panel collapsed relative bg-white">
            <p class="p-3 border-2 border-hiro-lightest">{{ score.collection.description }}</p>
            <div class="panel-control">
                <div class="flex w-full">
                    <button class="bg-hiro-lightest flex-1 font-bold text-white py-2">
                        <a :href="score.collection.links.edit">{{ 'components/accordion-list.edit' | trans }}</a>
                    </button>
                    <button class="bg-crayola flex-1 font-bold text-white py-2">
                        <a :href="score.collection.links.edit">{{ 'components/accordion-list.play' | trans }}</a>
                    </button>
                    <button class="bg-red-500 flex-1 font-bold text-white py-2">
                        <a :href="score.collection.links.edit">{{ 'components/accordion-list.delete' | trans }}</a>
                    </button>
                </div>
            </div>
        </div>
    </dt>
</template>

<script>

    export default {
        name: "AppAccordionListScore",

        data() {
            return {
                panel: {},
                scoreboard: {},
            }
        },

        props: {
            score: {
                required: true,
                type: Object,
            }
        },

        methods: {
            showPanel () {
                if (!this.isPanelOpened()) {
                    return this.expandPanel();
                }

                return this.collapsePanel();
            },

            expandPanel () {
                this.setAriaAttribute('aria-hidden', 'false');
                this.setAriaAttribute('aria-expanded', 'true');
                this.togglePanelClasses();
                return this.panel.className;
            },

            togglePanelClasses() {
                $(this.panel).toggleClass('collapsed');
                $(this.panel).toggleClass('expanded');
            },

            collapsePanel () {
                this.setAriaAttribute('aria-hidden', 'true');
                this.setAriaAttribute('aria-expanded', 'false');
                this.togglePanelClasses();
                return this.panel.className;
            },

            setAriaAttribute (ariaType, newProperty) {
                this.scoreboard.setAttribute(ariaType, newProperty)
            },

            isPanelOpened () {
                return !this.panel.classList.contains('collapsed');
            }
        },

        mounted () {
            this.panel = this.$el.getElementsByClassName('panel')[0];
            this.scoreboard = this.$el.getElementsByClassName('scoreboard')[0];
        }
    }
</script>

<style lang="scss" scoped>
    .accordion-item {
        a {
            height: 100px;

            @screen md {
                height: auto;
            }
        }
    }

    .scoreboard {
        height: 100%;
    }

    .scoring {
        height: 100%;

        span {
            width: 60px;
        }
    }

    .panel {
        max-height: 15em;
        height: auto;
        overflow: hidden;

        @include prefix((
            transition: max-height 0.75s,
        ), webkit moz);

        &.collapsed {
            max-height: 0;
        }
    }
</style>