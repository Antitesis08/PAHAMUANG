<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Interface ApiInterface
 * Sesuai class diagram: ApiInterface dengan 4 method CRUD standar.
 */
interface ApiInterface
{
    public function index(): \Inertia\Response;
    public function store(Request $request): \Illuminate\Http\RedirectResponse;
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse;
    public function destroy($id): \Illuminate\Http\RedirectResponse;
}