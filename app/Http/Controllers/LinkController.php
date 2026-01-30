<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon_path' => 'nullable|image|max:2048',
        ]);

        $iconPath = null;
        if($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('link-icons', 'public');
        }

        $request->user()->links()->create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'icon_path' => $iconPath,
        ]);

        return back()->with('success', 'Link Berhasil Ditambahkan.');
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
        if($link->user_id !== auth()->id()) {
            abort(403, 'Akses Ditolak');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|image|max:2048',
        ]);

        $link->title = $validated['title'];
        $link->url = $validated['url'];

        if($request->hasFile('icon')) {
            if($link->icon_path) {
                Storage::disk('public')->delete($link->icon_path);
            }

            $link->icon_path = $request->file('icon')->store('link-icons', 'public');
        }

        $link->save();

        return back()->with('success', 'Link berhasil diupdate!');  
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
