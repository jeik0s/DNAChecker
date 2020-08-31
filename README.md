Run python docker:
docker run -it --rm --name my-running-script -v "$PWD":/usr/src/myapp -w /usr/src/myapp python:3 python runDNA.py


Run PHP server:
docker run -it --rm --name ProjektAI -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.4-cli php index.php
