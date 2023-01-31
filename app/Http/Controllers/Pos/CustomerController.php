<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function allCustomersPage(){
        $customers = Customer::latest()->get();
        return view('backend.customer.all_customers')->with([
            'customers' => $customers
        ]);
    }

    public function addCustomerPage(){
        return view('backend.customer.add_customer');
    }

    public function addCustomer(Request $request){
        $customer_image = $request->file('customer_image');
        $name_generator = hexdec(uniqid()).'.'.$customer_image->getClientOriginalExtension();

        Image::make($customer_image)->resize(200,200)->save('upload/customer_images/'.$name_generator);
        $save_url = 'upload/customer_images/'.$name_generator;

        Customer::insert([
            'name' => $request->name,
            'customer_image' => $save_url,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.customers.page')->with($notification);
    }

    public function editCustomerPage($id){
        $customer = Customer::findOrFail($id);

        return view('backend.customer.edit_customer')->with([
            'customer' => $customer
        ]);
    }

    public function editCustomer(Request $request, $id){
        $customer = Customer::find($id);

        if($request->file('customer_image')){
            $customer_image = $request->file('customer_image');
            $name_generator = hexdec(uniqid()).'.'.$customer_image->getClientOriginalExtension();

            Image::make($customer_image)->resize(200,200)->save('upload/customer_images/'.$name_generator);
            $save_url = 'upload/customer_images/'.$name_generator;

            unlink($customer->customer_image);

            $customer->update([
                'name' => $request->name,
                'customer_image' => $save_url,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated with Image!',
                'alert-type' => 'success',
            );
        } else {
            $customer->update([
                'name' => $request->name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated without Image!',
                'alert-type' => 'success',
            );
        }

        return redirect()->route('all.customers.page')->with($notification);
    }

    public function deleteCustomer($id){
        $customer = Customer::findOrFail($id);
        unlink($customer->customer_image);

        $customer->delete();

        $notification = array(
            'message' => 'Customer Deleted!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function creditCustomer(){
        $payments = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.customer.customer_credit')->with([
            'payments' => $payments,
        ]);
    }

    public function creditCustomerPrint(){
        $payments = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_credit_print')->with([
            'payments' => $payments,
        ]);
    }

    public function editCustomerCreditPage($invoice_id){
        $payment = Payment::where('invoice_id', $invoice_id)->first();
        return view('backend.customer.edit_customer_credit')->with([
            'payment' => $payment,
        ]);
    }

    public function updateCustomerInvoice(Request $request, $invoice_id){
        if($request->new_paid_amount < $request->paid_amount){
            $notification = array(
                'message' => 'Payment is over the due amount!',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else {
            $payment = Payment::where('invoice_id', $invoice_id)->first();
            $payment_details = new PaymentDetails();
            $payment->paid_status = $request->paid_status;

            if($request->paid_status == 'full_paid'){
                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->new_paid_amount;
                $payment->due_amount = '0';
                $payment_details->current_paid_amount = $request->new_paid_amount;
            } elseif($request->paid_status == 'partial_paid'){
                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->paid_amount;
                $payment->due_amount = Payment::where('invoice_id', $invoice_id)->first()['due_amount'] - $request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }
            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d',strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Updated!',
                'alert-type' => 'success',
            );

            return redirect()->route('credit.customer')->with($notification);
        }
    }

    public function customerInvoiceDetails($invoice_id){
        $payment = Payment::where('invoice_id',$invoice_id)->first();
        return view('backend.pdf.invoice_details_pdf')->with([
            'payment' => $payment,
        ]);
    }

    public function paidCustomer(){
        $payments = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.customer.paid_customer')->with([
            'payments' => $payments,
        ]);
    }

    public function paidCustomerPrint(){
        $payments = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.paid_customer_print')->with([
            'payments' => $payments,
        ]);
    }

    public function customerWiseReport(){
        $customers = Customer::all();
        return view('backend.customer.customer_wise_report', compact('customers'));
    }

    public function customerCreditReport(Request $request){
        $payments = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.credit_customer_pdf')->with([
            'payments' => $payments,
        ]);
    }

    public function customerPaidReport(Request $request){
        $payments = Payment::where('customer_id', $request->customer_id)->where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.paid_customer_pdf')->with([
            'payments' => $payments,
        ]);
    }
}
