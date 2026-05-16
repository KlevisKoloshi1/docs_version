# syntax=docker/dockerfile:1
# Build after the PHP application image: `docker compose -f docker-compose.prod.yml build app`
ARG APP_IMAGE=docs-version-app:latest
FROM ${APP_IMAGE} AS laravel

FROM nginx:1.27-alpine
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=laravel /var/www/html/public /var/www/html/public
