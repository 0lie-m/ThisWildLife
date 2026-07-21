#!/bin/bash

set -euo pipefail

REPO_ROOT="$(
  cd "$(dirname "${BASH_SOURCE[0]}")/.."
  pwd
)"

cd "$REPO_ROOT"

BRANCH=$(/usr/bin/git branch --show-current)

case "$BRANCH" in
  dev)
    TARGET="$HOME/public_html/staging/9632/wp-content"
    ENVIRONMENT="staging"
    ;;

  main)
    TARGET="$HOME/public_html/wp-content"
    ENVIRONMENT="production"
    ;;

  *)
    echo "Deployment stopped: branch '$BRANCH' is not deployable."
    exit 1
    ;;
esac

if [ ! -d "$TARGET" ]; then
  echo "Deployment stopped: target directory does not exist: $TARGET"
  exit 1
fi

/bin/mkdir -p "$TARGET/themes/thiswildlife-theme"
/bin/cp -R \
  "$REPO_ROOT/theme/thiswildlife-theme/." \
  "$TARGET/themes/thiswildlife-theme/"

/bin/mkdir -p "$TARGET/plugins/thiswildlife-core"
/bin/cp -R \
  "$REPO_ROOT/plugins/thiswildlife-core/." \
  "$TARGET/plugins/thiswildlife-core/"

echo "Successfully deployed branch '$BRANCH' to $ENVIRONMENT."