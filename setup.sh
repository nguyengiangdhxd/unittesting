#!/bin/sh

echo "pull the updated code from repo"
git pull origin develop

echo "git branch"
git branch

echo "Build the updated file"
sudo docker build -t phpsetup .

echo "Check the existing images"
sudo docker image ls

echo "update docker service"
sudo docker service update apache2 --image phpsetup

echo 'Remove existing image'
sudo docker image rm -f phpsetup

echo "Check the existing services"
sudo docker service ls
