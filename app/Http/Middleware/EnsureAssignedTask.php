<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAssignedTask
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        $task = Task::findOrFail($request->route('id'));

        if (
            in_array($user->role, ['admin', 'tester'], true)
            && $task->assigned_to !== $user->id
        ) {
            abort(403);
        }

        return $next($request);
    }
}
