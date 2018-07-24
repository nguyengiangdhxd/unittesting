#!/bin/sh

echo "pull the updated code from repo"
git pull origin feature/custom-unittesting

echo "Build the updated file"
sudo docker build -t phpsetup .

echo "Check the existing images"
sudo docker image ls

echo "update docker service"
sudo docker service update apache2 --image phpsetup

echo "Check the existing services"
sudo docker service ls
