<?php

function route_page()
{
    return str_replace('.','-',Route::currentRouteName());
}