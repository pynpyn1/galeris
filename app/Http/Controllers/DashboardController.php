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
            $sevenDaysAgo = Carbon::now()->subDays(7);
            $newClients = User::where('role_group_id', 1)
                              ->where('created_at', '>=', $sevenDaysAgo)
                              ->count();

            $totalFolders = FolderModel::count();
            $totalPhotos = PhotoModel::count();
            $totalLinks = LinkModel::count();

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
                'recentFolders'
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
