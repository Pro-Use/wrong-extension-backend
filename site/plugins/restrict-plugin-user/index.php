<?php

if(($user = kirby()->user()) && $user->role()->name() === 'curator') {
    $dir = __DIR__ . '/blueprints/fields/curator/fromto.yml';
} else {
    $dir = __DIR__ . '/blueprints/fields/fromto.yml';
}

Kirby::plugin('robprouse/role-blueprints', [
    'blueprints' => [
        'fields/fromto' => $dir
    ]
]);

