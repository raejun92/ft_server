openssl req -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=KR/ST=Seoul/L=Seoul/ O=42Seoul/OU=Lee/CN=localhost" -keyout localhost.dev.key -out localhost.dev.crt
mv localhost.dev.crt etc/ssl/certs/
mv localhost.dev.key etc/ssl/private/
chmod 600 etc/ssl/certs/localhost.dev.crt etc/ssl/private/localhost.dev.key
# 인증서

# cp /tmp/default /etc/nginx/sites-available/
# nginx에 ssl, 리다이렉트, 오토인덱스, php-fpm 추가

wget https://files.phpmyadmin.net/phpMyAdmin/5.0.2/phpMyAdmin-5.0.2-all-languages.tar.gz
tar -xvf phpMyAdmin-5.0.2-all-languages.tar.gz
mv phpMyAdmin-5.0.2-all-languages phpmyadmin
mv phpmyadmin /var/www/html/
# phpmyadmin 설치

cp /tmp/config.inc.php /var/www/html/phpmyadmin/
# phpmyadmin 설정

# mysqladmin -u root -p password
# 비밀번호 설정이 안 됨

service mysql start
echo "CREATE DATABASE wordpress;" | mysql -u root --skip-password
echo "CREATE USER 'juchoi'@'localhost' IDENTIFIED BY 'juchoi';" | mysql -u root --skip-password
echo "GRANT ALL PRIVILEGES ON wordpress.* TO 'juchoi'@'localhost' WITH GRANT OPTION;" | mysql -u root --skip-password
# wordpress DB 테이블 생성

wget https://wordpress.org/latest.tar.gz
tar -xvf latest.tar.gz
mv wordpress/ var/www/html/
chown -R www-data:www-data /var/www/html/wordpress
# wordpress 설치

cp -rp ./tmp/wp-config.php /var/www/html/wordpress
# wordpress 설정

service nginx start
service php7.3-fpm start
service mysql restart
bash