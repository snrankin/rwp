#!/bin/bash

sed -i.bak -E "4 s/[0-9]+\.[0-9]+\.[0-9]+/$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH/" package.json &
sed -i.bak -E "7 s/[0-9]+\.[0-9]+\.[0-9]+/$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH/" rwp.php &
sed -i.bak -E "23 s/[0-9]+\.[0-9]+\.[0-9]+/$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH/" rwp.php &
sed -i.bak -E "13 s/[0-9]+\.[0-9]+\.[0-9]+/$VERSION_MAJOR.$VERSION_MINOR.$VERSION_PATCH/" changelog-template.hbs &
find . -type f -name '*.bak' -delete &
find . -type f -name '*.bak' -delete
