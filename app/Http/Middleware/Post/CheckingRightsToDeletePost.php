<?php

namespace App\Http\Middleware\Post;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckingRightsToDeletePost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $post = $request->route('post');
        if ($post->user_id !== auth()->id()) {
            return responseFailed('You dont have access to the current post.', 403);
        }

        return $next($request);
    }
}
