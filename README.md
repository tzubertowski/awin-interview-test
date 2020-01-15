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
- It's been a while since I used Symfony, due to having issues with having time I stuck to something I am comfortable with right now. I wish I had some time to refresh my knowledge though : )
- Laravel introduces too much overhead for such a small application. Which is why I chose Lumen as it's significantly smaller than Laravel (performance overhead, cognitive overhead), uses Laravel components - mainly the console components which help out a ton with the tasks presented. It's similar story back in the day with Symfony microkernel
- If I didn't use pre-existing frameworks I would have to handle CLI input myself or through the usage of another library. Lumen does not have much of an overhead in comparison to such libraries at the same time saving me time; thus the choice. Also, I don't believe building CLI framework was the goal of this task 

## Running the command
