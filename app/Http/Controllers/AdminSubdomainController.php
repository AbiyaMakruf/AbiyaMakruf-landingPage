<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use App\Models\SubdomainImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminSubdomainController extends Controller
{
    public function index()
    {
        $subdomains = Subdomain::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.dashboard', compact('subdomains'));
    }

    public function create()
    {
        $categories = Subdomain::distinct()->whereNotNull('category')->pluck('category');
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|string', // Comma separated
            'is_active' => 'boolean',
            'is_highlighted' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        $validated['is_active'] = $request->has('is_active');
        $validated['is_highlighted'] = $request->has('is_highlighted');

        // Generate unique slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Subdomain::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $validated['slug'] = $slug;

        $subdomain = Subdomain::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('subdomains/' . $subdomain->id, 'gcs');
                $url = Storage::disk('gcs')->url($path);
                
                $subdomain->images()->create([
                    'image_url' => $url,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Subdomain created successfully.');
    }

    public function edit(Subdomain $subdomain)
    {
        $categories = Subdomain::distinct()->whereNotNull('category')->pluck('category');
        return view('admin.edit', compact('subdomain', 'categories'));
    }

    public function update(Request $request, Subdomain $subdomain)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_active' => 'boolean',
            'is_highlighted' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        $validated['is_active'] = $request->has('is_active');
        $validated['is_highlighted'] = $request->has('is_highlighted');

        // Generate unique slug (excluding current subdomain)
        $slug = Str::slug($validated['name']);
        
        // Always check for uniqueness against other records (excluding current ID)
        // This handles both cases:
        // 1. Name changed -> New slug might conflict with existing record
        // 2. Name NOT changed -> Slug is same, but we must ensure it doesn't conflict (though it shouldn't if logic was correct before)
        // 3. Name changed slightly but slug remains same (e.g. "Test" -> "test") -> Check conflict
        
        $originalSlug = $slug;
        $count = 1;
        
        // Check if this slug exists in ANY record (including soft deleted ones) EXCEPT the current one being updated
        while (Subdomain::withTrashed()->where('slug', $slug)->where('id', '!=', $subdomain->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        $validated['slug'] = $slug;

        $subdomain->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('subdomains/' . $subdomain->id, 'gcs');
                $url = Storage::disk('gcs')->url($path);
                
                $subdomain->images()->create([
                    'image_url' => $url,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Subdomain updated successfully.');
    }

    public function destroy(Subdomain $subdomain)
    {
        $subdomain->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Subdomain deleted successfully.');
    }

    public function deleteImage(SubdomainImage $image)
    {
        // Optional: Delete from GCS as well
        // Storage::disk('gcs')->delete(str_replace(Storage::disk('gcs')->url(''), '', $image->image_url));
        
        $image->delete();
        return back()->with('success', 'Image deleted.');
    }
}
