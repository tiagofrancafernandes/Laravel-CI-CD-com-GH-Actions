#!/bin/bash

###########################################
### Tiago França <tiagofranca.com>       ##
### 2023-05-20                           ##
###########################################

DOCTL_VERSION=${DOCTL_VERSION:-1.94.0}

## Doc:
## https://docs.digitalocean.com/reference/doctl/reference/compute/ssh/

#############################################################################################
## :::: DO ACCESS TOKEN ::::
## Doc:
## https://docs.digitalocean.com/reference/api/create-personal-access-token/
## Tokens:
## https://cloud.digitalocean.com/account/api/tokens
##
## Set DO_ACCESS_TOKEN env
## Example:
## export DO_ACCESS_TOKEN=dop_v1_mytokenhere
##
## Or put on runtime example:
## DO_ACCESS_TOKEN=dop_v1_mytokenhere bash ./doctl.sh account get
#############################################################################################

if [ ! -f ./doctl ]; then
    wget -c "https://github.com/digitalocean/doctl/releases/download/v${DOCTL_VERSION}/doctl-${DOCTL_VERSION}-linux-amd64.tar.gz" -O "doctl-${DOCTL_VERSION}-linux-amd64.tar.gz" > /dev/null 2>&1;

    if [ $? -ne 0 ]; then
        echo -e ""
        echo -e "Fail on download DOCTL file!";
        echo -e ""
    fi

    tar xf "doctl-${DOCTL_VERSION}-linux-amd64.tar.gz"> /dev/null 2>&1;

    if [ $? -ne 0 ]; then
        echo -e ""
        echo -e "Fail on extract DOCTL file!";
        echo -e ""
    fi
fi

if [ -z ${DO_ACCESS_TOKEN} ]; then
    echo -e "Env 'DO_ACCESS_TOKEN' not found!"
    exit 100;
fi

if [ -f ./doctl ]; then
    ./doctl --access-token ${DO_ACCESS_TOKEN} ${@}
else
    echo -e "'./doctl' not found!"
    exit 120;
fi
