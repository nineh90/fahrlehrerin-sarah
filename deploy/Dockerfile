# Laufzeitumgebung für fahrlehrerinsarah.de
#
# Bewusst schlank: Das Projekt ist reines PHP ohne Composer und ohne
# Build-Schritt. Deshalb enthält das Image NUR die Serverkonfiguration – der
# Anwendungscode wird zur Laufzeit hineingehängt (siehe docker-compose.yml).
# Ein "git pull" auf dem Server ist damit schon der komplette Deploy, es muss
# kein Image neu gebaut werden.
FROM php:8.3-apache

# mod_rewrite für den Front Controller (public/.htaccess),
# mod_headers für die Sicherheitskopfzeilen weiter unten.
RUN a2enmod rewrite headers

# Docroot ist public/. Alles darüber – app/, storage/, .env – liegt damit
# außerhalb der Reichweite des Webservers und ist nicht abrufbar.
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
 && printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/z-docroot.conf \
 && a2enconf z-docroot

# Produktionsvorlage der php.ini: display_errors aus, sinnvolle Grenzwerte.
# Die App entscheidet über APP_DEBUG selbst noch einmal, das hier ist der
# Fallback, falls die .env fehlt.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Ein paar Kopfzeilen, die nichts kosten und Angriffsfläche wegnehmen.
RUN printf 'ServerTokens Prod\n\
ServerSignature Off\n\
Header always set X-Content-Type-Options "nosniff"\n\
Header always set X-Frame-Options "SAMEORIGIN"\n\
Header always set Referrer-Policy "strict-origin-when-cross-origin"\n' \
    > /etc/apache2/conf-available/z-haerten.conf \
 && a2enconf z-haerten
