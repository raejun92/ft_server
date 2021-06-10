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

이미지 생성
```
docker build . -t ft_server
```

파일 실행
```
docker run -it -p 80:80 -p 443:443 ft_server
```