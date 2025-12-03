<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
            <a href="{{ route('admin.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm">
                + Add Subdomain
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-lg sm:rounded-xl overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Title / Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($subdomains as $subdomain)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-slate-100 rounded-lg overflow-hidden">
                                            @if($subdomain->thumbnail())
                                                <img class="h-10 w-10 object-cover" src="{{ $subdomain->thumbnail() }}" alt="">
                                            @else
                                                <div class="flex items-center justify-center h-full text-slate-400 font-bold">
                                                    {{ substr($subdomain->title, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">
                                                {{ $subdomain->title }}
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                {{ $subdomain->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $subdomain->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $subdomain->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($subdomain->is_highlighted)
                                        <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Featured
                                        </span>
                                    @endif
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $subdomain->category ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.edit', $subdomain) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <div x-data="{ open: false }" class="inline-block">
                                        <button @click="open = true" class="text-red-600 hover:text-red-900">Delete</button>
                                        
                                        <!-- Delete Confirmation Modal -->
                                        <div x-show="open" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true" @click="open = false"></div>

                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full relative z-50">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                                                    Delete Subdomain
                                                                </h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-slate-500">
                                                                        Are you sure you want to delete <strong>{{ $subdomain->title }}</strong>?
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <form action="{{ route('admin.destroy', $subdomain) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Delete
                                                            </button>
                                                        </form>
                                                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $subdomains->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
