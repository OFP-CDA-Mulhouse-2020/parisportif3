#!/usr/bin/env sh

ln -sf "${PWD}/../setup-hooks/pre-commit.sh" "${PWD}/../.git/hooks/pre-commit"
chmod 744 "${PWD}/../.git/hooks/pre-commit"
