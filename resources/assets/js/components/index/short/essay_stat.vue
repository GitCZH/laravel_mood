<template>
    <div class="panel panel-info">
        <div class="panel-heading">心情驿站</div>
        <div class="panel-body">
            <div>
                发布<span class="label label-danger">{{essayCount}}</span>条短文
            </div>
            <div>
                收获<span class="label label-danger">{{essayCmtCount}}</span>条评论
            </div>
            <div v-if="essayLikeCount">
                收获<span class="label label-danger">{{essayLikeCount}}</span>条点赞
            </div>
            <div v-if="essayForward">
                收获<span class="label label-danger">{{essayForward}}</span>次转发
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "essay_stat.vue",
        data() {
            return {
                essayCount: 0,
                essayCmtCount: 0,
                essayLikeCount: 0,
                essayForward: 0,
            }
        },
        methods: {
            getStat: function() {
                var vueThis = this
                var url = "/mood/short/getUserEssayStat"
                var data = {}
                $.ajax({
                    url: url,
                    data:data,
                    dataType:"json",
                    type: "GET",
                    success: function (res) {
                        // console.log(vueThis.essay_user_info)
                        // console.log(vueThis.essay_items)
                        if (res.status_code != 0) {
                            alert(res.status_msg)
                            return false
                        }
                        // console.log(res)
                        vueThis.essayCount = res.result.essayCount
                        vueThis.essayCmtCount = res.result.essayCmtCount
                        vueThis.essayLikeCount = res.result.essayLikeCount
                        // console.log(vueThis.essay_items)
                        // console.log(vueThis.essay_user_info)
                    }
                })
            }
        },
        created() {
            this.getStat()
        }
    }
</script>

<style scoped>

</style>