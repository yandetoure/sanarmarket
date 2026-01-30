<?php

if (!function_exists('storage_url')) {
    /**
     * Get the storage URL for a given path.
     *
     * @param string|null $path
     * @return string
     */
    function storage_url(?string $path): string
    {
        if (!$path) {
            return asset('images/placeholder.png');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}
