<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return "Welcome to the Admin Panel! Your middleware check works.";
    }
}