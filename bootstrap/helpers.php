<?php

function route_page()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function showMsg($status, $message = '', $data = array())
{
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );
    exit(json_encode($result));
}

function make_excerpt($value,$length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/','',strip_tags($value)));

    return str_limit($excerpt,$length);
}