<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TicketController extends Controller
{
    public function index($phone)
    {
        return Inertia::render('VisitInit',['phone' =>$phone]);
    }
    public function update($phone)
    {
        return Inertia::render('VisitEnd',['phone' =>$phone]);
    }
}
