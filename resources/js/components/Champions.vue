<template>
    <div>
        <h2>Şampiyonluk Oranları</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Takım Adı</th>
                <th>Olabilirlik (%)</th>
                <th>GD</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="team in teams" :key="team.id">
                <td>{{ team.name }}</td>
                <td>{{ team.probability }}%</td>
                <td>{{ team.goal_difference }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teams: []
        };
    },
    mounted() {
        this.fetchChampionshipProbability();
    },
    methods: {
        fetchChampionshipProbability() {
            fetch('/api/champions')
                .then(response => response.json())
                .then(data => {
                    this.teams = data;
                })
                .catch(error => {
                    console.error('Error fetching championship probability:', error);
                });
        }
    }
};
</script>
