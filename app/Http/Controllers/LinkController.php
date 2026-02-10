<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkVisit;
use App\Models\ProfileVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        
        $links = $user->links()
                    ->withCount('visits')
                    ->orderBy('position', 'asc')
                    ->get();

        $totalViews = ProfileVisit::where('user_id', $user->id)->count();

        $totalLinkClicks = $user->links()->withCount('visits')->get()->sum('visits_count');
        
        return view('dashboard', compact('links', 'totalViews', 'totalLinkClicks'));
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
        if ($link->user_id !== auth()->id()) {
            abort(403, 'Akses Ditolak');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url',
            'icon'  => 'nullable|image|max:2048', // Max 2MB
        ]);

        $link->title = $validated['title'];
        $link->url   = $validated['url'];

        if ($request->hasFile('icon')) {
            if ($link->icon_path) {
                Storage::disk('public')->delete($link->icon_path);
            }

            $link->icon_path = $request->file('icon')->store('link-icons', 'public');
        }

        $link->save();

        return redirect()->route('dashboard')->with('success', 'Link berhasil diupdate!');
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
