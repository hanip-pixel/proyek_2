protected $routeMiddleware = [
    // ... yang lain
    'check.login' => \App\Http\Middleware\CheckLogin::class,
];