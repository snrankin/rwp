#!/usr/bin/env node

BB_TOKEN=$(curl -s -X POST -u "YNmntDzYKS9rGXXxDy:aZAFsPPQBYcSFACtCV5MSk7bbTxrDhXd" https://bitbucket.org/site/oauth2/access_token -d grant_type=client_credentials -d scopes="repository" | jq --raw-output '.access_token')

echo $BB_TOKEN &&
	npx semantic-release --debug
