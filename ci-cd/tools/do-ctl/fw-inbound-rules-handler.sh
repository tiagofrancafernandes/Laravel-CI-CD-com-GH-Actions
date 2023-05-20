#!/bin/bash

###########################################
### Tiago França <tiagofranca.com>       ##
### 2023-05-20                           ##
###########################################

DO_FIREWALL_ID=${DO_FIREWALL_ID}

if [ -z ${DO_FIREWALL_ID} ]; then
    echo -e "Env 'DO_FIREWALL_ID' not found!"
    exit 100;
fi

ACTION=$1
ACTION=$(echo "${ACTION}" | tr -d ' ')

# Declare an indexed array
ACTIONS=(add remove)

if [[ " ${ACTIONS[@]} " =~ " ${ACTION} " ]]; then
    echo -e ""
else
    echo -e ""
    echo -e "Action must be 'add' or 'remove'";
    echo -e ""
    exit 145
fi

if [ ! -n "${ACTION}" ]; then
    echo -e ""
    echo -e "Action must be 'add' or 'remove'";
    echo -e ""

    exit 150;
fi

SCRIPT_DIR=$(dirname $(readlink -f "$0"))

DOCTL_SCRIPT="${SCRIPT_DIR}/doctl.sh"

if [ ! -f ${DOCTL_SCRIPT} ]; then
    echo -e ""
    echo -e "Error: 'doctl.sh' not found!"
    echo -e ""

    exit 230;
fi

RUNNER_IP_FILE="${SCRIPT_DIR}/../network/runner-ip.sh"

if [ ! -f ${RUNNER_IP_FILE} ]; then
    echo -e ""
    echo -e "Error: 'runner-ip.sh' not found!"
    echo -e ""

    exit 300;
fi

IP_ADDRESS=${IP_ADDRESS:-$(bash "${RUNNER_IP_FILE}")}

IP_ADDRESS=$(echo "${IP_ADDRESS}" | tr -d ' ')

if [ -z ${DO_FIREWALL_ID} ]; then
    echo -e "Env 'DO_FIREWALL_ID' not found!"
    exit 100;
fi

if [ ! -n "${IP_ADDRESS}" ]; then
    echo -e ""
    echo -e "Env 'DO_FIREWALL_ID' not found or invalid!"
    echo -e ""
    exit 405;
fi

### RUN...

echo -e "";

if [ ${ACTION} = 'add' ]; then
    echo -e "Adding ${IP_ADDRESS} to inbound rules";

    bash "${DOCTL_SCRIPT}" compute firewall add-rules ${DO_FIREWALL_ID} --inbound-rules "protocol:TCP,ports:22,address:${IP_ADDRESS}"
else
    echo -e "Removing ${IP_ADDRESS} from inbound rules";

    bash "${DOCTL_SCRIPT}" compute firewall remove-rules ${DO_FIREWALL_ID} --inbound-rules "protocol:TCP,ports:22,address:${IP_ADDRESS}"
fi

if [ $? -ne 0 ];then
    echo -e ""
    echo -e "Error on ${ACTION} IP ${IP_ADDRESS}"
    exit 878
fi

echo -e "";
