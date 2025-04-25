# Nextcloud Configuration Files

### config.php: Configures Nextcloud with database, Redis, SMTP, S3, and app settings.

### apps.config.php: Defines paths for default (read-only) and custom (writable) apps.

### php.ini: Sets PHP OPcache and session parameters for performance and security.

### s3.config.php: Configures S3 storage with bucket, credentials, and SSL settings.

### smtp.config.php: Sets SMTP email with host, port, and auth from environment variables.

### upgrade-disable-web.config.php: Disables web-based Nextcloud updates for CLI control.

### swift.config.php: Configures Swift object storage with auth and container details.

### redis.config.php: Sets Redis for caching with host, port, and auth settings.

### reverse-proxy.config.php: Configures trusted proxies and URL overrides for proxied requests.

### config.sample.php: Documents Nextcloud settings for reference, not used in production.

### apache-pretty-urls.config.php: Enables clean URLs by setting the Apache RewriteBase.

### apcu.config.php: Configures APCu as the local memory caching backend.

### .htaccess: Restricts access to the directory and disables file indexing for Apache.
