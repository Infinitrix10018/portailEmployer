<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ModelCourriel;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $emailContent = ModelCourriel::first();

        if ($emailContent) {
            Mail::to('integrationtestadress@gmail.com')->send(new WelcomeMail($emailContent));
            return back()->with('success', 'Email sent successfully!');
        }

        return "No email content found in the database.";
    }
}
