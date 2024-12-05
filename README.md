\*\* setup

1. add to composer.json
2. add env variables to src/app/etc/env.php
    - CONNECTSTUFF_KEY = the key for the connectstuff afas connector
    - CONNECTSTUFF_URL = the url to the connectstuff afas connector

\*\* development
A docker magento environment may be setup for testing purposes

1. install from https://github.com/markshust/docker-magento
    - the magento install location should be on the same level as the plugins parent folder and should be called m2
    - if the parent folder is called 'dev' then the plugin should be contained in 'dev/plugin' and magento in 'dev/m2'
2. add the environment variables mentioned in the setup to the src/app/etc/env.php file
3. make some changes
4. update the plugin in the magento instance using 'npm run plugin:update'
