@extends('layouts.app')
@section('title','帖子主页')
@section('content')
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="fly-panel" style="margin-bottom: 0;">

                    <div class="fly-panel-title fly-filter">
                        <a href="{{ Request::url() }}?type={{ @$_GET['type'] }}&order=recent" @if(@$_GET['order'] === 'recent' || @!$_GET['order'])class="layui-this" @endif>按最新</a>
                        <span class="fly-mid"></span>
                        <a href="{{ Request::url() }}?type={{ @$_GET['type'] }}&order=default" @if(@$_GET['order'] === 'default')class="layui-this" @endif>按热议</a>

                    </div>

                    <ul class="fly-list">
                        @foreach($topics as $topic)
                        <li>
                            <a href="{{ route('users.home',['user'=>$topic->user->id]) }}" class="fly-avatar">
                                <img src="{{ $topic->user->avatar }}"
                                    alt="{{ $topic->user->name }}">
                            </a>
                            <h2>
                                <a class="layui-badge">{{ $topic->category->name }}</a>
                                <a href="{{ $topic->link()  }}">{{ $topic->title }}</a>
                            </h2>
                            <div class="fly-list-info">
                                <a href="{{ route('users.home',['user'=>$topic->user->id]) }}" link>
                                    <cite>{{ $topic->user->name }}</cite>
                                    {{-- <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                                    <i class="layui-badge fly-badge-vip">VIP3</i> --}}
                                </a>
                                <span>{{ $topic->created_at_human }}</span>

                                <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i class="iconfont icon-kiss"></i>
                                    {{ $topic->reward }}</span>
                                @if($topic->adopt)
                                <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
                                @endif
                                <span class="fly-list-nums">
                                    <i class="iconfont icon-pinglun1" title="回答"></i>{{ $topic->reply_count }}
                                </span>
                            </div>
                            <div class="fly-list-badge">
                                @if($topic->is_top)
                                <span class="layui-badge layui-bg-black">置顶</span>
                                @endif
                                @if($topic->good_topic)
                                <span class="layui-badge layui-bg-red">精帖</span>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <!-- <div class="fly-none">没有相关数据</div> -->

                    <div id="pull_right" style="text-align: center">
                        <div class="pull-right">
                            {{ $topics->appends(['type'=>@$_GET['type'],'order'=>@$_GET['order']])->render() }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="layui-col-md4">
                <dl class="fly-panel fly-list-one">
                    <dt class="fly-panel-title">本周热议</dt>
                    @foreach($topic_reply as $reply)
                    <dd>
                        <a href="{{ $reply->link() }}">{{ str_limit($reply->title,40,'') }}</a>
                        <span><i class="iconfont icon-pinglun1"></i> {{ $reply->reply_count }}</span>
                    </dd>
                    @endforeach

                    <!-- 无数据时 -->
                    <!--
        <div class="fly-none">没有相关数据</div>
        -->
                </dl>

                <div class="fly-panel">
                    <div class="fly-panel-title">
                        这里可作为广告区域
                    </div>
                    <div class="fly-panel-main">
                        <a href="" target="_blank" class="fly-zanzhu" style="background-color: #393D49;">虚席以待</a>
                    </div>
                </div>

                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">友情链接</h3>
                    <dl class="fly-panel-main">
                        <dd><a href="" target="_blank">layui</a>
                        <dd>
                        <dd><a href="" target="_blank">WebIM</a>
                        <dd>
                        <dd><a href="" target="_blank">layer</a>
                        <dd>
                        <dd><a href="" target="_blank">layDate</a>
                        <dd>
                        <dd><a href="" class="fly-link">申请友链</a>
                        <dd>
                    </dl>
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