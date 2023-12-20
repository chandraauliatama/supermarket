<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use PDF;

class PrintController extends Controller
{
    public function printSalesReport()
    {
        $salesGroupedByDate = Sale::all()->groupBy('created_at');

        $pdf = PDF::loadView('printSalesReport', compact('salesGroupedByDate'));

        return $pdf->stream();
    }

    public function printProductsReport()
    {
        $products = Product::all();

        $pdf = PDF::loadView('printProductsReport', compact('products'));

        return $pdf->stream();
    }
}
