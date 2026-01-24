<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkVisit;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    
    public function index()
    {
        $links = auth()
                ->user()
                ->links()
                ->withCount('visits')
                ->orderBy('position', 'asc')
                ->get();
                
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

    public function edit(Link $link)
    {
        if($link->user_id !== auth()->id()) {
            abort(403);
        }

        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $link->update([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        return redirect()->route('dashboard')->with('success', 'Link updated successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        foreach ($request->ids as $index => $id) {
            auth()->user()->links()->where('id', $id)->update(
                ['position' => $index
            ]);
        }

        return response()->json(['message' => 'Urutan berhasil diupdate.']);
    }

    public function visit(Link $link)
    {
        LinkVisit::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->away($link->url);
    }
}
