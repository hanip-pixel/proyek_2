protected $routeMiddleware = [
    // ... yang lain
    'check.login' => \App\Http\Middleware\CheckLogin::class,
    'auth.admin' => \App\Http\Middleware\AdminAuth::class,
];