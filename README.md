# Tms-Task模块

##配置说明

1、需要先配置config/ding.php，否则无法收到钉钉通知

2、执行`php artisan vendor:pushlish` 选中`tms-task-config`以及`tms-task-migrations`

3、执行`php artisan vendor:migrate`

4、crontab 添加 `php artisan tms:task:execute` 每分钟执行一次