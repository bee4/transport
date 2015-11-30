Feature: Ssh/Get
  In order to use SSH GET requests
  As a developper
  I need to be sure that message is handled properly

  Scenario: Try to DELETE on invalid URL
    Given I make a "DELETE" request to "/fichier.txt"
    Then I should got a status of "0"
    And  I should got an exception "Bee4\Transport\Exception\CurlException"

  Scenario: Try to DELETE on valid URL
    Given I make a "PUT" request to "/fichier.txt" with "content"
    And   I make a "DELETE" request to "/fichier.txt"
    Then I should got a status different than "0"
