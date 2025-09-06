<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\ErrorLog;
use Illuminate\Http\Request;

class MachineErrorLogController extends Controller
{
    public function index(Machine $machine)
    {
        $errorLogs = $machine->errorLogs()->with(['machines', 'tools'])->get();
        return response()->json($errorLogs);
    }

    public function store(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'sometimes|in:actual,fixed'
        ]);

        $errorLog = ErrorLog::create(array_merge($validated, [
            'status' => $validated['status'] ?? 'actual'
        ]));

        $machine->errorLogs()->attach($errorLog);

        return response()->json($errorLog->load('machines'), 201);
    }
}