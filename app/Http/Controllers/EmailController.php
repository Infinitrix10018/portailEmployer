<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Adresse destination
        $emailAddress = 'integrationtestadress@gmail.com';

        // Envoi email
        Mail::to($emailAddress)->send(new WelcomeMail());

        // Feedback
        return back()->with('success', 'Email sent successfully!');
    }
}
