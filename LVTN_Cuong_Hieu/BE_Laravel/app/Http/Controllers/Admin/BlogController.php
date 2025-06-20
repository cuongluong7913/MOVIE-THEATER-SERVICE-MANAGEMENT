<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    // Hiển thị danh sách và tìm kiếm
    public function index(Request $request)
    {
        $querry = Blog::with('admin');
        if ($request->has('keyword')) {
            $querry->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%');
        }

        return response()->json($querry->latest()->paginate(10));
    }

    //Thêm
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|integer|min:1|exists:admins,id', // Kiểu số + số nguyên dương
            'title' => [
                'required',
                'string',
                'min:5',
                'max:100',
                'regex:/^[\pL\s0-9\.,!?-]+$/u' // kiểm tra ký tự cho phép
            ],
            'content' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        ;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $blog = Blog::create($validated);
        return response()->json($blog, 201);
    }

    //Cập nhật 
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $validated = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'min:5',
                'max:100',
                'regex:/^[\pL\s0-9\.,!?-]+$/u' // giống như trên
            ],
            'content' => 'sometimes|required|string|min:10',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $blog->image = $request->file('image')->store('images', 'public');
        }

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();
        return response()->json($blog);
    }

    //Xoá
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(['message' => 'Blog được xoá thành công']);
    }

    //Thống kê số lượng blog
    public function count()
    {
        $count = Blog::count();
        return response()->json(['total_blogs' => $count]);
    }
}