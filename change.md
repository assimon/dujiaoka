  如果将来修改代码后需要重启，可以使用：

  # 停止旧服务
  lsof -ti:8000 | xargs kill -9

  # 清除缓存
  php artisan optimize:clear

  # 重启服务
  php artisan serve --port=8000

  现在试试创建推广码吧！
