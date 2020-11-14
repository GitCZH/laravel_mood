<template>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <el-menu-item index="1">
            <a href="/home">Mood</a>
        </el-menu-item>
        <el-menu-item index="2">
            <a href="/home">
                <img width="25" height="25" :src="navImg" alt="">
            </a>
        </el-menu-item>
        <el-menu-item index="3">
            <a href="/mood/short/index">主场</a>
        </el-menu-item>
        <el-submenu index="4">
            <template slot="title">口袋</template>
            <a href="">
                <el-menu-item index="4-1">B</el-menu-item>
            </a>
            <el-submenu index="4-2">
                <template slot="title">文件站</template>
                <a href="/mood/file/upload/index">
                    <el-menu-item index="4-2-1">上传</el-menu-item>
                </a>
                <a href="/mood/file/index">
                    <el-menu-item index="4-2-2">浏览</el-menu-item>
                </a>
            </el-submenu>
        </el-submenu>
        <el-submenu index="5" v-if="isLogin">
            <template slot="title">{{nickname}}</template>
            <el-menu-item>
                <a href="">个人信息</a>
            </el-menu-item>
            <el-menu-item>
                <a href="/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">退出</a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="csrfField" style="display:none"/>
                </form>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="5" v-else>
            <template slot="title">点击加入</template>
            <el-menu-item>
                <a href="/login">登录</a>
            </el-menu-item>
            <el-menu-item>
                <a href="/register">注册</a>
            </el-menu-item>
        </el-submenu>
    </el-menu>
</template>

<script>
    export default {
        name: "menu.vue",
        data() {
            return {
                activeIndex: '1',
                activeIndex2: '1',
                navImg: "",
                isLogin: false,
                nickname: "hello",
                csrfField: ""
            };
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            getHeaderImg() {
                var that = this
                $.ajax({
                    url:"/img/getNav",
                    method: 'GET',
                    data: {},
                    dataType: "json",
                    success: function (res) {
                        if (res.error_code == 0) {
                            that.navImg = res.result
                        }
                    }
                })
            },
            getLoginStatus() {
                var that = this
                // that.isLogin = true
                $.ajax({
                    url: "/home/getLoginStatus",
                    data: {},
                    dataType: 'json',
                    type: "GET",
                    success: function (res) {
                        if (res.error_code == 0) {
                            if (res.result.login == 1) {
                                that.isLogin = true
                                that.nickname = res.result.nickname
                            }
                        }
                    }
                })
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
                            that.csrfField = res.result
                        }
                    }
                })
            }
        },
        created: function() {
            this.getHeaderImg()
            this.getLoginStatus()
            this.getCsrfField()
        }
    }
</script>