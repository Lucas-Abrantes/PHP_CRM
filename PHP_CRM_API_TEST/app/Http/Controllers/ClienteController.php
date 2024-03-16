<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $clientes = Cliente::all();

       return response()->json($clientes);
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
            $cliente = Cliente::create($data);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->sendResponse([], 'Cliente criado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Cliente::where('id', $id)->firstOrFail();

        return $client;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'empresa' => 'required',
            'telefone' => 'required',
            'status'=> 'required'
        ]);

        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->update($data);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->sendResponse([], 'Cliente atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();

        } catch (\Exception $e) {
            throw $e;
        }
        
        return 'Cliente deletado';
    }
}
