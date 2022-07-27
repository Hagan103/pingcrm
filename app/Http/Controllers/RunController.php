<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RunController extends Controller
{

    public function create()
    {
        return Inertia::render('Runs/Create');
    }

    public function index()
    {
        return Inertia::render('Runs/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),

            'runs' => Auth::user()->account->runs()
                ->orderBy('id')
//                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($run) => [
                    'id' => $run->id,
                    'name' => $run->name,
                    'distance' => $run->distance,
                    'duration' => $run->duration,
                ]),
        ]);
    }


    public function store()
    {
        Auth::user()->account->runs()->create(
            array_merge(
                [
                    'user_id' => auth()->user()->id
                ],
                \Illuminate\Support\Facades\Request::validate([
                    'name' =>  ['required', 'max:100'],
                    'duration' => ['required', 'max:100'],
                    'distance' => ['required', 'max:100'],
                ])
            )
        );

        return Redirect::route('runs')->with('success', 'Run created.');
    }
}
