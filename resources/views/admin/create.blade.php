<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Subdomain</h2>
        </div>

        <div class="bg-white shadow-xl sm:rounded-xl p-4 sm:p-8 border border-gray-100">
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Subdomain Name (e.g. panel.example.com)</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Full URL</label>
                        <input type="url" name="url" required placeholder="https://..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Short Description</label>
                        <input type="text" name="short_description" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Long Description</label>
                        <textarea name="long_description" rows="4" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors"></textarea>
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" list="categories" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                        <datalist id="categories">
                            @foreach($categories as $category)
                                <option value="{{ $category }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Tags (comma separated)</label>
                        <input type="text" name="tags" placeholder="internal, production" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-gray-50 text-gray-900 transition-colors">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Screenshots</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                        <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple images.</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_highlighted" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">Highlight</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
