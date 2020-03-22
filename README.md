# Name search engine

## How to run locally?

First of all let's talk about requirements (yes, then are some basic ones :) 
    - [ ] Have `composer` installed locally. We are not going to run composer in docker, are we? Of course not.
    - [ ] Have `docker` installed... 
    - [ ] Have port `8080` clear on the host
    - [ ] Run this on a Mac for maximum effect

Now if all the above are checked (hope I didn't miss anything lol), then just navigate to the root folder of this project and run:
 - `bash up.sh`

There is also a simple command to destroy everything, you guessed it, it's `bash down.sh`.
What I like to do is chain these 2 together to always have a fresh environment. Try this: `bash down.sh && bash up.sh`

Now sit tight, have a coffee and let it build the containers. Don't worry about which port do you need to open in the browser, I will do that for you once everything is ready.


## How does it work?
- Open the browser and type a name in the input box.
- A request is made to the backend with terms and dupes (defaults to false).
- We will first look into the cache to see if there are any saved results based on your search, if not, then we go to the db and look there. 
- If at least one name is found in the db, then it will be cached in Redis for later uses. Sharing is caring right?
- A list of names will be returned to you in the frontend, ordered and filtered by dupes (true or false, you choose)


## Infrastructure architecture
There are 5 containers running different parts of the application:
- app: the main php app
- nginx: serves the php app
- db: mariadb
- redis: a Redis instance I guess :)
- seeder: a short lived container that has a main function of seeding the db and die. Don't worry if one containers seems to be stopping and restarting. This one depends on the db and we all know how slow is the db to build.


## Software architecture
The main php app is based on a DDD architecture. If you are familliar with it, you will recognize the folder structure:
- Application, holds the services that act as a bridge between the business logic and the router
- Domain, all the models are in here... well, at least 2 of them (that is all)
- Infrastructure, holds the adaptors for the third party packages and servers, here you will find the mysql, redis and the dependency container.

There is also a bootstrap folder that is used to register the dependencies in the dependency container for later use in the app.

The routing is based on the Slim framework as it is light and... not needed anyways :)


## Todo:

- [ ] Add tests, tests and more tests
- [ ] Write a jenkins file for the app microservice that will test, build and deploy the app
- [ ] Create a kubernetes cluster to run the application. 