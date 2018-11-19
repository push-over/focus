
@extends('layouts.app')
@section('title','登录')
@section('content')
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      {{-- <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
      </ul> --}}
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
              <div class="la<span style="padding-left:20px;">
                <a href="/auth/github" class="layui-btn" lay-filter="*" >GitHub登录</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
