<?php
return [
    'module' =>
    [
        'title' => 'QL bài viết',
        'icon' => 'fa fa-th-large',
        'name' => ['post'],
        'subModule' => [
            [
                'title' => 'QL nhóm bài viết',
                'route' => 'post.catalogue.index',
            ],
            [
                'title' => 'QL bài viết',
                'route' => 'post.index',
            ]
        ]
    ],
    [
        'title' => 'QL thành viên',
        'icon' => 'fa fa-user',
        'name' => ['user'],
        'subModule' => [
            [
                'title' => 'QL nhóm thành viên',
                'route' => 'user.catalogue.index',
            ],
            [
                'title' => 'QL  thành viên',
                'route' => 'user.index',
            ]
        ]
    ],
    [
        'title' => 'Cấu hình chung',
        'icon' => 'fa fa-th-large',
        'name' => ['language'],
        'subModule' => [
            [
                'title' => 'QL ngôn ngữ',
                'route' => 'language.index',
            ],

        ]
    ],
];
