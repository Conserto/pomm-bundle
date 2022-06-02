Feature: Ping

  Scenario:
    When I am on "/app_dev.php/ping"
    Then the response status code should be 200
    And print last response
    And I should see "PING"