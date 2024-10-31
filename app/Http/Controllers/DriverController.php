<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->has('number')) {
            $driver = Driver::where('contact', $request->number)->first();

            if ($driver) {
                return response()->json($driver);
            } else {
                return response()->json(['message' => 'Driver tidak ditemukan'], 404);
            }
        } else {
            $drivers = Driver::select([
                'id', 
                'name', 
                'nrp', 
                'contact', 
                'regency_id', 
                'licence_number', 
                'licence_active', 
                'licence_type', 
                'is_active', 
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])->get();

            return response()->json($drivers);
        }
    }
}
