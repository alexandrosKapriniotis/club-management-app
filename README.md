
# A Sports Club Management System

This project is part of a pre employment assignment for a full stack position role.


## Run Locally

Clone the project

```bash
  git clone https://github.com/alexandrosKapriniotis/club-management-app.git
```

Go to the project directory

```bash
  cd club-management-app
```

Install dependencies

```bash
  composer install
```

Run migrations (optional with seed flag)

```bash
  php artisan migrate --seed 
```

Link storage

```bash
  php artisan storage:link
```

Start the server

```bash
  php artisan serve
```

After running the database seeder you can login with the following admin user:
```bash
email: admin@example.com
password: password
```
