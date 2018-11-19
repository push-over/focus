@extends('layouts.app')
@section('title','基本设置')
@section('content')
<div class="layui-container fly-marginTop fly-user-main">
        <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
                <li class="layui-nav-item">
                    <a href="{{ route('users.home') }}">
                        <i class="layui-icon">&#xe609;</i>
                        我的主页
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ route('users.index') }}">
                        <i class="layui-icon">&#xe612;</i>
                        用户中心
                    </a>
                </li>
                <li class="layui-nav-item layui-this">
                    <a href="{{ route('users.edit') }}">
                        <i class="layui-icon">&#xe620;</i>
                        基本设置
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{ route('users.message') }}">
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
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this" lay-id="info">我的资料</li>
                <li lay-id="avatar">头像</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <form method="post">
                        <div class="layui-form-item">
                            <label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" disabled  required lay-verify="email" autocomplete="off"
                                    value="{{ Auth::user()->email }}" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="activate.html"
                                    style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_username" name="username" required lay-verify="required"
                                    autocomplete="off" value="" class="layui-input">
                            </div>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="radio" name="sex" value="0" checked title="男">
                                    <input type="radio" name="sex" value="1" title="女">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_city" class="layui-form-label">城市</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_city" name="city" autocomplete="off" value="" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label for="L_sign" class="layui-form-label">签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="随便写些什么刷下存在感" id="L_sign" name="sign" autocomplete="off" class="layui-textarea"
                                    style="height: 80px;"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
                        </div>
                </div>

                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <div class="avatar-add">
                            <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                            <button type="button" class="layui-btn upload-img">
                                <i class="layui-icon">&#xe67c;</i>上传头像
                            </button>
                            <img src="{{ Auth::user()->avatar }}">
                            <span class="loading"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection