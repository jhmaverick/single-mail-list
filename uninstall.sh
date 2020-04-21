#!/usr/bin/env bash

sed -i "s|/plugins/vestacp-mail-list/|/list/mail/|" /usr/local/vesta/web/templates/admin/panel.html
sed -i "s|/plugins/vestacp-mail-list/|/list/mail/|" /usr/local/vesta/web/templates/user/panel.html
