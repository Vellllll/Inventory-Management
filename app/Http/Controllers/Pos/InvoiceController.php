<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;

use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;
use App\Models\PaymentDetails;
use App\Models\Customer;

use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function allInvoicesPage(){
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.invoice.all_invoices')->with([
            'invoices' => $invoices
        ]);
    }

    public function addInvoicePage(){
        $categories = Category::all();
        $products = Product::all();
        $customers = Customer::all();

        $date = date('Y-m-d');

        $invoice = Invoice::orderBy('id', 'desc')->first();
        if($invoice == null){
            $first_register = '0';
            $invoice_no = $first_register + 1;
        } else {
            $invoice_last = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $invoice_no = $invoice_last + 1;
        }

        return view('backend.invoice.add_invoice')->with([
            'categories' => $categories,
            'products' => $products,
            'date' => $date,
            'invoice_no' => $invoice_no,
            'customers' => $customers,
        ]);
    }

    public function addInvoice(Request $request){
        if($request->category_id == null){
            $notification = array(
                'message' => "You don't choose any product!",
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        } else {
            if($request->paid_amount > $request->estimated_amount){
                $notification = array(
                    'message' => "Your paid amount is greater than grand total",
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->invoice_date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function() use($request, $invoice){
                    if($invoice->save()){
                        $count_category = count($request->category_id);

                        for($i = 0; $i < $count_category; $i++){
                            $invoice_details = new InvoiceDetails();
                            $invoice_details->date = date('Y-m-d', strtotime($request->invoice_date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '0';
                            $invoice_details->save();
                        }

                        if($request->customer_id == '0'){
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_number = $request->mobile_number;
                            $customer->email = $request->email;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetails();
                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if($request->paid_status == 'full_paid'){
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } else if($request->paid_status == 'full_due'){
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        } else if($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }

                        $payment->save();
                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->invoice_date));
                        $payment_details->save();

                    }
                });
            }
            $notification = array(
                'message' => "Invoice inserted!",
                'alert-type' => 'success',
            );
            return redirect()->route('all.invoices.page')->with($notification);
        }

    }

    public function pendingInvoicesPage(){
        $pending_invoices = Invoice::orderBy('date', 'desc')->where('status', '0')->get();

        return view('backend.invoice.approval_invoice')->with([
            'pending_invoices' => $pending_invoices,
        ]);
    }

    public function deleteInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        InvoiceDetails::where('invoice_id', $id)->delete();

        Payment::where('invoice_id', $id)->delete();

        PaymentDetails::where('invoice_id', $id)->delete();

        $notification = array(
            'message' => "Invoice deleted!",
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function approveInvoicePage($id){
        $invoice = Invoice::with('invoice_details')->findOrFail($id);

        return view('backend.invoice.approve_invoice')->with([
            'invoice' => $invoice,
        ]);

    }

    public function approveInvoice(Request $request, $id){
        foreach($request->selling_qty as $key => $item){
            $invoice_details = InvoiceDetails::where('id', $key)->first();
            $product = Product::where('id', $invoice_details->product_id)->first();
            if($product->quantity < $request->selling_qty[$key]){
                $notification = array(
                    'message' => "Stock is not sufficient!",
                    'alert-type' => 'error',
                );

                return redirect()->back()->with($notification);
            }
        }

        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function() use ($request, $invoice, $id){
            foreach($request->selling_qty as $key => $item){
                $invoice_details = InvoiceDetails::where('id', $key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                $product = Product::where('id', $invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
                $product->save();
            }
            $invoice->save();

        });
        $notification = array(
            'message' => "Invoice approved!",
            'alert-type' => 'success',
        );

        return redirect()->route('pending.invoices.page')->with($notification);
    }

    public function invoicePrintPage(){
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.invoice.print_invoice')->with([
            'invoices' => $invoices,
        ]);
    }

    public function printInvoice($id){
        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        return view('backend.pdf.print_invoice_pdf')->with([
            'invoice' => $invoice,
        ]);
    }

    public function dailyInvoiceReportPage(){
        return view('backend.invoice.daily_invoice_report');
    }

    public function dailyReportPdf(Request $request){
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $invoices = Invoice::whereBetween('date', [$start_date,$end_date])->where('status','1')->get();

        return view('backend.pdf.daily_invoice_report')->with([
            'invoices' => $invoices,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

}
