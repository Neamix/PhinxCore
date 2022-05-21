<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryRequest;
use App\Models\Inquirty;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function create(InquiryRequest $request)
    {
        return Inquirty::createInstance($request);
    }
}