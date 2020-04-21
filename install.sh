#!/usr/bin/env bash

PLUGIN_DIR="$(dirname "$(readlink -f "${BASH_SOURCE[0]}")")"

#if [[ ! -L /usr/local/vesta/web/list/mail && ! -d /usr/local/vesta/web/list/mail-original ]]; then
#    mv /usr/local/vesta/web/list/mail /usr/local/vesta/web/list/mail-original
#
#    ln -sf "$PLUGIN_DIR/list" /usr/local/vesta/web/list/mail
#else
#    echo "Could not create link to new mail list"
#    echo "There is already a directory called \"mail-original\" or the \"mail\" directory is already a link"
#fi
