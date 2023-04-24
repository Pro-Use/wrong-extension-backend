<?php

Kirby::plugin('robprouse/new-curator', [ 
    'hooks' => [
//        'user.create:after' => function ($user) {
//          if ($user->role()->id() === "curator") {
//            // create new page
//            $site = $this->site();
//            $page = $site->page('invites');
//            $content = [
//                'title' => $user->name(),
//                'text'  => $user->id(),
//                ];
//            
//            $page->createChild([
//              'content'  => $content,
//              'slug'     => $user->id(),
//              'template' => 'invite',
//              'isDraft' => false
//            ]);
//            
//            // restrict access to new page
//            $page_path = "- invites/" . strtolower($user->id());
//            $user->update([
//                'role'=>'curator',
//                'canaccess' => $page_path
//                ]);
//            
//            // gen new password
//            $newPW = str::random(8);
//            $user->changePassword($newPW);
//            
//            //email user
//            try {
//                $this->email([
//                  'from' => 'rob@prou.se',
//                  'replyTo' => 'rob@prou.se',
//                  'to' => $user->email(),
//                  'subject' => 'Popup invite',
//                  'template' => 'email-invite',
//                  'data' => [
//                      'user' => $user,
//                      'pwd' => $newPW,
//                      'url' => $site->url()
//                  ]
//                ]);
//              } catch (Exception $error) {
//                echo $error;
//                error_log($error, 0);
//              }
//          }
//          else if ($user->role()->id() === "extension-admin") {
//              $user->update([
//                'canaccess' => "- invites"
//                ]);
//          }
//        },
        'page.update:after' => function ($newPage) {
            if ($newPage->emailed() == 'false'){
                try {
                    $newPW = str::random(8);
                    $page_path = "- invites/" . $newPage->slug();
                    $user = $this->users()->create([
                      'name'      => $newPage->title(),
                      'email'     => $newPage->email(),
                      'password'  => $newPW,
                      'role'      => 'curator',
//                      'canaccess' => $page_path,
                      'content'   => [
                         'page_path' => $page_path,
                         'canaccess' => $page_path,
                       ]
                    ]);
                    $newPage->update(
                      ['emailed'=> 'true']
                    );
                    //            //email user
                    try {
                        $this->email([
//                          'transport' => [
//                            'type' => 'smtp',
//                            'host' => 'smtp.gmail.com',
//                            'port' => 587,
//                            'security' => true,
//                            'auth' => true,
//                            'username' => env('EMAIL_USER'),
//                            'password' => env('EMAIL_PASSWORD'),
//                          ],
                          'from' => env('EMAIL_USER'),
                          'replyTo' => 'info@arebyte.com',
                          'to' => $user->email(),
                          'subject' => 'Popup invite',
                          'template' => 'email-invite',
                          'data' => [
                              'user' => $user,
                              'pwd' => $newPW,
                              'url' => $this->site()->url()
                          ]
                        ]);
                      } catch (Exception $error) {
                        echo $error->getMessage();
                        error_log($error, 0);
                      }

                  } catch(Exception $error) {


                    echo $error->getMessage();
//                    error_log($error, 0);
                    // optional error message: $e->getMessage();

                  }
            }
        }
      ],
]);

