<?php
/**
 *
 * php artisan make:migration create_table_pages --create=pages
 * php artisan make:migration create_table_servises --create=services
 * php artisan make:migration create_table_peoples --create=peoples
 * php artisan make:migration create_table_portfolios --create=portfolios
 *
 * если на такую команду - дает ошибку типа:
 *
 * [ErrorException]
 * include(D:\OpenServer\domains\land54.loc\vendor\composer/../../database/migrations/2017_03_31_071957_create_table_
 * services.php): failed to open stream: No such file or directory
 *
 * эначит миграция с таким именем уже была создана и удалена. Ларик где-то это запомнил,
 * и теперь быкует. Нада чуть изменить имя миграции, а --create=[табл. с нужнным именем]
 *
 */