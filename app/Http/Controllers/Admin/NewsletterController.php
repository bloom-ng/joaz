<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subscribers = NewsletterSubscription::when($search, function($query) use ($search) {
                return $query->where('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.newsletters.index', compact('subscribers'));
    }

    /**
     * Export subscribers to CSV
     */
    public function exportToCsv()
    {
        $fileName = 'subscribers-' . now()->format('Y-m-d') . '.csv';
        $subscribers = NewsletterSubscription::select('email', 'created_at', 'is_subscribed')
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Email', 'Subscribed At', 'Status'];

        $callback = function() use($subscribers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($subscribers as $subscriber) {
                $row['Email']  = $subscriber->email;
                $row['Subscribed At']  = $subscriber->created_at->format('Y-m-d H:i:s');
                $row['Status'] = $subscriber->is_subscribed ? 'Subscribed' : 'Unsubscribed';

                fputcsv($file, array($row['Email'], $row['Subscribed At'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        NewsletterSubscription::create([
            'email' => $request->email,
            'is_subscribed' => true,
            'unsubscribe_token' => Str::random(32),
        ]);

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Subscriber added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterSubscription $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Subscriber deleted successfully!');
    }
}
