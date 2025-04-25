# Nextcloud NAS Project
This repository consists of the Nextcloud based NAS project done during my internship at Defence Institute of Advanced Technology (DIAT), Pune.

# Files & Folders
```
nextcloud_apps - Contains the app data of the applications installed on the server.
nextcloud_config - Contains the configuraton files of the nextcloud server.
nextcloud_data - Contains the database, antivirus, caching and batch files.
docker-compose.yaml - Contains the containers which we are using in Docker.
config.php - Kept a copy of main config.php outside for reference.
php.ini - Kept a copy of main php.ini outside for reference.
run_cron.bat - Batch file used for background tasks of nextcloud used in Windows Task Scheduler
```
## Detailed Readme File

# Nextcloud NAS Setup with Docker, Traefik, Collabora, and Tailscale on Windows

This README provides a concise, user-friendly guide to setting up a Nextcloud-based NAS on a Windows 10/11 system, developed during an internship at DIAT. The setup uses Docker Compose for containerization, Traefik for reverse proxy (partially implemented due to no public IP), Collabora Online for document editing, and Tailscale Funnel for secure remote access. It includes MariaDB for the database, Redis for caching, ClamAV for antivirus scanning, and Nextcloud Talk for team collaboration. The system runs on an Asus TUF F15 laptop (16GB RAM, 512GB storage) with Nextcloud Hub 30.0.6.2. The Nextcloud Docker image includes PHP 8.2 and Apache, so only specific dependencies (e.g., ClamAV, minimal tools) are installed in the container. All commands are tailored for Windows PowerShell, with bash commands for configuring the Nextcloud container. Apps like ClamAV and 2FA providers are installed and configured via the Nextcloud administration settings. Components are marked as Implemented, Partially Implemented, or Not Implemented to clarify the current setup status.

**--> Mostly the commands listed in this readme files are used in Windows Terminal/Powershell**

## Table of Contents

1. Prerequisites
2. Project Overview
3. Directory Structure
4. PowerShell Setup Instructions
5. Installing Dependencies in Nextcloud Container
6. Configuring Apps in Administration Settings
7. Configuring Session Security and 2FA
8. Task Scheduler for Cron
9. Tailscale Funnel Integration
10. Making Config File Editable
11. Backup Strategy
12. Security Considerations
13. Troubleshooting
14. Maintenance
15. Contributing

## 1. Prerequisites

Operating System: Windows 10/11 with WSL2 (Ubuntu, kernel 5.15.167.4 tested)

**Hardware:**\
Asus TUF F15 (16GB RAM, 512GB storage recommended)\
Docker: Docker Desktop with WSL2 backend\
Domain: DDNS (mynextcloud2934.ddns.net) and Tailscale domain (flash.reverse-elver.ts.net)\
Network: Stable internet for Let's Encrypt and Tailscale Funnel

**Software:**\
Git for Windows\
Tailscale client for Windows\
PowerShell 7+ (recommended)\
Basic knowledge of Docker, YAML, and Tailscale

**Tools:**\
VS Code for editing files\
Windows Terminal or PowerShell console

**Credentials:**\
Gmail app password for SMTP\
Tailscale account for Funnel

## 2. Project Overview

This project creates a secure, self-hosted NAS with:

Nextcloud: File storage, sharing, calendar, collaboration (v30.0.6.2) [Implemented]\
Traefik: Reverse proxy (limited by no public IP) [Partially Implemented]\
MariaDB: Database (v11.7.2) [Implemented]\
Redis: Caching [Implemented]\
ClamAV: Antivirus scanning [Implemented]\
Collabora Online: Document editing [Implemented]\
Nextcloud Talk: Chat, audio/video calls, screen-sharing [Implemented]\
Tailscale Funnel: Public access without port forwarding [Implemented]\
PHP: Included in Nextcloud image, optimized with OPcache, secure sessions [Implemented]\
Cron: Windows Task Scheduler [Implemented]\
Backups: Local backups implemented, cloud backups planned [Partially Implemented]

The setup supports multi-user access, file syncing, mobile access, and real-time collaboration, with security features like 2FA, encryption, and brute force protection.

## 3. Directory Structure

Create a project directory (D:\nextcloud-nas):\
D:\nextcloud-nas\
├── docker-compose.yaml\
├── config.php\
├── php.ini\
├── run_cron.bat\
├── letsencrypt\
├── nextcloud_data\
│   ├── data\
│   ├── db\
│   ├── redis\
│   ├── clamav\
├── nextcloud_config\
├── nextcloud_apps\


