<?php

namespace App\Http\Controllers;

use App\Models\ChatBotModel;
use App\Models\FolderModel;
use App\Models\LinkModel;
use App\Models\PackageModel;
use App\Models\PhotoModel;
use App\Models\PurchaseModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $CLIENT_PERMISSION = 'dashboard_client';


        if ($user->hasPermissionTo($CLIENT_PERMISSION)) {
            $packages = PackageModel::orderBy('id')->get();
            $chatbot = ChatBotModel::where('user_id', Auth::id())->first();

            $folders = FolderModel::where('user_id', Auth::id())
            ->with([
                'photos' => function ($q) {
                    $q->orderBy('id', 'asc');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($folder) {

                $cover = $folder->photos->first();
                $coverUrl = $cover
                    ? asset('storage/photos/' . $cover->filename)
                    : asset('asset/img/404.jpeg');

                return (object)[
                    'id'       => $folder->id,
                    'name'     => $folder->name,
                    'date'     => $folder->date_event,
                    'date_end'     => $folder->date_event_end,
                    'cover'    => $coverUrl,
                    'thumbnail'=> $folder->thumbnail,
                    'code'     => $folder->public_code,
                    'is_trial' => $folder->is_trial,
                ];
            });

            $hasActivePackage = PurchaseModel::with('package')
                ->where('user_id', Auth::id())
                ->active()
                ->first();

            $unpaidPurchase = PurchaseModel::with('package')
            ->where('user_id', Auth::id())
            ->where('payment_status', 'unpaid')
            ->orderBy('created_at', 'desc')
            ->first();



        return view('dashboard.client.index', compact('folders','chatbot', 'packages', 'user', 'hasActivePackage', 'unpaidPurchase'));

        } else {
            $totalClients = User::where('role_group_id', 1)->count();

            $thisMonthClients = User::where('role_group_id', 1)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $lastMonthClients = User::where('role_group_id', 1)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();

            $percentageClients = $lastMonthClients > 0 ? (($thisMonthClients - $lastMonthClients) / $lastMonthClients) * 100 : ($thisMonthClients > 0 ? 100 : 0);

            $sevenDaysAgo = Carbon::now()->subDays(7);
            $newClients = User::where('role_group_id', 1)
                ->where('created_at', '>=', $sevenDaysAgo)
                ->count();

            $totalFolders = FolderModel::count();
            $totalPhotos = PhotoModel::count();
            $totalLinks = LinkModel::count();

            $todayRevenue = PurchaseModel::where('payment_status', 'paid')
                ->whereDate('paid_at', now())
                ->sum('final_price');

            $yesterdayRevenue = PurchaseModel::where('payment_status', 'paid')
                ->whereDate('paid_at', Carbon::yesterday())
                ->sum('final_price');

            $percentageTodayRevenue = $yesterdayRevenue > 0 ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100 : ($todayRevenue > 0 ? 100 : 0);

            $monthRevenue = PurchaseModel::where('payment_status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('final_price');

            $lastMonthRevenue = PurchaseModel::where('payment_status', 'paid')
                ->whereMonth('paid_at', now()->subMonth()->month)
                ->whereYear('paid_at', now()->subMonth()->year)
                ->sum('final_price');

            $percentageMonthRevenue = $lastMonthRevenue > 0 ? (($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : ($monthRevenue > 0 ? 100 : 0);

            $totalRevenue = PurchaseModel::where('payment_status', 'paid')
                ->sum('final_price');

            $totalPurchases = PurchaseModel::where('payment_status', 'paid')
                ->count();

            $thisMonthTransactions = PurchaseModel::where('payment_status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->count();

            $lastMonthTransactions = PurchaseModel::where('payment_status', 'paid')
                ->whereMonth('paid_at', now()->subMonth()->month)
                ->whereYear('paid_at', now()->subMonth()->year)
                ->count();

            $percentageTransactions = $lastMonthTransactions > 0 ? (($thisMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100 : ($thisMonthTransactions > 0 ? 100 : 0);

            $monthlyStats = PurchaseModel::select(
                DB::raw('MONTH(paid_at) as month'),
                DB::raw('SUM(final_price) as total_revenue')
            )
                ->where('payment_status', 'paid')
                ->whereYear('paid_at', date('Y'))
                ->groupBy('month')
                ->pluck('total_revenue', 'month')
                ->toArray();

            $chartRevenueData = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartRevenueData[] = $monthlyStats[$i] ?? 0;
            }

            $recentClients = User::where('role_group_id', 1)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $recentFolders = FolderModel::with('client')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard.index', compact(
            'totalClients',
            'newClients',
            'totalFolders',
            'totalPhotos',
            'totalLinks',
            'recentClients',
            'recentFolders',
            'todayRevenue',
            'monthRevenue',
            'totalRevenue',
            'totalPurchases',
            'chartRevenueData',
            'percentageTodayRevenue',
            'percentageMonthRevenue',
            'percentageTransactions',
            'percentageClients'
        ));
        }
    }

    public function subscribe()
    {
        $userId = auth()->id();

        $hasActivePackage = PurchaseModel::with('package')
            ->where('user_id', $userId)
            ->active()
            ->first();

        $unpaidPurchase = PurchaseModel::with('package')
            ->where('user_id', Auth::id())
            ->where('payment_status', 'unpaid')
            ->orderBy('created_at', 'desc')
            ->first();

        $verificationPurchase = PurchaseModel::with('package')
            ->withTrashed()
            ->where('user_id', $userId)
            ->where('payment_status', 'waiting_verification')
            ->orderBy('created_at', 'desc')
            ->first();

        $packages = PackageModel::where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        return view('dashboard.client.event.subscribe', [
            'packages' => $packages,
            'verificationPurchase' => $verificationPurchase,
            'hasActivePackage' => $hasActivePackage,
            'unpaidPurchase' => $unpaidPurchase
        ]);
    }

}
