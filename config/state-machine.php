<?php

use App\Models\Post;

return [
    'posts_state_machine' => [
        'class' => Post::class,
        'graph' => 'posts_state_machine',
        'property_path' => 'status',
        'states' => [
            'draft',
            'moderation',
            'published',
        ],
        'transitions' => [
            'to_moderation' => [
                'from' => ['draft'],
                'to' => 'moderation',
            ],
            'to_published' => [
                'from' => ['moderation'],
                'to' => 'published',
            ],
            'to_draft' => [
                'from' => ['published'],
                'to' => 'draft',
            ],
            'to_moderation_from_published' => [
                'from' => ['published'],
                'to' => 'moderation',
            ],
        ],
        'callbacks' => [
            'guard' => [
                'guard_to_moderation' => [
                    'on' => 'to_moderation',
                    'can' => 'toModeration',
                ],

                'guard_to_published' => [
                    'on' => 'to_published',
                    'can' => 'toPublished',
                ],

                'guard_to_draft' => [
                    'on' => 'to_draft',
                    'can' => 'toDraft',
                ],

                'guard_to_moderation_from_published' => [
                    'on' => 'to_moderation_from_published',
                    'can' => 'toModerationFromPublished',
                ],
            ],
        ],
    ],
];
