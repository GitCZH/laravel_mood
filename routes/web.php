<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix("algorithm_sort")->group(function (){
   Route::get("/bubble", "Admin\AlgorithmSortController@bubble");
   Route::get("/select", "Admin\AlgorithmSortController@select");
   Route::get("/insert", "Admin\AlgorithmSortController@insert");
   Route::get("/shortInsert", "Admin\AlgorithmSortController@shortInsert");
});
//后台管理相关路由
Route::prefix("/admin")->middleware("mood_admin")->group(function (){
    Route::get("/sendMsg", "Admin\MsgController@sendRegMsg");
});

//前端心情驿站应用管理相关路由
Route::prefix("/mood/short")->middleware("mood_index")->group(function (){
    //发布心情短文路由
    Route::any("/publish", "Index\EssayController@publishEssay");
    //分页获取短文
    Route::get("/getEssayPage", "Index\EssayController@getEssayPage");
    //发布短文评论
    Route::any("/publishEssayCmt", "Index\EssayCmtController@publishEssayCmt");
    //获取短文评论
    Route::get("/getEssayCmtPage", "Index\EssayCmtController@getEssayCmtPage");
    //获取当前用户的短文统计数据
    Route::get("/getUserEssayStat", "Index\EssayController@getUserEssayStat");

    //页面路由
    Route::get("/index", "Index\EssayController@essayIndex")->name("essay_index");
    //点赞
    Route::get("/addClick", "Index\ClickLikeController@addClick");
    //获取点赞数据
    Route::get("/getEssayClick", "Index\ClickLikeController@getEssayClick");
});
Route::prefix("/mood/file")->middleware("mood_index")->group(function (){
    //保存用户上传文件信息
    Route::post("/save", "FileController@storeFileUploadInfo");
    //删除文件
    Route::post("/removeFile", "FileController@removeFile");
    //文件封面接口
    Route::post("/cover", "FileController@uploadFileCover");
    //上传文件路由
    Route::get("/upload/index", "FileController@uploadFilePage");
    //保存文件路由
    Route::post("/saveFile", "FileController@saveFile");
    //浏览
    Route::get("/index", "FileController@index");
});
//获取表单令牌
Route::get("/home/getCsrf", "HomeController@getCsrfField");
//获取标题logo
Route::get("/img/getNav", "FileController@getNav");
//获取登录状态
Route::get("/home/getLoginStatus", "HomeController@getLoginStatus");
//面试题目测试
Route::any("/topic01", "Admin\AlgorithmSortController@topic01");