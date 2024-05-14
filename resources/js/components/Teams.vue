<template>
    <div>
        <h2>Puan Durumu</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Takım Adı</th>
                <th>Oynanan</th>
                <th>Kazanan</th>
                <th>Kaybeden</th>
                <th>Beraberlik</th>
                <th>GD</th>
                <th>Puan</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="team in teams" :key="team.id">
                <td>{{ team.name }}</td>
                <td>{{ team.played }}</td>
                <td>{{ team.won }}</td>
                <td>{{ team.lost }}</td>
                <td>{{ team.drawn }}</td>
                <td>{{ team.goal_difference }}</td>
                <td>{{ team.points }}</td>
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
        this.fetchTeams();
    },
    methods: {
        fetchTeams() {
            fetch('/api/teams')
                .then(response => response.json())
                .then(data => {
                    this.teams = data.data;
                })
                .catch(error => {
                    console.error('Error fetching teams:', error);
                });
        }
    }
};
</script>
