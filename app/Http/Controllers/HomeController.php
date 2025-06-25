<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

  class HomeController extends Controller
  {
      public function index()
      {
          return view('home');
      }

      public function userDashboard()
    {
    Log::info('User Dashboard accessed');
    return view('user.dashboard'); // Đảm bảo view user/dashboard.blade.php tồn tại
    }

      public function logout()
      {
          Auth::logout();
          return redirect('/')->with('success', 'Đã đăng xuất.');
      }
  }