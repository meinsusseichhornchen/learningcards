<template>
    <li
        class="accordion-list__item"
        :class="collapsed ? `accordion-list__item--collapsed` : ``"
    >
        <div
            v-if="score.collection"
            class="accordion-list__item-wrapper">
            <input type="checkbox" class="accordion-list__control" aria-expanded="false" checked="checked">

            <div class="accordion-list__item-heading">
                <div class="accordion-list__item-info">
                    <span class="accordion-list__item-title">
                        {{ score.collection.name }}
                    </span>
                    <span class="accordion-list__item-time">
                        {{ score.last_time_played }}
                    </span>
                    <div class="accordion-list__item-scoreboard">
                        <div class="accordion-list__item-scoreboard__scoring">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            <span>{{ score.rights }}</span>
                        </div>
                        <div class="accordion-list__item-scoreboard__scoring">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"></path>
                            </svg>
                            <span>{{ score.wrongs }}</span>
                        </div>
                    </div>
                </div>

                <div class="accordion-list__item-handle">
                    <svg class="w-8 h-8 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <div class="accordion-list__item-panel">
                <p>
                    {{ score.collection.description }}
                </p>
                <div class="accordion-list__item-action">
                    <div class="cbg-actions">
                        <button>
                            <a :href="score.collection.links.play">
                                {{ 'collection.play' | trans }}
                            </a>
                        </button>
                        <button>
                            <a :href="score.collection.links.edit">
                                {{ 'collection.edit' | trans }}
                            </a>
                        </button>
                        <button>
                            <a :href="score.collection.links.delete">
                                {{ 'collection.delete' | trans }}
                            </a>
                        </button>
                    </div>
                </div>
            </div>

            <!--<transition-group
                v-show="collapsed"
                class="absolute w-full bg-white accordion-list__item-panel"
                name="panel-collapsing"
                tag="div"
            >
                <p v-show="collapsed" class="p-3 border-2 border-hiro-lightest" :key="`panel-description`">
                    {{ score.collection.description }}
                </p>

                <div v-show="collapsed" class="accordion-list__item-panel-control" :key="`panel-control`">
                    <transition-group
                        class="flex w-full"
                        name="`panel-control-collapsing`"
                        tag="div"
                    >
                        <button class="bg-hiro flex-1 font-bold text-white py-2" :key="`edit-button`">
                            <a :href="score.collection.links.edit" class="w-full">
                                {{ 'components/accordion-list.edit' | trans }}
                            </a>
                        </button>
                        <button class="bg-crayola flex-1 font-bold text-white py-2" :key="`play-button`">
                            <a :href="score.collection.links.edit">
                                {{ 'components/accordion-list.play' | trans }}
                            </a>
                        </button>
                        <button class="bg-red-500 flex-1 font-bold text-white py-2" :key="`delete-button`">
                            <a :href="score.collection.links.edit">
                                {{ 'components/accordion-list.delete' | trans }}
                            </a>
                        </button>
                    </transition-group>
                </div>
            </transition-group>-->
        </div>
    </li>
</template>

<script>

    export default {
        name: "AppAccordionListScore",

        data() {
            return {
                panel: {},
                scoreboard: {},
                collapsed: false,
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
                this.collapsed = true;
                return this.panel.className;
            },

            collapsePanel () {
                this.setAriaAttribute('aria-hidden', 'true');
                this.setAriaAttribute('aria-expanded', 'false');
                this.collapsed = false;
                return this.panel.className;
            },

            setAriaAttribute (ariaType, newProperty) {
                this.scoreboard.setAttribute(ariaType, newProperty)
            },

            isPanelOpened () {
                return this.collapsed;
            }
        },

        mounted () {
            this.panel = this.$el.getElementsByClassName('accordion-list__item-panel')[0];
            this.scoreboard = this.$el.getElementsByClassName('accordion-list__item-scoreboard')[0];
        }
    }
</script>