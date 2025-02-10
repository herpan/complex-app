<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{    
     //Controller Soal No. 8
    public function index(Request $request)
    {
        $query = Post::query();
    
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
    
        $posts = $query->paginate($request->input('limit', 10));
    
        return response()->json(['posts' => $posts], 200);
    }

    //Controller Soal No. 6
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
            ]);

            // Autentikasi pengguna dengan JWT
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'message' => 'User not found or unauthorized'
                ], 401);
            }

            // Buat post baru
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => $user->id,
            ]);

            // Beri respon sukses
            return response()->json([
                'post' => $post,
                'message' => 'Post created successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);        
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
