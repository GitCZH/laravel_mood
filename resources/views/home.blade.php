@extends('layouts.boot')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">登录提示：</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    你已成功登录！
                </div>
            </div>
        </div>
    </div>
    <readme></readme>
</div>
@endsection
