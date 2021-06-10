FROM	debian:buster
# 베이스 이미지 생성

RUN		apt-get -y update && apt-get -y install nginx openssl php-fpm mariadb-server php-mysql wget
# 새 이미지 레이어를 만들어 내 명령을 실행하고 결과를 커밋

ADD		srcs /.

EXPOSE	80 433

#CMD		bash run.sh