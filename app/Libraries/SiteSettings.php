<?php

namespace App\Libraries;

use RuntimeException;

class SiteSettings
{
    private const SETTINGS_FILE = WRITEPATH . 'site-settings.json';
    private const IMAGE_KEYS = ['hero', 'about'];

    public static function images(): array
    {
        if (! is_file(self::SETTINGS_FILE)) {
            return [];
        }

        $contents = file_get_contents(self::SETTINGS_FILE);
        if ($contents === false) {
            log_message('error', 'Unable to read site image settings.');
            return [];
        }

        $settings = json_decode($contents, true);
        if (! is_array($settings)) {
            log_message('error', 'Site image settings contain invalid JSON.');
            return [];
        }

        $images = [];
        foreach (self::IMAGE_KEYS as $key) {
            $path = $settings[$key] ?? '';
            if (! is_string($path) || ! preg_match('#^uploads/site-photos/[a-f0-9]{32}\.(jpg|png|webp)$#', $path)) {
                continue;
            }

            if (is_file(FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $path))) {
                $images[$key] = $path;
            }
        }

        return $images;
    }

    public static function saveImages(array $images): void
    {
        $settings = [];
        foreach (self::IMAGE_KEYS as $key) {
            $path = $images[$key] ?? '';
            if ($path !== '' && (! is_string($path) || ! preg_match('#^uploads/site-photos/[a-f0-9]{32}\.(jpg|png|webp)$#', $path))) {
                throw new RuntimeException('Invalid site image path.');
            }
            if ($path !== '') {
                $settings[$key] = $path;
            }
        }

        $json = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false || file_put_contents(self::SETTINGS_FILE, $json, LOCK_EX) === false) {
            throw new RuntimeException('Unable to save site image settings.');
        }
    }
}
