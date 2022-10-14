#!/bin/bash

    ipOLT="$1"
    userOLT="$2"
    passOLT="$3"
	slotOLT="$4"
	ponOLT="$5"
	serialONU="$6"
	lineProfileID="$7"
	srvProfileID="$8"
	descricaoONU="$9"
	

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
    echo "interface gpon 0/$4"
    sleep 0.2
	echo "ont add $5 sn-auth $6 omci ont-lineprofile-id $7 ont-srvprofile-id $8 desc $9"
    sleep 9.2
	echo ""
	sleep 0.2
    echo "quit"
	sleep 0.2
	echo "quit"
	sleep 0.2
    echo "quit"
	sleep 0.2
	echo "y"
	sleep 0.1
	) | telnet