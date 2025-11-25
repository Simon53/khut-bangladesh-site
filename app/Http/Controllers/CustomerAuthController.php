<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    public function loginForm() {
        return view('customer-login.index');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('customer.profile');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:customers,email',
    ]);

   
    $customer = Customer::create([
        'email' => $request->email,
        'first_name' => null,
        'last_name' => null,
        'display_name' => null,
        'password' => null, 
    ]);

    
    Auth::guard('customer')->login($customer);

    return redirect()->route('customer.profile');
}

    public function profileForm() {
        $customer = Auth::guard('customer')->user();
        return view('customer-login.profile', compact('customer'));
    }
   
   
    public function updateProfile(Request $request) {
            $customer = Auth::guard('customer')->user();

            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'display_name' => 'required|string',
                'email' => 'required|email|unique:customers,email,' . $customer->id,
                'new_password' => 'nullable|min:6|confirmed',
            ]);

            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->display_name = $request->display_name;
            $customer->email = $request->email;

            // ✅ Password logic
            if ($request->filled('new_password')) {
                if (is_null($customer->password)) {
                    $customer->password = Hash::make($request->new_password);
                } 
                else {
                    if ($request->filled('current_password') && Hash::check($request->current_password, $customer->password)) {
                        $customer->password = Hash::make($request->new_password);
                    } else {
                        return back()->withErrors(['current_password' => 'Current password is incorrect.']);
                    }
                }
            }

            $customer->save();

            return back()->with('success', 'Profile updated successfully!');
        }


    public function logout() {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }


    public function profile(){
        $customer = Auth::guard('customer')->user();
        $orders = \App\Models\Order::with('items')
                ->where('email', $customer->email)
                ->orderBy('id', 'desc')
                ->get();

            return view('customer-login.profile', compact('customer', 'orders'));
        }

     public function orderDetails($id){
        $customer = Auth::guard('customer')->user();

        $order = \App\Models\Order::with('items')
            ->where('email', $customer->email)
            ->where('id', $id)
            ->firstOrFail();

        return view('customer-login.partials.order-details', compact('order'));
    }   
}
