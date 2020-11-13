<template>
    <div class="jumbotron">
        <h1>Quotations <small>语录</small></h1>
        <p>落叶的一生，只是为了归根吗 -- <small>from 亚索</small></p>
        <p>不要错把仁慈，当成弱小 -- <small>from 艾希</small></p>
    </div>
</template>

<script>
    export default {
        name: "Readme.vue",
        mounted() {
            console.log('Component mounted.Readme')
        },
        created() {
            console.log("readme create")
        }
    }
</script>

<style scoped>

</style>