<div class="fly-header layui-bg-black">
        <div class="layui-container">
          <a class="fly-logo" href="/">
            <img src="/res/images/logo.png" alt="layui">
          </a>
          <ul class="layui-nav fly-nav layui-hide-xs">
            @foreach($category as $c)
            <li class="layui-nav-item layui-this">
              <a href="/"><i class="iconfont icon-ui"></i>{{ $c->name}}</a>
            </li>
            {{-- <li class="layui-nav-item">
              <a href="case/case.html"><i class="iconfont icon-iconmingxinganli"></i>案例</a>
            </li> --}}
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

            {{-- <li class="layui-nav-item layui-hide-xs">
              <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
            </li> --}}
            @else
            <!-- 登入后的状态 -->
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

      @if(route_page() === 'pages-index')
      <div class="fly-panel fly-column">
            <div class="layui-container">
              <ul class="layui-clear">
                <li class="layui-hide-xs layui-this"><a href="/">首页</a></li>
                <li><a href="jie/index.html">提问</a></li>
                <li><a href="jie/index.html">分享<span class="layui-badge-dot"></span></a></li>
                <li><a href="jie/index.html">讨论</a></li>
                <li><a href="jie/index.html">建议</a></li>
                <li><a href="jie/index.html">公告</a></li>
                <li><a href="jie/index.html">动态</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>

                <!-- 用户登入后显示 -->
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="user/index.html">我发表的贴</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="user/index.html#collection">我收藏的贴</a></li>
              </ul>

              <div class="fly-column-right layui-hide-xs">
                <span class="fly-search"><i class="layui-icon"></i></span>
                <a href="jie/add.html" class="layui-btn">发表新帖</a>
              </div>
              <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
                <a href="jie/add.html" class="layui-btn">发表新帖</a>
              </div>
            </div>
          </div>
        @endif