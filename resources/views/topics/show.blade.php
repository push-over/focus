@extends('layouts.app')
@section('title',$topic->title)
@section('content')
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8 content detail">
                <div class="fly-panel detail-box">
                    <h1>{{ $topic->title }}</h1>
                    <div class="fly-detail-info">
                        <!-- <span class="layui-badge">审核中</span> -->
                        <span class="layui-badge layui-bg-green fly-detail-column">{{ $topic->category->name }}</span>

                        @if($topic->adopt)
                        <span class="layui-badge" style="background-color: #5FB878;">已结</span>
                        @else
                        <span class="layui-badge" style="background-color: #999;">未结</span>
                        @endif
                        <span class="layui-badge layui-bg-black">置顶</span>

                        @if($topic->good_topic)
                        <span class="layui-badge layui-bg-red">精帖</span>
                        @endif

                        <div class="fly-admin-box" data-id="">
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                @if(isset(Auth::user()->id))
                                @if($topic->user_id === Auth::user()->id)
                                <input  class="layui-btn layui-btn-xs jie-admin" onclick="alert('确定要删除吗?')" value="删除" type="submit" value="删除">
                                @endif
                                @endif
                            </form>
                            {{-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span>
                            <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span>

                            <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">加精</span>
                            <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0" style="background-color:#ccc;">取消加精</span> --}}
                        </div>
                        <span class="fly-list-nums">
                            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> {{ $topic->reply_count }}</a>
                            <i class="iconfont" title="人气">&#xe60b;</i> {{ $topic->view_count }}
                        </span>
                    </div>
                    <div class="detail-about">
                        <a class="fly-avatar" href="{{ route('users.home',['user'=>$topic->user->id]) }}">
                            <img src="{{ $topic->user->avatar }}"
                                alt="{{ $topic->user->name }}">
                        </a>
                        <div class="fly-detail-user">
                            <a href="{{ route('users.home',['user'=>$topic->user->id]) }}" class="fly-link">
                                <cite>{{ $topic->user->name }}</cite>
                                {{-- <i class="iconfont icon-renzheng" title="认证信息：@{{ rows.user.approve }}"></i>
                                <i class="layui-badge fly-badge-vip">VIP3</i> --}}
                            </a>
                            <span>{{ $topic->created_at_human }}</span>
                        </div>
                        <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
                            @if($topic->reward)
                            <span style="padding-right: 10px; color: #FF7200">悬赏：{{ $topic->reward }}飞吻</span>
                            @endif
                            @if(isset(Auth::user()->id))
                            @if($topic->user_id === Auth::user()->id)
                            <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="{{ route('topics.edit',$topic->id) }}">编辑此贴</a></span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="detail-body photos">
                        {!! $topic->body !!}
                    </div>
                </div>

                <div class="fly-panel detail-box" id="flyReply">
                    <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                        <legend>回帖</legend>
                    </fieldset>

                    <ul class="jieda" id="jieda">
                            @if (count($replies))

                                @foreach($replies as $reply)
                                <li data-id="111" class="jieda-daan">
                                    <a name="item-1111111111"></a>
                                    <div class="detail-about detail-about-reply">
                                        <a class="fly-avatar" href="">
                                            <img src="{{ $reply->user->avatar }}"
                                                alt=" ">
                                        </a>
                                        <div class="fly-detail-user">
                                            <a href="" class="fly-link">
                                                <cite>{{ $reply->user->name }}</cite>

                                            </a>
                                            @if($reply->topic->user_id == $reply->user->id)
                                            <span>(楼主)</span>
                                            @endif
                                            <!--
                                                <span style="color:#5FB878">(管理员)</span>
                                                <span style="color:#FF9E3F">（社区之光）</span>
                                                <span style="color:#999">（该号已被封）</span>
                                                -->
                                        </div>

                                        <div class="detail-hits">
                                            <span>{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($reply->adopt)
                                        <i class="iconfont icon-caina" title="最佳答案"></i>
                                        @endif
                                    </div>
                                    <div class="detail-body jieda-body photos">
                                        <p>{!! $reply->content !!}</p>
                                    </div>
                                    <div class="jieda-reply">
                                        <span class="jieda-zan zanok" type="zan">
                                            <i class="iconfont icon-zan"></i>
                                            <em>5</em>
                                        </span>
                                        <span type="reply">
                                            <i class="iconfont icon-svgmoban53"></i>
                                            回复
                                        </span>

                                            <div class="jieda-admin">
                                                    @can('destroy', $reply)
                                                    <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                                                {{-- <span type="edit">编辑</span> --}}
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <span onclick="layer.confirm('确认删除该话题么？');">删除</span>
                                                </form>
                                                @endcan
                                                @if(!$reply->adopt && !$reply->topic->adopt)
                                                <span class="jieda-accept" type="accept">采纳</span>
                                                @endif
                                            </div>


                                    </div>
                                </li>
                                @endforeach

                                @else
                                <!-- 无数据时 -->
                               <li class="fly-none">消灭零回复</li>
                               @endif
                            </ul>


                        <div id="pull_right" style="text-align: center">
                            <div class="pull-right">
                                {{ $replies->render() }}
                            </div>
                        </div>



                    <div class="layui-form layui-form-pane">
                        @if(Auth::check())
                        <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <div class="layui-form-item layui-form-text">
                                <a name="comment"></a>
                                <div class="layui-input-block">
                                    <textarea id="L_content" name="content" required lay-verify="required" placeholder="请输入内容"
                                        class="layui-textarea fly-editor" style="height: 150px;"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                <button class="layui-btn" onclick="layer.msg('已回复', {icon:1, shade: 0.1, time:0})" lay-filter="*">提交回复</button>
                            </div>
                        </form>
                        @else
                        <div style="text-align: center">
                                <div>
                                    要回复请 <a href="/login"><b> 登录</b></a>
                                </div>
                        </div>
                        @endif
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
                        <a href="http://layim.layui.com/?from=fly" target="_blank" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01"
                            style="background-color: #5FB878;">LayIM 3.0 - layui 旗舰之作</a>
                    </div>
                </div>

                <div class="fly-panel" style="padding: 20px 0; text-align: center;">
                    <img src="../../res/images/weixin.jpg" style="max-width: 100%;" alt="layui">
                    <p style="position: relative; color: #666;">微信扫码关注 layui 公众号</p>
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
        border-color: #ddd;@section('styles')
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

@section('ScriptAfterJs')
    <script>
        layui.config({
            version: "3.0.0",
            base: '/res/mods/' //这里实际使用时，建议改成绝对路径
        }).extend({
            jie: 'jie'
        }).use('jie');
    </script>


@endsection