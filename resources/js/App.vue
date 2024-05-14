<template>
    <div class="container px-4 py-5" id="custom-cards">
        <div class="row align-items-stretch g-4 py-5">
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden rounded-5 shadow-lg p-2">
                    <team-component ref="teamComponent"></team-component>
                </div>
            </div>
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden rounded-5 shadow-lg p-2">
                    <champions-component ref="champComponent"></champions-component>
                </div>
            </div>
        </div>
        <div class="col">
            <actions-component @data-refresh="refreshData"></actions-component>
        </div>
    </div>
</template>
<script>

import TeamComponent from './components/Teams.vue';
import ActionsComponent from './components/Actions.vue';
import ChampionsComponent from './components/Champions.vue';

export default {
    components: {
        TeamComponent,
        ActionsComponent,
        ChampionsComponent
    },
    data() {
        return {
            teams: []
        };
    },
    methods: {
        refreshData() {
            this.$refs.teamComponent.fetchTeams();
            this.$refs.champComponent.fetchChampionshipProbability();
        }
    },
    mounted() {
    }
}
</script>

<style>
</style>
