<template>
    <div class="panel panel-primary">
        <div class="panel-heading">心情短文</div>
        <div class="panel-body">
            <div class="list-group">
                <div class="list-group-item" v-for="(item, eIndex) in essay_items">
                    <div class="row">
                        <div class="col-md-2">
                            <p class="user_nickname text-danger" v-if="essay_user_info[item.uid]" >
                                <span class="label label-danger">{{eIndex + 1}}</span>
                                <b>{{essay_user_info[item.uid].name}}</b>
                            </p>
                            <div class="user_avatar">
                                <a href="#" class="thumbnail">
                                    <img src="/imgs/short/bg_word.png" alt="头像">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="essay_content" style="min-height: 70px">
                                {{ item.content }}
                            </div>
                            <br>
                            <div class="essay_time">
                                <span>发布时间：</span>{{ item.ctime }}
                            </div>
                            <textarea name="cmt_content" id="" cols="30" rows="10">fff</textarea>
                        </div>
                        <div class="col-md-2">
                            <div class="essay_opt_btn" style="margin: 10px 5px">
                                <button aria-label="Center Align" class="btn btn-xs" v-bind:data-id="item.id">
                                    <span class="glyphicon glyphicon-comment"></span>
                                    评论
                                </button>
                            </div>
                            <div class="essay_opt_btn" style="margin: 10px 5px">
                                <button v-if="essay_likes[item.id]" aria-label="Center Align" class="btn btn-xs btn-danger" v-bind:data-uid="item.uid" v-bind:data-id="item.id" v-on:click="addClick($event)">
                                    <span class="glyphicon glyphicon-heart"></span>
                                    点赞
                                </button>
                                <button v-else aria-label="Center Align" class="btn btn-xs" v-bind:data-uid="item.uid" v-bind:data-id="item.id" v-on:click="addClick($event)">
                                    <span class="glyphicon glyphicon-heart"></span>
                                    点赞
                                </button>
                            </div>
                            <div  class="essay_opt_btn" style="margin: 10px 5px">
                                <button aria-label="Center Align" class="btn btn-xs">
                                    <span class="glyphicon glyphicon-share"></span>
                                    转发
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="cmt_content"  cols="30" rows="10"></textarea>
                            <button class="btn btn-warning">发布</button>
                        </div>
                    </div>
                </div>
                <!--保存最小的短文id-->
                <input type="hidden" v-model="lastEssayId" >
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "essay_list.vue",
        data() {
            return {
                essay_items: [],
                essay_ids: [],
                essay_likes: {

                },
                essay_user_info: [],
                essay_count: 0,
                essayId: 0,
                navActive: 'essay',
                lastEssayId: -1,
                clickId: 0
            }
        },
        methods:{
            getEssayList: function () {
                var vueThis = this
                var url = "/mood/short/getEssayPage"
                var data = {essayId: this.essayId}
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
                        vueThis.essay_items = res.result.list
                        vueThis.essay_user_info = vueThis.obj2arr(res.result.userInfo)
                        vueThis.essay_ids = res.result.essayIds

                        //取最后一个元素的id
                        var lastItem = vueThis.essay_items.slice(-1)
                        vueThis.lastEssayId = lastItem[0].id

                        //获取点赞数据
                        vueThis.getLikes()
                        // console.log(vueThis.essay_items)
                        // console.log(vueThis.essay_user_info)
                    }
                })
            },
            //对象转数组
            obj2arr: function (obj) {
                let res = new Array()
               for (var key in obj) {
                   res[key] = obj[key]
               }
                return res
            },
            scroll: function () {
                // 缓存指针
                let _this = this;
                // 设置一个开关来避免重负请求数据
                let sw = true;
                /**
                 * 判断滚动条到底部，需要用到DOM的三个属性值，即scrollTop、clientHeight、scrollHeight。


                 scrollTop为滚动条在Y轴上的滚动距离。

                 clientHeight为内容可视区域的高度。

                 scrollHeight为内容可视区域的高度加上溢出（滚动）的距离。

                 从这个三个属性的介绍就可以看出来，滚动条到底部的条件即为scrollTop + clientHeight == scrollHeight。

                 代码如下（兼容不同的浏览器）。

                 let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                 let clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
                 let scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;

                 避免没有数据的时候 重复执行 scrollHeight > clientHeight
                 if(scrollHeight > clientHeight && scrollTop + clientHeight === scrollHeight) {
                    this.loadmore();
                 }
                 */
                // 注册scroll事件并监听
                window.addEventListener('scroll',function(){
                    let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                    let clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
                    let scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;

                    // console.log(scrollTop)
                    // console.log(clientHeight)
                    // console.log(scrollHeight)

                    // 判断是否滚动到底部
                    if(scrollTop + clientHeight >= scrollHeight) {
                        // console.log(sw);
                        // 如果开关打开则加载数据
                        if(sw==true){
                            // 将开关关闭
                            sw = false;
                            console.log(_this.lastEssayId)
                            var url = "/mood/short/getEssayPage?essayId=" + _this.lastEssayId
                            axios.get(url)
                                .then(function(response){
                                    console.log(response.data)
                                    if (response.data.status_code == -1001) {
                                        alert("加载完了")
                                        return false
                                    }
                                    // return false
                                    // console.log(JSON.parse(response.data));
                                    var items = response.data.result.list
                                    var userInfo = response.data.result.userInfo
                                    var tmpEssayIds = response.data.result.essayIds
                                    // console.log(userInfo)
                                    userInfo = _this.obj2arr(userInfo)

                                    //添加到数组
                                    items.forEach(function (val, index) {
                                        _this.essay_items.push(val)
                                        _this.lastEssayId = val.id
                                    })

                                    userInfo.forEach(function (uVal, uIndex) {
                                        _this.essay_user_info.push(uVal)
                                    })

                                    tmpEssayIds.forEach(function (iVal, iIndex) {
                                        _this.essay_ids.push(iVal)
                                    })
                                    //获取点赞数据
                                    _this.getLikes()
                                    // 数据更新完毕，将开关打开
                                    sw = true;
                                }).catch(function(error){
                                    console.log(error);
                                });
                        }
                    }
                });
            },
            //点赞
            addClick: function (e) {
                var curE = e.currentTarget;
                this.clickId = $(curE).attr("data-id")
                var forUid = $(curE).attr('data-uid')
                console.log(forUid)
                var url = "/mood/short/addClick"
                var data = {
                    'content_type': "essay",
                    'content_id': this.clickId,
                    'for_uid': forUid
                }
                $.ajax({
                    url: url,
                    data:data,
                    dataType:'json',
                    type:"GET",
                    success:function (res) {
                        if (res.status_code != 0) {
                            alert(res.status_msg)
                            return false
                        }
                        //更新点赞图标颜色
                        $(curE).addClass('btn-danger')
                    }
                })
            },
            getLikes: function () {

                var vueThis = this
                var url = "/mood/short/getEssayClick"
                var data = {
                    content_type: 'essay',
                    content_id: vueThis.essay_ids
                }

                $.ajax({
                    url: url,
                    data:data,
                    dataType: 'json',
                    type: "GET",
                    success: function (res) {
                        if (res.status_code == 0) {
                            //赋值点赞数据
                            vueThis.essay_likes = res.result.likes
                            console.log(vueThis.essay_likes)
                        }
                    }
                })
            }
        },
        created() {
            this.getEssayList()
        },
        mounted() {
            this.scroll()
        }
    }
</script>

<style scoped>

</style>