# Prerequirements

This setup uses docker to spin up php 7.3 container

Requirements:

- [Docker + docker-compose installed](https://docs.docker.com/install/)

## Setting up

### 1. Building the app

This step will:

- build images for php container
- install dependencies for the PHP app

Execute:

```bash
./run.sh install
```

### 2. Running the app

Execute:

```bash
./run.sh dev
```

# About

This repository contains solutions for technical tasks for Awin interview.

## Why PHP?

This test is for a PHP heavy engineer position, thus PHP was chosen for the solution

## Why Lumen?
- It's been a while since I used Symfony. Apologies but I found it difficult to find time to refresh my knowledge about it. I stuck with something I was comfortable with.
- Laravel introduces too much overhead for such a small application. Which is why I chose Lumen as it's significantly smaller than Laravel (performance overhead, cognitive overhead), uses Laravel components - mainly the console components which help out a ton with the tasks presented. It's similar story back in the day with Symfony microkernel
- If I didn't use pre-existing frameworks I would have to handle CLI input myself or through the usage of another library. Lumen does not have much of an overhead in comparison to such libraries at the same time saving me time; thus the choice. Also, I don't believe building CLI framework was the goal of this task 

## Running the command
Make sure the docker container is running, then simply:

1. SSH into the container
```
docker exec -it awin-service /bin/bash
```
2. Execute the command
```
php artisan merchant:transaction_report 2
```

## Running the Tests
Make sure the docker container is running, then simply:

1. SSH into the container
```
docker exec -it awin-service /bin/bash
```
2. Execute the command
```
./vendor/bin/phpunit
```