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
    
    public function index()
    {
        $taskApiUrl = config('app.task_api_url');
        $loginResult = $this->login();

        // Check if login was successful
        if (isset($loginResult['access_token']) && isset($loginResult ['expires_in'])) {
            $accessToken = $loginResult['access_token'];
            $expiry = $loginResult['expires_in'];

            $response = Http::withToken($accessToken)->get($taskApiUrl);
            if ($response->successful() && $response->body()) {
                $task = $response->json();
                return view('tasks.index' , compact('task'));
            } else {
                return "error";
            }
        } else {
            return $loginResult; // Return or handle the error message
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
