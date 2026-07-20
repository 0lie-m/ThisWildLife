#!/bin/bash

set -euo pipefail

REPO_ROOT="$(
  cd "$(dirname "${BASH_SOURCE[0]}")/.."
  pwd
)"

cd "$REPO_ROOT"

CURRENT_COMMIT=$(/usr/bin/git rev-parse HEAD)

/usr/bin/git fetch origin dev --quiet

REMOTE_COMMIT=$(/usr/bin/git rev-parse origin/dev)

if [ "$CURRENT_COMMIT" = "$REMOTE_COMMIT" ]; then
  exit 0
fi

/usr/bin/git merge --ff-only origin/dev

echo "New dev commit detected: $REMOTE_COMMIT"

/usr/local/cpanel/bin/uapi \
  VersionControlDeployment create \
  repository_root="$REPO_ROOT"