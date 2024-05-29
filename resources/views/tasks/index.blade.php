@extends('layouts.app')
@section('content')

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
                 @foreach($tasks as $task)
                     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                         <td class="w-4 p-4">{{ $loop->iteration }}</td>
                         <td class="px-6 py-4">
                             <button style="background-color: {{ $task->colorCode }}" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                         </td>
                         <td class="px-6 py-4">{{ $task->task }}</td>
                         <td class="px-6 py-4">{{ $task->title }}</td>
                         <td class="px-6 py-4">{{ $task->description }}</td>
                     </tr>
                 @endforeach
                 </tbody>
             </table>
         </div>
     </div>
 
     <script>
         let allTasks = [];
 
         function fetchTasks() {
             $('#tasks-container').addClass('hidden'); // Hide the table container with transition
             $('#loading-spinner').show(); // Show the spinner
 
             $.ajax({
                 url: '/tasks/update',
                 method: 'GET',
                 success: function(data) {
                     allTasks = data; // Store the data for search functionality
                     updateTable(allTasks);
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
 
         function updateTable(tasks) {
             let tbody = $('#tasks-table-body');
             tbody.empty();
             tasks.forEach((item, index) => {
                 let truncatedDescription = item.description.length > 120 ? item.description.substring(0, 120) + '...' : item.description;
                 let row = `
                     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                         <td class="w-4 p-4">${index + 1}</td>
                         <td class="px-6 py-4">
                             <button style="background-color: ${item.colorCode}" class="font-medium rounded-lg text-sm px-5 py-5 me-2 mb-2"></button>
                         </td>
                         <td class="px-6 py-4">${item.task}</td>
                         <td class="px-6 py-4">${item.title}</td>
                         <td class="px-6 py-4">
                             <span class="description-short">${truncatedDescription}</span>
                             <span class="description-full hidden">${item.description}</span>
                             ${item.description.length > 120 ? '<button class="toggle-description text-blue-500">more</button>' : ''}
                         </td>
                     </tr>`;
                 tbody.append(row);
             });
         }
 
         function searchTasks(query) {
             query = query.toLowerCase();
             const filteredTasks = allTasks.filter(item => 
                 item.task.toLowerCase().includes(query) ||
                 item.title.toLowerCase().includes(query) ||
                 item.description.toLowerCase().includes(query)
             );
             updateTable(filteredTasks);
         }
 
         $(document).ready(function() {
             fetchTasks();
             setInterval(fetchTasks, 20000);
 
             $('#default-search').on('input', function() {
                 const query = $(this).val();
                 searchTasks(query);
             });
 
             $(document).on('click', '.toggle-description', function() {
                 const $this = $(this);
                 const $short = $this.siblings('.description-short');
                 const $full = $this.siblings('.description-full');
 
                 if ($full.hasClass('hidden')) {
                     $full.removeClass('hidden');
                     $short.addClass('hidden');
                     $this.text('less');
                 } else {
                     $full.addClass('hidden');
                     $short.removeClass('hidden');
                     $this.text('more');
                 }
             });
         });
     </script>




@endsection
