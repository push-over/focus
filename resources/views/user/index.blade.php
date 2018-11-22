@extends('layouts.app')
@section('title','用户中心')
@section('content')

<div class="layui-container fly-marginTop fly-user-main">
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
        <li class="layui-nav-item">
            <a href="{{ route('users.home',['user'=> $user->id]) }}">
                <i class="layui-icon">&#xe609;</i>
                我的主页
            </a>
        </li>
        <li class="layui-nav-item layui-this">
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
        <li class="layui-nav-item">
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
        <!--
    <div class="fly-msg" style="margin-top: 15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>
    </div>
    -->
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖（<span>{{ count(Auth::user()->topics )}}</span>）</li>
                <li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span>{{ count(Auth::user()->coupons) }}</span>）</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-tab-item layui-show">
                    <ul class="mine-view jie-row">
                        @foreach($topics as $topic)
                        <li>
                            <a class="jie-title" href="{{ $topic->link() }}" target="_blank">{{ $topic->title }}</a>
                            <i>{{ $topic->created_at_human }}</i>
                            <a class="mine-edit" href="{{ route('topics.edit',$topic->id) }}">编辑</a>
                            <em>{{ $topic->view_count }}阅/{{ $topic->reply_count }}答</em>
                        </li>
                        @endforeach
                    </ul>
                    <div id="LAY_page"></div>
                </div>
                <div class="layui-tab-item">
                    <ul class="mine-view jie-row">
                        @foreach($coupons as $coupon)
                        <li>
                            <a class="jie-title" href="{{ $coupon->topic->link() }}" target="_blank">{{ $coupon->topic->title }}</a>
                            <i>收藏于23小时前</i> </li>

                        @endforeach
                    </ul>
                    <div id="LAY_page1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


