<?php

return [
  'blocks' => [
    'fieldsets' => [
      'custom' => [
        'label' => 'Custom blocks',
        'type' => 'group',
        'fieldsets' => [
          'faq'
        ]
      ],
      'kirby' => [
        'label' => 'Kirby blocks',
        'type' => 'group',
        'fieldsets' => [
          'heading',
          'text',
          'list',
          'quote',
          'image',
          'video',
          'code',
          'markdown'
        ]
      ]
    ]
  ],
  'panel' =>[
    'install' => true
  ],
  // Store last popup update time
  'hooks' => [
      'page.changeStatus:after' => function ($newPage, $oldPage) {
        if ($newPage->status() != 'draft'&& $newPage->isChildOf('invites')){
            $page = $this->site()->find('invites');
            $now = new DateTime("now");
            $page->update(['lastUpdated' => $now->getTimestamp()]);
        }
      },
      'page.update:after' => function ($newPage, $oldPage) {
        if ($newPage->status() != 'draft'&& $newPage->isChildOf('invites')){
            $page = $this->site()->find('invites');
            $now = new DateTime("now");
            $page->update(['lastUpdated' => $now->getTimestamp()]);
        }
      }
  ],
          
//  Restrict Access
  'sylvainjule.bouncer.list' => [
     'curator' => [
         'fieldname' => 'canaccess'
      ],
    ],
   'debug'  => true,
];
