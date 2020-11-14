<template>
    <el-form :model="uploadForm" :rules="rules" ref="uploadForm" label-width="100px" class="demo-uploadForm">
        <el-form-item label="文件名称" prop="title">
            <el-input v-model="uploadForm.title"></el-input>
        </el-form-item>
        <el-form-item label="文件描述" prop="desc">
            <el-input v-model="uploadForm.desc"></el-input>
        </el-form-item>
        <el-upload
                class="upload-demo"
                action="/mood/file/cover"
                :file-list="fileList"
                :data="postData"
                :on-success="uploadSuccessCover"
                :on-remove="handleRemove"
                :before-remove="beforeRemove"
                list-type="picture">
            <el-button size="small" type="primary">上传封面</el-button>
            <div slot="tip" class="el-upload__tip">只能上传jpg/png/gif文件，且不超过5M</div>
        </el-upload>
        <el-tabs @tab-click="handleClick"  type="border-card">
            <el-tab-pane label="上传图片" name="img">
                <el-upload
                        class="upload-demo"
                        action="/mood/file/saveFile"
                        :file-list="fileList"
                        :multiple=true
                        :data="postData"
                        :limit="9"
                        :on-success="uploadSuccessFile"
                        :before-remove="beforeRemove"
                        :on-remove="handleRemove"
                        list-type="picture">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">图片最大5M，文档最大10M，音频最大10M，视频最大</div>
                </el-upload>
            </el-tab-pane>
            <el-tab-pane label="上传文档" name="doc">
                <el-upload
                        class="upload-demo"
                        action="/mood/file/saveFile"
                        multiple
                        :limit="3"
                        :data="postData"
                        :on-exceed="handleExceed"
                        :on-success="uploadSuccessFile"
                        :before-remove="beforeRemove"
                        :on-remove="handleRemove"
                        :file-list="fileList">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只支持上传doc,xlxs,csv,ppt,txt,md，最大支持10M</div>
                </el-upload>
            </el-tab-pane>
            <el-tab-pane label="上传音频" name="voice">
                <el-upload
                        class="upload-demo"
                        action="/mood/file/saveFile"
                        multiple
                        :limit="3"
                        :data="postData"
                        :on-exceed="handleExceed"
                        :before-remove="beforeRemove"
                        :on-remove="handleRemove"
                        :file-list="fileList">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只支持上传mp3，wav，wave，wma，flac，ape，最大支持50M</div>
                </el-upload>
            </el-tab-pane>
            <el-tab-pane label="上传视频" name="video">
                <el-upload
                        class="upload-demo"
                        action="/mood/file/saveFile"
                        multiple
                        :limit="3"
                        :data="postData"
                        :on-exceed="handleExceed"
                        :before-remove="beforeRemove"
                        :on-remove="handleRemove"
                        :file-list="fileList">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只支持上传mpeg，avi，mov，asf，nAvi，最大支持200M</div>
                </el-upload>
            </el-tab-pane>
        </el-tabs>
        <el-form-item>
            <el-button type="primary" @click="submitForm('uploadForm')">立即创建</el-button>
            <el-button @click="resetForm('uploadForm')">重置</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name:"upload_img_temp.vue",
        data() {
            return {
                activeName: {},
                fileList: [],
                coverFile: [],
                postData: {},
                uploadData: {
                    fileUrl: ""
                },
                uploadForm: {
                    //上传的文件类型
                    fileType: 0,
                    //上传成功的文件列表
                    fileListInfo: [],
                    //上传成功的封面地址
                    cover_url: "",
                },
                removeFormData: {
                    //删除的文件名
                    filename: "",
                    //删除的文件类型
                    fileType: 0
                },
                rules: {
                    title: [
                        { required: true, message: '请输入文件名称', trigger: 'blur' },
                        { min: 1, max: 15, message: '长度在 1 到 15 个字符', trigger: 'blur' }
                    ],
                    desc: [
                        { required: true, message: '请文件描述', trigger: 'change' }
                    ],
                    type: [
                        { required: true, message: '请选择文件类型', trigger: 'change' }
                    ],
                },
                //保存上传成功的文件数据
                storeFileMap:[],
            };
        },
        methods: {
            //tab标签页点击 同一时间只允许上传一类文件
            handleClick(tab, event) {
                // console.log(tab.name);
                switch (tab.name) {
                    case "img":
                        this.uploadForm.fileType = 1;
                        this.postData.fileType = 1;
                        this.removeFormData.fileType = 1
                        break;
                    case "doc":
                        this.uploadForm.fileType = 2;
                        this.postData.fileType = 2;
                        this.removeFormData.fileType = 2;
                        break;
                    case "voice":
                        this.uploadForm.fileType = 3;
                        this.postData.fileType = 3;
                        this.removeFormData.fileType = 3;
                        break;
                    case "video":
                        this.uploadForm.fileType = 4;
                        this.postData.fileType = 4;
                        this.removeFormData.fileType = 4;
                        break;
                    default:
                }
            },
            handleRemove(file, fileList) {
                console.log(file)
                //删除服务器文件
                if (!this.removeFile(file)) {
                    return false
                }
                //删除当前数组元素
                fileList.forEach(function (val, index) {
                    if (file.name == val.name) {
                        fileList.splice(index, 1)
                        //调用删除接口
                    }
                })
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`确定移除 ${ file.name }？`);
            },
            handleExceed(files, fileList) {
                this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`);
            },
            //封面上传成功
            uploadSuccessCover(response, file, fileList) {
                if (response.status_code != 0) {
                    this.$message.error('封面文件上传失败，请稍后再试');
                    this.fileList.pop()
                } else {
                    this.uploadForm.cover_url = response.result.src
                    //保存上传后的文件与列表文件对应关系
                    this.storeUploadFileInfo(file, response.result.newName)
                    this.$message({
                        message: '封面文件上传成功',
                        type: 'success'
                    });
                }
            },
            //文件上传成功
            uploadSuccessFile(response, file, fileList) {
                if (response.status_code == 0) {
                    this.uploadForm.fileListInfo.push(response.result)
                    //保存上传后的文件与列表文件对应关系
                    this.storeUploadFileInfo(file, response.result.newName)
                    this.$message({
                        message: '文件上传成功',
                        type: 'success'
                    });
                } else {
                    //上传失败是删除当前图片预览
                    fileList.pop()
                    this.$message.error(response.status_msg);
                }
            },
            removeFile(file) {
                var removeFlag = true
                var that = this
                //获取当前文件与服务器新文件对应关系
                var delFilename = ""
                this.storeFileMap.forEach(function (val, index) {
                    if (file.uid == val.uid) {
                        delFilename = val.newName
                        return false
                    }
                })
                var delIndex = -1
                this.uploadForm.fileListInfo.forEach(function (val, index) {
                    if (val.newName == delFilename) {
                        delIndex = index
                        return false
                    }
                })
                console.log(delIndex)
                if (delIndex >= 0) {
                    //删除当前元素
                    this.uploadForm.fileListInfo.splice(delIndex, 1)
                }
                this.removeFormData.filename = delFilename
                $.ajax({
                    url: "/mood/file/removeFile",
                    data: this.removeFormData,
                    dataType: 'json',
                    type: 'POST',
                    success: function (res) {
                        if (res.status_code == 0) {
                            that.$message.success(res.status_msg)
                        } else {
                            that.$message.error(res.status_msg)
                            removeFlag = false
                        }
                    }
                })
                return removeFlag
            },
            storeUploadFileInfo(file, newName) {
                //file.uid与新文件名对应
                var fileObj = {
                    uid: file.uid,
                    newName: newName
                }
                this.storeFileMap.push(fileObj)
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
                            that.uploadForm._token = res.result
                            that.removeFormData._token = res.result
                        }
                    }
                })
            },
            submitForm(formName) {
                var that =this
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        $.ajax({
                            url: '/mood/file/save',
                            data: this.uploadForm,
                            dataType: 'json',
                            type: "POST",
                            success: function (res) {
                                if (res.status_code == 0) {
                                    that.$message({
                                        message: '文件上传成功',
                                        type: 'success'
                                    });
                                    //清空表单
                                    that.resetForm('uploadForm', "【文件已上传成功】")
                                } else {
                                    this.$message.error(response.status_msg);
                                }
                            }
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName, msg = '') {
                this.$refs[formName].resetFields();
                //清空文件列表
                if (confirm("是否清空文件列表？" + msg)) {
                    this.fileList = []
                    //清楚上传文件列表
                    this.uploadForm.fileListInfo = []
                    this.uploadForm.cover_url = ""
                }
            }
        },
        created: function () {
            this.getCsrfField()
        }
    }
</script>

<style scoped>

</style>