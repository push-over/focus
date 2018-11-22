﻿/**

 @Name: Fly社区主入口

 */


layui.define(['layer', 'laytpl', 'form', 'element', 'upload', 'util', 'laypage'], function (exports) {

    var $ = layui.jquery,
        layer = layui.layer,
        laytpl = layui.laytpl,
        form = layui.form,
        element = layui.element,
        upload = layui.upload,
        util = layui.util,
        laypage = layui.laypage,
        device = layui.device()

        ,
        DISABLED = 'layui-btn-disabled';

        var strUrl = window.location.href;
        var arrUrl = strUrl.split("/");
        var strPage = arrUrl[arrUrl.length-1];
        var id=strPage.replace(/[^0-9]/ig,"");

        var reg = /^[\'\"]+|[\'\"]+$/g;
        var c = JSON.stringify(arrUrl[3]);
        var route = c.replace(reg,"");
        // var tag_token = $(".tag_token").val();
        if(route != 'users' && route != 'topics') {

            var s = strUrl.split("?");
            var s1 = s[1] ? s[1] : '';
            var se = s1.replace(reg,"");
            var select = se ? se : '';
            window.onload = function () {

                loadData() //请求数据
                getPage() //分页操作
            }

            var page = 1; //设置首页页码
            var limit = 10; //设置一页显示的条数
            var total; //总条数

            function loadData() {
                $.ajax({
                    type: "GET",
                    url: "/topics_page?page="+page, //对应controller的URL
                    async: false,
                    dataType: 'json',
                    data: {
                        "pageIndex": page,
                        "pageSize": limit,
                        "category_id": id,
                        'select': select,
                        // '_token': tag_token
                    },
                    success: function (ret) {
                        total = ret.total; //设置总条数
                        var data = ret.data;
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                        html += ` <li>
                        <a href="/users/`+data[i].user_id+`/home" class="fly-avatar">
                            <img src="`+data[i].user.avatar+`"
                                alt="`+data[i].user.name+`">
                        </a>
                        <h2>
                            <a class="layui-badge">`+data[i].category.name+`</a>
                            <a href="/topics/`+data[i].id+`" title="`+data[i].title+`">`+data[i].title+`</a>
                        </h2>
                        <div class="fly-list-info">
                            <a href="/users/`+data[i].user_id+`/home" link>
                                <cite>`+data[i].user.name+`</cite>
                                <!-- <i class="iconfont icon-renzheng" title="认证信息：XXX"></i> -->
                                <!--  <i class="layui-badge fly-badge-vip">VIP3</i> -->
                            </a>
                            <span>`+data[i].created_at_human+`</span>

                            <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i class="iconfont icon-kiss"></i>
                                `+data[i].reward+`
                            </span>`

                            if(data[i].adopt) {
                                    html+=   `<span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>`;
                            }

                            html+=  `<span class="fly-list-nums">
                                <i class="iconfont icon-pinglun1" title="回答"></i> `+data[i].reply_count+`
                            </span>
                        </div>
                        <div class="fly-list-badge">`;
                        if(data[i].good_topic) {
                            html+= `<span class="layui-badge layui-bg-red">精帖</span>`;
                        }
                        html+= `</div>
                    </li>`;
                        }
                        $(".topic").empty().append(html);
                    }
                });
            }

            function getPage() {
                layui.use('laypage', function () {
                    var laypage = layui.laypage;

                    laypage.render({
                        elem: 'topic-page',
                        count: total, //数据总数，从服务端得到
                        limit: limit, //每页条数设置
                        limits: limit,
                        prev: '<i class="layui-icon">&#xe65a;</i>',
                        next:'<i class="layui-icon">&#xe65b;</i>',
                        layout:['prev','page','next','limit','refresh','skip'],
                        jump: function (obj, first) {
                            //obj包含了当前分页的所有参数，比如：
                            //console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
                            //console.log(obj.limit); //得到每页显示的条数
                            page = obj.curr; //改变当前页码
                            limit = obj.limit;

                            //首次不执行
                            if (!first) {
                                loadData() //加载数据
                            }
                        }
                    });
                });
            }
        }

    //阻止IE7以下访问
    if (device.ie && device.ie < 8) {
        layer.alert('如果您非得使用 IE 浏览器访问焦点社区，那么请使用 IE8+');
    }

    layui.focusInsert = function (obj, str) {
        var result, val = obj.value;
        obj.focus();
        if (document.selection) { //ie
            result = document.selection.createRange();
            document.selection.empty();
            result.text = str;
        } else {
            result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
            obj.focus();
            obj.value = result.join('');
        }
    };


    //数字前置补零
    layui.laytpl.digit = function (num, length, end) {
        var str = '';
        num = String(num);
        length = length || 2;
        for (var i = num.length; i < length; i++) {
            str += '0';
        }
        return num < Math.pow(10, length) ? str + (num | 0) : num;
    };

    var fly = {

        //Ajax
        json: function (url, data, success, options) {
                var that = this,
                    type = typeof data === 'function';

                if (type) {
                    options = success
                    success = data;
                    data = {};
                }

                options = options || {};

                return $.ajax({
                    type: options.type || 'post',
                    dataType: options.dataType || 'json',
                    data: data,
                    url: url,
                    success: function (res) {
                        if (res.status === 0) {
                            success && success(res);
                        } else {
                            layer.msg(res.msg || res.code, {
                                shift: 6
                            });
                            options.error && options.error();
                        }
                    },
                    error: function (e) {
                        layer.msg('请求异常，请重试', {
                            shift: 6
                        });
                        options.error && options.error(e);
                    }
                });
            }

            //计算字符长度
            ,
        charLen: function (val) {
                var arr = val.split(''),
                    len = 0;
                for (var i = 0; i < val.length; i++) {
                    arr[i].charCodeAt(0) < 299 ? len++ : len += 2;
                }
                return len;
            }

            ,
        form: {}


            //新消息通知
            ,
        newmsg: function () {
            var elemUser = $('.fly-nav-user');
            if (layui.cache.user.uid !== -1 && elemUser[0]) {
                fly.json('/message/nums/', {
                    _: new Date().getTime()
                }, function (res) {
                    if (res.status === 0 && res.count > 0) {
                        var msg = $('<a class="fly-nav-msg" href="javascript:;">' + res.count + '</a>');
                        elemUser.append(msg);
                        msg.on('click', function () {
                            fly.json('/message/read', {}, function (res) {
                                if (res.status === 0) {
                                    location.href = '/user/message/';
                                }
                            });
                        });
                        layer.tips('你有 ' + res.count + ' 条未读消息', msg, {
                            tips: 3,
                            tipsMore: true,
                            fixed: true
                        });
                        msg.on('mouseenter', function () {
                            layer.closeAll('tips');
                        })
                    }
                });
            }
            return arguments.callee;
        }

    };
    //签到
    var tplSignin = ['{{# if(d.signed){ }}', '<button class="layui-btn layui-btn-disabled">今日已签到</button>', '<span>获得了<cite>{{ d.experience }}</cite>飞吻</span>', '{{# } else { }}', '<button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>', '<span>可获得<cite>{{ d.experience }}</cite>飞吻</span>', '{{# } }}'].join(''),
        tplSigninDay = '已连续签到<cite>{{ d.days }}</cite>天'

        ,
        signRender = function (data) {
            console.log(data)
            laytpl(tplSignin).render(data, function (html) {
                elemSigninMain.html(html);
            });
            laytpl(tplSigninDay).render(data, function (html) {
                elemSigninDays.html(html);
            });
        }

        ,
        elemSigninHelp = $('#LAY_signinHelp'),
        elemSigninTop = $('#LAY_signinTop'),
        elemSigninMain = $('.fly-signin-main'),
        elemSigninDays = $('.fly-signin-days');

    if (elemSigninMain[0]) {
        /*
        fly.json('/sign/status', function(res){
          if(!res.data) return;
          signRender.token = res.data.token;
          signRender(res.data);
        });
        */
    }
    $('body').on('click', '#LAY_signin', function () {
        var othis = $(this);

        if (othis.hasClass(DISABLED)) return;
        console.log(othis)

        fly.json('', {
            token: signRender.token || 1
        }, function (res) {
            signRender(res.data);
        }, {
            error: function () {
                othis.removeClass(DISABLED);
            }
        });

        othis.addClass(DISABLED);
    });

    //签到说明
    elemSigninHelp.on('click', function () {
        layer.open({
            type: 1,
            title: '签到说明',
            area: '300px',
            shade: 0.8,
            shadeClose: true,
            content: ['<div class="layui-text" style="padding: 20px;">', '<blockquote class="layui-elem-quote">“签到”可获得社区飞吻，规则如下</blockquote>', '<table class="layui-table">', '<thead>', '<tr><th>连续签到天数</th><th>每天可获飞吻</th></tr>', '</thead>', '<tbody>', '<tr><td>＜5</td><td>5</td></tr>', '<tr><td>≥5</td><td>10</td></tr>', '<tr><td>≥15</td><td>15</td></tr>', '<tr><td>≥30</td><td>20</td></tr>', '</tbody>', '</table>', '<ul>', '<li>中间若有间隔，则连续天数重新计算</li>', '<li style="color: #FF5722;">不可利用程序自动签到，否则飞吻清零</li>', '</ul>', '</div>'].join('')
        });
    });

    //签到活跃榜
    var tplSigninTop = ['{{# layui.each(d.data, function(index, item){ }}', '<li>', '<a href="/u/{{item.uid}}" target="_blank">', '<img src="{{item.user.avatar}}">', '<cite class="fly-link">{{item.user.username}}</cite>', '</a>', '{{# var date = new Date(item.time); if(d.index < 2){ }}', '<span class="fly-grey">签到于 {{ layui.laytpl.digit(date.getHours()) + ":" + layui.laytpl.digit(date.getMinutes()) + ":" + layui.laytpl.digit(date.getSeconds()) }}</span>', '{{# } else { }}', '<span class="fly-grey">已连续签到 <i>{{ item.days }}</i> 天</span>', '{{# } }}', '</li>', '{{# }); }}', '{{# if(d.data.length === 0) { }}', '{{# if(d.index < 2) { }}', '<li class="fly-none fly-grey">今天还没有人签到</li>', '{{# } else { }}', '<li class="fly-none fly-grey">还没有签到记录</li>', '{{# } }}', '{{# } }}'].join('');

    elemSigninTop.on('click', function () {
        var loadIndex = layer.load(1, {
            shade: 0.8
        });

        fly.json('', function (res) { //实际使用，请将 url 改为真实接口
            var tpl = $(['<div class="layui-tab layui-tab-brief" style="margin: 5px 0 0;">', '<ul class="layui-tab-title">', '<li class="layui-this">最新签到</li>', '<li>今日最快</li>', '<li>总签到榜</li>', '</ul>', '<div class="layui-tab-content fly-signin-list" id="LAY_signin_list">', '<ul class="layui-tab-item layui-show"></ul>', '<ul class="layui-tab-item">2</ul>', '<ul class="layui-tab-item">3</ul>', '</div>', '</div>'].join('')),
                signinItems = tpl.find('.layui-tab-item');

            layer.close(loadIndex);

            layui.each(signinItems, function (index, item) {
                var html = laytpl(tplSigninTop).render({
                    data: res.data[index],
                    index: index
                });
                $(item).html(html);
            });

            layer.open({
                type: 1,
                title: '签到活跃榜 - TOP 20',
                area: '300px',
                shade: 0.8,
                shadeClose: true,
                id: 'layer-pop-signintop',
                content: tpl.prop('outerHTML')
            });

        }, {
            type: 'get'
        });
    });


    //回帖榜
    var tplReply = ['{{# layui.each(d.data, function(index, item){ }}', '<dd>', '<a href="/u/{{item.uid}}">', '<img src="{{item.user.avatar}}">', '<cite>{{item.user.username}}</cite>', '<i>{{item["count(*)"]}}次回答</i>', '</a>', '</dd>', '{{# }); }}'].join(''),
        elemReply = $('#LAY_replyRank');

    if (elemReply[0]) {
        /*
        fly.json('/top/reply/', {
          limit: 20
        }, function(res){
          var html = laytpl(tplReply).render(res);
          elemReply.find('dl').html(html);
        });
        */
    };

    //相册
    if ($(window).width() > 750) {
        layer.photos({
            photos: '.photos',
            zIndex: 9999999999,
            anim: -1
        });
    } else {
        $('body').on('click', '.photos img', function () {
            window.open(this.src);
        });
    }


    //搜索
    $('.fly-search').on('click', function () {
        layer.open({
            type: 1,
            title: false,
            closeBtn: false
                //,shade: [0.1, '#fff']
                ,
            shadeClose: true,
            maxWidth: 10000,
            skin: 'fly-layer-search',
            content: ['<form action="http://cn.bing.com/search">', '<input autocomplete="off" placeholder="搜索内容，回车跳转" type="text" name="q">', '</form>'].join(''),
            success: function (layero) {
                var input = layero.find('input');
                input.focus();

                layero.find('form').submit(function () {
                    var val = input.val();
                    if (val.replace(/\s/g, '') === '') {
                        return false;
                    }
                    input.val('site:layui.com ' + input.val());
                });
            }
        })
    });

//新消息通知
fly.newmsg();

//发送激活邮件
fly.activate = function (email) {
    fly.json('/api/activate/', {}, function (res) {
        if (res.status === 0) {
            layer.alert('已成功将激活链接发送到了您的邮箱，接受可能会稍有延迟，请注意查收。', {
                icon: 1
            });
        };
    });
};


    $('#LAY-activate').on('click', function () {
        fly.activate($(this).attr('email'));
    });

    //点击@
    $('body').on('click', '.fly-aite', function () {
        var othis = $(this),
            text = othis.text();
        if (othis.attr('href') !== 'javascript:;') {
            return;
        }
        text = text.replace(/^@|（[\s\S]+?）/g, '');
        othis.attr({
            href: '/jump?username=' + text,
            target: '_blank'
        });
    });

    //表单提交
    form.on('submit(*)', function (data) {
        var action = $(data.form).attr('action'),
            button = $(data.elem);
        fly.json(action, data.field, function (res) {
            var end = function () {
                if (res.action) {
                    location.href = res.action;
                } else {
                    fly.form[action || button.attr('key')](data.field, data.form);
                }
            };
            if (res.status == 0) {
                button.attr('alert') ? layer.alert(res.msg, {
                    icon: 1,
                    time: 10 * 1000,
                    end: end
                }) : end();
            };
        });
        return false;
    });

    //加载特定模块
    if (layui.cache.page && layui.cache.page !== 'index') {
        var extend = {};
        extend[layui.cache.page] = layui.cache.page;
        layui.extend(extend);
        layui.use(layui.cache.page);
    }

    //加载IM
    if (!device.android && !device.ios) {
        //layui.use('im');
    }



    //手机设备的简单适配
    var treeMobile = $('.site-tree-mobile'),
        shadeMobile = $('.site-mobile-shade')

    treeMobile.on('click', function () {
        $('body').addClass('site-mobile');
    });

    shadeMobile.on('click', function () {
        $('body').removeClass('site-mobile');
    });

    //获取统计数据
    $('.fly-handles').each(function () {
        var othis = $(this);
        $.get('/api/handle?alias=' + othis.data('alias'), function (res) {
            othis.html('（下载量：' + res.number + '）');
        })
    });

    //固定Bar
    util.fixbar({
        bar1: '&#xe642;',
        bgcolor: '#009688',
        click: function (type) {
            if (type === 'bar1') {
                location.href = '/topics/create';
            }
        }
    });
    exports('fly', fly);
});