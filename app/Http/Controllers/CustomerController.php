<?php

// app/Http/Controllers/CustomerController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('quotes')->latest('id')->get();
        return view('admin_panel.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin_panel.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        return view('admin_panel.customers.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function show($id)
    {
        $customer = Customer::with('quotes')->findOrFail($id);
        return view('admin_panel.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted.');
    }
}
