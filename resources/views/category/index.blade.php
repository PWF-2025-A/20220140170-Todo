<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-black">
            {{ __('CATEGORY LIST') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-black">
                    
                    <div class="flex justify-between items-center mb-5">
                        <x-create-button href="{{ route('category.create') }}" />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-black">
                            <thead class="bg-gray-100 uppercase text-xs font-semibold text-black">
                                <tr>
                                    <th class="px-6 py-3">Category Name</th> 
                                    <th class="px-6 py-3">Number of Tasks</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="border-b even:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('category.edit', $category) }}" class="hover:underline text-black">
                                                {{ $category->title }}
                                            </a>
                                        </td>                                      

                                        <td class="px-6 py-4">{{ $category->todos_count }}</td>

                                        <td class="px-6 py-4">
                                            <form method="POST" action="{{ route('category.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-xs">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-black">
                                            No categories available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (session('success'))
                        <div class="mt-6 text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
