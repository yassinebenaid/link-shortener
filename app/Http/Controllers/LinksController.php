<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Response;
use Jenssegers\Agent\Agent;

class LinksController extends Controller
{
    public function index(Request $request): Response
    {
        return inertia('Link/Index', [
            'sort' => $sort = $request->str('sort')->value(),
            'links' => LinkResource::collection(
                $request->user()
                    ->links()
                    ->sortBy($sort)
                    ->withCount('clicks')
                    ->paginate()
            ),
        ]);
    }

    public function store(CreateLinkRequest $request): RedirectResponse
    {
        $link = new Link();
        $link->user_id = $request->user()->id;
        $link->original = $request->original;
        $link->slug = $request->slug;

        $link->save();

        return back();
    }

    public function destroy(Request $request, Link $link): HttpResponse
    {
        $user = $request->user();

        if ($link->user_id != $user->id) {
            abort(403);
        }

        $link->delete();

        return response(status: 204);
    }

    public function out(string $link): RedirectResponse|Response
    {
        $link = Link::where('slug', $link)->first();

        if (! $link) {
            return inertia('Link/Invalid');
        }

        $agent = new Agent();

        Click::create([
            'model_id' => $link->id,
            'model_type' => $link::class,
            'platform' => $agent->platform(),
            'device' => $agent->deviceType(),
        ]);

        return redirect($link->original);
    }
}
