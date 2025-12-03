<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-slate-900 py-16 sm:py-24 text-center px-4 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/20 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white mb-6 tracking-tight">
                Explore My <span class="text-indigo-400">Project</span>
            </h1>
            
            <!-- Search -->
            <div class="max-w-2xl mx-auto relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search subdomains..." 
                        class="w-full bg-white border-0 text-slate-900 rounded-lg py-4 px-6 shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-slate-400 text-lg"
                    >
                    <button type="submit" class="absolute right-3 top-3 text-slate-400 hover:text-indigo-600 p-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-8 relative z-20">
        
        <!-- Filters/Sort (Simple UI) -->
        <div class="flex justify-end mb-8">
            <form action="{{ route('home') }}" method="GET" class="flex items-center space-x-2 bg-white p-1 rounded-lg shadow-sm border border-slate-200">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="sort" onchange="this.form.submit()" class="bg-transparent border-none text-slate-600 text-sm focus:ring-0 cursor-pointer font-medium">
                    <option value="highlighted" {{ request('sort') == 'highlighted' ? 'selected' : '' }}>Featured First</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Added</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                </select>
            </form>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($subdomains as $subdomain)
                <div x-data="{ open: false }" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-slate-100 flex flex-col h-full">
                    <!-- Thumbnail -->
                    <div class="h-48 bg-slate-100 relative overflow-hidden">
                        @if($subdomain->thumbnail())
                            <img src="{{ $subdomain->thumbnail() }}" alt="{{ $subdomain->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="flex items-center justify-center h-full bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <span class="text-5xl font-bold opacity-20">{{ substr($subdomain->title, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        @if($subdomain->is_highlighted)
                            <div class="absolute top-3 right-3 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                Featured
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $subdomain->title }}</h3>
                            @if($subdomain->category)
                                <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-full font-medium border border-slate-200">{{ $subdomain->category }}</span>
                            @endif
                        </div>
                        <p class="text-slate-500 text-sm mb-6 line-clamp-2 flex-grow">
                            {{ $subdomain->short_description }}
                        </p>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                            <button @click="open = true" class="text-slate-600 font-medium text-sm hover:text-indigo-600 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Details
                            </button>
                            <a href="{{ $subdomain->url }}" target="_blank" class="bg-slate-900 hover:bg-indigo-600 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Visit
                            </a>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="open = false"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-200 relative z-50 max-h-[90vh] flex flex-col">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 overflow-y-auto">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-3xl leading-8 font-bold text-slate-900 mb-2" id="modal-title">
                                                {{ $subdomain->title }}
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-indigo-600 font-medium mb-6 flex items-center justify-center sm:justify-start">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                                    <a href="{{ $subdomain->url }}" target="_blank" class="hover:underline">{{ $subdomain->name }}</a>
                                                </p>
                                                
                                                <!-- Gallery Slider (Simple Alpine) -->
                                                @if($subdomain->images->count() > 0)
                                                    <div x-data="{ activeSlide: 0, slides: {{ $subdomain->images->pluck('image_url') }} }" class="relative w-full h-72 bg-slate-100 rounded-xl mb-6 overflow-hidden shadow-inner border border-slate-200 z-0">
                                                        <template x-for="(slide, index) in slides" :key="index">
                                                            <div x-show="activeSlide === index" class="absolute inset-0 transition-opacity duration-500">
                                                                <img :src="slide" class="w-full h-full object-cover">
                                                            </div>
                                                        </template>
                                                        
                                                        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2" x-show="slides.length > 1">
                                                            <template x-for="(slide, index) in slides" :key="index">
                                                                <button @click="activeSlide = index" :class="{'bg-white scale-125': activeSlide === index, 'bg-white/50 hover:bg-white/80': activeSlide !== index}" class="w-2.5 h-2.5 rounded-full transition-all shadow-sm"></button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="text-slate-600 leading-relaxed text-left relative z-10 bg-white">
                                                    <h4 class="font-semibold text-slate-900 mb-2">Description</h4>
                                                    <div class="prose prose-slate max-w-none">
                                                        @if($subdomain->long_description)
                                                            {!! nl2br(e($subdomain->long_description)) !!}
                                                        @else
                                                            <p>{{ $subdomain->short_description }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($subdomain->tags)
                                                    <div class="mt-6 flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                                                        @foreach($subdomain->tags as $tag)
                                                            <span class="bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full border border-slate-200">
                                                                #{{ $tag }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-200">
                                    <a href="{{ $subdomain->url }}" target="_blank" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                        Visit Subdomain
                                    </a>
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-5 py-2.5 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors" @click="open = false">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="inline-block p-4 rounded-full bg-slate-100 mb-4">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">No subdomains found</h3>
                    <p class="text-slate-500 mt-1">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
