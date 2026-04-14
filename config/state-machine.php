<?php

use App\Enums\PostStatus;
use App\Models\Post;

return [
    'posts_state_machine' => [
        'class' => Post::class,
        'graph' => 'posts_state_machine',
        'property_path' => 'status',
        'states' => [
            PostStatus::DRAFT->value,
            PostStatus::MODERATION->value,
            PostStatus::PUBLISHED->value,
        ],
        'transitions' => [
            'to_moderation' => [
                'from' => [PostStatus::DRAFT->value],
                'to' => PostStatus::MODERATION->value,
            ],
            'to_published' => [
                'from' => [PostStatus::MODERATION->value],
                'to' => PostStatus::PUBLISHED->value,
            ],
            'to_draft' => [
                'from' => [PostStatus::PUBLISHED->value],
                'to' => PostStatus::DRAFT->value,
            ],
            'to_moderation_from_published' => [
                'from' => [PostStatus::PUBLISHED->value],
                'to' => PostStatus::MODERATION->value,
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
