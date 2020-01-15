#!/bin/bash
if [ "$1" == "install" ]; then
    printf "\e[1;33;4;44mBuilding images & installing dependencies\e[0m\n"
    docker-compose -f docker-compose.builder.yml build
    docker-compose -f docker-compose.builder.yml up
    exit 0
fi

if [ "$1" == "dev" ]; then
    printf "\e[1;33;4;44mRunning local dev containers\e[0m\n"
    docker-compose up
    exit 0
fi

printf "\e[\e[101mCommand not recognised. Allowed commands: install, dev\e[0m\n"
exit 1
