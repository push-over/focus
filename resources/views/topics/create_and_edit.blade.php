@extends('layouts.app')
@section('title','新增修改')
@section('content')
    <div class="layui-container fly-marginTop">
        <div class="fly-panel" pad20 style="padding-top: 5px;">
            <!--<div class="fly-none">没有权限</div>-->
            <div class="layui-form layui-form-pane">
                <div class="layui-tab layui-tab-brief" lay-filter="user">
                    <ul class="layui-tab-title">
                        <li class="layui-this">发表新帖
                            <!-- 编辑帖子 -->
                        </li>
                    </ul>
                    <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                        <div class="layui-tab-item layui-show">
                            <form action="" method="post">
                                <div class="layui-row layui-col-space15 layui-form-item">
                                    <div class="layui-col-md3">
                                        <label class="layui-form-label">所在专栏</label>
                                        <div class="layui-input-block">
                                            <select lay-verify="required" name="class" lay-filter="column">
                                                <option></option>
                                                <option value="0">提问</option>
                                                <option value="99">分享</option>
                                                <option value="100">讨论</option>
                                                <option value="101">建议</option>
                                                <option value="168">公告</option>
                                                <option value="169">动态</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-col-md9">
                                        <label for="L_title" class="layui-form-label">标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_title" name="title" required lay-verify="required"
                                                autocomplete="off" class="layui-input">
                                            <!-- <input type="hidden" name="id" value="@{{d.edit.id}}"> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-row layui-col-space15 layui-form-item layui-hide" id="LAY_quiz">
                                    <div class="layui-col-md3">
                                        <label class="layui-form-label">所属产品</label>
                                        <div class="layui-input-block">
                                            <select name="project">
                                                <option></option>
                                                <option value="layui">layui</option>
                                                <option value="独立版layer">独立版layer</option>
                                                <option value="独立版layDate">独立版layDate</option>
                                                <option value="LayIM">LayIM</option>
                                                <option value="Fly社区模板">Fly社区模板</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-col-md3">
                                        <label class="layui-form-label" for="L_version">版本号</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_version" value="" name="version" autocomplete="off"
                                                class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-col-md6">
                                        <label class="layui-form-label" for="L_browser">浏览器</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_browser" value="" name="browser" placeholder="浏览器名称及版本，如：IE 11"
                                                autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item layui-form-text">
                                    <div class="layui-input-block">
                                        <textarea id="L_content" name="content" required lay-verify="required"
                                            placeholder="详细描述" class="layui-textarea fly-editor" style="height: 260px;"></textarea>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-inline">
                                        <label class="layui-form-label">悬赏飞吻</label>
                                        <div class="layui-input-inline" style="width: 190px;">
                                            <select name="experience">
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="50">50</option>
                                                <option value="60">60</option>
                                                <option value="80">80</option>
                                            </select>
                                        </div>
                                        <div class="layui-form-mid layui-word-aux">发表后无法更改飞吻</div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="L_vercode" class="layui-form-label">人类验证</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="L_vercode" name="vercode" required lay-verify="required"
                                            placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid">
                                        <span style="color: #c00;">1+1=?</span>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-filter="*" lay-submit>立即发布</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ScriptAfterJs')
    <script>
        layui.define('fly', function(exports){

var $ = layui.jquery;
var layer = layui.layer;
var util = layui.util;
var laytpl = layui.laytpl;
var form = layui.form;
var fly = layui.fly;

var gather = {}, dom = {
  jieda: $('#jieda')
  ,content: $('#L_content')
  ,jiedaCount: $('#jiedaCount')
};

//监听专栏选择
form.on('select(column)', function(obj){
  var value = obj.value
  ,elemQuiz = $('#LAY_quiz')
  ,tips = {
    tips: 1
    ,maxWidth: 250
    ,time: 10000
  };
  elemQuiz.addClass('layui-hide');
  if(value === '0'){
    layer.tips('下面的信息将便于您获得更好的答案', obj.othis, tips);
    elemQuiz.removeClass('layui-hide');
  } else if(value === '99'){
    layer.tips('系统会对【分享】类型的帖子予以飞吻奖励，但我们需要审核，通过后方可展示', obj.othis, tips);
  }
});

//提交回答
fly.form['/jie/reply/'] = function(data, required){
  var tpl = '<li>\
    <div class="detail-about detail-about-reply">\
      <a class="fly-avatar" href="/u/@{{ layui.cache.user.uid }}" target="_blank">\
        <img src="@{{= d.user.avatar}}" alt="@{{= d.user.username}}">\
      </a>\
      <div class="fly-detail-user">\
        <a href="/u/@{{ layui.cache.user.uid }}" target="_blank" class="fly-link">\
          <cite>@{{d.user.username}}</cite>\
        </a>\
      </div>\
      <div class="detail-hits">\
        <span>刚刚</span>\
      </div>\
    </div>\
    <div class="detail-body jieda-body photos">\
      @{{ d.content}}\
    </div>\
  </li>'
  data.content = fly.content(data.content);
  laytpl(tpl).render($.extend(data, {
    user: layui.cache.user
  }), function(html){
    required[0].value = '';
    dom.jieda.find('.fly-none').remove();
    dom.jieda.append(html);

    var count = dom.jiedaCount.text()|0;
    dom.jiedaCount.html(++count);
  });
};

//求解管理
gather.jieAdmin = {
  //删求解
  del: function(div){
    layer.confirm('确认删除该求解么？', function(index){
      layer.close(index);
      fly.json('/api/jie-delete/', {
        id: div.data('id')
      }, function(res){
        if(res.status === 0){
          location.href = '/jie/';
        } else {
          layer.msg(res.msg);
        }
      });
    });
  }

  //设置置顶、状态
  ,set: function(div){
    var othis = $(this);
    fly.json('/api/jie-set/', {
      id: div.data('id')
      ,rank: othis.attr('rank')
      ,field: othis.attr('field')
    }, function(res){
      if(res.status === 0){
        location.reload();
      }
    });
  }

  //收藏
  ,collect: function(div){
    var othis = $(this), type = othis.data('type');
    fly.json('/collection/'+ type +'/', {
      cid: div.data('id')
    }, function(res){
      if(type === 'add'){
        othis.data('type', 'remove').html('取消收藏').addClass('layui-btn-danger');
      } else if(type === 'remove'){
        othis.data('type', 'add').html('收藏').removeClass('layui-btn-danger');
      }
    });
  }
};

$('body').on('click', '.jie-admin', function(){
  var othis = $(this), type = othis.attr('type');
  gather.jieAdmin[type] && gather.jieAdmin[type].call(this, othis.parent());
});

//异步渲染
var asyncRender = function(){
  var div = $('.fly-admin-box'), jieAdmin = $('#LAY_jieAdmin');
  //查询帖子是否收藏
  if(jieAdmin[0] && layui.cache.user.uid != -1){
    fly.json('/collection/find/', {
      cid: div.data('id')
    }, function(res){
      jieAdmin.append('<span class="layui-btn layui-btn-xs jie-admin '+ (res.data.collection ? 'layui-btn-danger' : '') +'" type="collect" data-type="'+ (res.data.collection ? 'remove' : 'add') +'">'+ (res.data.collection ? '取消收藏' : '收藏') +'</span>');
    });
  }
}();

//解答操作
gather.jiedaActive = {
  zan: function(li){ //赞
    var othis = $(this), ok = othis.hasClass('zanok');
    fly.json('/api/jieda-zan/', {
      ok: ok
      ,id: li.data('id')
    }, function(res){
      if(res.status === 0){
        var zans = othis.find('em').html()|0;
        othis[ok ? 'removeClass' : 'addClass']('zanok');
        othis.find('em').html(ok ? (--zans) : (++zans));
      } else {
        layer.msg(res.msg);
      }
    });
  }
  ,reply: function(li){ //回复
    var val = dom.content.val();
    var aite = '@'+ li.find('.fly-detail-user cite').text().replace(/\s/g, '');
    dom.content.focus()
    if(val.indexOf(aite) !== -1) return;
    dom.content.val(aite +' ' + val);
  }
  ,accept: function(li){ //采纳
    var othis = $(this);
    layer.confirm('是否采纳该回答为最佳答案？', function(index){
      layer.close(index);
      fly.json('/api/jieda-accept/', {
        id: li.data('id')
      }, function(res){
        if(res.status === 0){
          $('.jieda-accept').remove();
          li.addClass('jieda-daan');
          li.find('.detail-about').append('<i class="iconfont icon-caina" title="最佳答案"></i>');
        } else {
          layer.msg(res.msg);
        }
      });
    });
  }
  ,edit: function(li){ //编辑
    fly.json('/jie/getDa/', {
      id: li.data('id')
    }, function(res){
      var data = res.rows;
      layer.prompt({
        formType: 2
        ,value: data.content
        ,maxlength: 100000
        ,title: '编辑回帖'
        ,area: ['728px', '300px']
        ,success: function(layero){
          fly.layEditor({
            elem: layero.find('textarea')
          });
        }
      }, function(value, index){
        fly.json('/jie/updateDa/', {
          id: li.data('id')
          ,content: value
        }, function(res){
          layer.close(index);
          li.find('.detail-body').html(fly.content(value));
        });
      });
    });
  }
  ,del: function(li){ //删除
    layer.confirm('确认删除该回答么？', function(index){
      layer.close(index);
      fly.json('/api/jieda-delete/', {
        id: li.data('id')
      }, function(res){
        if(res.status === 0){
          var count = dom.jiedaCount.text()|0;
          dom.jiedaCount.html(--count);
          li.remove();
          //如果删除了最佳答案
          if(li.hasClass('jieda-daan')){
            $('.jie-status').removeClass('jie-status-ok').text('求解中');
          }
        } else {
          layer.msg(res.msg);
        }
      });
    });
  }
};

$('.jieda-reply span').on('click', function(){
  var othis = $(this), type = othis.attr('type');
  gather.jiedaActive[type].call(this, othis.parents('li'));
});


//定位分页
if(/\/page\//.test(location.href) && !location.hash){
  var replyTop = $('#flyReply').offset().top - 80;
  $('html,body').scrollTop(replyTop);
}

exports('jie', null);
});
    </script>
@endsection