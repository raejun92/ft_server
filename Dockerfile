FROM	debian:buster
# 베이스 이미지 생성

RUN		apt-get -y update 
RUN     apt-get -y install nginx openssl php-fpm mariadb-server php-mysql wget vim
# 새 이미지 레이어를 만들어 내 명령을 실행하고 결과를 커밋

COPY	./srcs/run.sh ./
# COPY	./srcs/default ./tmp
COPY	./srcs/wp-config.php ./tmp
COPY	./srcs/config.inc.php ./tmp

ADD		./srcs/default /etc/nginx/sites-available/
# ADD		./srcs/wp-config.php /var/www/html/wordpress/
# ADD		./srcs/config.inc.php /var/www/html/phpmyadmin/

EXPOSE	80 443
# 포트 설정

CMD		bash run.sh
# 쉘 실행