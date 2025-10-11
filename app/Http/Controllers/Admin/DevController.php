<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Action;
use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevController extends Controller
{
    /**
     * Show developer tools page
     */
    public function index()
    {
        // Get current state - optimized to only load what we need for display
        $pages = Page::withCount('actions')
            ->select('id', 'name', 'route_pattern', 'description')
            ->get();
        
        $enumPages = PageEnum::cases();
        $enumActions = ActionEnum::cases();
        
        return view('admin.dev.index', compact('pages', 'enumPages', 'enumActions'));
    }
    
    /**
     * Sync pages from PageEnum to database
     */
    public function syncPages()
    {
        try {
            DB::beginTransaction();
            
            $synced = [];
            $created = [];
            $updated = [];
            
            foreach (PageEnum::cases() as $pageEnum) {
                $page = Page::updateOrCreate(
                    ['route_pattern' => $pageEnum->value],
                    [
                        'name' => $pageEnum->label(),
                        'description' => $pageEnum->description(),
                    ]
                );
                
                if ($page->wasRecentlyCreated) {
                    $created[] = $pageEnum->label();
                } else {
                    $updated[] = $pageEnum->label();
                }
                
                $synced[] = [
                    'id' => $page->id,
                    'name' => $page->name,
                    'route_pattern' => $page->route_pattern,
                    'description' => $page->description,
                ];
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pages synced successfully',
                'data' => [
                    'synced' => $synced,
                    'created' => $created,
                    'updated' => $updated,
                    'total' => count($synced),
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync pages: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Sync actions from ActionEnum to database
     */
    public function syncActions()
    {
        try {
            DB::beginTransaction();
            
            $synced = [];
            $created = [];
            $updated = [];
            
            // Get all pages
            $pages = Page::all()->keyBy('route_pattern');
            
            foreach (PageEnum::cases() as $pageEnum) {
                $page = $pages->get($pageEnum->value);
                
                if (!$page) {
                    continue; // Skip if page doesn't exist
                }
                
                // Get available actions for this page
                $availableActions = $pageEnum->availableActions();
                
                foreach ($availableActions as $actionEnum) {
                    $action = Action::updateOrCreate(
                        [
                            'page_id' => $page->id,
                            'slug' => $actionEnum->value,
                        ],
                        [
                            'name' => $actionEnum->label(),
                        ]
                    );
                    
                    if ($action->wasRecentlyCreated) {
                        $created[] = $page->name . ' - ' . $action->name;
                    } else {
                        $updated[] = $page->name . ' - ' . $action->name;
                    }
                    
                    $synced[] = [
                        'id' => $action->id,
                        'page' => $page->name,
                        'name' => $action->name,
                        'slug' => $action->slug,
                    ];
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Actions synced successfully',
                'data' => [
                    'synced' => $synced,
                    'created' => $created,
                    'updated' => $updated,
                    'total' => count($synced),
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync actions: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Sync both pages and actions in one go
     */
    public function syncAll()
    {
        try {
            // Sync pages first
            $pagesResponse = $this->syncPages();
            $pagesData = $pagesResponse->getData();
            
            if (!$pagesData->success) {
                return $pagesResponse;
            }
            
            // Then sync actions
            $actionsResponse = $this->syncActions();
            $actionsData = $actionsResponse->getData();
            
            if (!$actionsData->success) {
                return $actionsResponse;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'All pages and actions synced successfully',
                'data' => [
                    'pages' => $pagesData->data,
                    'actions' => $actionsData->data,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get current state of pages and actions
     */
    public function getState()
    {
        $pages = Page::with('actions')->get()->map(function($page) {
            return [
                'id' => $page->id,
                'name' => $page->name,
                'route_pattern' => $page->route_pattern,
                'description' => $page->description,
                'actions_count' => $page->actions->count(),
                'actions' => $page->actions->map(function($action) {
                    return [
                        'id' => $action->id,
                        'name' => $action->name,
                        'slug' => $action->slug,
                    ];
                }),
            ];
        });
        
        $enumPages = collect(PageEnum::cases())->map(function($page) {
            return [
                'value' => $page->value,
                'label' => $page->label(),
                'description' => $page->description(),
                'available_actions' => collect($page->availableActions())->map(fn($action) => $action->value)->toArray(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => [
                'database_pages' => $pages,
                'enum_pages' => $enumPages,
                'enum_actions' => ActionEnum::options(),
            ]
        ]);
    }
}
