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
## DO_ACCESS_TOKEN=dop_v1_mytokenhere bash${SCRIPT_DIR}/doctl.sh account get
#############################################################################################

SCRIPT_DIR=$(dirname $(readlink -f "$0"));

cd "${SCRIPT_DIR}"

if [ ! -f ${SCRIPT_DIR}/doctl ]; then
    wget -c "https://github.com/digitalocean/doctl/releases/download/v${DOCTL_VERSION}/doctl-${DOCTL_VERSION}-linux-amd64.tar.gz" -O "${SCRIPT_DIR}/doctl-${DOCTL_VERSION}-linux-amd64.tar.gz" > /dev/null 2>&1;

    if [ $? -ne 0 ]; then
        echo -e ""
        echo -e "Fail on download DOCTL file!";
        echo -e ""
    fi

    tar xf "${SCRIPT_DIR}/doctl-${DOCTL_VERSION}-linux-amd64.tar.gz"> /dev/null 2>&1;

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

if [ -f "${SCRIPT_DIR}/doctl" ]; then
    chmod +x ${SCRIPT_DIR}/doctl

    ${SCRIPT_DIR}/doctl --access-token ${DO_ACCESS_TOKEN} ${@}
else
    echo -e "'doctl' not found!"
    exit 120;
fi
