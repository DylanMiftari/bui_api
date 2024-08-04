<?php

return [
    "cyberattack" => [
        "min_target_level" => env("CYBERATTACK_MIN_TARGET_LEVEL", 3),
        "cost" => env("CYBERATTACK_COST", 5_000),
        "chance" => env("CYBERATTACK_SUCCESS_CHANCE", 50), // in %
        "money_robed" => env("CYBERATTACK_MONEY_ROBED", 15_000),
    ],
    "ai_drone" => [
        "house" => [
            "cost" => env("AI_DRONE_HOUSE_COST", 5_000),
            "chance" => env("AI_DRONE_HOUSE_CHANCE", 25), // in %
            "min_robed_quantity" => env("AI_DRONE_HOUSE_MIN_ROBED_QUANTITY", 85), // in %
            "max_robed_quantity" => env("AI_DRONE_HOUSE_MAX_ROBED_QUANTITY", 100), // in %
            "min_target_money" => env("AI_DRONE_HOUSE_MIN_MONEY_TARGET", 3_500),
        ],
        "player" => [
            "cost" => env("AI_DRONE_PLAYER_COST", 5_000),
            "chance" => env("AI_DRONE_PLAYER_CHANCE", 100), // in %
            "min_robed_quantity" => env("AI_DRONE_PLAYER_MIN_ROBED_QUANTITY", 85), // in %
            "max_robed_quantity" => env("AI_DRONE_PLAYER_MAX_ROBED_QUANTITY", 100), // in %
            "min_target_money" => env("AI_DRONE_PLAYER_MIN_MONEY_TARGET", 3_500),
        ]
    ],
    "shoplifting" => [
        "cost" => env("SHOPLIFTING_COST", 1_000),
        "chance" => env("SHOPLIFTING_CHANCE", 75), // in %
        "base_robed_money_min" => env("SHOPLIFTING_BASE_ROBED_MONEY_MIN", 250),
        "base_robed_money_max" => env("SHOPLIFTING_BASE_ROBED_MONEY_MAX", 1_500),
    ],
    "phishing" => [
        "min_target_money" => env("PHISHING_MIN_TARGET_MONEY", 10_000),
        "cost" => env("PHISHING_COST", 30_000),
        "chance" => env("PHISHING_CHANCE", 1), // in %
        "robed_quantity" => env("PHISHING_ROBED_QUANTITY", 50), // in %
    ]
];