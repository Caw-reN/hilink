<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    
    public function index()
    {
        $links = auth()->user()->links()->orderBy('position', 'asc')->get();
        return view('dashboard', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $position = auth()->user()->links()->max('position') + 1;

        auth()->user()->links()->create([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        return redirect()->back()->with('success', 'Link added successfully.');
    }

    public function destroy(Link $link)
    {
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        $link->delete();

        return redirect()->back()->with('success', 'Link deleted successfully.');
    }
}
