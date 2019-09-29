[![Build Status](https://travis-ci.org/sqe-galerie/bildergalerie.svg?branch=develop)](https://travis-ci.org/sqe-galerie/bildergalerie)
[![Coverage](https://sonarcloud.io/api/badges/measure?key=sqe%3Abildergalerie%3Adevelop&metric=coverage#.svg)](https://sonarcloud.io/dashboard?id=sqe%3Abildergalerie%3Adevelop)
 [![Coverage](https://sonarcloud.io/api/badges/measure?key=sqe%3Abildergalerie%3Adevelop&metric=new_coverage#.svg)](https://sonarcloud.io/dashboard?id=sqe%3Abildergalerie%3Adevelop)
 

# Getting started

First install required dependencies with composer:

    php composer.phar install
    
Then setup the database and set the correct parameters in the `.env` file (see [.env.sample](./.env.sample)
for details).

# Project links
* [Backlog](https://github.com/sqe-galerie/bildergalerie/projects/1) - organizes our project TODOs
* [4Minitz](https://4minitz-htw.felixble.de/) - takes care about our meeting minutes
* [Wiki](https://github.com/sqe-galerie/bildergalerie/wiki) - contains our documentation
* [Demo Server](http://demo.hildes-bildergalerie.de/) - shows the `develop` version
* [TravisCI](https://travis-ci.org/sqe-galerie/bildergalerie) - runs tests on each commit and deploys the app to our demo server
* [SonarQube](https://sonarcloud.io/dashboard?id=sqe%3Abildergalerie%3Adevelop) - keeps an eye on our code quality

# Getting started as developer

To run the application you can use [vagrant](https://www.vagrantup.com/) to set up the development environment.
 So first intall vagrant. Then you can start the environment by simply executing the following command
 (in the project root directory):
 
    vagrant up
    
This launches a virtual machine containing all necessary dependencies (nginx web server, mysql database, composer, etc.).
When the VM is running it will automatically sync the complete project folder with the VM's app directory.

After VM has been started you can access the application with your browser at [http://5.5.5.5](http://5.5.5.5).

## Reset local testing environment

If you want to reset your testing environemnt (database / uploads directory) simply execute the `reset-db` npm script:

    npm run reset-db
    
## Auto-Tests and useful scripts

Our test code is placed in the `test` directory. The tests and other useful utitlies can be executes as npm scripts with the `npm run` command. See the [package.json](./package.json#L12) script property for a list of all scripts. If you want to run our end-to-end tests just execute the following script, to give one example:

    npm run test:e2e
