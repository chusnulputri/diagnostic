<?php

namespace App\Http\Middleware;

use App\Models\m_company_subscription;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class HasActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $company = $request->user()->company()->first();
        // $companyId = $company->c_id;
        // $companyType = $company->c_type;
        // if ($companyType == 'mitra') {
        //     $subscription = m_company_subscription::where('cs_company_id', $companyId)->first();
        //     if ($subscription->cs_isactive && $subscription->cs_end_date > Carbon::now()) {
        //         return $next($request);
        //     } else {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Subscription anda telah habis'
        //         ], 403);
        //     }
        // }
        return $next($request);
    }
}
