<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\Response;

class UserNotFoundException extends Exception
{
    protected $message = 'User not found';

    public function render()
    {
        return response()->json([
            'error' => $this->getMessage()
        ], Response::HTTP_NOT_FOUND);
    }
}
