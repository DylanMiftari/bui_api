<?php

return [
    "alarm" => [
        "house" => [
            "decrease_chance" => env("HOUSE_ALARM_DECREASE_CHANCE", 2), // in %
            "decrease_robed_quantity_min" => env("HOUSE_ALARM_DECREASE_ROBED_QUANTITY_MIN", 5), // in %
            "decrease_robed_quantity_max" => env("HOUSE_ALARM_DECREASE_ROBED_QUANTITY_MAX", 10), // in %
        ],
        "company" => [
            "decrease_chance" => env("HOUSE_ALARM_DECREASE_CHANCE", 5), // in %
            "decrease_robed_quantity_min" => env("HOUSE_ALARM_DECREASE_ROBED_QUANTITY_MIN", 7), // in %
            "decrease_robed_quantity_max" => env("HOUSE_ALARM_DECREASE_ROBED_QUANTITY_MAX", 13), // in %
        ],
    ],
    "pepperSpray" => [
        "decrease_chance" => env("PEPPER_SPRAY_DECREASE_CHANCE", 20), // in %
        "decrease_robed_quantity" => env("PEPPER_SPRAY_DECREASED_ROBED_QUANTITY", 50), // in %
    ],
    "gas_dispenser" => [
        "bank" => [
            "decrease_robed_quantity" => env("BANK_GAS_DISPENSER_DECREASE_ROBED_QUANTITY", 50), // in %
            "gas_per_use" => env("BANK_GAS_DISPENSER_GAS_PER_USE", 0.3), // in kg
        ],
        "company" => [
            "decrease_robed_quantity" => env("COMPANY_GAS_DISPENSER_DECREASE_ROBED_QUANTITY", 50), // in %
            "gas_per_use" => env("COMPANY_GAS_DISPENSER_GAS_PER_USE", 0.3), // in kg
        ],
    ],
    "reinforced_door" => [
        "chance_divider" => env("REINFORCED_DOOR_CHANCE_DIVIDER", 2),
    ],
    "bodyguard" => [
        "house" => [
            "chance_divider" => env("HOUSE_BODYGUARD_CHANCE_DIVIDER", 3),
            "duration" => env("HOUSE_BODYGUARD_DURATION", 21), // in days
        ],
        "player" => [
            "chance_divider" => env("HOUSE_BODYGUARD_CHANCE_DIVIDER", 3),
            "duration" => env("HOUSE_BODYGUARD_DURATION", 21), // in days
        ],
    ],
    "securityguard" => [
        "bank" => [
            "max_member" => env("BANK_SECURITY_GUARD_MAX_COUNT", 10),
            "duration" => env("BANK_SECURITY_GUARD_DURATION", 21), // in days
            "first_members_count" => env("BANK_SECURITY_GUARD_FIRST_MEMBERS_COUNT", 5),
            "first_decrease_chance" => env("BANK_SECURITY_GUARD_FIRST_DECREASE_CHANCE", 3), // in %
            "second_decrease_chance" => env("BANK_SECURITY_GUARD_SECOND_DECREASE_CHANCE", 1), // in %
            "first_decrease_robed_quantity" => env("BANK_SECURITY_GUARD_FIRST_DECREASE_ROBED_QUANTITY", 3), // in %
            "second_decrease_robed_quantity" => env("BANK_SECURITY_GUARD_SECOND_DECREASE_ROBED_QUANTITY", 1), // in %
        ],
        "company" => [
            "max_member" => env("COMPANY_SECURITY_GUARD_MAX_COUNT", 10),
            "duration" => env("COMPANY_SECURITY_GUARD_DURATION", 21), // in days
            "first_members_count" => env("COMPANY_SECURITY_GUARD_FIRST_MEMBERS_COUNT", 5),
            "first_decrease_chance" => env("COMPANY_SECURITY_GUARD_FIRST_DECREASE_CHANCE", 3), // in %
            "second_decrease_chance" => env("COMPANY_SECURITY_GUARD_SECOND_DECREASE_CHANCE", 1), // in %
            "first_decrease_robed_quantity" => env("COMPANY_SECURITY_GUARD_FIRST_DECREASE_ROBED_QUANTITY", 3), // in %
            "second_decrease_robed_quantity" => env("COMPANY_SECURITY_GUARD_SECOND_DECREASE_ROBED_QUANTITY", 1), // in %
        ],
    ],
    "cyberdefense" => [
        "company" => [
            "cyberattack_chance" => env("CYBERDEFENSE_CYBERATTACK_CHANCE", 20), // in %
            "duration" => env("CYBDERDEFENSE_DURATION", 14), // in days
        ],
        "bank" => [
            "phishing_chance" => env("CYBERDEFENSE_PHISHING_CHANCE", 0.01), // in %
            "duration" => env("CYBDERDEFENSE_DURATION", 14), // in days
        ],
    ],
    "anti_ai" => [
        "player" => [
            "ai_drone_rob_chance" => env("ANTI_AI_AI_DRONE_ROB_CHANCE", 40), // in %
        ],
        "house" => [
            "ai_drone_rob_chance" => env("ANTI_AI_AI_DRONE_ROB_CHANCE", 5), // in %
        ],
    ],
    "containment_system" => [
        "bank" => [
            "rob_chance" => env("BANK_CONTAINMENT_ROB_CHANCE", 2), // in %
            "compensation_cost" => env("BANK_CONTAINMENT_COMPENSATION_COST", 100_000),
        ],
        "company" => [
            "rob_chance" => env("COMPANY_CONTAINMENT_ROB_CHANCE", 2), // in %
            "compensation_cost" => env("COMPANY_CONTAINMENT_COMPENSATION_COST", 100_000),
        ]
    ]
];