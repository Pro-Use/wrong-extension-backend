<?php

if(($user = kirby()->user()) && $user->role()->name() === 'curator') {
    $dir = __DIR__ . '/blueprints/curator/fromto.yml';
} else {
    $dir = __DIR__ . '/blueprints/fromto.yml';
}

Kirby::plugin('robprouse/role-blueprints', [
    'blueprints' => [
        'fields/fromto' => $dir,
        'fields/day' => function ($kirby) {
            return include __DIR__ . '/blueprints/day.php';
        },
        'fields/event_date' => function ($kirby) {
            return include __DIR__ . '/blueprints/event_date.php';
        },
    ]
]);

