<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['name'] =  $user->name;
            $success['role'] = $user->typeUser->name;  // Assume 'typeUser' is your relation name

            return $this->sendResponse($success, 'Sucesso!');
        } else {
            return $this->sendError(__('login failed'), ['error' => 'Falhou']);
        }

    }
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout()
    {
        try {
            Auth::user();

            return $this->sendResponse([], 'Logout feito');
        } catch (\Throwable $th) {
            return $this->sendError("Error", [$th->getMessage()], 500);
        }
    }
}
