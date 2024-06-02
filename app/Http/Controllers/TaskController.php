<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
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

        if ($response->successful()) {
            $data = $response->json();

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

    public function index()
    {
        $tasksResponse = $this->getTasks();
    
        if ($tasksResponse->status() == 200) {
            $tasks = $tasksResponse->getData();
            return view('tasks.index', compact('tasks'));
        } else {
            return "error";
        }
    }
    
    public function getTasks()
    {
        $taskApiUrl = config('app.task_api_url');
        $loginResult = $this->login();
    
        if (isset($loginResult['access_token']) && isset($loginResult['expires_in'])) {
            $accessToken = $loginResult['access_token'];
    
            $response = Http::withToken($accessToken)->get($taskApiUrl);
            if ($response->successful() && $response->body()) {
                $tasks = $response->json();
                return response()->json($tasks);
            } else {
                return response()->json(['error' => 'Failed to fetch tasks'], 500);
            }
        } else {
            return response()->json($loginResult, 500); 
        }
    }

}
