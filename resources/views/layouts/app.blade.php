<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="喵酱社区">
    <meta name="description" content="这是一个充满爱的社区">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','喵酱社区')</title>

    <link rel="stylesheet" href="/res/layui/css/layui.css">
    <link rel="stylesheet" href="/res/css/global.css">

</head>

<body>

    <div id="app">
        @include('layouts._header')
            @yield('content')
        @include('layouts._footer')
    </div>

    <script src="/res/layui/layui.js"></script>
    <script>
        layui.cache.page = '';
        layui.cache.user = {
            username: '游客',
            uid: -1,
            avatar: '/res/images/avatar/00.jpg',
            experience: 83,
            sex: '男'
        };
        layui.config({
            version: "3.0.0",
            base: '/res/mods/' //这里实际使用时，建议改成绝对路径
        }).extend({
            fly: 'index'
        }).use('fly');
    </script>

    <script type="text/javascript">
        var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_30088308'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol +
            "w.cnzz.com/c.php%3Fid%3D30088308' type='text/javascript'%3E%3C/script%3E"));
    </script>

</body>

</html>