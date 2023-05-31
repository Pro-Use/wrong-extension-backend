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
  'routes' => function ($kirby) {
      return [
        [
          'pattern' => 'archive.json',
          'action'  => function () {
            $page = $kirby()->page('invites');
            $data = $page->children()
              ->filter(function ($child) {
              return $child->status() != 'draft';
            });
            $all_sets = [];
            foreach($data as $set) {
              $from = new DateTime($set->from(), new DateTimeZone('Europe/London'));
              $to = new DateTime($set->to(), new DateTimeZone('Europe/London'));
              $set_info = [
                'from' => (string)$from->format('Y-m-d'),
                'to' => (string)$to->format('Y-m-d'),
                'curator' => (string)$set->title(),
                'title' => (string)$set->popupSetTitle(),
                'text' => (string)$set->popupSetText()
              ];
              $popups = $set->popups()->toStructure();
              $popups_json = [];
              foreach($popups as $popup) {
                $dates = explode(", ", $popup->date());
                sort($dates);
                if($dates[0] == ''){
                  $dates = [$from->format('Y-m-d')];
                }
                $id = base64_encode($popup->url());
                $popups_json[] = [
                  'popup_title' => (string)$popup->popup_title(),
                  'popup_info' => (string)$popup->popup_text(), 
                  'id' => (string)$id,
                  'url' => (string)$popup->url(),
                  'info_url' => (string)$set->url()."?id=".$id,
                  'fullscreen' => (string)$popup->fullscreen(),
                  'width' => (string)$popup->width(),
                  'height' => (string)$popup->height(),
                  'position' => (string)$popup->position(),
                  'popup_date' => $dates[0],
                  'popup_time' => (string)$popup->time(),
                ];
              }
              $set_info['popups'] = $popups_json;
              $all_sets[] = $set_info;
            }
          return $all_sets;
          }
        ]
      ];

  },
//  Restrict Access
  'sylvainjule.bouncer.list' => [
     'curator' => [
         'fieldname' => 'canaccess'
      ],
    ],
   'debug'  => true,
];
