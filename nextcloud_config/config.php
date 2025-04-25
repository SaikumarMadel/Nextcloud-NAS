<?php
$CONFIG = array (
  'htaccess.RewriteBase' => '/',
  'memcache.local' => '\\OC\\Memcache\\APCu',
  'memcache.locking' => '\\OC\\Memcache\\Redis',
  'memcache.session' => '\\OC\\Memcache\\Redis',
  'redis' => 
  array (
    'host' => 'redis',
    'password' => '',
    'port' => 6379,
  ),
  'apps_paths' => 
  array (
    0 => 
    array (
      'path' => '/var/www/html/apps',
      'url' => '/apps',
      'writable' => false,
    ),
    1 => 
    array (
      'path' => '/var/www/html/custom_apps',
      'url' => '/custom_apps',
      'writable' => true,
    ),
  ),
  'upgrade.disable-web' => true,
  'instanceid' => 'ocgpgmnn2cbe',
  'passwordsalt' => 'SfRjmq0PWLv58kvc5ts9tLWPM8WevZ',
  'secret' => 'abfnJH1XP5ZHzAcjmQISHdwGfjh8HcTIrdXTHS+XeZMNjOsh',
  'trusted_domains' => 
  array (
    0 => 'localhost',
    1 => '100.105.98.104',
    2 => 'mynextcloud2934.ddns.net',
    3 => '192.168.4.17',
    4 => 'localhost:8090',
    5 => '[2409:40c2:1048:66c9:190a:6a43:6b9d:f146]',
    6 => '152.58.33.250',
    7 => 'flash.reverse-elver.ts.net',
  ),
  'trusted_proxies' => 
  array (
    0 => '106.216.247.107',
    1 => '152.58.33.250',
  ),
  'forwarded_for_headers' => 
  array (
    0 => 'HTTP_X_FORWARDED_FOR',
  ),
  'session_lifetime' => '900',
  'session_keepalive' => 'false',
  'auto_logout' => 'true',
  'remember_login_cookie_lifetime' => '0',
  'session_relaxed' => false,
  'csrf.disabled' => false,
  'cookie_lifetime' => 3600,
  'session_refresh_time' => 300,
  'logout_url' => '/index.php/logout?clear=1',
  'allow_local_remote_servers' => true,
  'password_policy' => false,
  'cron' => 'Cron',
  'maintenance_window_start' => 3,
  'default_phone_region' => 'IN',
  'loglevel' => 2,
  'log_rotate_size' => 104857600,
  'datadirectory' => '/var/www/html/data',
  'dbtype' => 'mysql',
  'version' => '30.0.6.2',
  'overwrite.cli.url' => 'https://flash.reverse-elver.ts.net',
  'overwriteprotocol' => 'https',
  'dbname' => 'nextcloud',
  'dbhost' => 'nextcloud-db',
  'dbport' => '',
  'dbtableprefix' => 'oc_',
  'mysql.utf8mb4' => true,
  'dbuser' => 'nextclouduser',
  'dbpassword' => 'securepassword',
  'installed' => true,
  'maintenance' => false,
  'mail_smtpmode' => 'smtp',
  'mail_smtpsecure' => 'tls',
  'mail_smtpauthtype' => 'LOGIN',
  'mail_smtpauth' => 1,
  'mail_smtpport' => '587',
  'mail_smtpname' => 'madelsai2004@gmail.com',
  'mail_smtppassword' => 'semy iupr mfav byxe',
  'mail_from_address' => 'madelsai2004',
  'mail_domain' => 'gmail.com',
  'memcache.distributed' => '\\OC\\Memcache\\Redis',
  'mail_smtphost' => 'smtp.gmail.com',
  'app_configs' => 
  array (
    'files_antivirus' => 
    array (
      'av_mode' => 'daemon',
      'av_host' => 'clamav',
      'av_port' => '3310',
      'av_max_file_size' => 1073741824,
      'av_infected_action' => 'only_log',
    ),
    'richdocuments' => 
    array (
      'wopi_allowlist' => '152.58.30.76,192.168.4.154,172.19.0.1',
      'timeout' => 15,
    ),
  ),
  'bruteforce_protection' => true,
  'app_install_overwrite' => 
  array (
    0 => 'files_external_gdrive',
    1 => 'extract',
  ),
  'defaultapp' => '',
);
