
@extends('layouts.app')
@section('title','登录')
@section('content')
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">仅支持使用GitHub账号登录</li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">

                <div class="layui-form-item">
                    <a href="/auth/github" class="layui-btn" lay-filter="*">GitHub</a>
                </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
