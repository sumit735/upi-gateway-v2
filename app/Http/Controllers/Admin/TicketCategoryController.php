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
            'is_active' => 'sometimes|boolean',
        ]);

        $category = TicketCategory::create(array_merge($validated, [
            'is_active' => isset($validated['is_active']) ? (bool)$validated['is_active'] : false,
        ]));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => $category,
            ], 201);
        }

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
            'is_active' => 'sometimes|boolean',
        ]);

        $ticketCategory->update(array_merge($validated, [
            'is_active' => isset($validated['is_active']) ? (bool)$validated['is_active'] : false,
        ]));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'category' => $ticketCategory->fresh(),
            ], 200);
        }

        return redirect()->route('admin.ticket-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category
     */
    public function destroy(TicketCategory $ticketCategory)
    {
        if ($ticketCategory->tickets()->count() > 0) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete category with existing tickets'], 400);
            }

            return redirect()->back()->with('error', 'Cannot delete category with existing tickets');
        }

        $ticketCategory->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully'], 200);
        }

        return redirect()->route('admin.ticket-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
