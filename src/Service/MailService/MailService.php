<?php

namespace App\Service\MailService;

use App\Entity\Profile;
use App\Event\ProfileModerated;
use GuzzleHttp\Client;

class MailService extends Client
{

    /**
     * @var ServiceConfig
     */
    protected $serviceConfig;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->serviceConfig = new ServiceConfig($config['service']);
    }

    public function sendApprovedTemplate($email, $uuid)
    {
        $this->sendTemplateToUser($email, ServiceConfig::TEMPLATE_APPROVED, ['UUID' => $uuid]);
    }

    public function sendDeniedTemplate($email)
    {
        $this->sendTemplateToUser($email, ServiceConfig::TEMPLATE_DENIED);
    }

    protected function sendTemplateToUser($email, $template, $vars = null)
    {
        $this->post('mail/send', [
            'body' => json_encode([
                'personalizations' => [
                    [
                        'to' => [
                            [
                                'email' => $email
                            ]
                        ],
                        'dynamic_template_data' => $vars
                    ]
                ],
                'from' => [
                    'email' => $this->serviceConfig->getFromAddress(),
                ],
                'template_id' => $this->serviceConfig->getTemplate($template)
            ])
        ]);
    }

    public function onProfileModerated(ProfileModerated $event)
    {
        switch($event->getModStatus()) {
            case Profile::MOD_APPROVED:
                $this->sendApprovedTemplate($event->getEmail(), $event->getUuid());
                break;
            case Profile::MOD_DENIED:
                $this->sendDeniedTemplate($event->getEmail());
                break;
        }
    }

}