FROM nginx:1.17.2

RUN rm -rf /etc/nginx/conf.d/default.conf

COPY ./site.conf /etc/nginx/conf.d/site.conf

WORKDIR /app