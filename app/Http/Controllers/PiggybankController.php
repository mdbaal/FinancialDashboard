<?php

namespace App\Http\Controllers;

use App\Models\Piggybank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PiggybankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('piggybanks');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Piggybank $piggybank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piggybank $piggybank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piggybank $piggybank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piggybank $piggybank)
    {
        //
    }
}
