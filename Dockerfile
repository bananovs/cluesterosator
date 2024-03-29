FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y wget nano nginx php7.2 php7.2-fpm php7.2-intl php7.2-curl php7.2-mbstring php7.2-xml

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#RUN groupadd -g 1000 www-data
#RUN useradd -u 1000 -ms /bin/bash -g www-data www-data

COPY --chown=www-data:www-data ./app /home/www
# COPY ./app /home/www/
WORKDIR /home/www/
RUN chmod 777 -R  data
RUN chown -R www-data:www-data ./data
RUN chown -R www-data:www-data /var

# Copying default Nginx configuration
COPY ./conf/default.conf /etc/nginx/conf.d/default.conf

RUN apt update \
    && apt install -y --no-install-recommends build-essential \
    python3 \
    python3-pip \
    python3-setuptools \
    python3-wheel \
    python3-cffi \
    python3-dev \
    libpq-dev \
    && apt-get upgrade -y \
    && apt-get clean \
    && ln -s /usr/bin/python3 /usr/bin/python \
    && ln -s /usr/bin/pip3 /usr/bin/pip \
    && rm -rf /var/lib/apt/lists/*

ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1
ENV PYTHONIOENCODING=utf-8
ENV LANG=ru_RU.UTF-8

COPY ./app/requirements.txt /home/www/requirements.txt
RUN pip install -r requirements.txt

EXPOSE 8000

ADD entrypoint.sh /root/entrypoint.sh
ENTRYPOINT [ "/bin/bash", "/root/entrypoint.sh" ]

USER root

