@extends('layouts.user')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9fafa;
    }

    .contact-container {
        max-width: 900px;
        margin: 60px auto;
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        padding: 40px;
    }

    .contact-heading {
        font-size: 26px;
        font-weight: 600;
        color: #22577A;
        margin-bottom: 20px;
    }

    .contact-description {
        font-size: 16px;
        color: #5f6f68;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 500;
        color: #003B3B;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 12px 14px;
    }

    .btn-submit {
        background-color: #FF7700;
        color: white;
        padding: 12px 24px;
        font-weight: 500;
        border-radius: 10px;
        border: none;
        transition: 0.2s ease-in-out;
    }

    .btn-submit:hover {
        background-color: #e06600;
    }

    .contact-info {
        margin-top: 40px;
        font-size: 15px;
        color: #333;
    }

    .contact-info i {
        color: #22577A;
        margin-right: 10px;
    }
</style>

<div class="container contact-container">
    <h2 class="contact-heading">Contact Us</h2>
    <p class="contact-description">
        Have questions, suggestions, or feedback about air quality in Colombo? Reach out to our team and we’ll get back to you shortly.
    </p>

    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. John Doe" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="e.g. johndoe@example.com" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="e.g. Feedback, Support..." required>
        </div>

        <div class="mb-4">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
        </div>

        <button type="submit" class="btn-submit">Send Message</button>
    </form>

    <div class="contact-info mt-5">
        <p><i class="bi bi-envelope-fill"></i> support@airscape.lk</p>
        <p><i class="bi bi-telephone-fill"></i> +94 71 123 4567</p>
        <p><i class="bi bi-geo-alt-fill"></i> Colombo Metropolitan Air Quality Project, NSBM Green University</p>
    </div>
</div>
@endsection