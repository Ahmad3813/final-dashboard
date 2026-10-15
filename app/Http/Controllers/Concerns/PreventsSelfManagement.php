<?php

namespace App\Http\Controllers\Concerns;


use Illuminate\Http\Request;


trait PreventsSelfManagement
{
    protected function preventSelfManagement(Request $request, int|string $id): void
    {
        if ((int) $request->user()->id === (int) $id) {
            abort(403);
        }
    }
}