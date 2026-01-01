<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Get all published blog posts
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all published posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="List of published posts",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Posts retrieved successfully")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $posts = Post::published()
                ->with(['user:id,name', 'approvedComments'])
                ->withCount('approvedComments')
                ->latest('published_at')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $posts,
                'message' => 'Posts retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve posts',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single blog post by slug
     * 
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Get(
     *     path="/api/posts/{slug}",
     *     summary="Get a single post by slug",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Post slug",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Post retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Post not found")
     *         )
     *     )
     * )
     */
    public function show($slug)
    {
        try {
            $post = Post::published()
                ->where('slug', $slug)
                ->with([
                    'user:id,name,email',
                    'approvedComments' => function($query) {
                        $query->latest();
                    }
                ])
                ->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'error' => 'Post not found or not published'
                ], 404);
            }

            // Increment view count (optional)
            $post->increment('views');

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve post',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit a comment for a published post
     * 
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Post(
     *     path="/api/posts/{slug}/comments",
     *     summary="Submit a comment for a post",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Post slug",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"author_name","author_email","content"},
     *             @OA\Property(property="author_name", type="string", example="John Doe"),
     *             @OA\Property(property="author_email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="content", type="string", example="Great post!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment submitted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Comment submitted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Post not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function storeComment(Request $request, $slug)
    {
        try {
            // First, find the published post
            $post = Post::published()->where('slug', $slug)->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'error' => 'Post not found or not published'
                ], 404);
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'author_name' => 'required|string|max:255',
                'author_email' => 'required|email|max:255',
                'content' => 'required|string|min:3|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create the comment
            $comment = $post->comments()->create([
                'author_name' => $request->author_name,
                'author_email' => $request->author_email,
                'content' => $request->content,
                'status' => 'pending', // Comments need approval
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $comment->id,
                    'author_name' => $comment->author_name,
                    'author_email' => $comment->author_email,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at,
                ],
                'message' => 'Comment submitted successfully. It will be visible after approval.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to submit comment',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get comments for a specific post
     * 
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($slug)
    {
        try {
            $post = Post::published()->where('slug', $slug)->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'error' => 'Post not found'
                ], 404);
            }

            $comments = $post->approvedComments()
                ->latest()
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $comments,
                'message' => 'Comments retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve comments',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}