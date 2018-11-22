@extends('layouts.app')
@section('title',isset($topic->id) ? '修改话题' : '发表话题')
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
                    @if (count($errors) > 0)
                        <fieldset class="layui-elem-field">
                            <legend>有错误发生：</legend>
                            <div style="color:red" class="layui-field-box">
                                @foreach ($errors->all() as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </div>
                          </fieldset>
                    @endif
                    <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                        <div class="layui-tab-item layui-show">
                            @if($topic->id)
                            <form action="{{ route('topics.update',$topic->id) }}" method="POST" accept-charset="UTF-8">
                                <input type="hidden" name="_method" value="PUT">
                                @else
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                @endif
                                <input type="hidden" class="tag_token" name="_token" value="{{ csrf_token() }}">
                                <div class="layui-row layui-col-space15 layui-form-item">
                                    <div class="layui-col-md3">
                                        <label class="layui-form-label">所属分类</label>
                                        <div  class="layui-input-block">
                                            <select lay-verify="required"  name="category_id" lay-filter="column">
                                                <option></option>
                                                @foreach($category as $c)
                                                <option {{ $c->id == $topic->category_id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-col-md9">
                                        <label for="L_title" class="layui-form-label">标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_title" name="title" required lay-verify="required"
                                                autocomplete="off" value="{{ $topic->title }}" class="layui-input">
                                        </div>
                                    </div>
                                </div>

                                <div class="layui-form-item layui-form-text">
                                    <div class="layui-input-block">
                                        <textarea id="editor" name="body" required
                                            placeholder="详细描述"  style="height: 260px;">{{ $topic->body }}</textarea>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                        <div class="layui-inline">
                                            <label class="layui-form-label">所属专栏</label>
                                            <div class="layui-input-inline" style="width: 190px;">
                                                <select @if($topic->id) disabled @endif lay-verify="required" name="type" >
                                                    <option value="{{ $topic->type }}">
                                                    @if($topic->type ===1)
                                                        提问
                                                    @elseif($topic->type === 2)
                                                        分享
                                                    @elseif($topic->type === 3)
                                                        讨论
                                                    @elseif($topic->type === 4)
                                                        建议
                                                    @endif
                                                    </option>
                                                    <option value="1">提问</option>
                                                    <option value="2">分享</option>
                                                    <option value="3">讨论</option>
                                                    <option value="4">建议</option>
                                                    <option disabled value="5">公告</option>
                                                    <option disabled value="6">动态</option>
                                                </select>
                                            </div>
                                            <div class="layui-form-mid layui-word-aux">发表后无法更改专栏</div>
                                        </div>
                                    </div>
                                <div class="layui-form-item">
                                    <div class="layui-inline">
                                        <label class="layui-form-label">悬赏飞吻</label>
                                        <div class="layui-input-inline" style="width: 190px;">
                                            <select name="reward">
                                                <option value="{{ $topic->reward }}">{{ $topic->reward }}</option>
                                                <option value="0">0</option>
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
                                {{-- <div class="layui-form-item">
                                    <label for="L_vercode" class="layui-form-label">人类验证</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="L_vercode" name="vercode" required lay-verify="required"
                                            placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid">
                                        <span style="color: #c00;">1+1=?</span>
                                    </div>
                                </div> --}}
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-filter="*">立即发布</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/simditor.js') }}"></script>

    <script>
    $(document).ready(function(){
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('topics.upload_image') }}',
                params: { _token: '{{ csrf_token() }}' },
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true, //设定是否支持图片黏贴上传，这里我们使用 true 进行开启；
        });
    });
    </script>

@stop