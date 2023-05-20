#!/bin/bash

if [ -f "${HOME}/.bash_history" ]; then
    mv "${HOME}/.bash_history" "${HOME}/.bash_history_old"
fi

if [ -f "${HOME}/.zsh_history" ]; then
    mv "${HOME}/.zsh_history" "${HOME}/.zsh_history_old"
fi

touch ".devcontainer/bash_history"
ln -sf "$(pwd -P)/.devcontainer/bash_history" "${HOME}/.bash_history"
touch ".devcontainer/zsh_history"
ln -sf "$(pwd -P)/.devcontainer/zsh_history" "${HOME}/.zsh_history"

echo -e "---------------------------------------------------------"
echo -e "Begin of psysh intall..."
curl -o /usr/bin/psysh https://psysh.org/psysh > /dev/null 2>&1
chmod +x /usr/bin/psysh
ln -sf /usr/bin/psysh /usr/bin/tinker
/usr/bin/psysh --version
echo -e "Finish of psysh intall..."
echo -e "---------------------------------------------------------"


echo -e "---------------------------------------------------------"
echo -e "Begin of composer v2 intall..."
echo $(date +%Y-%m-%d_%H:%I:%S)
echo -e ""
curl -o /usr/bin/composer https://getcomposer.org/download/latest-2.2.x/composer.phar > /dev/null 2>&1

chmod +x /usr/bin/composer
/usr/bin/composer -V
echo -e "Finish of composer v2 intall..."
echo -e "---------------------------------------------------------"
