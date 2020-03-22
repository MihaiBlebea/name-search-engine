FROM nginx:latest

RUN rm /etc/nginx/conf.d/default.conf

RUN apt-get update 

RUN apt-get install curl -y

COPY site.conf ./etc/nginx/conf.d/default.conf