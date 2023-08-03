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
            header("Access-Control-Allow-Origin: *");
            $page = kirby()->page('invites');
            $data = kirby()->site()->archive()->toPages();
            $all_sets = [];
            foreach($data as $set) {
              if ($set->days()->isNotEmpty()){
                $from = new DateTime($set->from(), new DateTimeZone('Europe/London'));
                if ($set->archiveImage()->isNotEmpty()){
                  $archiveImage = $set->archiveImage()->toFile()->srcset([350, 700]);
                } else {
                  $archiveImage = false;
                }
                $set_info = [
                  'from' => (string)$from->format('d-m-Y'),
                  'days' => $set->days()->toInt(),
                  'curator' => (string)$set->title(),
                  'title' => (string)$set->popupSetTitle(),
                  'text' => (string)$set->popupSetText(),
                  'project' => (string)$set->slug(),
                  'img' => $archiveImage,
                ];
                $popups = $set->popups()->toStructure();
                $popups_json = [];
                foreach($popups as $popup) {
                  $id = base64_encode($popup->url());
                  if ($popup->day()->isNotEmpty() && $popup->archivable()->toBool()){
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
                      'popup_day' => (string)$popup->day(),
                      'popup_time' => (string)$popup->time(),
                    ];
                  }
                }
                $set_info['popups'] = $popups_json;
                $all_sets[] = $set_info;
              }
            }
          echo json_encode($all_sets);
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
