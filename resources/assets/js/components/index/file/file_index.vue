<template>
    <el-row :gutter="20">
        <el-col :span="6" v-for="fileCard in fileList" :key="fileCard.id" >
            <el-card :body-style="{ padding: '0px' }" shadow="hover">
                <div slot="header" class="clearfix">
                    <span>{{fileCard.title}}</span>
                </div>
<!--                <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image">-->
                <el-image :src="fileCard.coverUrl"  style="height: 150px;"></el-image>
                <div style="padding: 14px;">
                    <span>{{fileCard.desc}}</span>
                    <div class="bottom clearfix">
                        <time class="time">{{ fileCard.uploadTime }}</time>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
</template>
<style>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    .el-col {
        margin-bottom: 10px;
    }
</style>
<script>
    export default {
        name: "file_index",
        data() {
            return {
                currentDate: new Date(),
                fileList: [
                    {
                        title: "我的图片01",
                        coverUrl: "/imgs/cover.jpg",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 1
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 2
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 3
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 4
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 5
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 6
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 7
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 8
                    },
                    {
                        title: "我的图片01",
                        coverUrl: "https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png",
                        desc: "我新上传的图片快来看看",
                        uploadTime: "2020-11-11 00:00:00",
                        id: 9
                    },
                ]
            };
        }
    }
</script>

<style scoped>

</style>