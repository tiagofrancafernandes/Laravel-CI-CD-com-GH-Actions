<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileHelpers
{
    /**
     * Detects the MIME type of a given file
     *
     * @param string $fileName The full path to the name whose MIME type you want to find out
     *
     * @return string The MIME type, e.g. image/jpeg
     */
    public static function getMimeType(string $fileName): string
    {
        try {
            if (\file_exists($fileName)) {
                return mime_content_type($fileName);
            }

            return '';
        } catch (\Throwable $th) {
            \Log::error($th);

            if (config('app.debug')) {
                throw $th;
            }

            return '';
        }
    }

    /**
     * humanFileSize function
     *
     * Returns a human readable file size
     *
     * @param string|int $size
     * @param string $unit
     *
     * @return string
     */
    public static function humanFileSize(string|int $size, $unit = ""): string
    {
        if (!\is_numeric($size)) {
            return '';
        }

        if ((!$unit && $size >= 1 << 30) || $unit == "GB") {
            return number_format($size / (1 << 30), 0, '.', '.') . " GB";
        }

        if ((!$unit && $size >= 1 << 20) || $unit == "MB") {
            return number_format($size / (1 << 20), 0, '.', '.') . " MB";
        }

        if ((!$unit && $size >= 1 << 10) || $unit == "KB") {
            return number_format($size / (1 << 10), 0, '.', '.') . " KB";
        }

        return number_format($size) . " bytes";
    }

    /**
     * sizeInMb function
     *
     * Returns a human MB file size
     *
     * @param string|int $size
     *
     * @return string
     */
    public static function sizeInMb(string|int $size): string
    {
        return static::humanFileSize($size, 'MB');
    }

    /**
     * fileInfo function
     *
     * Returns all file info
     *
     * @param string $filePath
     *
     * @return ?array
     */
    public static function fileInfo(
        string $filePath
    ): ?array {
        $info = [
            'dirname' => \null,
            'basename' => \null,
            'extension' => \null,
            'filename' => \null,
            'size_in_bytes' => 0,
            'human_file_size' => '0',
            'mime_type' => 'type/undefined',
        ];

        try {
            if (!\is_file($filePath)) {
                return \null;
            }

            $info = [...$info, ...pathinfo($filePath)];
            $info['mime_type'] = mime_content_type($filePath);

            $info['size_in_bytes'] = $size = \filesize($filePath);
            $info['human_file_size'] = static::humanFileSize($size);
            $info['dimensions'] = static::getImageDimensions($filePath);

            $info['full_local_Path'] = \sprintf(
                '%s/%s',
                $info['dirname'] ?? '',
                $info['basename'] ?? '',
            );

            return $info ?? [];
        } catch (\Throwable $th) {
            \Log::error($th);

            if (config('app.debug')) {
                throw $th;
            }

            return \null;
        }
    }

    /**
     * function makeUploadedFile
     *
     * @param string $filePath
     * @param string $originalName
     *
     * @return ?\Illuminate\Http\UploadedFile
     */
    public static function makeUploadedFile(string $filePath, string $originalName = ''): ?UploadedFile
    {
        if (!\is_file($filePath)) {
            return \null;
        }

        return new UploadedFile($filePath, $originalName);
    }

    /**
     * function getImageDimensions
     *
     * @param null|string|UploadedFile $uploadedFile
     *
     * @return array
     */
    public static function getImageDimensions(null|string|UploadedFile $uploadedFile): array
    {
        if (!$uploadedFile) {
            return [];
        }

        $uploadedFile = \is_string($uploadedFile) ? static::makeUploadedFile($uploadedFile) : $uploadedFile;

        return (array) ($uploadedFile->dimensions() ?: []);
    }

    /**
     * titleByFileName function
     *
     * @param string $fileName
     * @param array $charsToReplace `['_', '.', '  ']`
     * @param string $replaceBy
     * @return \Illuminate\Support\Stringable
     */
    public static function titleByFileName(
        string $fileName,
        array $charsToReplace = [],
        string|array $replaceBy = ''
    ): \Illuminate\Support\Stringable {
        $charsToReplace = $charsToReplace ?: ['_', '.', '  '];
        $replaceBy = $replaceBy ?: ' ';
        $str = str($fileName)->explode('.');
        $str->pop(); /* Remove extension */
        $str = str($str->implode(' '));

        return $str->replace($charsToReplace, $replaceBy)->slug($replaceBy)->ucfirst();
    }

    /**
     * function getExtension
     *
     * @param string $file
     * @param bool $withDot = false
     *
     * @return string
     */
    public static function getExtension(string $file, bool $withDot = false): string
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        return $extension && $withDot ? ".{$extension}" : $extension;
    }
}
