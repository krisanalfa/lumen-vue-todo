# Todo App

Technologies used:
- [Vue.js 2](https://vuejs.org/)
- [Vue Router 2](https://router.vuejs.org/en/)
- [Vuex](https://vuex.vuejs.org/en/)
- [VueHttp](https://github.com/pagekit/vue-resource/)

Backend:
- [Lumen 5.4](https://lumen.laravel.com/docs/5.4)

## Quick Start

### Backend

```bash
cd todo-api
composer install
# configure your key, database, etc in `.env` file
php artisan migrate --seed
php -S localhost:9000 -t public
# default login is johndoe@example.com:johndoe
```

### Frontend

```bash
cd todo-app
yarn install # or npm install
yarn dev # or npm run dev
```
