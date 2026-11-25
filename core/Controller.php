<?php
abstract class Controller
{
    protected function view(string $viewPath, array $data = []): void
    {
        extract($data);
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $file = __DIR__ . '/../app/views/' . str_replace('.', '/', $viewPath) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            http_response_code(500);
            die("View [{$viewPath}] tidak ditemukan.");
        }
    }

    protected function redirect(string $path): void
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $target = $base . '/' . ltrim($path, '/');
        header('Location: ' . $target);
        exit;
    }
}
