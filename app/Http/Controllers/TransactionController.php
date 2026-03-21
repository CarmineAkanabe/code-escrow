<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $updatedTransaction = Transaction::with('gig')->get();
        
        return TransactionResource::collection($updatedTransaction);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function release(Transaction $transaction, PaymentService $paymentService): JsonResponse
    {
        try {
            $updatedTransaction = $paymentService->releaseFunds($transaction);

            return response()->json([
                'message' => 'Funds released successfully.',
                'data' => $updatedTransaction
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
