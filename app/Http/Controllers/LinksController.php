<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Response;

class LinksController extends Controller
{
    public function index(Request $request): Response
    {
        return inertia('Link/Index', [
            'links' => LinkResource::collection(
                $request->user()->links()->paginate(10)
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
}
