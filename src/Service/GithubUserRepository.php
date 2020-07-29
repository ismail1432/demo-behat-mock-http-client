<?php
namespace App\Service;

use App\Entity\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubUserRepository
{
    private $githubClient;

    public function __construct(HttpClientInterface $githubClient)
    {
        $this->githubClient = $githubClient;
    }

    public function findByUsername($username): ?User
    {
        $path = '/users/'.$username;
        $response = $this->githubClient->request('GET', $path)->toArray();

        return User::create($response);
    }
}
