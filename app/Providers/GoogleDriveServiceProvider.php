<?php

namespace App\Providers;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Storage::extend('google', function ($app, $config) {
            $client = $this->getClient($config);

            $service = new Google_Service_Drive($client);

            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
            $driver = new Filesystem($adapter);

            return new FilesystemAdapter($driver, $adapter);
        });
    }

    private function getClient($config)
    {
        $client = new Google_Client();
        $client->setClientId($config['clientId']);
        $client->setClientSecret($config['clientSecret']);
        $client->refreshToken($config['refreshToken']);

        // Get the token from cache
        $accessToken = session()->get('google_access_token');
        $expiresIn = session()->get('google_token_expires_in');

        if ($accessToken && $expiresIn) {
            $client->setAccessToken($accessToken);

            // Check if the token has expired
            if ($client->isAccessTokenExpired()) {
                $this->refreshToken($client, $config);
            }
        } else {
            $this->refreshToken($client, $config);
        }

        return $client;
    }

    private function refreshToken($client, $config)
    {
        try {
            $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);
            $newToken = $client->getAccessToken();

            session()->put('google_access_token', $newToken['access_token']);
            session()->put('google_token_expires_in', $newToken['expires_in']);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
