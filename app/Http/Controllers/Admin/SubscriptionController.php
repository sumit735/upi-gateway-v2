<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions
     */
    public function index()
    {
        $subscriptions = Subscription::ordered()->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Get subscriptions list for DataTable (API)
     */
    public function list(Request $request)
    {
        try {
            $subscriptions = Subscription::ordered()->get();

            return DataTables::of($subscriptions)
                ->addColumn('duration', function ($subscription) {
                    return '<span class="badge bg-info">' . $subscription->duration_text . '</span>';
                })
                ->addColumn('price_display', function ($subscription) {
                    $html = '<div>';
                    $html .= '<span class="fw-bold text-primary">₹' . number_format($subscription->final_price, 2) . '</span>';
                    if ($subscription->discount_percentage > 0) {
                        $html .= '<br><small class="text-muted"><del>₹' . number_format($subscription->price, 2) . '</del></small>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('discount_display', function ($subscription) {
                    if ($subscription->discount_percentage > 0) {
                        return '<span class="badge bg-success-transparent text-success">' . 
                               number_format($subscription->discount_percentage, 2) . '% OFF</span>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('status_badge', function ($subscription) {
                    if ($subscription->is_active) {
                        return '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Active</span>';
                    }
                    return '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Inactive</span>';
                })
                ->addColumn('popular_badge', function ($subscription) {
                    if ($subscription->is_popular) {
                        return '<span class="badge bg-warning"><i class="ti ti-star me-1"></i>Popular</span>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('actions', function ($subscription) {
                    $actions = '<div class="d-flex gap-2 justify-content-end">';
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-light" onclick="viewSubscription(' . $subscription->id . ')" title="View Details">';
                    $actions .= '<i class="ti ti-eye"></i>';
                    $actions .= '</button>';
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-primary" onclick="editSubscription(' . $subscription->id . ')" title="Edit">';
                    $actions .= '<i class="ti ti-edit"></i>';
                    $actions .= '</button>';
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-danger" onclick="deleteSubscription(' . $subscription->id . ', \'' . addslashes($subscription->name) . '\')" title="Delete">';
                    $actions .= '<i class="ti ti-trash"></i>';
                    $actions .= '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['duration', 'price_display', 'discount_display', 'status_badge', 'popular_badge', 'actions'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load subscriptions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the subscription details
     */
    public function show(Subscription $subscription)
    {
        return response()->json([
            'success' => true,
            'subscription' => $subscription
        ]);
    }

    /**
     * Store a newly created subscription
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subscriptions,name',
            'duration_type' => 'required|in:days,months,years',
            'duration_value' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['discount_percentage'] = $request->discount_percentage ?? 0;
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['is_popular'] = $request->has('is_popular') ? 1 : 0;
            $data['sort_order'] = $request->sort_order ?? 0;

            // Handle features array
            if ($request->has('features') && is_array($request->features)) {
                $data['features'] = array_filter($request->features);
            }

            $subscription = Subscription::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Subscription plan created successfully',
                'subscription' => $subscription
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription plan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified subscription
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subscriptions,name,' . $subscription->id,
            'duration_type' => 'required|in:days,months,years',
            'duration_value' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['discount_percentage'] = $request->discount_percentage ?? 0;
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['is_popular'] = $request->has('is_popular') ? 1 : 0;
            $data['sort_order'] = $request->sort_order ?? 0;

            // Handle features array
            if ($request->has('features') && is_array($request->features)) {
                $data['features'] = array_filter($request->features);
            }

            $subscription->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Subscription plan updated successfully',
                'subscription' => $subscription
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update subscription plan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle subscription status
     */
    public function toggleStatus(Subscription $subscription)
    {
        try {
            $subscription->is_active = !$subscription->is_active;
            $subscription->save();

            return response()->json([
                'success' => true,
                'message' => 'Subscription status updated successfully',
                'is_active' => $subscription->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle popular status
     */
    public function togglePopular(Subscription $subscription)
    {
        try {
            $subscription->is_popular = !$subscription->is_popular;
            $subscription->save();

            return response()->json([
                'success' => true,
                'message' => 'Popular status updated successfully',
                'is_popular' => $subscription->is_popular
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update popular status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified subscription
     */
    public function destroy(Subscription $subscription)
    {
        try {
            $subscription->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subscription plan deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subscription: ' . $e->getMessage()
            ], 500);
        }
    }
}

