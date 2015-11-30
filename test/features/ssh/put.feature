Feature: Ssh/Put
  In order to use SSH PUT requests
  As a developper
  I need to be sure that message is handled properly

  Scenario: Try to PUT on valid URL
    Given I make a "PUT" request to "/file.txt" with "content"
    Then I should got a status of "0"
    And  I make a "GET" request to "/file.txt"
    And  I should have a body of "content"
