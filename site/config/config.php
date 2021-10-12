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
          
//  Restrict Access
  'sylvainjule.bouncer.list' => [
     'curator' => [
         'fieldname' => 'canaccess'
      ],
    ],
   'debug'  => true,
    // Validate popup
//    'hooks' => [
//        'page.update:after' => function ($page) {
//            $popups = $page->popups()->toStructure();
//            $errors = 'false';
//            $f_timestamp = $this->from()->toDate();
//            $t_timestamp = $this->to()->toDate();
//            foreach($popups as $popup) {
//                if ($popup->date() != ""){
//                    $p_timestamp = $popup->date()->toDate();
//                    if ( $p_timestamp < $f_timestamp ||
//                            $p_timestamp > $t_timestamp) {
//                        $errors = 'true';
//                        break;
//                    }
//                }
//            }
//            $page->dateError() = $errors;
//        }
//    ]
];
