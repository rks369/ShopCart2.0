
<?php
  require 'vendor/autoload.php';
  use \Mailjet\Resources;
  $mj = new \Mailjet\Client('e5f5f2b06c3314dde4bba8ab4bb69672','b0b7729796c5e0c7d239ab175b0812a5',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "ritesh8519147@jmieti.edu.in",
          'Name' => "Ritesh"
        ],
        'To' => [
          [
            'Email' => "rkstuvwxyz@gmail.com",
            'Name' => "Ritesh"
          ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'TextPart' => "My first Mailjet email",
        'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());
?>
