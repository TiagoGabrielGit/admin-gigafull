#!/bin/bash

    ipOLT="$1"
    userOLT="$2"
    passOLT="$3"
	CVLAN="$4"
	slotOLT="$5"
	ponOLT="$6"
	idONU="$7"
	gemport="$8"
	SVLAN="$9"
	GEMPORT="${10}"

	(echo open "$1"
	sleep 1
	echo "$2"
	sleep 1
	echo "$3"
	sleep 1
    echo "enable"
	sleep 0.2
    echo "scroll 512"
    sleep 0.2
	echo "config"
    sleep 0.2
	echo "service-port vlan $4 gpon 0/$5/$6 ont $7 gemport ${10} multi-service user-vlan $9"
	sleep 0.5
	echo ""
	sleep 0.2
	echo "quit"
	sleep 0.2
    echo "quit"
	sleep 0.2
	echo "y"
	sleep 0.1
	) | telnet