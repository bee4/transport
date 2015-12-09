Feature: Ssh/Head
  In order to use SSH HEAD requests
  As a developper
  I need to be sure that message is handled properly

  Scenario: Try to HEAD on valid URL
    Given I make a "HEAD" request to "/"
    Then  I should got a status of "0"
    And   I should have an empty body
