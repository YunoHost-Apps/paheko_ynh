#!/bin/bash

# Ending the migration process from Gogs to Gitea

set -u

#=================================================
# IMPORT GENERIC HELPERS
#=================================================

source /usr/share/yunohost/helpers

#=================================================
# SET VARIABLES
#=================================================

old_app="__OLD_APP__"
new_app="__NEW_APP__"
script_name="$0"

#=================================================
# DELETE OLD APP'S SETTINGS
#=================================================

# `app=""` Circumvents this issue: https://github.com/YunoHost/issues/issues/2138
app="" ynh_secure_remove --file="/etc/yunohost/apps/$old_app"

yunohost app ssowatconf


#=================================================
# REMOVE THE OLD USER
#=================================================
ynh_user_exists --username=$old_app && ynh_system_user_delete $old_app

#=================================================
# DELETE THIS SCRIPT
#=================================================

echo "rm $script_name" | at now + 1 minutes
