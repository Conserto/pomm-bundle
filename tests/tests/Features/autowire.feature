Feature: Autowire

  Scenario:
    When I am on "/app_dev.php/get_autowire/test"
    Then the response status code should be 200
    And print last response
    Then I should see "test => value"