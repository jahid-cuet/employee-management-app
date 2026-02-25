<?php

namespace App\Http\Controllers;

use App\Constants\AppConstant;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Article $article)
    {
        // Ekhane $article-er moddhe shob data auto chole ashbe (ID diye find kora lagbe na)
        return Inertia::render('gateways/Index', [
            'gateways' => AppConstant::getGateways(),
            'article' => $article,
        ]);
    }

    public function paymentAccounts(Article $article, string $gateway)
    {
        $allGateways = AppConstant::getGateways();

        // Security check: Gateway exist kore kina
        if (!array_key_exists($gateway, $allGateways)) {
            abort(404);
        }

        return Inertia::render('gateways/Pay', [
            'gateway'         => $allGateways[$gateway],
            'articles'         => $article,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, string $gateway)
    {
        // Handle the selected payment gateway
        $gateways = AppConstant::getGateways();

        if (!isset($gateways[$gateway])) {
            abort(404, 'Gateway not found');
        }

        return Inertia::render('gateways/Show', [
            'article' => $article,
            'gateway' => $gateways[$gateway],
            'gatewayKey' => $gateway,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
