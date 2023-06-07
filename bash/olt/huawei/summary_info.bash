#!/bin/bash

ip="$1"
usuario="$2"
password="$3"
frame="$4"
slot="$5"
pon="$6"

(echo open "$1"
sleep 1
echo "$2"
sleep 1
echo "$3"
sleep 0.5
echo "enable"
sleep 0.2
echo "scroll 512"
sleep 0.2
echo "config"
sleep 0.2
echo "interface gpon $4/$5"
sleep 0.3
echo "display ont info summary $6"
sleep 2
echo ""
sleep 0.3
echo "quit"
sleep 0.3
echo "quit"
sleep 0.3
echo "quit"
sleep 0.3
echo "y"
sleep 0.2
) | telnet