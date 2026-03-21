@extends('layouts.app')

@section('title', 'RaKe Infra')

@section('content')

<section class="hero">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('assets/video/rake vid2.mp4') }}" type="video/mp4">
    </video>

    <div class="hero-content">
        <h1>Building Tomorrow’s Infrastructure</h1>
        <p>Quality • Strength • Reliability</p>
    </div>
</section>

<section id="services" class="services">
    <h2>Our Services</h2>

    <div class="service-grid">
        <div class="service-box">
            <h3>Residential Construction</h3>
            <p>Premium villas and gated communities.</p>
        </div>
        <div class="service-box">
            <h3>Commercial Projects</h3>
            <p>IT parks, offices, and business spaces.</p>
        </div>
        <div class="service-box">
            <h3>Industrial Projects</h3>
            <p>Factories and heavy infrastructure.</p>
        </div>
        <div class="service-box">
            <h3>Road & Civil Works</h3>
            <p>Durable public infrastructure.</p>
        </div>
    </div>
</section>
<!-- PROJECTS -->
<section id="projects" class="projects">
    <h2>Our Projects</h2>

    <div class="project-grid">
        <div class="project-box">
            <img src="{{ asset('assets/images/img1.jpg') }}">
            <h3>Steel Structure Project</h3>
            <p>Hyderabad</p>
        </div>

        <div class="project-box">
            <img src="{{ asset('assets/images/11.jpg') }}">
            <h3>IT Park Development</h3>
            <p>Financial District</p>
        </div>

        <div class="project-box">
            <img src="{{ asset('assets/images/12.jpg') }}">
            <h3>Circular Commercial Complex</h3>
            <p>Ongole</p>
        </div>

        <div class="project-box">
            <img src="{{ asset('assets/images/13.avif') }}">
            <h3> Office </h3>
            <p>Madhapur</p>
        </div>
    </div>
</section>


      <!-- ABOUT -->
<section id="about" class="about">
    <div class="about-container">

        <div class="about-text">
            <h2>About RaKe Infra</h2>

<p>
    RaKe Infra is a fast-growing and trusted name in the construction 
    and infrastructure development industry. With a strong commitment 
    to engineering excellence and customer satisfaction, we deliver 
    projects that combine modern design, structural integrity, and 
    long-term sustainability.
</p>

<p>
    Our expertise covers residential, commercial, industrial, and 
    civil infrastructure projects. From premium gated communities to 
    high-rise towers, commercial complexes, and large-scale 
    infrastructure works, RaKe Infra ensures unmatched quality in 
    every stage of execution.
</p>

<p>
    We believe that great construction is built on a foundation of 
    innovation and responsibility. Our team of architects, structural 
    engineers, project managers, and skilled workforce work together 
    to bring every client’s vision to life with precision and 
    transparency.
</p>

<p>
    Over the years, RaKe Infra has earned the trust of customers 
    through timely delivery, a professional approach, and the use of 
    high-quality materials and advanced construction technologies. 
    Our goal is not just to build structures, but to create lasting 
    landmarks that reflect our values of reliability, strength, and 
    excellence.
</p>

<p>
    With a forward-looking approach and commitment to innovation, 
    RaKe Infra continues to shape the future of urban development 
    while contributing to the growth and modernization of the 
    infrastructure landscape.
</p>

        </div>

        <div class="about-image">
            <img src="{{ asset('assets/images/cmp.jpg') }}">
        </div>

    </div>
</section>



<section id="contact" class="contact">
    <h2>Contact Us</h2>
    <p>Flat No.301, Avas Pride,Street No:14, Tarnaka, Hyderabad - 500007</p>
    <p>Email: info@rakeinfra.in</p>
</section>

<footer>
    <p>© 2025 RaKe Infra. All Rights Reserved.</p>
</footer>

@endsection
