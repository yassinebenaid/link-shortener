<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia('Home/Index', [
            'totalLinks' => fn () => $request->user()->links()->count(),
            'totalClicks' => fn () => $request->user()->clicks()->count(),
            'clicksHistory' => fn () => $this->getClicksHistory($request->user()),
        ]);
    }

    private function getClicksHistory(User $user)
    {
        return $this->sanitizeDays(29, Click::join('links', 'clicks.model_id', '=', 'links.id')
            ->where(['links.user_id' => $user->id, 'clicks.model_type' => Link::class])
            ->selectRaw('DATE(clicks.created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->where('clicks.created_at', '>=', now()->subDays(30))
            ->pluck('count', 'date'));
    }

    private function sanitizeDays(int $days, Collection $data)
    {
        $history = [];

        foreach (range($days, 0) as $day) {
            $day = now()->subDays($day);
            $history[$day->format('d/m')] = [
                'day' => $day->format('d'),
                'count' => 0,
            ];
        }

        foreach ($data as $day => $value) {
            $day = Carbon::make($day);

            if (isset($history[$day->format('d/m')])) {
                $history[$day->format('d/m')] = [
                    'day' => $day->format('d'),
                    'count' => $value,
                ];
            }
        }

        return array_values($history);
    }
}
