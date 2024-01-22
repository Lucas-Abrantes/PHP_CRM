<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = User::orderBy('created_at', 'desc')
        ->where('status', 1)
        ->withRequestFilters($request)
        ->orderByRaw('created_at DESC');

        return $clients;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
            'email' => 'required',
            'empresa' => 'required',
            'telefone' => 'required'
        ]);

        $data['password'] = Hash::make($request->password);

        try {
            auth()->user()->store($data);
        } catch (\Exception $e) {
            throw $e;

            return $this->sendError('Erro', [], 400);
        }

        return $this->sendResponse([], 'Cliente criado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = User::where('id', $id)->firstOrFail();

        return $client;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'nullable|min:8|confirmed',
            'email' => 'required',
            'empresa' => 'required',
            'telefone' => 'required'
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        try {
            auth()->user()->update($data);
        } catch (\Exception $e) {
            throw $e;

            return $this->sendError('Erro', [], 403);
        }

        return $this->sendResponse([], 'Cliente atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::where('id', $id)->delete();

        } catch (\Exception $e) {
            throw $e;

            return $this->sendError('Erro', [], 400);
        }
        
        return 'Cliente deletado hahaha';

    }
}
