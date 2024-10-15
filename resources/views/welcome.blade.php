<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @notifyCss

        <x-notify::notify />
        @notifyJs

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="bg-slate-500">
        <div class="container flex flex-col items-center justify-center w-3/4 h-full p-16 mx-auto mt-6 bg-white rounded-xl">
            <h1 class="font-sans text-4xl font-bold ">To Do List</h1>
            <form method="POST" class="flex flex-col items-start justify-center w-full mt-8" action={{ route('upload.data') }}>
                @csrf
                <input type="text" class="w-full p-3 m-2 bg-gray-200 rounded-xl" placeholder="The To Do Tittle" name="title">
                <textarea name="description" id="" rows="2" class="w-full p-3 m-2 bg-gray-200 rounded-xl" placeholder="The To Do Description"></textarea>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 p-3 m-2 md:justify-center">Add Task</button>
            </form>
            <hr class="w-full mx-3 my-4 border-gray-300 border-1"/>
            @foreach ($getAllData as $data)
            <div class="flex flex-col justify-between w-full p-3 mx-auto md:flex-row">
                <div id="backgroundData">
                    <p>{{ $data->title }}</p>
                    <p>{{ $data->description }}</p>
                </div>
                <div class="flex items-center justify-center mt-3 md:mt-0">
                    <form action="/home/{{ $data->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-green-700 focus:outline-none hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-xl me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" id="checklist" onclick="checklist()" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
                    </form>
                    <button type="button" class="px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-xl hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" id="open-modal-btn-{{ $data->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>
                    <form action="/home/{{ $data->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-red-700 focus:outline-none hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-xl me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                    </form>
                </div>
            </div>
            <div id="modal-view-{{ $data->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 flex justify-center hidden w-full h-screen bg-black bg-opacity-50 items-center-top">
                <div class="relative w-full max-w-md max-h-full p-4">
                    <div class="relative bg-white rounded-lg shadow ">
                        <div class="flex items-center justify-between p-4 border-b border-black rounded-t md:p-5">
                            <h3 class="text-lg font-semibold text-black">Edit To Do</h3>
                            <button id="close-modal-btn-{{ $data->id }}" type="button" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form class="p-4 md:p-5" action="{{ route('update.data', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="col-span-2">
                                    <label for="title" class="block mb-2 text-sm font-medium text-black">Title</label>
                                    <input type="text" name="title" id="title-{{ $data->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                </div>
                                <div class="col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-black">Description</label>
                                    <textarea id="description-{{ $data->id }}" rows="4" name="description" class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
    </body>
    <script>
        document.querySelectorAll('[id^="open-modal-btn-"]').forEach(btn => {
            const todoId = btn.id.split('-').pop();
            const modalView = document.getElementById(`modal-view-${todoId}`);
            const closeModalBtn = document.getElementById(`close-modal-btn-${todoId}`);

            btn.addEventListener('click', () => {
                modalView.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                modalView.classList.add('hidden');
            });

            window.addEventListener('click', (e) => {
                if (e.target == modalView) {
                    modalView.classList.add('hidden');
                }
            });
        });
    </script>

</html>


