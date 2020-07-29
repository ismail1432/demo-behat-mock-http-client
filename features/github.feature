Feature:
  In order to fetch a User from Github
  As a developer
  I want to have a repository that fetch a User from a username

  Scenario: Fetch a User from Github by a username
    Given The response have the following body:
      | id     | 42     |
      | login  | ismail1432 |
    When I fetch a user with username ismail1432
    Then I should have an instance of User with id 42 and login ismail1432
