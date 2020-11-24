#!/bin/sh

### Bloquage des noms de fichiers non ascii

# Désactive le verificateur de shell pour la commande ci-dessous
# shellcheck disable=SC2046
if [ $(git diff --cached --name-only --diff-filter=A -z HEAD | LC_ALL=C tr -d '[ -~]\0' | wc -c) != 0 ]; then
  cat <<\EOF
Error: Attempt to add a non-ASCII file name.
This is banned in this project...
EOF
  exit 1
fi
