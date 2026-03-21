<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\PlotBooking;
use App\Models\Agreement;
use App\Models\SaleDeed;
use App\Models\RequestForm;
use App\Models\Feedback;

class DashboardController extends Controller
{
    /**
     * ================= ADMIN DASHBOARD =================
     */
    public function adminDashboard()
    {
        // TOTAL PLOTS
        $totalPlots = Plot::count();

        // AVAILABLE PLOTS
        $availablePlots = Plot::where('status', 'available')->count();

        // ✅ BOOKED PLOTS (SINGLE SOURCE OF TRUTH)
        $bookedPlots = PlotBooking::where('status', PlotBooking::STATUS_BOOKED)->count();

        // ✅ AGREEMENTS (SHOULD MATCH BOOKED)
        $agreementsCount = Agreement::count();

        // SALE DEEDS
        $saleDeedsCount = SaleDeed::count();

        // (REQUESTS + FEEDBACK)
        $requests = RequestForm::latest()->get();
         $feedbacks = Feedback::latest()->get();

        return view('admin.dashboard', compact(
            'totalPlots',
            'availablePlots',
            'bookedPlots',
            'agreementsCount',
            'saleDeedsCount',
            'requests',
            'feedbacks',

        ));
    }

    /**
     * ================= SALES DASHBOARD =================
     */
    public function salesDashboard()
    {
        $salesId = auth()->id();

        // TOTAL PLOTS (GLOBAL)
        $totalPlots = Plot::count();

        // AVAILABLE PLOTS (GLOBAL)
        $availablePlots = Plot::where('status', 'available')->count();

        // ✅ SALES PERSON BOOKED PLOTS
        $bookedPlots = PlotBooking::where('status', PlotBooking::STATUS_BOOKED)
            ->where('sales_person_id', $salesId)
            ->count();

        // ✅ SALES PERSON AGREEMENTS
        $agreementsCount = Agreement::whereHas('booking', function ($q) use ($salesId) {
            $q->where('sales_person_id', $salesId);
        })->count();

        return view('dashboard.index', compact(
            'totalPlots',
            'availablePlots',
            'bookedPlots',
            'agreementsCount'
        ));
    }
}
