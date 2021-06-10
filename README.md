# ft_server
This is a System Administration subject. You will discover Docker and you will set up your first web server.

# 도커 만들기
도커에 데비안 설치
```
docker pull debian:buster
```
- 데비안 이미지 생성

이미지 컨테이너로 실행
```
docker run -it -p 80:80 -p 443:443 debian:buster
```
- -i: 표준 입출력 활성화
- -p: 웹서버의 포트 설정

NGINX 설치
```
apt-get -y update // 최신 목록 받기
apt-get -y install nginx
```

서버 연결 확인
```
service nginx start // 시작
service nginx status // 상태 확인
```

openssl로 self-signed SSL 인증서 발급
```
apt-get -y install openssl vim // vim은 이것저것 수정할 때 사용
openssl req -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=KR/ST=Seoul/L=Seoul/ O=42Seoul/OU=Lee/CN=localhost" -keyout localhost.dev.key -out localhost.dev.crt
mv localhost.dev.crt etc/ssl/certs/
mv localhost.dev.key etc/ssl/private/
chmod 600 etc/ssl/certs/localhost.dev.crt etc/ssl/private/localhost.dev.key
```
- Self-signed 인증서
    - CSR 명시적 생성 -> 인증서에 self-sign -> 인증서 완성
    - CSR을 명시적으로 생성하지 않고, key와 부가정보들을 입력하여 직접 self-sign 하여 인증서 완성

nginx에 SSL 추가하기
```
vim /etc/nginx/sites-available/default

server {
listen 80 default_server; // listen : 서버에서 라우팅 할 특정 port를 정의한다 listen [::]:80 default_server;
// default_server : 여러개의 서버블록을 작성할 때 단 하나의 서버블록에만 존재해야 한다. 별로의 지정하지 않은 도메인으로 들어오는 다른 모든 요청에 대해 해당 블록이 처리함을 의미한다.
}
server {
listen 443;
ssl on;
ssl_certificate /etc/ssl/certs/localhost.dev.crt; ssl_certificate_key /etc/ssl/private/localhost.dev.key;
root /var/www/html;
index index.html index.htm index.nginx-debian.html; ...
}
```
- 위와 같이 파일 수정
- service nginx reload로 수정사항 확인

nginx에 php-fpm 연동
```
apt-get -y install php-fpm

vim /etc/nginx/sites-available/default

location ~ \.php$ // location은 .php확장자로 끝나는 요청을 처리기 위한 부분이다. 
{
include snippets/fastcgi-php.conf;

fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;

}
```
- 위와 같이 주석을 해체하고 php설치한 버전과 일치 시킴
- sites-available: 설정 파일 위치
- sites-enabled: 실행시킬 파일 위치

php-fpm 동작 확인
```
service php7.3-fpm start 동작
service php7.3-fpm status 동작 확인
/var/www/html/ 위치로 가서 phpinfo.php 파일을 만듦

phpinfo.php
<?php phpinfo();?>
```
- service nginx reload 로 수정 사항 적용
- 실패 시 cat /var/log/nginx/error.log 에러 로그 확인
- localhost/phpinfo.php 접속으로 확인

MySQL 설치
```
apt-get -y install mariadb-server php-mysql
apt-get install -y wget

phpmyadmin 설치 및 압축해제
wget https://files.phpmyadmin.net/phpMyAdmin/5.0.2/phpMyAdmin-5.0.2-all- languages.tar.gz
tar -xvf phpMyAdmin-5.0.2-all-languages.tar.gz // 압축 해제
mv phpMyAdmin-5.0.2-all-languages phpmyadmin // phpmyadmin 으로 이름을 바꿈
mv phpmyadmin /var/www/html/ // 위치 이동
```

phpmyadmin 설정
```
cp -rp var/www/html/phpmyadmin/config.sample.inc.php var/www/html/phpmyadmin/ config.inc.php // phpmyadmin/config.sample.inc.php 파일을 복사해 config.inc.php 만듦

vim var/www/html/phpmyadmin/config.inc.php
$cfg['blowfish_secret'] = '이 부분에 넣는다'; /* YOU MUST FILL IN THIS FOR COOKIE AUTH! */
```
- [암호 생성기](https://phpsolved.com/phpmyadmin-blowfish-secret-generator/?g=5cecac771c51c)
- service nginx reload
- service mysql start
- service php7.3-fpm restart 

mysql database 테이블 생성
```
mysql
show databases;
CREATE DATABASE IF NOT EXISTS wordpress;
show databases;
```

mysql 루트와 모든 권한을 가진 사용자
```
루트
mysqladmin -u root -p password
기존 패스워드 없으니 엔터 입력 
새 패스워드 입력
한 번 더 입력

사용자 
mysql
CREATE USER 'juchoi'@'localhost' IDENTIFIED BY 'juchoi';
GRANT ALL PRIVILEGES ON wordpress.* TO 'juchoi'@'localhost' WITH GRANT OPTION;
```

wordpress 설치
```
wget https://wordpress.org/latest.tar.gz
tar -xvf latest.tar.gz
mv wordpress /var/www/html/
chown -R www-data:www-data /var/www/html/wordpress
```

wordpress 설정
```
cp var/www/html/wordpress/wp-config-sample.php var/www/html/wordpress/wp-config.php 
vim var/www/html/wordpress/wp-config.php 

아래 부분을 내용에 맞게 바꿔준다. 

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'yeosong' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
```

# 도커 실행
이미지 생성
```
docker build . -t ft_server
```

파일 실행
```
docker run -it -p 80:80 -p 443:443 ft_server
```