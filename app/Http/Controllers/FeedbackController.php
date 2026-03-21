<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForm;
use App\Models\Feedback;

class FeedbackController extends Controller
{

    public function storeRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'request_type' => 'required'
        ]);

        RequestForm::create($request->all());

        return back()->with('success','Request Submitted');
    }


    public function storeFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'rating' => 'required',
            'feedback' => 'required'
        ]);

        Feedback::create($request->all());

        return back()->with('success','Feedback Submitted');
    }


    public function dashboard()
    {
        $requests = RequestForm::latest()->get();
        $feedbacks = Feedback::latest()->get();

        return view('admin.dashboard', compact('requests','feedbacks'));
    }
    public function showTables()
{
    $requests = RequestForm::latest()->get();
    $feedbacks = Feedback::latest()->get();

    return view('admin.requests_feedback',compact('requests','feedbacks'));
}

}