<?php

namespace App\Service;

use App\Entity\Profile;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class MailService extends Client
{

    const TAG_APPROVED = 'photo_approved';
    const TAG_DENIED = 'photo_denied';

    private $listId;

    public function __construct($listId, array $config = [])
    {
        parent::__construct($config);
        $this->listId = $listId;
    }

    public function subscribeUser(Profile $profile)
    {
        $this->updateUser($profile->getEmail(), ['status' => 'subscribed']);
    }

    public function updateTag(Profile $profile, $tag)
    {
        $this->updateUser($profile->getEmail(), [
            'merge_fields' => [
                'UUID' => $profile->getUuid()
            ]
        ]);
        try {
            $this->post(sprintf('lists/%s/members/%s/tags', $this->listId, md5(strtolower($profile->getEmail()))), [
                'body' => json_encode([
                    'tags' => [
                        [
                            'name' => $tag,
                            'status' => 'active'
                        ]
                    ]
                ])
            ]);
        } catch(RequestException $e) {
            var_dump($e->getMessage());exit;
        }
    }

    public function updateUser($email, $fields = [])
    {
        try {
            $this->put(sprintf('lists/%s/members/%s', $this->listId, md5(strtolower($email))), [
                'body' => json_encode(array_merge([
                    'email_address' => $email
                ], $fields))
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