@extends('layouts.app')
@section('title')
心情驿站
@endsection
@section('content')
<div class="container">
    <div class="row">
<!--        发布短文组件-->
        <publish_essay></publish_essay>
    </div>
    <div class="row">
        <div class="col-md-2">
            <essay_stat></essay_stat>
        </div>
        <div class="col-md-10">
            <essay_list></essay_list>
        </div>
    </div>
</div>
@endsection