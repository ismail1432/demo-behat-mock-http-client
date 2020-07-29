<?php
namespace App\Tests\Behat;

use App\Entity\User;
use App\Service\GithubUserRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Webmozart\Assert\Assert;

final class GithubContext implements Context
{
    /** @var GithubUserRepository $githubRepo */
    private $githubRepo;
    /** @var App\Entity\User $user */
    private $user;

    /**
     * @Given The response have the following body:
     */
    public function theResponseHaveTheFollowingBody(TableNode $tableNode)
    {
        $this->githubRepo = new GithubUserRepository(
            new MockHttpClient(
                new MockResponse(json_encode($tableNode->getRowsHash()))
                ,'https://api.github.com')
        );
    }

    /**
     * @When I fetch a user with username :username
     */
    public function iFetchAUserWithUsername(string $username)
    {
        $user = $this->githubRepo->findByUsername($username);

        Assert::notNull($user, sprintf("Unable to fetch a User"));
        $this->user = $user;
    }

    /**
     * @Then I should have an instance of User with id :id and login :login
     */
    public function iShouldHaveAnInstanceOfUserWithIdAndLogin(string $id, string $login)
    {
        Assert::isInstanceOf($this->user, User::class, sprintf("Attempted to have a %s, but got a %s", User::class, get_class($this->user)));
        Assert::eq($this->user->id, $id, sprintf("Wrong value for 'id'"));
        Assert::eq($this->user->login, $login, sprintf("Wrong value for 'login'"));
    }
}
