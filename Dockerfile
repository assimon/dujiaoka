FROM webdevops/php-nginx:7.4
COPY . /app
WORKDIR /app
RUN [ "sh", "-c", "composer install --ignore-platform-reqs" ]
RUN echo "#!/bin/bash\nphp artisan queue:work >/tmp/work.log 2>&1 &\nsupervisord" > /app/start.sh
RUN [ "sh", "-c", "chmod -R 777 /app" ]
CMD [ "sh", "-c","/app/start.sh" ]
