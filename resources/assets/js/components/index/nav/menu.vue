<template>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <el-menu-item index="1">Mood</el-menu-item>
        <el-menu-item index="2">
            <img width="25" height="25" :src="navImg" alt="">
        </el-menu-item>
        <el-menu-item>
            <a href="/mood/short/index">心情驿站</a>
        </el-menu-item>
        <el-submenu index="3">
            <template slot="title">杂货铺</template>
            <el-menu-item index="2-1">
                <a href="/mood/file/img/index">图片站</a>
            </el-menu-item>
            <el-submenu index="2-4">
                <template slot="title">选项4</template>
                <el-menu-item index="2-4-1">选项1</el-menu-item>
            </el-submenu>
        </el-submenu>
        <el-menu-item index="4" class=""><a href="https://www.ele.me" target="_blank">订单管理</a></el-menu-item>
    </el-menu>
</template>

<script>
    export default {
        name: "menu",
        data() {
            return {
                activeIndex: '1',
                activeIndex2: '1',
                navImg: ""
            };
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            getHeaderImg() {
                var that = this
                $.ajax({
                    url:"/mood/file/img/getNav",
                    method: 'GET',
                    data: {},
                    dataType: "json",
                    success: function (res) {
                        if (res.error_code == 0) {
                            that.navImg = res.result
                        }
                    }
                })
            }
        },
        created: function() {
            this.getHeaderImg()
        }
    }
</script>