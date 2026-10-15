<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }
    public function create()
    {
        return view('blogs.create-blog');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'short_title' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()
            ->route('blog')
            ->with('success', 'Blog created successfully.');
    }
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()
            ->route('blog')
            ->with('success', 'Blog deleted successfully.');
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.view-blog', compact('blog'));
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.edit-blog', compact('blog'));
    }
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'short_title' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $validated['image'] = $request->file('image')
                ->store('blogs', 'public');
        }



        $blog->update($validated);

        return redirect()
            ->route('blog')
            ->with('success', 'Blog updated successfully.');
    }
}
