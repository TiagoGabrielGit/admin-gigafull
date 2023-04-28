#!/bin/bash

ipOLT="$1"
userOLT="$2"
passOLT="$3"
slotOLT="$4"
ponOLT="$5"
idONU="$6"

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
echo "interface gpon 0/$4"
sleep 0.4
echo "display ont info $5 $6"
sleep 0.4
echo ""
sleep 0.4
echo "display ont optical-info $5 $6"
sleep 0.4
echo ""
sleep 0.4
echo "quit"
sleep 0.4
echo "quit"
sleep 0.2
echo "quit"
sleep 0.2
echo "y"
sleep 0.2
) | telnet