#!/bin/bash

###########################################
### Tiago França <tiagofranca.com>       ##
### 2023-05-20                           ##
###########################################

command_exists() {
    command -v "$1" > /dev/null 2>&1
}

getip() {
    if command_exists curl; then
        curl checkip.amazonaws.com
    elif command_exists wget; then
        echo $(wget -q checkip.amazonaws.com -O -)
    else
        echo "Please install curl or wget"
        exit 1
    fi
}

getip
