# E2E Tests

End-to-End Tests are done with [TestCafe](https://devexpress.github.io/testcafe/) Framework.


## TODO

- [ ] [Page Object](https://martinfowler.com/bliki/PageObject.html) for the application, [see here too](https://devexpress.github.io/testcafe/documentation/recipes/using-page-model.html)
- [ ] how to reset the database?
    - test-hook to reset db before each test, maybe with a SQL script 
    - setup database (e.g.`bildergalerie_e2e_test`) for test only?
    - detect that php run in test env, [something like "Beispiel #4"](http://php.net/manual/de/features.commandline.webserver.php), switch to test configuration?
- [ ] run tests on windows, create `run.bat`
- [ ] create test reports

## Requirements
- Node.js (tested with 8.x LTS)
- TestCafe (`npm install -g testcafe`)

## Automated Test Run (Linux)

Use the command `./run.sh` to execute the e2e tests. The script perform the following steps:
1. startup the php server locally
2. run the e2e tests
3. shutdown the php server

## Manual Run Tests

    // run tests with chrome browser
    testcafe chrome test/**/*.test.js
    
    // run tests with all installed browsers
    testcafe all test/**/*.test.js
    
    // cool: run tests on remote device
    testcafe remote test/**/*.test.js
    
    // cool, too: run tests on chrome headless
    testcafe "chrome:headless" test/**/*.test.js
    
