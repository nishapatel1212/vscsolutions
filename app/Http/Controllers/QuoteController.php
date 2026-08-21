<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with('items')
            ->latest()
            ->get();

        return view(
            'admin_panel.quote.index',
            compact('quotes')
        );
    }


    public function create()
    {
        // Example: 20082026A
        $quoteNumber = now()->format('dmY') . 'A';

        return view(
            'admin_panel.quote.create',
            compact('quoteNumber')
        );
    }


    public function store(Request $request)
    {
        $request->validate([

            'quote_date' => 'required|date',

            'customer_name' => 'required|string|max:255',

            'customer_email' => 'nullable|email',

            'customer_phone' => 'nullable|string|max:50',

            'customer_address' => 'nullable|string',

            'description' => 'required|array|min:1',
            'description.*' => 'required|string',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:0',

            'amount' => 'required|array|min:1',
            'amount.*' => 'required|numeric|min:0',

            'notes' => 'nullable|string',

        ]);


        DB::beginTransaction();

        try {

            /*
             * Generate Quote Number
             *
             * Example:
             * 20082026A
             * 20082026B
             * 20082026C
             */

            $datePrefix = Carbon::parse(
                $request->quote_date
            )
                ->timezone('Australia/Melbourne')
                ->format('dmY');


            $lastQuote = Quote::where(
                'quote_number',
                'like',
                $datePrefix . '%'
            )
                ->orderByDesc('id')
                ->first();


            if ($lastQuote) {

                $lastLetter = substr(
                    $lastQuote->quote_number,
                    -1
                );

                $nextLetter = chr(
                    ord($lastLetter) + 1
                );
            } else {

                $nextLetter = 'A';
            }


            $quoteNumber = $datePrefix . $nextLetter;


            /*
             * Calculate Subtotal
             */

            $subtotal = 0;


            foreach (
                $request->description as $key => $description
            ) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $subtotal += $quantity * $amount;
            }


            /*
             * GST
             *
             * Currently GST = 0
             */

            $tax = 0;

            $total = $subtotal + $tax;


            /*
             * Create Quote
             */

            $quote = Quote::create([

                'quote_number' => $quoteNumber,

                'quote_date' => $request->quote_date,

                'customer_name' => $request->customer_name,

                'customer_email' => $request->customer_email,

                'customer_phone' => $request->customer_phone,

                'customer_address' => $request->customer_address,

                'subtotal' => $subtotal,

                'tax' => $tax,

                'total' => $total,

                'notes' => $request->notes,

            ]);


            /*
             * Create Quote Items
             */

            foreach (
                $request->description as $key => $description
            ) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $itemTotal = $quantity * $amount;


                $quote->items()->create([

                    'description' => $description,

                    'quantity' => $quantity,

                    'amount' => $amount,

                    'total' => $itemTotal,

                ]);
            }


            DB::commit();


            return redirect()
                ->route('quote.index')
                ->with(
                    'success',
                    'Quote ' . $quoteNumber . ' created successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function edit($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        return view(
            'admin_panel.quote.edit',
            compact('quote')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'quote_date' => 'required|date',

            'customer_name' => 'required|string|max:255',

            'customer_email' => 'nullable|email',

            'customer_phone' => 'nullable|string|max:50',

            'customer_address' => 'nullable|string',

            'description' => 'required|array|min:1',
            'description.*' => 'required|string',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',

            'amount' => 'required|array|min:1',
            'amount.*' => 'required|numeric|min:0',

            'notes' => 'nullable|string',

        ]);


        DB::beginTransaction();

        try {

            /*
            * Find Quote
            */

            $quote = Quote::with('items')
                ->findOrFail($id);


            /*
            * Calculate Subtotal
            */

            $subtotal = 0;


            foreach ($request->description as $key => $description) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $subtotal += $quantity * $amount;
            }


            /*
            * GST
            *
            * Currently 0
            */

            $tax = 0;

            $total = $subtotal + $tax;


            /*
            * Update Quote
            */

            $quote->update([

                'quote_date' => $request->quote_date,

                'customer_name' => $request->customer_name,

                'customer_email' => $request->customer_email,

                'customer_phone' => $request->customer_phone,

                'customer_address' => $request->customer_address,

                'subtotal' => $subtotal,

                'tax' => $tax,

                'total' => $total,

                'notes' => $request->notes,

            ]);


            /*
            * Delete Existing Items
            */

            $quote->items()->delete();


            /*
            * Create Updated Items
            */

            foreach ($request->description as $key => $description) {

                $quantity = (float) $request->quantity[$key];

                $amount = (float) $request->amount[$key];

                $itemTotal = $quantity * $amount;


                $quote->items()->create([

                    'description' => $description,

                    'quantity' => $quantity,

                    'amount' => $amount,

                    'total' => $itemTotal,

                ]);
            }


            DB::commit();


            return redirect()
                ->route('quote.index')
                ->with(
                    'success',
                    'Quote ' . $quote->quote_number .
                        ' updated successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    public function show($id)
    {
        $quote = Quote::with('items')
            ->findOrFail($id);

        return view(
            'admin_panel.quote.show',
            compact('quote')
        );
    }
}
