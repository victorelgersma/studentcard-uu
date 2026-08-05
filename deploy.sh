#!/usr/bin/env bash
#
# deploy.sh
#
# Deploys the martenitsi order form to the Hetzner host.
#

set -euo pipefail

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &>/dev/null && pwd)"

REMOTE_HOST="hetzner"
REMOTE_DIR="~/html/studentcard"

echo "==> Checking local files..."

FILES=(
    "index.php"
    "send_order.php"
    "composer.json"
    "composer.lock"
    "style.css"
)

for file in "${FILES[@]}"; do
    if [[ ! -f "${SCRIPT_DIR}/${file}" ]]; then
        echo "Error: missing local file: ${SCRIPT_DIR}/${file}" >&2
        exit 1
    fi
done

if [[ ! -d "${SCRIPT_DIR}/vendor" ]]; then
    echo "Error: missing vendor directory. Run composer install first." >&2
    exit 1
fi

echo "==> Ensuring remote directory exists..."
ssh "$REMOTE_HOST" "mkdir -p $REMOTE_DIR"

echo "==> Uploading PHP files..."
rsync -avz --inplace \
    "${SCRIPT_DIR}/index.php" \
    "${SCRIPT_DIR}/send_order.php" \
    "${SCRIPT_DIR}/style.css" \
    "${REMOTE_HOST}:${REMOTE_DIR}/"

echo "==> Uploading Composer files..."
rsync -avz --inplace \
    "${SCRIPT_DIR}/composer.json" \
    "${SCRIPT_DIR}/composer.lock" \
    "${REMOTE_HOST}:${REMOTE_DIR}/"

echo "==> Uploading dependencies..."
rsync -avz --inplace \
    "${SCRIPT_DIR}/vendor/" \
    "${REMOTE_HOST}:${REMOTE_DIR}/vendor/"

echo "==> Deployment complete!"
echo "https://studentcard.vjbe.net"
