<template>
    <el-upload
            class="upload-demo"
            action="/mood/file/img/save"
            :on-preview="handlePreview"
            :on-remove="handleRemove"
            :file-list="fileList"
            multiple="true"
            :data="postData"
            list-type="picture">
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
    </el-upload>
</template>

<script>
    export default {
        name:"upload_img_temp.vue",
        data() {
            return {
                fileList: [{name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}, {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}],
                postData: {

                }
            };
        },
        methods: {
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            getCsrfField() {
                var that = this
                $.ajax({
                    url: "/home/getCsrf",
                    method: "GET",
                    data: {},
                    dataType: "json",
                    success:function (res) {
                        if (res.error_code == 0) {
                            that.postData._token = res.result
                        }
                    }
                })
            }
        },
        created: function () {
            this.getCsrfField()
        }
    }
</script>

<style scoped>

</style>