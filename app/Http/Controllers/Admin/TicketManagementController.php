<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketReply;
use App\Models\User;
use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketManagementController extends Controller
{
    /**
     * Display a listing of all tickets
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['category', 'user', 'assignedTo'])
            ->withCount('attachments')
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(20);
        $categories = TicketCategory::active()->get();
        
        return view('admin.tickets.index', compact('tickets', 'categories'));
    }

    public function createIndex(Request $request) {
        $categories = TicketCategory::active()->get();
        return view('admin.tickets.create', compact('categories'));
    }

    /**
     * Display the specified ticket
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['category', 'user', 'assignedTo', 'attachments', 'replies.user', 'replies.attachments']);
        $admins = User::whereHas('role', function($q) {
            $q->where('name', 'Admin');
        })->get();
        
        return view('admin.tickets.show', compact('ticket', 'admins'));
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket->update($validated);

        if ($validated['status'] === 'resolved') {
            $ticket->update(['resolved_at' => now()]);
        }

        return redirect()->back()->with('success', 'Ticket status updated successfully');
    }

    /**
     * Assign ticket to admin
     */
    public function assign(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->back()->with('success', 'Ticket assigned successfully');
    }

    /**
     * Add a reply to ticket
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:20480|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx',
        ]);

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin_reply' => true,
        ]);

        // Handle file uploads for reply (with reply_id)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachment = $this->uploadAttachment($ticket, $reply, $file);
                $attachments[] = [
                    'id' => $attachment->id,
                    'file_name' => $attachment->file_name,
                    'file_type' => $attachment->file_type,
                    'file_size' => round($attachment->file_size / 1024, 2) . ' KB',
                    'file_url' => asset('storage/' . $attachment->file_path),
                    'is_image' => $attachment->isImage(),
                ];
            }
        }

        // Update ticket status if it's new
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply added successfully',
                'reply' => [
                    'id' => $reply->id,
                    'message' => $reply->message,
                    'user_name' => Auth::user()->name,
                    'is_admin' => true,
                    'created_at' => $reply->created_at->format('M d, Y h:i A'),
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=48&background=f5222d&color=fff',
                    'attachments' => $attachments
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Reply added successfully');
    }

    /**
     * Upload and store attachment
     */
    private function uploadAttachment($ticket, $reply, $file)
    {
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        
        // Determine file type
        $fileType = 'document';
        if (str_starts_with($mimeType, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $fileType = 'video';
        }

        // Store file
        $path = $file->store('ticket-attachments/' . $ticket->id, 'public');

        // Create attachment record with reply_id
        return \App\Models\TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'reply_id' => $reply ? $reply->id : null,
            'file_name' => $fileName,
            'file_path' => $path,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
        ]);
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->update($validated);

        return redirect()->back()->with('success', 'Ticket priority updated successfully');
    }

    /**
     * Get ticket statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];

        return response()->json($stats);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ticket_categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|max:20480|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx',
        ]);

        // Create ticket
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->uploadAttachment($ticket, null, $file);
            }
        }

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully! Your ticket number is: ' . $ticket->ticket_number,
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'redirect' => route('admin.tickets.show', $ticket)
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully! Your ticket number is: ' . $ticket->ticket_number);
    }
}
