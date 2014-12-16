#!/usr/bin/env sh
SRC_DIR="`pwd`"
cd "`dirname "$0"`"
cd "../enlitepro/zf2-scaffold/bin"
BIN_TARGET="`pwd`/scaffold.php"
cd "$SRC_DIR"
"$BIN_TARGET" "$@"
