<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No transactions found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transactions retrieved successfully',
            'data' => $transactions,
        ], 200);
    }

    public function show(string $id) {
        $transaction = Transaction::with(['user', 'book'])->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'transaction not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'transaction retrieved successfully',
            'data' => $transaction,
        ], 200);
    }

    public function store(Request $request)
    {
        //1. validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validartion error',
                'data' => $validator->errors()
            ], 422);
        }

        //2. generate orderNumber -> unique | ORD-0003
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        //3. ambil user yang sedang login & cek login (apakah ada data user?)
        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        //4. mencari data buku dari request
        $book = Book::find($request->book_id);

        //5. cek stock buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 400);
        }

        //6. hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;    

        //7. kurangi stock buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        //8. simpan data transaksi
        $transactions = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully!',
            'data' => $transactions
        ], 201);       
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        // 2. Cari transaksi
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        // 3. Cari buku lama & buku baru
        $oldBook = Book::find($transaction->book_id);
        $newBook = Book::find($request->book_id);

        // 4. Kembalikan stok buku lama
        if ($oldBook) {
            $oldQuantity = $transaction->total_amount / $oldBook->price;
            $oldBook->stock += (int) $oldQuantity;
            $oldBook->save();
        }

        // 5. Cek stok buku baru
        if ($newBook->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock for the selected book',
            ], 400);
        }

        // 6. Hitung total harga baru
        $totalAmount = $newBook->price * $request->quantity;

        // 7. Kurangi stok buku baru
        $newBook->stock -= $request->quantity;
        $newBook->save();

        // 8. Update transaksi
        $transaction->book_id = $request->book_id;
        $transaction->total_amount = $totalAmount;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ], 200);
    }

    public function destroy(string $id) {
        $transaction = Transaction::find($id);
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        // Cari buku terkait
        $book = Book::find($transaction->book_id);
        if ($book) {
            // Kembalikan stok buku
            $quantity = $transaction->total_amount / $book->price;
            $book->stock += (int) $quantity;
            $book->save();
        }

        // Hapus transaksi
        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction cancelled and stock restored',
        ], 200);
    }
}