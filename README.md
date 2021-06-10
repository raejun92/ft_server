# ft_server
This is a System Administration subject. You will discover Docker and you will set up your first web server.

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

openssl로 self-sined SSL 인증서 발급
```
apt-get -y install openssl vim // vim은 이것저것 수정할 때 사용
openssl req -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=KR/ST=Seoul/L=Seoul/O=42Seoul/OU=Lee/CN=localhost" -keyout localhost.dev.key
mv localhost.dev.crt etc/ssl/certs/
mv localhost.dev.key etc/ssl/private/
chmod 600 etc/ssl/certs/localhost.dev.crt etc/ssl/private/localhost.dev.key
```

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

location ~ \.php$ // location은 .php확장자로 끝나는 요청을 처리기 위한 부분이다. {
}
include snippets/fastcgi-php.conf;
## With php-fpm (or other unix sockets): fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
## With php-cgi (or other tcp sockets): #fastcgi_pass 127.0.0.1:9000;
```
- 위와 같이 주석을 해체하고 php설치한 버전과 일치 시킴
- sites-available: 설정 파일 위치
- sites-enabled: 실행시킬 파일 위치
- service php7.3-fpm start 동작
- service php7.3-fpm status 동작 확인


이미지 생성
```
docker build . -t ft_server
```

파일 실행
```
docker run -it -p 80:80 -p 443:443 ft_server
```