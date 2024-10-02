<?php

namespace App\Infrastructures\Storage;

use App\Infrastructures\Storage\Contract\IStorageInfrastructure;
use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Space implements IStorageInfrastructure
{
    public function upload(UploadedFile $file,
                           string       $fileContent,
                           string       $fileOriginalName,
                           string       $fileExtension,
                           string       $path,
                           bool         $replace = false): string
    {
        $disk = Storage::disk('space');

        if (!$disk->exists($path)) {
            $disk->makeDirectory($path);
        }

        if (!$replace) {
            $newFileName = $fileOriginalName;
            $counter = 1;

            while ($disk->exists($path . '/' . $newFileName)) {
                $newFileName = pathinfo($fileOriginalName, PATHINFO_FILENAME) . '_' . $counter++ . '.' . $fileExtension;
            }

            $fileOriginalName = $newFileName;
        }

//        return '/' . $disk->putFileAs($path, $file, $fileOriginalName, 'public');
        return '/' . $disk->putFileAs($path, $file, $fileOriginalName, 'public');
    }

    public function download(string $filePath): StreamedResponse
    {
        $disk = Storage::disk('space');

        $path = parse_url($filePath, PHP_URL_PATH);

        if (!$disk->exists($path)) {
            throw new NotFoundException();
        }

        return $disk->download($path);
    }

    public function delete(string $filePath): bool
    {
        $disk = Storage::disk('space');

        $path = parse_url($filePath, PHP_URL_PATH);

        if (!$disk->exists($path)) {
            throw new Exception("File not found at the specified URL.");
        }

        return $disk->delete($path);
    }
}
