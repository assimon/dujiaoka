## 先覆盖旧的.env
cp .env data/dujiaoka/.env

docker-compose --env-file .env.docker restart web

docker exec dujiaoka php artisan config:clear


## 重启
1. 重启所有服务（推荐）：
docker-compose --env-file .env.docker restart

2. 只重启 web 应用容器：
docker-compose --env-file .env.docker restart web

3. 如果需要重新加载配置并重建：
docker-compose --env-file .env.docker down
docker-compose --env-file .env.docker up -d

4. 查看容器状态：
docker-compose --env-file .env.docker ps

5. 查看日志（确认配置是否生效）：
docker-compose --env-file .env.docker logs -f web

注意：
- 因为 docker-compose.yml 中将 .env 文件挂载到了容器内（第 10 行），重启容器后新配置会自动生效
- 如果修改了数据库连接等关键配置，建议使用方法 3 完全重启服务

你想重启服务吗？我可以帮你执行命令。


## 清除缓存
docker exec -it dujiaoka php artisan config:clear && \
docker exec -it dujiaoka php artisan cache:clear && \
docker exec -it dujiaoka php artisan view:clear && \
docker exec -it dujiaoka php artisan route:clear
