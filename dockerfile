# docker build -t dr .
# 토대가 되는 이미지를 지정
FROM richarvey/nginx-php-fpm

# 이미지를 빌드할 때 실행할 명령어를 지정
# RUN apt-get update
# RUN apt-get install -y nginx
# RUN apt install -y php-fpm
# RUN apt-get install -y nano

# 이미지에 파일이나 폴더를 복사
COPY . /var/www/html

# RUN, CMD, ENTRYPOINT, ADD, COPY에 정의된 명령어를 실행하는 작업 디렉토리를 지정
# WORKDIR /etc/nginx

# WORKDIR에서 실행할 명령어 지정
# CMD ["service", "php7.4-fpm", "start"]
# CMD ["nginx", "-g", "daemon off;"]

# VOLUME ["D:\PC\project\portfolio\dr"]

# 환경 변수 설정
ENV DB_HOST maria
# ENV DB_PORT 3306
# ENV DB_USER root
# ENV DB_PASSWORD password
# ENV DB_NAME mydatabase

EXPOSE 80