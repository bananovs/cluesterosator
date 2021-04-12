# cluesterosator
docker build -t clusters .

docker run -it -d -p 2113:8000 --name cluesters clusters:latest
