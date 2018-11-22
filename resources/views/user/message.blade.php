@extends('layouts.app')
@section('title','我的消息')
@section('content')

<div class="layui-container fly-marginTop fly-user-main">
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
        <li class="layui-nav-item">
            <a href="{{ route('users.home',['user'=> $user->id]) }}">
                <i class="layui-icon">&#xe609;</i>
                我的主页
            </a>
        </li>
        <li class="layui-nav-item">
            <a href="{{ route('users.index',['user'=> $user->id]) }}">
                <i class="layui-icon">&#xe612;</i>
                用户中心
            </a>
        </li>
        <li class="layui-nav-item">
            <a href="{{ route('users.edit',['user'=> $user->id]) }}">
                <i class="layui-icon">&#xe620;</i>
                基本设置
            </a>
        </li>
        <li class="layui-nav-item layui-this">
            <a href="{{ route('users.message',['user'=> $user->id]) }}">
                <i class="layui-icon">&#xe611;</i>
                我的消息
            </a>
        </li>
    </ul>
    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon">&#xe602;</i>
    </div>
    <div class="site-mobile-shade"></div>

    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon">&#xe602;</i>
    </div>
    <div class="site-mobile-shade"></div>


    <div class="fly-panel fly-panel-user" pad20>
        <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
            {{-- <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button> --}}
            <div id="LAY_minemsg" style="margin-top: 10px;">
                <!--<div class="fly-none">您暂时没有最新消息</div>-->
                <ul class="mine-msg">
                    @foreach ($notifications as $notification)
                        <li data-id="123">
                            <blockquote class="layui-elem-quote">
                                <a href="{{ route('users.home', $notification->data['user_id']) }}" target="_blank"><cite>{{ $notification->data['user_name'] }}</cite></a>回答了您的求解<a
                                    target="_blank" href="{{ route('topics.show', $notification->data['topic_id']) }}"><cite>{{ $notification->data['topic_title'] }}</cite></a>
                            </blockquote>
                            <p><span>{{ $notification->data['reply_created'] }}</span></p>
                            <br>
                        </li>
                    @endforeach

                    <li data-id="123">
                        <blockquote class="layui-elem-quote">
                            系统消息：欢迎使用 喵酱社区
                        </blockquote>
                        <p><span>{{ $user->created_at->diffForHumans() }}</span></p>
                        <br>
                    </li>
                </ul>

                <div id="pull_right" style="text-align: center">
                        <div class="pull-right">
                                {{ $notifications->render() }}
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
    #pull_right{
        text-align:center;
    }
    .pull-right {
        /*float: left!important;*/
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #428bca;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
        color: #2a6496;
        background-color: #eee;
        border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #009688;
        border-color: #428bca;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .clear{
        clear: both;
    }
</style>
@endsection