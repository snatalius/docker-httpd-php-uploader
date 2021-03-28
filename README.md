# File Uploader

A docker container that allows devices to upload or download files to/from the container via local network. This enables file sharing between devices within the same network.

The service is made using HTML, CSS and PHP and run on Debian's Apache HTTPD with PHP (image provided by Docker). 

## How to deploy

Prerequisite: Docker (and optionally, Docker Compose) is required to build and run the file uploader container.

### With Docker Compose

- Run Terminal/Command Prompt and set this directory as the working path.
- Execute command `docker-compose up --build`. It may take a while for Docker to build and deploy the image.
- Once finished, the service can be accessed from the host device via url `http://localhost:8080/uploader/`

### Without Docker Compose

- Run Terminal/Command Prompt and set this directory as the working path.
- Execute the following command:

```
docker build -t snl/uploader-latest .

docker run -p 8080:80 --name docker-httpd-php-uploader_apache_1 snl/uploader-latest
```
- Once finished, the service can be accessed from the host device via url `http://localhost:8080/uploader/`

## How to Use

The service can be accessed from devices other than the host via url `http://<host_ip_address>:8080/uploader/`. Please check the IP address of the host using command `ifconfig` (Linux/UNIX) or `ipconfig` (Windows). Please ensure that the host's firewall has been set to allow connection to port 8080.

To upload a file, simply select the file to upload, type the secret key and click _Upload_. If successful, the file can be found under `http://<host_ip_address>:8080/uploader/files`.

The secret key is meant to prevent unwanted users to upload unwanted files to the container. It is initially set to `admin`, but it can be changed on `http://<host_ip_address>:8080/uploader/changekey.php`.

## Next Steps

Find a way so that the files folder (in the container) can be bound to transfer folder (in the host machine) without having the folder ownership to root (the current problem).

## Credits

Developed by Samuel Natalius © 2021