#!/usr/bin/env bash

sed -i "s|/list/mail/|/plugins/vestacp-mail-list/|" /usr/local/vesta/web/templates/admin/panel.html
sed -i "s|/list/mail/|/plugins/vestacp-mail-list/|" /usr/local/vesta/web/templates/user/panel.html
