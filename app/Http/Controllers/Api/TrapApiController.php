<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trap;

class TrapApiController extends Controller
{
    public function index()
    {
        $traps = Trap::orderBy('type_detector')
            ->orderBy('no_trap')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data trap berhasil diambil',
            'data' => $traps,
        ]);
    }

    public function show(Trap $trap)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data trap berhasil diambil',
            'data' => $trap,
        ]);
    }
}