<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class MailService extends Client
{

    private $listId;

    public function __construct($listId, array $config = [])
    {
        parent::__construct($config);
        $this->listId = $listId;
    }

    public function subscribeUser($email)
    {
        try {
            $this->post(sprintf('lists/%s/members', $this->listId), [
                'body' => json_encode([
                    'status' => 'subscribed',
                    'email_address' => $email
                ])
            ]);
        } catch(RequestException $e) {
            if($e->getResponse()->getStatusCode() === Response::HTTP_BAD_REQUEST) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                if(array_key_exists('title', $response) && strtolower($response['title']) == 'member exists') {
                    return; // fail silently, member already exists but the PUT call mailchimp suggests does not seem to exist
                }
            }
            throw $e;
        }
    }

}