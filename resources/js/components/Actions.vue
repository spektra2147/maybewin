<template>
    <div>
        <button class="btn btn-dark" @click="generateFixture">Karşılaşmaları Oluştur</button>
        <button class="btn btn-dark m-1" @click="playMatch">Maç Oyna</button>
        <button class="btn btn-dark m-1" @click="playAllMatches">Tüm Maçları Oyna</button>
        <button class="btn btn-dark" @click="reset">Sıfırla</button>
    </div>
</template>

<script>
export default {
    methods: {
        playMatch() {
            fetch('/api/play')
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.errors);
                    }
                    this.$emit('data-refresh');
                })
                .catch(error => {
                    console.error('Error playing match:', error);
                });
        },
        generateFixture() {
            fetch('/api/generate-fixture')
                .then(response => response.json())
                .then(data => {
                    console.log('Fixture generated:', data);
                    this.$emit('data-refresh');
                })
                .catch(error => {
                    console.error('Error playing match:', error);
                });
        },
        playAllMatches() {
            fetch('/api/play-all')
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.errors);
                    }
                    console.log('All matches played successfully:', data);
                    this.$emit('data-refresh');
                })
                .catch(error => {
                    console.error('Error playing all matches:', error);
                });
        },
        reset() {
            fetch('/api/reset')
                .then(response => response.json())
                .then(data => {
                    console.log('Reset successfully:', data);
                    this.$emit('data-refresh');
                })
                .catch(error => {
                    console.error('Error resetting:', error);
                });
        }
    }
};
</script>
