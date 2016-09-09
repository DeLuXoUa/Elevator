Welcome!<br>
If you see this, you web server work not correct.<br>
First you need get rights to write folder 'tmp' on root of project; Easy way is 'chmod 777 ./tmp' from you console.
Please edit your web server config, and change root directory to /path/you/server/elevator/www.<br>
Add www on end of line server root.<br><br><br>
Nginx config sample:<br>


server {<br><br>

server_name elevator.lc<br><br>
root /var/www/elevator/wwws;<br><br>
rewrite ^/(.*)/$ /$1 permanent;<br>
index index.html index.htm index.php;<br><br>
location ~ \.php$ {<br>
try_files $uri = 404;<br>
include fastcgi_params;<br>
fastcgi_pass   127.0.0.1:9000;<br>
fastcgi_index index.php;<br>
fastcgi_split_path_info ^(.+\.php)(.*)$;<br>
fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;<br>
fastcgi_ignore_client_abort on;<br>
}<br><br>

location / {<br>
 try_files $uri $uri/ /index.php;<br>
}<br><br>

}