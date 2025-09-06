<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function update(Request $request, ErrorLog $errorLog)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:actual,fixed,stopped',
            'solution' => 'nullable|string'
        ]);

        if (isset($validated['status'])) {
            switch ($validated['status']) {
                case 'fixed':
                    $validated['fixed_at'] = now();
                    break;
                case 'stopped':
                    $validated['stopped_at'] = now();
                    $validated['resumed_at'] = null;
                    break;
                case 'actual':
                    // If resuming from stopped state
                    if ($errorLog->status === 'stopped') {
                        $validated['resumed_at'] = now();
                    }
                    break;
            }
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
