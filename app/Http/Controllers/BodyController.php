<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BodyController extends Controller
{
    public function index()
    {
        return Inertia::render('Bodies/Index', [
            'filters' => Request::all('search', 'trashed'),
            'bodies' => Auth::user()->account->bodies()
                ->orderBy('id')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($body) => [
                    'id' => $body->id,
                    'name' => $body->name,
                    'age' => $body->age,
                    'weight' => $body->weight,
                    'height' => $body->height,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Bodies/Create');
    }

    public function createbody(){
        return Inertia::render('Bodies/CreateBody');
    }

    public function store()
    {
        Auth::user()->account->bodies()->create(
            array_merge(
                [
                    'user_id' => auth()->user()->id
                ],
                Request::validate([
                    'name' => ['required', 'max:100'],
                    'body_fat_percentage' => ['required', 'max:100'],
                    'weight' => ['required', 'max:50',],
                    'height' => ['required', 'max:50'],
                    'age' => ['required', 'max:150'],
                ])
            )
        );

        return Redirect::route('bodies')->with('success', 'Body created.');
    }

    public function edit(Body $body)
    {
        return Inertia::render('Bodies/Edit', [
            'body' => [
                'id' => $body->id,
                'name' => $body->name,
                'body_fat_percentage' => $body->body_fat_percentage,
                'age' => $body->age,
                'weight' => $body->weight,
                'height' => $body->height,
            ],
        ]);
    }

    public function update(Body $body)
    {
        $body->update(
            Request::validate([
//                'name' => ['required', 'max:100'],
                'body_fat_percentage' => ['required', 'max:100'],
                'weight' => ['required', 'max:50',],
                'height' => ['required', 'max:50'],
                'age' => ['required', 'max:150'],
            ])
        );

//        return Redirect::back()->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization)
    {
//        $organization->delete();
//
//        return Redirect::back()->with('success', 'Organization deleted.');
    }

    public function restore(Organization $organization)
    {
//        $organization->restore();
//
//        return Redirect::back()->with('success', 'Organization restored.');
    }
}
