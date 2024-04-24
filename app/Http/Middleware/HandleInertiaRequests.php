<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;
use App\Models\Timber\TimberSpecies;
// use App\Models\News\News;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'timber_species' => TimberSpecies::all()->map(function ($species) {
                return [
                    'id' => $species->id,
                    'speacies' => $species->speacies,
                    'class' => $species->class,
                    'diameter'== $species->diameter,
                    'length'== $species->length,
                    'seller'== $species->seller,
                    'location'== $species->location,
                    'price'== $species->price,
                    'date'== $species->date,
                ];
            }),
            // 'news' => News::all()->map(function ($news) {
            //     return [
            //         'id' => $species->id,
            //         'speacies' => $species->speacies,
            //         'class' => $species->class,
            //         'diameter'== $species->diameter,
            //         'length'== $species->length,
            //         'seller'== $species->seller,
            //         'location'== $species->location,
            //         'price'== $species->price,
            //         'date'== $species->date,
            //     ];
            // }),
        ]);
    }
}