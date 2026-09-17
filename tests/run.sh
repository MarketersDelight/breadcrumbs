#!/bin/sh
# Run Breadcrumbs tests against the sibling Marketers Delight theme checkout.

set -e
cd "$(dirname "$0")/.."

theme="$(cd ../../themes/marketers-delight 2>/dev/null && pwd)" || {
	echo 'Breadcrumbs tests require a sibling Marketers Delight theme checkout.' >&2
	exit 1
}

php "$theme/tests/bin/phpunit.phar" -c phpunit.xml "$@"
