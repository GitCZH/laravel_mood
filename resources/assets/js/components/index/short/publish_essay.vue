<template>
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">聊聊发生什么了吧~</div>
            <div class="panel-body">
                <textarea class="form-control" rows="3" v-model="essayContent"></textarea>
                <br>
                <button class="btn btn-primary" v-on:click="publishEssay">发布</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "publish_essay.vue",
        data() {
            return {
                essayContent: "分享点什么吧~"
            }
        },
        methods: {
            //发布短文
            publishEssay: function () {
                var url = "/mood/short/publish"
                var data = {
                    content: this.essayContent
                }
                $.ajax({
                    url: url,
                    data: data,
                    dataType: 'json',
                    type: "GET",
                    success: function (res) {
                        if (res.status_code != 0) {
                            alert(res.status_msg)
                            return false
                        }
                        location.reload()
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>