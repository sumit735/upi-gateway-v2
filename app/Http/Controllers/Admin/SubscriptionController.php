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
        return view('admin.subscriptions.index');
    }

    /**
     * Get subscriptions list for DataTables (AJAX)
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $subscriptions = Subscription::query()->ordered();

            // Apply status filter if provided
            if ($request->filled('status_filter')) {
                $subscriptions->where('is_active', $request->status_filter);
            }

            return DataTables::of($subscriptions)
                ->addColumn('duration', function ($subscription) {
                    return '<span class="badge bg-info">' . $subscription->duration_text . '</span>';
                })
                ->addColumn('price_display', function ($subscription) {
                    $html = '<div>';
                    $html .= '<span class="fw-bold">₹' . number_format($subscription->final_price, 2) . '</span>';
                    if ($subscription->discount_percentage > 0) {
                        $html .= '<br><small class="text-muted"><del>₹' . number_format($subscription->price, 2) . '</del></small>';
                        $html .= ' <span class="badge bg-success-transparent">' . $subscription->discount_percentage . '% OFF</span>';
                    }
                    $html .= '</div>';
                    return $html;
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
                    return '';
                })
                ->addColumn('actions', function ($subscription) {
                    $actions = '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewSubscription(' . $subscription->id . ')">
                                        <i class="ti ti-eye me-2"></i>View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editSubscription(' . $subscription->id . ')">
                                        <i class="ti ti-edit me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="toggleStatus(' . $subscription->id . ', ' . ($subscription->is_active ? 0 : 1) . ')">
                                        <i class="ti ti-toggle-' . ($subscription->is_active ? 'left' : 'right') . ' me-2"></i>' . ($subscription->is_active ? 'Deactivate' : 'Activate') . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="togglePopular(' . $subscription->id . ', ' . ($subscription->is_popular ? 0 : 1) . ')">
                                        <i class="ti ti-star me-2"></i>' . ($subscription->is_popular ? 'Remove Popular' : 'Mark as Popular') . '
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteSubscription(' . $subscription->id . ', \'' . addslashes($subscription->name) . '\')">
                                        <i class="ti ti-trash me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                    return $actions;
                })
                ->rawColumns(['duration', 'price_display', 'status_badge', 'popular_badge', 'actions'])
                ->make(true);
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

