Feature: Ssh/Get
  In order to use SSH GET requests
  As a developper
  I need to be sure that message is handled properly

  Scenario: Try to GET on valid URL
    Given I make a "GET" request to "/"
    Then I should got a status of "0"
