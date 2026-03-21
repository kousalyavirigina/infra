@extends('layouts.app')

@section('title', 'Feedback')

@section('content')



<section class="feedback-section">

    <div class="feedback-wrapper">

        <!-- LEFT FORM — REQUEST FORM -->
        <div class="form-box">
            <h2>Request a Service</h2>

                <form method="POST" action="/submit-request">
                    @csrf

                    <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Request Type</label>
                    <select name="request_type" class="form-control">
                    <option>Construction Inquiry</option>
                    <option>Project Estimate</option>
                    <option>Site Visit</option>
                    <option>General Query</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label>Message</label>
                    <textarea name="message" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                    Submit Request
                    </button>

                </form>
        </div>

        <!-- RIGHT FORM — FEEDBACK FORM -->
        <div class="form-box">
            <h2>Share Your Feedback</h2>

                <form method="POST" action="/submit-feedback">
                    @csrf

                    <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                    <label>Rating</label>
                    <select name="rating" class="form-control">
                    <option>Excellent</option>
                    <option>Very Good</option>
                    <option>Good</option>
                    <option>Poor</option>
                    </select>
                    </div>

                    <div class="mb-3">
                    <label>Feedback</label>
                    <textarea name="feedback" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                    Submit Feedback
                    </button>

                </form>
        </div>

    </div>

</section>