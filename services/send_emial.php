
<?php
require 'vendor/autoload.php';

use \Mailjet\Resources;

function sendMail(string $to, string $name, string $subject, string $body): bool
{

  $mj = new \Mailjet\Client('e5f5f2b06c3314dde4bba8ab4bb69672', 'b0b7729796c5e0c7d239ab175b0812a5', true, ['version' => 'v3.1']);

  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "ritesh8519147@jmieti.edu.in",
          'Name' => "Ritesh"
        ],
        'To' => [
          [
            'Email' => $to,
            'Name' => $name
          ]
        ],
        'Subject' => $subject,
        'HTMLPart' => $body,
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  return $response->success();
}

?>
