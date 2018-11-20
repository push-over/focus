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