docker-compose.yaml: Defines services (Traefik, Nextcloud, MariaDB, Redis, ClamAV, Collabora) [Implemented]\
config.php: Configures Redis, database, security, apps [Implemented]\
php.ini: PHP optimizations, session settings [Implemented]\
run_cron.bat: Batch script for cron jobs [Implemented]\
letsencrypt\: Stores Let's Encrypt certificates (partial use) [Partially Implemented]\
nextcloud_data\: Persistent storage for data, database, Redis, ClamAV [Implemented]\
nextcloud_config\: Configuration files [Implemented]\
nextcloud_apps\: Custom apps [Implemented]

## 4. PowerShell Setup Instructions [Implemented]

  ### 1. Install Prerequisites

Enable WSL2:wsl --install

Restart if prompted.\
Install Docker Desktop:\
Download from docker.com.\
Enable WSL2 backend.\
``` Verify:docker --version  docker-compose --version ``` 

Install Git:\
Download from git-scm.com.\
``` Verify:git --version ```

Install Tailscale:\
Download from tailscale.com.\
``` Verify:tailscale version ```


 ### 2. Create Project Directory

``` New-Item -ItemType Directory -Path "D:\nextcloud-nas" -Force   Set-Location "D:\nextcloud-nas" ```

 ### 3. Create Configuration Files

Copy docker-compose.yaml, config.php, php.ini, run_cron.bat into D:\nextcloud-nas using VS Code or:git clone <repository-url>

Update Configurations:\
  docker-compose.yaml:\
'Set email: madelsai2004@gmail.com to yours.\
Update domains: mynextcloud2934.ddns.net, flash.reverse-elver.ts.net, collabora.flash.reverse-elver.ts.net.\
Adjust paths: D:\\nextcloud_data.\
Set passwords: securepassword, rootpassword, securecollabora.'

  config.php:
```
Add trusted_domains: localhost, flash.reverse-elver.ts.net, mynextcloud2934.ddns.net.
 Set mail_smtpname: madelsai2004@gmail.com, mail_smtppassword: **** **** **** ****. ( Generate an app password for mail configuration )
 Set overwrite.cli.url: https://flash.reverse-elver.ts.net. 
```
  php.ini:

Verify session settings (see Configuring Session Security and 2FA).

  run_cron.bat:
```
@echo off
echo %date% %time% - Running Nextcloud cron >> "D:\nextcloud_data\data\cron.log"
docker exec -u 33 nextcloud php -f /var/www/html/cron.php >> "D:\nextcloud_data\data\cron.log" 2>&1
  ```

 ### 4. Create Directories

```
New-Item -ItemType Directory -Path "D:\nextcloud-nas\letsencrypt" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_data\data" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_data\db" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_data\redis" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_data\clamav" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_config" -Force
New-Item -ItemType Directory -Path "D:\nextcloud-nas\nextcloud_apps" -Force
```
 ### 5. Create Docker Network

```
docker network create nextcloud-net
```
 ### 6. Pull and Start Containers

```
docker-compose pull
docker-compose up -d
```

  7. Verify Services
```
Check status:docker-compose ps
```
```
View logs:docker-compose logs traefik
docker-compose logs nextcloud
docker-compose logs nextcloud-db
docker-compose logs redis
docker-compose logs clamav
docker-compose logs collabora


Access:
Traefik: http://traefik.localhost (limited use)
Nextcloud: https://flash.reverse-elver.ts.net or https://mynextcloud2934.ddns.net
Collabora: https://collabora.flash.reverse-elver.ts.net
```


 ### 8. Complete Nextcloud Setup

