<?php

    namespace App\Http\Controllers;

    use App\Models\Account;
    use App\Models\Category;
    use App\Models\Transaction;
    use Exception;
    use Illuminate\Http\Request;

    class TransactionController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            // Won't be used
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create(Account $account)
        {
            // Form for creating new transaction
            return view('transactions.create', ['account' => $account]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request, Account $account)
        {
            $balance_before = $account->transactions()
                ->where('date', '<', $request->input('date'))
                ->orderby('date', 'desc')
                ->first()->amount_after ?? 0;

            $amount = str_replace(',', '.', $request->input('amount'));

            Category::firstOrCreate(['name' => $request->input('category')]);

            // store new transaction to account
            $account->transactions()->create([
                'id' => null,
                'account' => $request->input('account'),
                'sender' => $request->input('sender'),
                'receiver' => $request->input('receiver'),
                'description' => $request->input('description'),
                'amount' => $amount,
                'amount_after' => $balance_before + $amount,
                'date' => $request->input('date'),
                'category' => $request->input('category') ?? 'None'
            ]);

            // Update all transactions
            $this->updateTransactions($account, $request->input('date'), $balance_before + $amount);

            // Update account with new balance of last transaction
            $account->balance = $account
                ->transactions()
                ->orderBy('date', 'desc')
                ->first()->amount_after;

            $account->save();

            return redirect(route('accounts.show', $account->fresh()))->with('success', 'Created new transaction successfully.');
        }

        private function updateTransactions(Account $account, string $date, $newAmount): void
        {
            // Get all transaction after the date of the new one and update amount after
            $nextTransactions = $account
                ->transactions()
                ->where('date', '>', $date)
                ->orderby('date')
                ->get();

            // Balance after this transaction
            $newAmountAfter = $newAmount;

            /** @var Transaction $nextTransaction */
            foreach ($nextTransactions as $nextTransaction) {

                $newAmountAfter += $nextTransaction->amount;

                $nextTransaction->amount_after = $newAmountAfter;
                $nextTransaction->save();
            }
        }

        /**
         * Display the specified resource.
         */
        public function show(Transaction $transaction)
        {
            // Won't be used
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Account $account, Transaction $transaction)
        {
            // Form to update the description, amount and receiver, date, category
            return view('transactions.edit', ['account' => $account, 'transaction' => $transaction]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Account $account, Transaction $transaction)
        {
            $updateTransactions = false;
            // If receiver changed
            if ($request->input('receiver') !== $transaction->receiver) {
                $transaction->receiver = $request->input('receiver');
                $transaction->save();
            }

            // If desc changed
            if ($request->input('description') !== $transaction->description) {
                $transaction->description = $request->input('description');
                $transaction->save();
            }

            // If amount changed, update amount after and set flag for updating all transactions afterward
            $amount = str_replace(',', '.', $request->input('amount'));
            $balance_before = $account->transactions()
                ->where('date', '<', $request->input('date'))
                ->orderby('date', 'desc')
                ->first()->amount_after ?? 0;

            if ($amount !== $transaction->amount) {
                $transaction->amount = $amount;


                $transaction->amount_after = $balance_before + $amount;
                $transaction->save();

                $updateTransactions = true;
            }

            // If date changed
            if ($request->input('date') !== $transaction->date) {
                $transaction->date = $request->input('date');
                $transaction->save();
            }

            // If category changed
            if ($request->input('category') !== $transaction->category) {
                Category::firstOrCreate(['name' => $request->input('category')]);
                $transaction->category = $request->input('category');
                $transaction->save();
            }


            if ($updateTransactions) {
                $this->updateTransactions($account, $request->input('date'), $balance_before + $amount);
            }

            // Update account with new balance of last transaction
            $account->balance = $account->transactions()->orderBy('date', 'desc')->first()->amount_after;
            $account->save();

            return redirect(route('accounts.show', ['account' => $account->fresh()]))->with('success', 'Transaction updated successfully');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Account $account, Transaction $transaction)
        {
            $date = $transaction->date;

            $amount_before = $account->transactions()
                ->where('date', '<', $date)
                ->orderby('date', 'desc')
                ->first()->amount_after ?? 0;

            try {
                $transaction->delete();

                $this->updateTransactions($account, $date, $amount_before);
                // Update account with new balance of last transaction
                $account->balance = $account
                    ->transactions()
                    ->orderBy('date', 'desc')
                    ->first()->amount_after;

                $account->save();
            } catch (Exception $exception) {
                return redirect()->back()->with('error', 'Failed to delete transaction. Try again later.');
            }

            return redirect(route('accounts.show', ['account' => $account->fresh()]))->with('success', 'Transaction deleted successfully');
        }
    }
