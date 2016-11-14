#!/bin/bash
# deploy files on apache2 webserver



if [ "$1" = "" ] || [ "$1" = "local" ]
then
	cp -R ~/Develop/Kettu/gentics/src/* /var/www/html/gentics/
fi

if [ "$1" == "uber" ]
then
	scp -r ~/Develop/Kettu/gentics/src/* kettu@bellatrix.uberspace.de:/home/kettu/html/linksearch/
fi
