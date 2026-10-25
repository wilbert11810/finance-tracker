# --- PHP runtime ---
FROM php:8.3-apache AS php-base
RUN docker-php-ext-install mysqli \
 && a2enmod rewrite \
 && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# --- Vue build ---
FROM node:20-alpine AS web
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# --- Production image ---
FROM php-base AS prod
ENV PORT=10000
RUN sed -i 's/Listen 80/Listen ${PORT}/; s/:80>/:${PORT}>/' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
COPY --from=web /app/dist/ /var/www/html/
COPY api/ /var/www/html/api/
