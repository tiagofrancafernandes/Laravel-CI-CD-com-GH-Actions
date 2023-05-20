ARG VARIANT="mainline-alpine-slim"
ARG ALPINE_PASSWD="123"

FROM nginx:${VARIANT}

## separate with space, like "nano zsh"
ARG APK_PACKAGES="nano"

ARG INSTALL_ZSH="true"

ARG USERNAME=vscode

# # RUN() { $@; }

RUN apk --no-cache add php81-fpm \
php81-bcmath \
php81-bz2 \
php81-cli \
php81-common \
php81-curl \
php81-dev \
php81-gd \
php81-gmp \
php81-imap \
php81-mbstring \
php81-opcache \
php81-mongodb \
php81-pgsql \
php81-pdo_pgsql \
php81-pdo_sqlite \
php81-mysqli \
php81-mysqlnd \
php81-sqlite3 \
php81-pecl-yaml \
php81-xml \
php81-zip \
php81-dom \
php81-intl \
php81-cli \
php81-xdebug \
php81-redis \
php81-pecl-uuid \
php81-gmp \
php81-imap \
php81-simplexml \
php81-sockets \
php81-openssl \
php81-pecl-lzf \
php81-doc \
php81-pecl-memcached \
php81-pecl-xdebug \
php81-pecl-mongodb \
php81-pecl-memcache \
php81-pecl-redis \
php81-pecl-swoole \
php81-fileinfo \
php81-xmlwriter \
php81-tokenizer \
php81-phar \
composer \
composer-zsh-completion \
openssh \
zip \
unzip \
openssl \
sqlite \
bash \
wget \
curl \
git \
zsh \
nano \
util-linux \
shadow \
hstr

RUN apk --no-cache add nano ${APK_PACKAGES}

# RUN echo -e "${ALPINE_PASSWD}\n${ALPINE_PASSWD}" | passwd root
# RUN echo -e "${ALPINE_PASSWD}" | chsh -s root /bin/zsh

### BEGIN of ZSH and OHMYZSH
RUN echo -e "123\n123" | passwd root
RUN echo -e "123" | chsh -s $(which zsh) root

RUN if [ -d "${HOME}/.oh-my-zsh" ]; then rm -rf "${HOME}/.oh-my-zsh"; fi

RUN if [ -f "${HOME}/.zshrc" ]; then rm -f "${HOME}/.zshrc"; fi

RUN touch "${HOME}/.bash_history"
RUN touch "${HOME}/.zsh_history"

RUN curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh | sh -

RUN git clone https://github.com/zsh-users/zsh-autosuggestions.git "${HOME}/.oh-my-zsh/custom/plugins/zsh-autosuggestions"
RUN echo 'source $HOME/.oh-my-zsh/custom/plugins/zsh-autosuggestions/zsh-autosuggestions.zsh' >> ~/.zshrc

RUN echo HIST_STAMPS="yyyy-mm-dd" >> ~/.zshrc
RUN echo "setopt HIST_EXPIRE_DUPS_FIRST" >> ~/.zshrc
RUN echo "setopt HIST_IGNORE_DUPS" >> ~/.zshrc
RUN echo "setopt HIST_IGNORE_ALL_DUPS" >> ~/.zshrc
RUN echo "setopt HIST_IGNORE_SPACE" >> ~/.zshrc
RUN echo "setopt HIST_FIND_NO_DUPS" >> ~/.zshrc
RUN echo "setopt HIST_SAVE_NO_DUPS" >> ~/.zshrc

RUN echo "alias ls='ls --color=auto'" >> ~/.zshrc
RUN echo "alias las='ls -lahS'" >> ~/.zshrc
RUN echo "alias apk='apk --no-cache'" >> ~/.zshrc

RUN hstr --show-zsh-configuration >> ~/.zshrc
### END of ZSH and OHMYZSH

RUN rm -rf /var/cache/apk/*
