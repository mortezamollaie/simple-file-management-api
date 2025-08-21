<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('public-updates', function () {
    return true;
});
