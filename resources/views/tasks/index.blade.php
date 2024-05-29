@extends('layouts.app')
@section('content')



    {{--        <div class="relative w-full mb-4">--}}

    {{--            <input  type="text" id="search-dropdown"--}}
    {{--                   class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"--}}
    {{--                   placeholder="البحث عن الرسائل">--}}
    {{--        </div>--}}
    {{--    <button wire:click="submitSearch" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">Search</button>--}}
    {{--            <a href="{{ route(' ') }}" type="button" class="float-left focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-3 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">رسالة جديدة</a>--}}
    <style>
        .spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #tasks-container {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        #tasks-container.hidden {
            opacity: 0;
        }
    </style>
    <div class="spinner" id="loading-spinner"></div>
    <div class="container mx-auto index-container" id="tasks-container">
        <h1 class="text-center text-5xl mt-5 font-semibold text-gray-800 capitalize sm:text-5xl dark:text-white form-title block me-auto mb-5">Tasks</h1>

        <form class="max-w-md mx-auto mb-5 mt-5">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Tasks" required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="tasks-table">
                <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">#</th>
                    <th scope="col" class="px-6 py-3">Color</th>
                    <th scope="col" class="px-6 py-3">Task</th>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                </tr>
                </thead>
                <tbody id="tasks-table-body">
                @foreach($task as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <button style="background-color: {{ $item['colorCode'] }}" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                        </td>
                        <td class="px-6 py-4">{{ $item['task'] }}</td>
                        <td class="px-6 py-4">{{ $item['title'] }}</td>
                        <td class="px-6 py-4">{{ $item['description'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function fetchTasks() {
            $('#tasks-container').addClass('hidden'); // Hide the table container with transition
            $('#loading-spinner').show(); // Show the spinner

            $.ajax({
                url: '/tasks/update',
                method: 'GET',
                success: function(data) {
                    let tbody = $('#tasks-table-body');
                    tbody.empty();
                    data.forEach((item, index) => {
                        let row = `
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">${index + 1}</td>
                                <td class="px-6 py-4">
                                    <button style="background-color: ${item.colorCode}" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                                </td>
                                <td class="px-6 py-4">${item.task}</td>
                                <td class="px-6 py-4">${item.title}</td>
                                <td class="px-6 py-4">${item.description}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                },
                error: function() {
                    console.error('Failed to fetch tasks.');
                },
                complete: function() {
                    $('#loading-spinner').hide(); // Hide the spinner
                    $('#tasks-container').removeClass('hidden'); // Show the table container with transition
                }
            });
        }

        // $(document).ready(function() {
        //     fetchTasks();
        //     setInterval(fetchTasks, 20000);
        // });
    </script>




@endsection
