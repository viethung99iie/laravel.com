<?php
return [
    'module' => [
        [
            'title' => 'Product Management',
            'icon' => 'fa fa-cube',
            'name' => ['product', 'attribute'],
            'subModule' => [
                [
                    'title' => 'Product Group Management',
                    'route' => 'product.catalogue.index',
                ],
                [
                    'title' => 'Product Management',
                    'route' => 'product.index',
                ],
                [
                    'title' => 'Attribute Type Management',
                    'route' => 'attribute.catalogue.index',
                ],
                [
                    'title' => 'Attribute Management',
                    'route' => 'attribute.index',
                ],

            ],
        ],
        [
            'title' => 'Post Management',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => 'Post Group Management',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'Post Management',
                    'route' => 'post.index',
                ],
            ],
        ],
        [
            'title' => 'User Group Management',
            'icon' => 'fa fa-user',
            'name' => ['user', 'permission'],
            'subModule' => [
                [
                    'title' => 'User Group Management',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'User Management',
                    'route' => 'user.index',
                ],
                [
                    'title' => 'Permission Management',
                    'route' => 'permission.index',
                ],
            ],
        ],
        [
            'title' => 'General Configuration',
            'icon' => 'fa fa-file',
            'name' => ['language', 'generate'],
            'subModule' => [
                [
                    'title' => 'Language Management',
                    'route' => 'language.index',
                ],
                [
                    'title' => 'Module Management',
                    'route' => 'generate.index',
                ],

            ],
        ],
    ],
];
