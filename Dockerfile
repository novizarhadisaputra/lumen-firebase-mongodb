RUN apt update
RUN apt install php7.3
RUN php -v
RUN apt install nginx
RUN ufw app list
RUN ufw allow 'Nginx HTTP'
RUN ufw status
RUN systemctl status nginx
RUN ip addr show eth0 | grep inet | awk '{ print $2; }' | sed 's/\/.*$//'
# skip step
RUN curl -4 icanhazip.com
RUN systemctl start nginx
RUN mkdir -p /var/www/example.com/
RUN apt install git-all
RUN git --version
RUN cd /var/www/
RUN git pull origin master https://github.com/novizarhadisaputra/lumen-firebase-mongodb.git
RUN cd lumen-firebase-mongodb
RUN composer install
RUN mv public /var/www/example


