@extends('layouts.app')
@section('title','基本设置')
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
        <li class="layui-nav-item layui-this">
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
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this" lay-id="info">我的资料</li>
                <li lay-id="avatar">头像</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <div>
                        <input type="hidden" class="tag_token" name="_token" value="{{ csrf_token() }}">
                        <div class="layui-form-item">
                            <label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" required lay-verify="email" autocomplete="off"
                                    value="{{ $user->email }}" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="activate.html"
                                    style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_username" name="name" required lay-verify="required"
                                    autocomplete="off" value="{{ $user->name }}" class="layui-input">
                            </div>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="radio" name="sex" value="0" title="男" @if($user->sex === 0) checked
                                    @endif>
                                    <input type="radio" name="sex" value="1" title="女" @if($user->sex === 1) checked
                                    @endif>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_city" class="layui-form-label">城市</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_city" name="city"  autocomplete="off" value="{{ $user->city }}"
                                    class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label for="L_sign" class="layui-form-label">签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="随便写些什么刷下存在感" id="L_sign" name="description" autocomplete="off"
                                    class="layui-textarea" style="height: 80px;">{{ $user->description }}</textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" id="user-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
                        </div>
                    </div>
                </div>

                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <div class="avatar-add">
                            <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                            <button type="button" class="layui-btn upload-img">
                                <i class="layui-icon">&#xe67c;</i>上传头像
                            </button>
                            <img class="img-upload-view" src="{{ $user->avatar }}">
                            <span class="loading"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ScriptAfterJs')
<script>
    layui.define(['laypage', 'fly', 'element', 'flow'], function (exports) {

        var $ = layui.jquery;
        var layer = layui.layer;
        var util = layui.util;
        var laytpl = layui.laytpl;
        var form = layui.form;
        var laypage = layui.laypage;
        var fly = layui.fly;
        var flow = layui.flow;
        var element = layui.element;
        var upload = layui.upload;

        var gather = {},
            dom = {
                mine: $('#LAY_mine'),
                mineview: $('.mine-view'),
                minemsg: $('#LAY_minemsg'),
                infobtn: $('#LAY_btninfo')
            };


        //显示当前tab
        if(location.hash){
            element.tabChange('user', location.hash.replace(/^#/, ''));
        }

        element.on('tab(user)', function(){
            var othis = $(this), layid = othis.attr('lay-id');
            if(layid){
            location.hash = layid;
            }
        });

        var tag_token = $(".tag_token").val();
        //普通图片上传
        var uploadInst = upload.render({
            elem: '.upload-img',
            type: 'images',
            exts: 'jpg|png|gif', //设置一些后缀，用于演示前端验证和后端的验证
            url: '/update_avatar/'+'{{ Auth::user()->id }}',
            data: {
                '_token': tag_token
            },
            before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('.img-upload-view').attr('src', result); //图片链接（base64）
                });
            },
            done: function (res) {
                //如果上传成功
                if (res.status === 1) {
                    layer.msg(res.message, {
                        icon: 1,
                        time: 1000,
                        shade: 0.1
                    }, function () {
                        location.reload();
                    });
                    // return layer.msg('上传成功');
                } else { //上传失败
                    layer.msg(res.message);
                }
            },
            error: function () {
                //演示失败状态，并实现重传
                layer.msg('上传', {
                    icon: 5,
                    time: 1000,
                    shade: 0.1
                },function () {
                    return false;
                });
                // return layer.msg('上传失败,请重新上传');
            }
        });


         //监听提交
        form.on('submit(*)', function(data){
            console.log(data);
             //根据ip获取城市
            if ($('#L_city').val() === '') {
                $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function () {
                    data.field.city = $('#L_city').val(remote_ip_info.city || '');
                });
            }

            $.ajax({
                type: 'PUT',
                url: '/users/'+'{{ Auth::user()->id }}',
                data:data.field,
                success:function(data) {
                    layer.msg('资料更新成功', {
                        icon: 1,
                        time: 1000,
                        shade: 0.1
                    }, function () {
                        location.reload();
                    });

                },

            });
        });

        exports('user', null);

    });
</script>
@endsection