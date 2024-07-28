<?php

return [
    "change_cost" => env("CHANGE_CITY_COST", 10_000),
    "default_travel_time" => env("CHANGE_CITY_DEFAULT_TRAVEL_TIME", 5), // in days
    "travel_tier_multiplicator" => env("CHANGE_CITY_TIER_MULTIPLICATOR", 1),
];