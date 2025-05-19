<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12 text-black dark:text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">
                    @if (request('search'))
                        <h2 class="pb-3 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            Search results for: ({{ request('search') }})
                        </h2>
                    @endif

                    <form class="flex items-center gap-4 mb-4">
                        <x-text-input 
                            id="search" 
                            name="search" 
                            type="text" 
                            class="w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                            placeholder="Search by name or email..." 
                            value="{{ request('search') }}" 
                            autofocus
                        />

                        <x-primary-button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{ __('Search') }}
                        </x-primary-button>
                    </form>

                    <div class="flex items-center justify-between">
                        <div></div>

                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="text-sm text-green-600 dark:text-green-400">
                                {{ session('success') }}
                            </p>
                        @endif

                        @if (session('danger'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="text-sm text-red-600 dark:text-red-400">
                                {{ session('danger') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="hidden px-6 py-3 md:table-cell">Email</th>
                                <th scope="col" class="px-6 py-3">Todo</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-black dark:text-white">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 text-black dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="hidden px-6 py-4 md:table-cell text-black dark:text-white">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-black dark:text-white whitespace-nowrap">
                                        <p>
                                            {{ $user->todo->count() }}
                                            <span>
                                                <span class="text-green-600 dark:text-green-400">
                                                    ({{ $user->todo->where('is_done', true)->count() }}
                                                </span>
                                                /
                                                <span class="text-blue-600 dark:text-blue-400">
                                                    {{ $user->todo->where('is_done', false)->count() }})
                                                </span>
                                            </span>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col md:flex-row md:items-center md:space-x-3 space-y-2 md:space-y-0">
                                            @if ($user->is_admin)
                                                <form action="{{ route('user.removeadmin', $user) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                        Remove Admin
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('user.makeadmin', $user) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                                        Make Admin
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('user.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>