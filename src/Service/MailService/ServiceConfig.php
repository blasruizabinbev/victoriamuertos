<?php

namespace App\Service\MailService;

use Assert\Assert;

class ServiceConfig
{

    const TEMPLATE_APPROVED = 'approved';
    const TEMPLATE_DENIED = 'denied';

    /** @var array */
    private $config;

    public function __construct(array $config) {
        Assert::lazy()
            ->that($config, 'from_address')->keyExists('from_address')
            ->that($config, 'templates')->keyExists('templates')->isArray()
            ->that($config['templates'], self::TEMPLATE_APPROVED)->keyExists(self::TEMPLATE_APPROVED)
            ->that($config['templates'], self::TEMPLATE_DENIED)->keyExists(self::TEMPLATE_DENIED)
            ->verifyNow();

        $this->config = $config;
    }

    public function getFromAddress()
    {
        return $this->config['from_address'];
    }

    public function getTemplate($template)
    {
        Assert::that($this->config['templates'])->keyExists($template);
        return $this->config['templates'][$template];
    }

}