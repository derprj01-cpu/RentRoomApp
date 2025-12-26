<?php

function dashboardRoute()
{
    return auth()->user()->role === 'admin'
        ? route('admin.dashboard')
        : route('user.dashboard');
}

?>
