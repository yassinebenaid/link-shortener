# Link Shortener

A web application that allows users to shorten long urls into a short, more manageable urls.

# Local Setup

_The installation process assumes you have `docker compose` installed_

To run this application locally, You have two options:

## You are running linux

If you are running linux, you need to clone this repository, then in the project root directory run `./setup.bash`:

1. Clone the repository:

```bash
git clone https://github.com/yassinebenaid/link-shortener.git

```

2. Navigate to application root directory:

```bash
cd link-shortener
```

3. Run the setup script

```bash
./setup.bash
```

**Note**: The `setup.bash` script might work on **MAC** too. However, I'm not sure if bash on linux is compatible with mac.

## If you are on other platforms:

I have no idea if this would work on **Windows**, but its your responsibility to change the commands as needed.

If you are using other platforms you can just follow these instructions:

1. Copy `.env.example` file to `.env`

```bash
cp .env.example .env.example
```

2. Install composer dependencies

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
composer install --ignore-platform-reqs
```

3. Run the containers

```bash
./vendor/bin/sail up -d
```

4. Generate app key

```bash
./vendor/bin/sail artisan key:generate
```

5. Install NPM modules

```bash
./vendor/bin/sail npm update
```

6. Build Frontend Assets

```bash
./vendor/bin/sail npm run build
```

7. Run migrations

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

8. Clear cached files

```bash
./vendor/bin/sail artisan optimize:clear
```

# Using the application

If you followed the above steps without any opstacles. you should be able to visit the application using any browser at: [http://localhost](http://localhost)

The you can use the following credentials to login:
**Email** : ysbenaid@gmail.com
**Password**: password

## How to stop it?

To stop the application and remove any related containers:

```bash
./vendor/bin/sail down
```

## How to start it again?

To stop the application and remove any related containers:

```bash
./vendor/bin/sail up -d
```
