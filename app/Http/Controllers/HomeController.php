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
        // Normally we should move these queries to a separate Repository.
        // However, The whole purpose is for testing so no need to add more boilerplate
        return inertia('Home/Index', [
            'totalLinks' => fn () => $request->user()->links()->count(),
            'totalClicks' => fn () => $request->user()->clicks()->count(),
            'clicksHistory' => fn () => $this->getClicksHistory($request->user()),
            'clicksByPlatform' => fn () => $this->getClicksByField($request->user(), 'platform', 5),
            'clicksByDevice' => fn () => $this->getClicksByField($request->user(), 'device', 5),
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

    private function getClicksByField(User $user, string $field, int $limit): array
    {
        return Click::join('links', 'clicks.model_id', '=', 'links.id')
            ->where(['links.user_id' => $user->id, 'clicks.model_type' => Link::class])
            ->selectRaw("$field, COUNT(*) as count")
            ->groupBy($field)
            ->limit($limit)
            ->pluck('count', $field)
            ->map(fn ($count, $field) => [
                'label' => $field,
                'count' => $count,
            ])
            ->values()
            ->toArray();
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
                    'day' => $day->format('d/m'),
                    'count' => $value,
                ];
            }
        }

        return array_values($history);
    }
}
