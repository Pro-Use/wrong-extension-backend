<?php

Kirby::plugin('robprouse/new-curator', [ 
    'hooks' => [
        'user.create:after' => function ($user) {
          if ($user->role()->id() === "curator") {
            // create new page
            $site = $this->site();
            $page = $site->page('invites');
            $content = [
                'title' => $user->name(),
                'text'  => $user->id(),
                ];

            $page->createChild([
              'content'  => $content,
              'slug'     => $user->id(),
              'template' => 'invite',
              'isDraft' => false
            ]);
            $page_path = "- invites/" . strtolower($user->id());
            $user->update([
                'role'=>'curator',
                'canaccess' => $page_path
                ]);
            try {
                $this->email([
                  'from' => 'rob@prou.se',
                  'replyTo' => 'rob@prou.se',
                  'to' => $user->email(),
                  'subject' => 'Popup invite',
                  'template' => 'email-invite',
                  'data' => [
                      'user' => $user
                  ]
                ]);
              } catch (Exception $error) {
                echo $error;
                error_log($error, 0);
              }
          }
        }
      ],
]);

