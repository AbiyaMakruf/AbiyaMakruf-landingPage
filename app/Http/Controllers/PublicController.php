<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Subdomain::query()
            ->where('is_active', true)
            ->with('images');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('title', 'ilike', "%{$search}%")
                  ->orWhere('short_description', 'ilike', "%{$search}%");
            });
        }

        if ($request->has('sort')) {
            switch ($request->get('sort')) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('is_highlighted', 'desc')->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('is_highlighted', 'desc')->orderBy('created_at', 'desc');
        }

        $subdomains = $query->get();

        return view('welcome', compact('subdomains'));
    }

    public function show(Subdomain $subdomain)
    {
        if (!$subdomain->is_active) {
            abort(404);
        }
        $subdomain->load('images');
        return response()->json($subdomain);
    }
}
