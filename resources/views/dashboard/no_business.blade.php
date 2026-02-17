@extends('layouts.dashboard', ['title' => 'No Business Profile'])

@section('content')
<div class="max-w-2xl mx-auto py-32 text-center">
    <div class="w-32 h-32 bg-gray-100 dark:bg-[#1e293b] rounded-full flex items-center justify-center text-6xl mx-auto mb-10 shadow-inner">🔒</div>
    <h1 class="text-5xl font-black text-gray-900 dark:text-white mb-6 leading-tight">Access Restricted</h1>
    <p class="text-xl text-gray-500 dark:text-[#94a3b8] mb-12 leading-relaxed">
        Your account doesn't have a business profile set up yet. 
        <br><br>
        <span class="font-bold text-gray-900 dark:text-white">Business profiles can only be created by the administrator.</span>
        <br>
        Please contact our support team to get your business ID and password.
    </p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('contact') }}" class="px-10 py-5 bg-[#ff6b6b] text-white rounded-2xl font-black text-lg shadow-xl shadow-[#ff6b6b]/30 hover:-translate-y-1 transition-all">
            Contact Admin
        </a>
        <a href="{{ url('/') }}" class="px-10 py-5 bg-gray-100 dark:bg-[#1e293b] text-gray-900 dark:text-white rounded-2xl font-black text-lg hover:bg-gray-200 transition-all">
            Back to Home
        </a>
    </div>
</div>
@endsection
