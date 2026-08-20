<?php
declare(strict_types=1);

/**
 * Minimalistischer Router. Routen werden als (Methode, Pfad, Handler) registriert.
 * Pfad-Platzhalter in geschweiften Klammern, z.B. /buchung/{id}/stornieren.
 * Handler: [ControllerClass::class, 'methode'].
 */
final class Router
{
    /** @var array<int, array{method:string, pattern:string, handler:array}> */
    private array $routes = [];

    public function get(string $pattern, array $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, array $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    private function add(string $method, string $pattern, array $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    /** Ermittelt den angefragten Pfad relativ zum BASE_PATH. */
    private function currentPath(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $uri = rawurldecode($uri);
        if (BASE_PATH !== '' && str_starts_with($uri, BASE_PATH)) {
            $uri = substr($uri, strlen(BASE_PATH));
        }
        $uri = '/' . trim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path   = $this->currentPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            $regex = $this->compile($route['pattern']);
            if (preg_match($regex, $path, $matches)) {
                $params = array_filter(
                    $matches,
                    static fn ($k) => !is_int($k),
                    ARRAY_FILTER_USE_KEY
                );
                [$class, $action] = $route['handler'];
                (new $class())->$action(...array_values($params));
                return;
            }
        }

        $this->notFound();
    }

    private function compile(string $pattern): string
    {
        $regex = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $regex . '$#';
    }

    private function notFound(): void
    {
        http_response_code(404);
        render('errors/404', ['title' => 'Seite nicht gefunden', 'noindex' => true]);
    }
}
