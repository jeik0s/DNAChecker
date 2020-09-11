Run python:
- docker run -it --rm --name my-running-script -v "$PWD":/usr/src/myapp -w /usr/src/myapp python:3 python runDNA.py


Run PHP server:
- docker run -d -p 8888:80 --name ProjektAI -v "$PWD":/var/www/html php:7.2-apache

Open browser:
- localhost:8888


Special Thanks to:
- https://towardsdatascience.com/genetic-algorithm-implementation-in-python-5ab67bb124a6
- https://towardsdatascience.com/a-simple-genetic-algorithm-from-scratch-in-python-4e8c66ac3121
- https://pypi.org/project/geneticalgorithm/
- https://datascienceplus.com/genetic-algorithm-in-machine-learning-using-python/
