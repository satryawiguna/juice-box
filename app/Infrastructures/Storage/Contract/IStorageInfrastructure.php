<?php

namespace App\Infrastructures\Storage\Contract;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface IStorageInfrastructure
{
    public function upload(UploadedFile $file,
                           string       $fileContent,
                           string       $fileOriginalName,
                           string       $fileExtension,
                           string       $path,
                           bool         $replace = false): string;

    public function download(string $filePath): StreamedResponse|string|null;

    public function delete(string $filePath): bool;
}
