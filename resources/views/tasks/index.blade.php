@extends('layouts.app')
@section('content')



    <div>
{{--        <div class="relative w-full mb-4">--}}

{{--            <input  type="text" id="search-dropdown"--}}
{{--                   class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"--}}
{{--                   placeholder="البحث عن الرسائل">--}}
{{--        </div>--}}
        {{--    <button wire:click="submitSearch" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">Search</button>--}}


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        حالة الرسالة
                    </th>
                    <th scope="col" class="px-6 py-3">
                        اسم العميل
                    </th>

                    <th scope="col" class="px-6 py-3">
                        عنوان الرسالة
                    </th>

                    <th scope="col" class="px-6 py-3">
                        تاريخ البدء
                    </th>
                    <th scope="col" class="px-6 py-3">
                        تاريخ الانتهاء
                    </th>
                    <th scope="col" class="px-6 py-3">
                        عدد مرات التذكير المتبقية
                    </th>
                    <th scope="col" class="px-6 py-3">
                        موعد الإرسال القادم
                    </th>
                    <th scope="col" class="px-6 py-3">
                        العمليات
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($task as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" >
                        <td class="w-4 p-4">
                            {{ $loop->iteration }}
                        </td>


                        <td class="px-6 py-4">
                            {{$item['task']}}

                        </td>
                        <td class="px-6 py-4">
                            {{$item['title']}}
                        </td>

                        <td class="px-6 py-4">
                            {{$item['description']}}
                        </td>
                        <td class="px-6 py-4">
                            {{$item['colorCode']}}
                        </td>


                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

{{--        <div class="mt-5">    {{ $messages->links() }}--}}
{{--        </div>--}}
    </div>



@endsection
