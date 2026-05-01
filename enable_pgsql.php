<?php
$file = 'c:/laragon/bin/php/php-8.3.26-nts-Win32-vs16-x64/php.ini';
$content = file_get_contents($file);
$content = str_replace(';extension=pdo_pgsql', 'extension=pdo_pgsql', $content);
$content = str_replace(';extension=pgsql', 'extension=pgsql', $content);
file_put_contents($file, $content);
echo "Done";
