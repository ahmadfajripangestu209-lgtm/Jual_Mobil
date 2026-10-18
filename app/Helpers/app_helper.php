<?php

if (! function_exists('app_path')) {
    function app_path(string $path = ''): string
    {
        $configuredPath = parse_url((string) config('App')->baseURL, PHP_URL_PATH);
        $configuredBasePath = '/' . trim((string) $configuredPath, '/');
        $requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
        $basePath = '';
        $relativePath = ltrim($path, '/');

        if (
            $configuredBasePath !== '/'
            && is_string($requestPath)
            && ($requestPath === $configuredBasePath || str_starts_with($requestPath, $configuredBasePath . '/'))
        ) {
            $basePath = $configuredBasePath;
        }

        if (
            $configuredBasePath !== '/'
            && ($relativePath === trim($configuredBasePath, '/') || str_starts_with($relativePath, trim($configuredBasePath, '/') . '/'))
        ) {
            $relativePath = substr($relativePath, strlen(trim($configuredBasePath, '/')));
            $relativePath = ltrim($relativePath, '/');
        }

        return rtrim($basePath, '/') . '/' . $relativePath;
    }
}
