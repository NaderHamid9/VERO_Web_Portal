<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetTasksCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command gets tasks list from the API';

    /**
     * Execute the console command.
     */
    public function login()
    {
        $loginApiUrl = config('app.loginApiUrl');
        $loginToken = config('app.loginToken');
        $username = config('app.vero_username');
        $password = config('app.vero_password');



        $postData = [
            'username' => $username,
            'password' => $password,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $loginToken,
            'Content-Type' => 'application/json',
        ])->post($loginApiUrl, $postData);

        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            // Extract the access_token
            $accessToken = $data['oauth']['access_token'];
            $expiry = $data['oauth']['expires_in'];
            return [
                'access_token' => $accessToken,
                'expires_in' => $expiry,
            ];
        } else {
            return $this->error($response->body());


        }
    }

    public function handle()
    {
        $taskApiUrl = config('app.task_api_url');
        $loginResult = $this->login();

        // Check if login was successful
        if (isset($loginResult['access_token']) && isset($loginResult['expires_in'])) {
            $accessToken = $loginResult['access_token'];
            $expiry = $loginResult['expires_in'];

            $response = Http::withToken($accessToken)->get($taskApiUrl);
            if ($response->successful() && $response->body()) {

            } else {
                return [
                    'error' => $response->body(),
                ];
            }
        } else {
            return $loginResult; // Return or handle the error message
        }
    }
}
