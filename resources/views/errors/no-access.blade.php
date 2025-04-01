@extends('layouts.admin')

@section('content')
<style>
    body {
        background-color:  #f7fdfb;
    }

    .no-access-card {
        max-width: 460px;
        background-color: #ecfef4;
        border: 2px solid #00b894;
        border-radius: 18px;
        padding: 40px 30px;
        margin: 60px auto;
        text-align: center;
        box-shadow: 0 0 20px rgba(0, 184, 148, 0.15);
    }

    .orb {
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, #00b894 0%, #019875 100%);
        border-radius: 50%;
        margin: 0 auto 20px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0); }
    }

    .heading {
        font-size: 22px;
        font-weight: 600;
        color: #003B3B;
        margin-bottom: 10px;
    }

    .message {
        font-size: 15px;
        color: #444;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .inspiration-box {
        background-color: #d1fff0;
        border-left: 5px solid #00b894;
        font-style: italic;
        padding: 14px 16px;
        border-radius: 12px;
        color: #00695c;
        margin-bottom: 20px;
    }

    .button-group {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 16px;
    }

    .btn-soft {
        background-color: #00b894;
        color: #fff;
        border: none;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-soft:hover {
        background-color: #019875;
    }

    .footer-note {
        margin-top: 60px;
        font-size: 12px;
        color: #999;
        text-align: center;
    }
</style>

<div class="no-access-card">
    <div class="orb"></div>

    <div class="heading">This Area is Secured 🛡</div>

    <div class="message">
        Only Web Masters have access to Admin User Management.<br>
        You're doing an amazing job as Admin — here's a thought to boost your day!
    </div>

    <div class="inspiration-box" id="quoteBox">
        “Even quiet roles build loud impact.” – AirScape, 2049
    </div>

    <div class="button-group">
        <button class="btn-soft" onclick="shuffleQuote()">Inspire Me Again ✨</button>
        <a href="{{ route('dashboard') }}" class="btn-soft">Return to Dashboard</a>
    </div>
</div>

<div class="footer-note">
    © {{ date('Y') }} AirScape • Designed for calm intelligence
</div>

<script>
    const quotes = [
        "“Admins are architects of trust.”",
        "“You’re doing more than you think. Keep going.”",
        "“True systems stay strong with silent strength.”",
        "“Admins simplify the world — one panel at a time.”",
        "“Purpose matters more than permission.”",
    ];

    function shuffleQuote() {
        const random = Math.floor(Math.random() * quotes.length);
        document.getElementById('quoteBox').innerText = quotes[random];
    }
</script>
@endsection