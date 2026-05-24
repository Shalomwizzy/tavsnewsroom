@extends('layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-item active">Contact</span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Contact Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="bg-light py-2 px-4 mb-3">
            <h3 class="m-0">Contact Us</h3>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="bg-light mb-3" style="padding: 30px;">
                    <h6 class="fw-bold">Reach Out to Us</h6>
                    <p>We are here to assist you with any questions or concerns. Feel free to get in touch with us through the contact details below or fill out the form to send us a message directly.</p>
                   
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-2x fa-envelope-open text-primary me-3"></i>
                        <div class="d-flex flex-column">
                            <h6 class="fw-bold">Email Us</h6>
                            <p class="m-0">{{ $siteEmail }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-2x fa-phone-alt text-primary me-3"></i>
                        <div class="d-flex flex-column">
                            <h6 class="fw-bold">Call Us</h6>
                            <p class="m-0">{{ $sitePhone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="contact-form bg-light mb-3" style="padding: 30px;">
                    <div id="success"></div>
                    <form name="sentMessage" id="contactForm" method="POST" action="{{ route('contact.store') }}" novalidate="novalidate">
                        @csrf
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control p-4" name="name" placeholder="Your Name" required />
                                @error('name')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control p-4" name="email" placeholder="Your Email" required />
                                @error('email')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control p-4" name="subject" placeholder="Subject" required />
                            @error('subject')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control p-4" rows="4" name="message" placeholder="Message" required></textarea>
                            @error('message')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Honeypot: bots fill this, humans don't --}}
                        <input type="text" name="_honeypot" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="_form_time" value="{{ time() }}">
                        <div>
                            <button class="btn fw-semibold px-4" style="height:50px; background-color:#ED1C24; border-color:#ED1C24; color:#fff;" type="submit" id="sendMessageButton">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection

