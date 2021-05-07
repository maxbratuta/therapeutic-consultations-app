# Therapeutic Consultations

![Therapeutic Consultations](https://i.ibb.co/7tjNfnn/therapeutic-consultations.png)

Create a project for displaying therapeutic consultation.


## Used Libraries:

- [Tailwind CSS](https://tailwindcss.com/)
- [axios](https://www.npmjs.com/package/axios)
- [vis.js](https://visjs.github.io/vis-timeline/docs/timeline/index.html)
- [moment.js](https://momentjs.com/)
- [SweetAlert 2](https://sweetalert2.github.io/)


## Installation Overview

**1. Install prerequisites.**
- nginx
- php-fpm 7.4
- mysql 8
- composer
- nodejs
- npm

**2. Clone project.**

```sh
git clone https://github.com/maxbratuta/therapeutic-consultations-app.git
```

**3. Configure nginx.**
```sh
server {

    listen 80;
    listen [::]:80;

    server_name therapeutic-consultations-app.loc;
    root /var/www/therapeutic-consultations-app/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php-fpm:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**4. Create MySQL database.**

**5. Configure application.**

Copy `/path_to_project/.env.example` file to `/path_to_project/.env`.
Then add right configuration information to the new file.
- database access info
- application URL info
- ect.

**6. Run install script.**

Run next command to install external libraries.
```sh
composer install
```

**7. Run scripts using next command in `/path_to_project/` directory.**
```sh
php artisan migrate
```

**8. Run the install script for front.**

Run next command to install external libraries.
```sh
npm install
```

**9. Build frontend.**

Run next command to build external libraries.
```sh
npm run *env*
```

## Generate Test Data

Run next command to generate test data.

```sh
php artisan db:seed
```
