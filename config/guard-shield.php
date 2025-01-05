<?php

return [
    "provider" => [
        "users" => [
            "id" => "use_id",
            "model" => env('AUTH_MODEL', App\Models\User::class)
        ]
    ],

    "make-test" => [
        "users" => [
            [
                "name" => "User Administrator",
                'email' => "user@administrator.om",
                "password" => "test123"
            ],
            [
                "name" => "User Person",
                'email' => "user@person.om",
                "password" => "test123"
            ],
            [
                "name" => "User Guest",
                'email' => "user@guest.om",
                "password" => "test123"
            ]
        ],
        "role" => [
            ["Administrator", "Rule to administrators."],
            ["User", "Rule to users."],
            ["Guest", "Rule to guests."]
        ],
        "permissions" => [
            ["View", "Permission to view action"],
            ["Create", "Permission to create action"],
            ["Edit", "Permission to edit action"],
            ["Remove", "Permission to remove action"],
        ]
    ]
];
