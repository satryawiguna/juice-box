<?php

namespace App\Infrastructures\Storage;

use App\Infrastructures\Storage\Contract\IStorageInfrastructure;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GDrive implements IStorageInfrastructure
{
    public function upload(UploadedFile $file,
                           string       $fileContent,
                           string       $fileOriginalName,
                           string       $fileExtension,
                           string       $path,
                           bool         $replace = false): string
    {
        if (!Storage::cloud()->exists($path)) {
            Storage::cloud()->makeDirectory($path);
        }

        if (!$replace) {
            $files = collect(Storage::cloud()->listContents($path, false))
                ->where('type', 'file')
                ->pluck('path')
                ->map(fn($file) => pathinfo($file, PATHINFO_BASENAME))
                ->toArray();

            $newFileName = $fileOriginalName;
            $counter = 1;

            while (in_array($newFileName, $files)) {
                $newFileName = pathinfo($fileOriginalName, PATHINFO_FILENAME) . '_' . $counter++ . '.' . $fileExtension;
            }

            $fileOriginalName = $newFileName;
        }

        $filePath = $path . '/' . $fileOriginalName;
        Storage::cloud()->put($filePath, $fileContent);
        $metadata = Storage::cloud()->getMetadata($filePath);
        $fileId = $metadata['path'];

        return $fileId;
    }


    public function download(string $filePath): string|null
    {
        if (!Storage::cloud()->exists($filePath)) {
            throw new Exception('File not found.');
        }

        $fileContent = Storage::cloud()->get($filePath);

        return $fileContent;
    }

    public function delete(string $filePath): bool
    {
        if (!Storage::cloud()->exists($filePath)) {
            throw new Exception('File not found.');
        }

        return Storage::cloud()->delete($filePath);
    }
}
