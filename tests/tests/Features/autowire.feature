Feature: Autowire

  Scenario:
    When I am on "/app_dev.php/get_autowire/test"
    And print last response
    Then the response status code should be 200
    Then I should see "test => value"
