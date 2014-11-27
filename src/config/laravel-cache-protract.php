<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache prolonging time
    |--------------------------------------------------------------------------
    |
    | When cache expires it will be prolonged by this value.
    | The thread which hit expired cache will be responsible for it refresh.
    | Other threads will be using the prolonged cache.
    |
    | Time is defined in minutes.
    |
    */
    'prolong_time' => 2,

];
