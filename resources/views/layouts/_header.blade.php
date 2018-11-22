<div class="fly-header layui-bg-black">
        <div class="layui-container">
          <a class="fly-logo" href="/" >
            <img src="/res/images/logo.png" alt="layui">
          </a>
          <ul class="layui-nav fly-nav layui-hide-xs">

            @foreach($category as $c)
            <li class="layui-nav-item {{ active_class((if_route('categories.show') && if_route_param('category', $c->id)),'layui-this') }}">
              <a style="padding: 0px 20px;" href="{{ route('categories.show',$c->id) }}">{{ $c->name }}</a>
            </li>
            @endforeach
          </ul>

          <ul class="layui-nav fly-nav-user">

            @guest
            <!-- 未登入的状态 -->
            <li  class="layui-nav-item">
                <img width="34" src="/images/github.png" class="iconfont icon-touxiang layui-hide-xs" alt="">
              {{-- <a class="iconfont icon-touxiang layui-hide-xs" href="{{ route('login') }}"></a> --}}
            </li>
            <li class="layui-nav-item">
              <a href="{{ route('login') }}">登入</a>
            </li>

            @else
            <!-- 登入后的状态 -->
            <li class="layui-nav-item layui-hide-xs">
                    <a @if(Auth::user()->notification_count) style="color:red" @endif href="{{ route('users.message',['user'=>Auth::user()->id]) }}"  title="消息" class="iconfont icon-tongzhi">@if(Auth::user()->notification_count) {{ Auth::user()->notification_count }} @endif</a>
            </li>

            <li class="layui-nav-item">
              <a class="fly-nav-avatar" href="javascript:;">
                <cite class="layui-hide-xs">{{ Auth::user()->name }}</cite>
                <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>
                <img src="{{ Auth::user()->avatar }}">
              </a>
              <dl class="layui-nav-child">
                <dd><a href="{{ route('users.edit',['users'=>Auth::user()->id]) }}"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                <dd><a href="{{ route('users.message',['users'=>Auth::user()->id])}}"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
                <dd><a href="{{ route('users.home',['users'=>Auth::user()->id]) }}"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                <hr style="margin: 5px 0;">
                <dd><a href="{{ route('logout') }}" style="text-align: center;" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">退出</a></dd>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </dl>
            </li>

            @endguest
          </ul>
        </div>
      </div>

      @if(route_page() === 'pages-index' || route_page() === 'topics-show' || route_page() === 'categories-show' || route_page() === 'topics-index')
      <div class="fly-panel fly-column">
            <div class="layui-container">
              <ul class="layui-clear">
                <li @if(@!$_GET['type'])class="layui-this" @endif class="layui-hide-xs"><a href="/">首页</a></li>
                <li @if(@$_GET['type']=='1')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=1"  >提问</a></li>
                <li @if(@$_GET['type']=='2')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=2" >分享<span class="layui-badge-dot"></span></a></li>
                <li @if(@$_GET['type']=='3')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=3" >讨论</a></li>
                <li @if(@$_GET['type']=='4')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=4" >建议</a></li>
                <li @if(@$_GET['type']=='5')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=5" >公告</a></li>
                <li @if(@$_GET['type']=='6')class="layui-this" @endif><a href="{{ route('topics.index') }}?type=6" >动态</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>

                <!-- 用户登入后显示 -->
                @if(isset(Auth::user()->id))
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{{ route('users.index',['user'=>Auth::user()->id]) }}">我发表的贴</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{{ route('users.index',['user'=>Auth::user()->id]) }}#collection">我收藏的贴</a></li>
                @endif
            </ul>

              <div class="fly-column-right layui-hide-xs">
                <span class="fly-search"><i class="layui-icon"></i></span>
                <a href="{{ route('topics.create') }}" class="layui-btn">发表新帖</a>
              </div>
              <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
                <a href="{{ route('topics.create') }}" class="layui-btn">发表新帖</a>
              </div>
            </div>
          </div>
        @endif