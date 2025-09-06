<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function update(Request $request, ErrorLog $errorLog)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:actual,fixed',
            'solution' => 'nullable|string'
        ]);

        if (isset($validated['status']) && $validated['status'] === 'fixed') {
            $validated['fixed_at'] = now();
        }

        $errorLog->update($validated);

        return response()->json($errorLog->fresh());
    }

    public function destroy(ErrorLog $errorLog)
    {
        $errorLog->delete();
        return response()->json(null, 204);
    }
}