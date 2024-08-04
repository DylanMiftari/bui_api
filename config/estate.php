<?php

return [
    "robot_construction" => [ // all stats in %
        "increase_price" => env("ESTATE_ROBOT_INCREASE_PRICE", 100),
        "decrease_duration" => env("ESTATE_ROBOT_DECREASE_DURATION", 50)
    ],
    "robot_2_construction" => [ // all stats in %
        "increase_price" => env("ESTATE_ROBOT_2_INCREASE_PRICE", 30),
        "decrease_duration" => env("ESTATE_ROBOT_2_DECREASE_DURATION", 65)
    ],
];