<?php

return [
    "provider" => [
        "models" => [
            "load-migrations" => true,
            "permissions" => [
                "model" => \Larakeeps\GuardShield\Models\Permission::class,
                "database" => "guard_shield_permissions"
            ],
            "roles" => [
                "model" => \Larakeeps\GuardShield\Models\Role::class,
                "database" => "guard_shield_roles"
            ],
            "modules" => [
                "model" => \Larakeeps\GuardShield\Models\Module::class,
                "database" => "guard_shield_permissions_modules"
            ],
            "assigns" => [
                "roles" => [
                    "database" => "guard_shield_assigns_roles"
                ],
                "permissions" => [
                    "database" => "guard_shield_assigns"
                ],
            ],
        ],
        "users" => [
            "key_type" => "id",
            "id" => "user_id",
            "model" => env('AUTH_MODEL', App\Models\User::class),
            'database' => 'users'
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
