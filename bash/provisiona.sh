#!/bin/bash

    variavel1="$1"
    variavel2="$2"
    variavel3="$3"


	(echo open "10.20.20.38"
	sleep 3
	echo "tiago.gabriel"
	sleep 3
	echo "cxmh2g8034"
	sleep 3
    echo "enable"
	sleep 0.2
    echo "scroll 512"
    sleep 0.2
	echo "config"
    sleep 2
    echo "interface gpon 0/1"
    sleep 2
    echo "display ont optical-info 1 1"
    sleep 2
    echo "quit"
	sleep 0.2
	echo "quit"
	sleep 0.2
    echo "quit"
	sleep 0.2
	echo "y"
	sleep 0.1
	) | telnet