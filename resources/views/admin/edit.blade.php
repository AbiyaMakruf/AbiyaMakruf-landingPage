<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Edit Subdomain</h2>
        </div>

        <div class="bg-white shadow-lg sm:rounded-xl p-8 border border-slate-100">
            <form action="{{ route('admin.update', $subdomain) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Title</label>
                        <input type="text" name="title" value="{{ old('title', $subdomain->title) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Subdomain Name</label>
                        <input type="text" name="name" value="{{ old('name', $subdomain->name) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Full URL</label>
                        <input type="url" name="url" value="{{ old('url', $subdomain->url) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Short Description</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $subdomain->short_description) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Long Description</label>
                        <textarea name="long_description" rows="4" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">{{ old('long_description', $subdomain->long_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Category</label>
                        <input type="text" name="category" value="{{ old('category', $subdomain->category) }}" list="categories" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                        <datalist id="categories">
                            @foreach($categories as $category)
                                <option value="{{ $category }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tags (comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', implode(', ', $subdomain->tags ?? [])) }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 bg-white text-slate-900">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Add New Screenshots</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-slate-500">Hold Ctrl (Windows) or Command (Mac) to select multiple images.</p>
                    </div>

                    <!-- Existing Images -->
                    @if($subdomain->images->count() > 0)
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Current Images</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach($subdomain->images as $image)
                                    <div class="relative group">
                                        <img src="{{ $image->image_url }}" class="h-24 w-full object-cover rounded-lg shadow-sm">
                                        <button type="button" onclick="if(confirm('Delete this image?')) document.getElementById('delete-image-{{ $image->id }}').submit()" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $subdomain->is_active ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                            <label class="ml-2 block text-sm text-slate-700">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_highlighted" value="1" {{ $subdomain->is_highlighted ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                            <label class="ml-2 block text-sm text-slate-700">Highlight</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="bg-white py-2 px-4 border border-slate-300 rounded-lg shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update
                    </button>
                </div>
            </form>
            
            <!-- Hidden forms for image deletion -->
            @foreach($subdomain->images as $image)
                <form id="delete-image-{{ $image->id }}" action="{{ route('admin.image.delete', $image) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
</x-app-layout>
