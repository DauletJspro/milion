<template>
    <div class="card">
        <div class="card-body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "App.vue"
}
</script>

<style scoped>
.container {
    width: 100% !important;
    padding: 0;
}
</style>
