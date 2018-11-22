@extends('layouts.app')

@section ('title', '喵酱社区')

@section('content')
<div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="fly-panel">
                    <div class="fly-panel-title fly-filter">
                        <a>置顶</a>
                        <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_goSignin" style="color: #FF5722;">去签到</a>
                    </div>
                    <ul class="fly-list top-page">
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

                                <span class="layui-badge layui-bg-black">置顶</span>
                                @if($topic->good_topic)
                                <span class="layui-badge layui-bg-red">精帖</span>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="fly-panel" style="margin-bottom: 0;">
                    <input type="hidden" class="tag_token" name="_token" value="{{ csrf_token() }}">
                    <div class="fly-panel-title fly-filter topic-order">
                        <a href="{{ Request::url() }}?select=" @if(@!$_GET['select'])  class="layui-this" @endif>综合</a>
                        <span class="fly-mid"></span>
                        <a href="{{ Request::url() }}?select=no_adopt" @if(@$_GET['select'] == 'no_adopt')  class="layui-this" @endif>未结</a>
                        <span class="fly-mid"></span>
                        <a href="{{ Request::url() }}?select=adopt" @if(@$_GET['select'] == 'adopt')  class="layui-this" @endif>已结</a>
                        <span class="fly-mid"></span>
                        <a href="{{ Request::url() }}?select=good_topic" @if(@$_GET['select'] == 'good_topic')  class="layui-this" @endif>精华</a>
                    </div>

                    <ul class="fly-list topic">

                    </ul>



                    <div style="text-align: center">
                        <div id="topic-page">
                        </div>
                    </div>

                </div>
            </div>
            <div class="layui-col-md4">

                <div class="fly-panel">
                    <h3 class="fly-panel-title">温馨通道</h3>
                    <ul class="fly-panel-main fly-list-static">
                        <li>
                            <a href="" target="_blank">我的 的 GitHub 仓库，欢迎Star</a>
                        </li>

                    </ul>
                </div>


                {{-- <div class="fly-panel fly-signin">
                    <div class="fly-panel-title">
                        签到
                        <i class="fly-mid"></i>
                        <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
                        <i class="fly-mid"></i>
                        <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>
                        <span class="fly-signin-days">已连续签到<cite>16</cite>天</span>
                    </div>
                    <div class="fly-panel-main fly-signin-main">
                        <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
                        <span>可获得<cite>5</cite>飞吻</span>

                        <!-- 已签到状态 -->
                        <!--
              <button class="layui-btn layui-btn-disabled">今日已签到</button>
              <span>获得了<cite>20</cite>飞吻</span>
              -->
                    </div>
                </div> --}}

                <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
                    <h3 class="fly-panel-title">回贴周榜</h3>
                    <dl>
                        @foreach($users as $user)
                        <dd>
                            <a href="{{ route('users.home',['user'=>$user->id]) }}">
                                <img src="{{ $user->avatar }}"><cite>{{$user->name}}</cite><i>{{ count($user->replies) }}次回答</i>
                            </a>
                        </dd>
                        @endforeach
                    </dl>
                </div>

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
                        <a href="" target="_blank" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01"
                            style="background-color: #5FB878;">LayIM 3.0 - layui 旗舰之作</a>
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
                        <dd><a href=""
                                class="fly-link">申请友链</a>
                        <dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
@endsection
