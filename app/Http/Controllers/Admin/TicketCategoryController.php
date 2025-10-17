<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the categories
     */
    public function index()
    {
        $categories = TicketCategory::withCount('tickets')->latest()->get();
        return view('admin.tickets.categories.index', compact('categories'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7',
            'is_active' => 'boolean',
        ]);

        TicketCategory::create($validated);

        return redirect()->route('admin.ticket-categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, TicketCategory $ticketCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7',
            'is_active' => 'boolean',
        ]);

        $ticketCategory->update($validated);

        return redirect()->route('admin.ticket-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category
     */
    public function destroy(TicketCategory $ticketCategory)
    {
        if ($ticketCategory->tickets()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with existing tickets');
        }

        $ticketCategory->delete();

        return redirect()->route('admin.ticket-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