Open Nextcloud in a browser (https://flash.reverse-elver.ts.net)  
Create an admin account.  
Verify database: host nextcloud-db, user nextclouduser, password securepassword, database nextcloud.  
Complete the wizard.

## 5. Installing Dependencies in Nextcloud Container [Implemented]

The Nextcloud Docker image includes PHP 8.2 and Apache, so only specific dependencies for ClamAV (files_antivirus) and minimal tools are installed.\
Access Bash Editor  
``` docker exec -it nextcloud bash ```

Install ClamAV
```
apt-get update
apt-get install -y clamav libclamav-dev
freshclam
pecl install clamav
echo "extension=clamav.so" >> /usr/local/etc/php/conf.d/clamav.ini
exit
```
Install Additional Tools
```
apt-get install -y cron nano curl
exit
```

Tools:\
cron: For potential internal scheduling (Task Scheduler is primary).\
nano: File editing.\
curl: Network troubleshooting.

Verify Installations
```
docker exec nextcloud clamscan --version
docker exec nextcloud php -m | findstr clamav
docker exec nextcloud which cron'
```

## 6. Configuring Apps in Administration Settings [Implemented]

Apps with administrative functions are installed and configured via the web interface under Administration > Apps, simplifying setup for ClamAV (files_antivirus), 2FA providers, Collabora Online (richdocuments), and Nextcloud Talk (talk).\
Install Apps

Log in as an admin.\
Navigate to Apps (top-right menu).\
Browse or search for apps:\
Files Antivirus (files_antivirus): Integrates ClamAV for file scanning.\
Two-Factor TOTP Provider (twofactor_totp): Enables Google Authenticator-based 2FA.\
Two-Factor Email (twofactor_email): Enables email-based 2FA.\
Collabora Online (richdocuments): Enables document editing.\
Nextcloud Talk (talk): Enables chat and video calls.


Click Download and enable for each app.

Configure Apps

Go to Administration > Settings.\
Configure each app:\
Files Antivirus:\
Set Mode to Daemon.\
Set Host to clamav, Port to 3310.\
Set Max File Size to 1073741824 (1GB).\
Set Infected Action to Only log.


Two-Factor TOTP Provider:\
Enable under Security > Two-Factor Authentication.\
Users can set up TOTP in their personal security settings.


Two-Factor Email:\
Enable under Security > Two-Factor Authentication.\
Ensure SMTP is configured (config.php).


Collabora Online:\
Set Collabora Online server to https://collabora.flash.reverse-elver.ts.net.\
Configure WOPI allowlist in config.php if needed.


Nextcloud Talk:\
Configure STUN/TURN servers for video calls (optional).\
Set up group chat permissions.

Command-Line Alternative\
If apps fail to install via the web interface:
```
docker exec -u 33 nextcloud php /var/www/html/occ app:install files_antivirus
docker exec -u 33 nextcloud php /var/www/html/occ app:install twofactor_totp
docker exec -u 33 nextcloud php /var/www/html/occ app:install twofactor_email
docker exec -u 33 nextcloud php /var/www/html/occ app:install richdocuments
docker exec -u 33 nextcloud php /var/www/html/occ app:install talk
```
## 7. Configuring Session Security and 2FA [Implemented]

Session settings and 2FA enhance security.\
Update config.php
``` docker-compose cp nextcloud:/var/www/html/config/config.php "D:\nextcloud-nas\config.php"```

Edit D:\nextcloud-nas\config.php:
```
'session_lifetime' => 900,
'session_keepalive' => false,
'auto_logout' => true,
'remember_login_cookie_lifetime' => 0,
'session_relaxed' => false,
'csrf.disabled' => false,
'cookie_lifetime' => 3600,
'session_refresh_time' => 300,
'logout_url' => '/index.php/logout?clear=1','
```
Copy back:
``` docker-compose cp "D:\nextcloud-nas\config.php" nextcloud:/var/www/html/config/config.php```

Update php.ini
```docker-compose cp nextcloud:/usr/local/etc/php/php.ini "D:\nextcloud-nas\php.ini"```

Edit D:\nextcloud-nas\php.ini:
```
[Session]
session.gc_maxlifetime = 3600
session.cookie_lifetime = 0
session.gc_probability = 1
session.gc_divisor = 100
session.use_strict_mode = 1
session.cookie_secure = 1
session.cookie_httponly = 1
session.cache_limiter = nocache'
```
Copy back:
```
docker-compose cp "D:\nextcloud-nas\php.ini" nextcloud:/usr/local/etc/php/php.ini 
docker-compose restart nextcloud
```
Enable 2FA
```
TOTP Provider:docker exec -u 33 nextcloud php /var/www/html/occ app:enable twofactor_totp

Email-Based 2FA:docker exec -u 33 nextcloud php /var/www/html/occ app:enable twofactor_email
```
Configure in web interface (see Configuring Apps in Administration Settings).

## 8. Task Scheduler for Cron [Implemented]

Windows Task Scheduler is used instead of container cron for reliability.\
Setup Task Scheduler

Create D:\nextcloud-nas\run_cron.bat:
```
@echo off
echo %date% %time% - Running Nextcloud cron >> "D:\nextcloud_data\data\cron.log"
docker exec -u 33 nextcloud php -f /var/www/html/cron.php >> "D:\nextcloud_data\data\cron.log" 2>&1
```

Test:
```
& "D:\nextcloud-nas\run_cron.bat"
Get-Content "D:\nextcloud_data\data\cron.log"
```

Configure Task Scheduler:taskschd.msc

Create Task: "NextcloudCron", run with highest privileges.\
Trigger: Daily, repeat every 5 minutes.\
Action: Program cmd.exe, Arguments /c D:\nextcloud-nas\run_cron.bat.

Export task:```Export-ScheduledTask -TaskName "NextcloudCron" -Path "D:\nextcloud-nas\NextcloudCron.xml"```

Import task:```Register-ScheduledTask -Xml (Get-Content "D:\nextcloud-nas\NextcloudCron.xml" | Out-String) -TaskName "NextcloudCron"```


## 9. Tailscale Funnel Integration [Implemented]

Tailscale Funnel enables public access without a public IP.\
Setup Tailscale

Authenticate: ```tailscale up```

Enable Funnel: ```tailscale funnel 8080 ```

Verify:``` tailscale status ```

Update config.php: ```docker-compose cp nextcloud:/var/www/html/config/config.php "D:\nextcloud-nas\config.php"```

Edit trusted_domains:
```
'trusted_domains' => array(
  0 => 'localhost',
  1 => 'flash.reverse-elver.ts.net',
  2 => 'mynextcloud2934.ddns.net',
),
```
Copy back: ```docker-compose cp "D:\nextcloud-nas\config.php" nextcloud:/var/www/html/config/config.php```


Test: ```curl https://flash.reverse-elver.ts.net```

## 10. Making Config File Editable [Implemented]

Access the bash editor
```docker exec -it nextcloud bash```

Inside:
```
ls -ld /var/www/html/config
chown -R www-data:www-data /var/www/html/config
chmod -R 750 /var/www/html/config
exit
```

Copy config: 
```docker-compose cp nextcloud:/var/www/html/config/config.php "D:\nextcloud-nas\config.php" ```


Copy back: 
```
docker-compose cp "D:\nextcloud-nas\config.php" nextcloud:/var/www/html/config/config.php
docker restart nextcloud
```


## 11. Backup Strategy [Partially Implemented]

  Local Backup [Implemented]

```
docker run --rm --volumes-from nextcloud-db -v ${PWD}:/backup busybox tar czf /backup/db-backup.tar.gz /var/lib/mysql
Copy-Item -Path "D:\nextcloud-nas\nextcloud_data\data" -Destination "D:\backups\nextcloud_data" -Recurse
```
  Cloud Backup (Rclone) [Not Implemented]

Install Rclone:
```
Invoke-WebRequest -Uri "https://downloads.rclone.org/rclone-current-windows-amd64.zip" -OutFile "rclone.zip"
Expand-Archive -Path "rclone.zip" -DestinationPath "D:\rclone"
```

Configure Rclone (e.g., Google Drive):D:\rclone\rclone.exe config


Sync backups:D:\rclone\rclone.exe sync "D:\backups\nextcloud_data" gdrive:nextcloud-backup


## 12. Security Considerations [Implemented]

HTTPS: Traefik with HSTS, Let's Encrypt (limited by no public IP) [Partially Implemented]\
Passwords: Strong, unique passwords [Implemented]\
2FA: TOTP, email-based authentication [Implemented]\
Session Management: 1-hour logout, secure cookies [Implemented]\
Brute Force Protection: 30-second lockout after 10 failed logins [Implemented]\
Encryption: End-to-end encryption for files [Implemented]\
Tailscale: Encrypted mesh network with Funnel [Implemented]\
ClamAV: Scans uploads for malware [Implemented]\
Updates: Regular updates for Docker, Nextcloud, Tailscale [Implemented]\
Backups: Local backups implemented, cloud backups planned [Partially Implemented]\

## 13.Troubleshooting [Implemented]

Traefik:
```
docker logs nextcloud-traefik
Test-NetConnection traefik.localhost -Port 80
```

Nextcloud: 
```
docker-compose ps
docker logs nextcloud
docker logs nextcloud-db

```
Collabora:
```
docker logs collabora
Test-NetConnection collabora.flash.reverse-elver.ts.net -Port 9980
```

ClamAV:
```
docker exec nextcloud-clamav freshclam
docker logs clamav
```

Cron:```Get-Content "D:\nextcloud_data\data\cron.log"```


Tailscale:
```
tailscale status
tailscale debug logs
```

Internal Server Error (App Issue):
```
docker exec -u 33 nextcloud php /var/www/html/occ app:list
docker exec -u 33 nextcloud php /var/www/html/occ app:disable <app_id>
```

## 14.Maintenance [Implemented]

Update Docker:
```
docker-compose pull
docker-compose up -d
```

Update Nextcloud:
```docker exec -u 33 nextcloud php /var/www/html/occ upgrade```

Update Tailscale: 
```tailscale update```

Backup:
```
Copy-Item -Path "D:\nextcloud-nas\nextcloud_data" -Destination "D:\backups\nextcloud_data" -Recurse
Copy-Item -Path "D:\nextcloud-nas\nextcloud_config" -Destination "D:\backups\nextcloud_config" -Recurse
Copy-Item -Path "D:\nextcloud-nas\letsencrypt" -Destination "D:\backups\letsencrypt" -Recurse
```

## 15. Contributing

Contact **Saikumar Anil Madel** (saimadel@outlook.com) for questions or contributions.\
Fork or submit pull requests. For issues, include:

Logs: ```docker-compose logs > logs.txt ```
Steps to reproduce.\
System: ``` docker info ```

