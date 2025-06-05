<?php // Silence is golden. ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbis - Professional Web Design Services</title>
    <meta name="description" content="Beautiful, responsive websites starting from just £199. Professional web design services for businesses of all sizes.">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="styles.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" as="style">
    <link rel="preload" href="/stock/front-video.mp4" as="video" type="video/mp4">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://www.chatbase.co">
</head>
<body>
    
    <!-- Header Section -->
    <header id="header" data-aos="fade-down">
        <?php include "header.html"; ?>
    </header>

    <main id="main-content">
        <!-- Hero Section with Video Background -->
        <section id="home" class="hero hero-video" aria-label="Hero Section" data-aos="fade-up">
            <div class="video-container">
                <video autoplay muted loop playsinline class="hero-video" aria-hidden="true">
                    <source src="/stock/front-video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-overlay"></div>
            </div>
            <div class="hero-content" data-aos="zoom-in" data-aos-delay="200">
                <h1 class="hero-title">Beautiful Websites Built for Your Success</h1>
                <p class="hero-subtitle">We create stunning, responsive websites that help your business grow and stand out from the competition.</p>
                <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
                    <a href="#pricing" class="btn btn-primary btn-large scroll-link">Get Started</a>
                    <a href="#about" class="btn btn-outline btn-large scroll-link">Learn More</a>
                </div>
            </div>
            <a href="#about" class="scroll-down" aria-label="Scroll down" data-aos="fade-up" data-aos-delay="600">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>
        
        <!-- About Section -->
        <section id="about" class="section about-section" aria-labelledby="about-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <span class="section-subtitle">New Professional Website</span>
                    <h2 id="about-heading" class="section-title">From Just <span class="highlight">£199</span></h2>
                </div>
                
                <div class="about-content">
                    <div class="about-image" data-aos="fade-right" data-aos-delay="200">
                        <img src="/stock/frontpic.jpg" alt="Example of our website design" loading="lazy">
                    </div>
                    
                    <div class="about-text" data-aos="fade-left" data-aos-delay="200">
                        <h3>Why Choose Orbis Web Design?</h3>
                        <p>We specialize in creating custom websites that not only look beautiful but also drive results. Our team of experienced designers and developers work closely with you to understand your business needs and create a website that truly represents your brand.</p>
                        
                        <div class="features-grid">
                            <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
                                <i class="fas fa-rocket"></i>
                                <h4>Fast Loading</h4>
                                <p>Optimized for speed to keep visitors engaged</p>
                            </div>
                            <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
                                <i class="fas fa-mobile-alt"></i>
                                <h4>Mobile Friendly</h4>
                                <p>Looks great on all devices</p>
                            </div>
                            <div class="feature-item" data-aos="zoom-in" data-aos-delay="500">
                                <i class="fas fa-search"></i>
                                <h4>SEO Ready</h4>
                                <p>Built to rank well in search engines</p>
                            </div>
                            <div class="feature-item" data-aos="zoom-in" data-aos-delay="600">
                                <i class="fas fa-shield-alt"></i>
                                <h4>Secure</h4>
                                <p>Built with security best practices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Services Section -->
        <section id="services" class="section services-section bg-light" aria-labelledby="services-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 id="services-heading" class="section-title">Our Services</h2>
                    <p class="section-description">Comprehensive web solutions tailored to your business needs</p>
                </div>
                
                <div class="services-grid">
                    <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="service-title">Custom Website Design</h3>
                        <p class="service-description">Tailored designs that reflect your brand and engage your audience.</p>
                        <a href="#contact" class="service-link scroll-link">Get Started <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="service-title">Responsive Development</h3>
                        <p class="service-description">Websites that look great on all devices, from desktop to mobile.</p>
                        <a href="#contact" class="service-link scroll-link">Get Started <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="service-title">E-commerce Solutions</h3>
                        <p class="service-description">Online stores designed to convert visitors into customers.</p>
                        <a href="#contact" class="service-link scroll-link">Get Started <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="service-title">SEO Optimization</h3>
                        <p class="service-description">Built-in SEO to help your site rank higher in search results.</p>
                        <a href="#contact" class="service-link scroll-link">Get Started <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Pricing Section -->
        <section id="pricing" class="section pricing-section" aria-labelledby="pricing-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 id="pricing-heading" class="section-title">Pricing Plans</h2>
                    <p class="section-description">Choose the perfect plan for your business needs</p>
                </div>
                
                <div class="pricing-grid">
                    <div class="pricing-card" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="plan-name">Basic</h3>
                        <div class="plan-price" data-monthly="£199" data-yearly="£2030">
                            <span class="price-amount">£199</span>
                            <span class="billing-cycle">/ one-time</span>
                        </div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> 1 Page Website</li>
                            <li><i class="fas fa-check"></i> Mobile Responsive</li>
                            <li><i class="fas fa-check"></i> Contact Form</li>
                            <li><i class="fas fa-check"></i> 1 Revision Round</li>
                        </ul>
                        <button class="btn btn-outline select-plan" data-plan="basic">Select Plan</button>
                    </div>
                    
                    <div class="pricing-card popular" data-aos="fade-up" data-aos-delay="300">
                        <div class="popular-badge">Most Popular</div>
                        <h3 class="plan-name">Professional</h3>
                        <div class="plan-price" data-monthly="£499" data-yearly="£5090">
                            <span class="price-amount">£499</span>
                            <span class="billing-cycle">/ one-time</span>
                        </div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> 6 Page Website</li>
                            <li><i class="fas fa-check"></i> Mobile Responsive</li>
                            <li><i class="fas fa-check"></i> Basic SEO</li>
                            <li><i class="fas fa-check"></i> 3 Revision Rounds</li>
                            <li><i class="fas fa-check"></i> Basic Analytics</li>
                            <li><i class="fas fa-check"></i> 1 year hosting included (Add on's may apply)</li>
                        </ul>
                        <button class="btn btn-primary select-plan" data-plan="professional">Select Plan</button>
                    </div>
                    
                    <div class="pricing-card" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="plan-name">Premium</h3>
                        <div class="plan-price" data-monthly="£899" data-yearly="£9170">
                            <span class="price-amount">£899</span>
                            <span class="billing-cycle">/ one-time</span>
                        </div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> Unlimited Pages</li>
                            <li><i class="fas fa-check"></i> Mobile Responsive</li>
                            <li><i class="fas fa-check"></i> Advanced SEO</li>
                            <li><i class="fas fa-check"></i> E-commerce Functionality</li>
                            <li><i class="fas fa-check"></i> 5 Revision Rounds</li>
                            <li><i class="fas fa-check"></i> Advanced Analytics</li>
                            <li><i class="fas fa-check"></i> Priority Support</li>
                        </ul>
                        <button class="btn btn-outline select-plan" data-plan="premium">Select Plan</button>
                    </div>
                </div>
                
                <div class="pricing-footer" data-aos="fade-up" data-aos-delay="500">
                    <p>Need a custom solution? <a href="#contact" class="scroll-link">Contact us</a> for a tailored quote.</p>
                </div>
            </div>
        </section>
        
        <!-- Maintenance Plans Section -->
        <section id="maintenance" class="section pricing-section" aria-labelledby="maintenance-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 id="maintenance-heading" class="section-title">Maintenance Plans</h2>
                    <p class="section-description">Choose the perfect plan for your business needs</p>
                </div>

                <div class="pricing-grid">
                    <div class="pricing-card" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="plan-name">Basic Maintenance</h3>
                        <div class="plan-price" data-monthly="£29" data-yearly="£290">
                            <span class="price-amount">£29</span>
                            <span class="billing-cycle">/ month</span>
                        </div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> Monthly plugin/theme updates</li>
                            <li><i class="fas fa-check"></i> Basic security checks</li>
                            <li><i class="fas fa-check"></i> Monthly backup</li>
                            <li><i class="fas fa-check"></i> Email support (48-hr response)</li>
                        </ul>
                        <button class="btn btn-outline select-plan" data-plan="basic-maintenance">Select Plan</button>
                    </div>
                    
                    <div class="pricing-card" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="plan-name">Premium Maintenance</h3>
                        <div class="plan-price" data-monthly="£59" data-yearly="£590">
                            <span class="price-amount">£59</span>
                            <span class="billing-cycle">/ month</span>
                        </div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> Everything in Basic</li>
                            <li><i class="fas fa-check"></i> Weekly updates & backups</li>
                            <li><i class="fas fa-check"></i> Uptime monitoring</li>
                            <li><i class="fas fa-check"></i> Performance optimization</li>
                            <li><i class="fas fa-check"></i> 24–48 hr support</li>
                        </ul>
                        <button class="btn btn-outline select-plan" data-plan="premium-maintenance">Select Plan</button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- How It Works Section -->
        <section id="process" class="section process-section bg-light" aria-labelledby="process-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 id="process-heading" class="section-title">Our Process</h2>
                    <p class="section-description">Simple steps to your perfect website</p>
                </div>
                <div class="process-steps" data-aos="fade-up" data-aos-delay="200" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                    <p>Watch how we turn your ideas into reality.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="400" style="text-align: center; margin-top: 20px;">
                    <video 
                        id="process-video" 
                        width="40%" 
                        autoplay 
                        muted 
                        loop 
                        playsinline 
                        style="border-radius: 20px; display: block; margin: 0 auto;"
                    >
                        <source src="/stock/howitworks.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
        </section>

        <!-- Video Introduction Section -->
        <section class="section video-section" aria-label="Video Introduction">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="section-title">Watch Our Introduction</h2>
                    <p class="section-description">See what makes Orbis different</p>
                </div>
                <div class="video-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <video id="intro-video" width="100%" poster="/stock/pic123.png" playsinline controls>
                        <source src="/stock/homevid4.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </section>
        
        <!-- Testimonials Section -->
        <section id="testimonials" class="section testimonials-section" aria-labelledby="testimonials-heading">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 id="testimonials-heading" class="section-title">What Our Clients Say</h2>
                    <p class="section-description">Don't just take our word for it</p>
                </div>
                
                <div class="testimonials-slider">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="testimonial-content">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Orbis transformed our online presence. Our new website has already increased our leads by 40% in the first month! They're amazing honestly!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user-circle big-icon"></i>
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Sarah Johnson</h4>
                                <p class="author-title">Marketing Director, BrightCo</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="testimonial-content">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"The team at Orbis was professional, creative, and delivered our e-commerce site ahead of schedule. Highly recommended!"</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user-circle big-icon"></i>
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Chloe Sargent</h4>
                                <p class="author-title">CEO, Glow With Chlo</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="testimonial-content">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="testimonial-text">"Our new website perfectly captures our brand identity. The design process was collaborative and the results exceeded our expectations."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="fas fa-user-circle big-icon"></i>
                            </div>
                            <div class="author-info">
                                <h4 class="author-name">Emma Rodriguez</h4>
                                <p class="author-title">Founder, GreenLeaf Organics</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="section contact-section" aria-labelledby="contact-heading">
            <div class="container">
                <div class="contact-container">
                    <div class="contact-info" data-aos="fade-up">
                        <h2 id="contact-heading" class="section-title">Get In Touch</h2>
                        <p class="contact-description">Ready to start your project? Contact us today for a free consultation.</p>
                        
                        <div class="contact-details">
                            <div class="contact-item" data-aos="fade-up" data-aos-delay="200">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <h3>Email</h3>
                                    <a href="mailto:orbis.web.service@gmail.com">orbis.web.service@gmail.com</a>
                                </div>
                            </div>
                            
                            <div class="contact-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <h3>Phone</h3>
                                    <a href="tel:07983097946">07983097946</a>
                                </div>
                            </div>
                            
                            <div class="contact-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <h3>Location</h3>
                                    <p>Liverpool, England</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-links" data-aos="fade-up" data-aos-delay="500">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    
                    <div class="contact-form-wrapper" data-aos="fade-up" data-aos-delay="600">
                        <form id="contact-form" class="contact-form" action="your_processing_script.php" method="POST" novalidate>
                            <input type="hidden" name="access_key" value="f1eec908-971f-471e-bf67-3b60ec9ce43a">
                            <input type="hidden" name="subject" value="New Contact Form Submission">
                            <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                            
                            <div class="form-group">
                                <label for="contact-name">Full Name *</label>
                                <input type="text" id="contact-name" name="name" required>
                                <span class="error-message"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-email">Email Address *</label>
                                <input type="email" id="contact-email" name="email" required>
                                <span class="error-message"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-phone">Phone Number</label>
                                <input type="tel" id="contact-phone" name="phone">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-message">Your Message *</label>
                                <textarea id="contact-message" rows="5" name="message" required></textarea>
                                <span class="error-message"></span>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="domain">Need a domain?</label>
                                    <select id="domain" name="domain" required>
                                        <option value="">Select option</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <span class="error-message"></span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="hosting">Need hosting?</label>
                                    <select id="hosting" name="hosting" required>
                                        <option value="">Select option</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <span class="error-message"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="plan-type">Interested in (optional)</label>
                                <select id="plan-type" name="plan_type">
                                    <option value="">Select plan</option>
                                    <option value="basic">Basic (£199)</option>
                                    <option value="professional">Professional (£499)</option>
                                    <option value="premium">Premium (£899)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <span class="btn-text">Send Message</span>
                                <span class="btn-loader" aria-hidden="true"></span>
                            </button>
                            
                            <div class="form-feedback"></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer" data-aos="fade-up">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-about" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="footer-logo">Orbis</h3>
                    <p class="footer-about-text">Creating beautiful, functional websites that help your business grow.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-col footer-links" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul>
                        <li><a href="#home" class="scroll-link">Home</a></li>
                        <li><a href="#services" class="scroll-link">Services</a></li>
                        <li><a href="#pricing" class="scroll-link">Pricing</a></li>
                        <li><a href="#about" class="scroll-link">About</a></li>
                        <li><a href="#contact" class="scroll-link">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col footer-services" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="footer-title">Services</h3>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">E-commerce</a></li>
                        <li><a href="#">SEO</a></li>
                        <li><a href="#">Hosting</a></li>
                        <li><a href="#">Maintenance</a></li>
                    </ul>
                </div>
                
                <div class="footer-col footer-contact" data-aos="fade-up" data-aos-delay="500">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> orbis.web.service@gmail.com</li>
                        <li><i class="fas fa-phone"></i> 07983097946</li>
                        <li><i class="fas fa-map-marker-alt"></i> Liverpool, England</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom" data-aos="fade-up" data-aos-delay="600">
                <div class="footer-legal">
                    <a href="/legal/Privacy Policy.pdf">Privacy Policy</a>
                    <a href="/legal/Terms of Service.pdf">Terms of Service</a>
                    <a href="/legal/Cookie Policy.pdf">Cookie Policy</a>
                </div>
                <p class="footer-copyright">&copy; <span id="current-year"></span> Orbis Web Solutions. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#header" class="back-to-top" aria-label="Back to top" data-aos="fade-up" data-aos-delay="200">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Chat Widget -->
    <script>
        (function(){
          if(!window.chatbase || window.chatbase("getState") !== "initialized"){
            window.chatbase = (...arguments) => {
              if(!window.chatbase.q) { window.chatbase.q = [] }
              window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
              get(target, prop) {
                if(prop === "q") { return target.q }
                return (...args) => target(prop, ...args)
              }
            })
          }
          const onLoad = function(){
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "NGl387OgjEzQGrMakQ2Qx";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script);
          };
          if(document.readyState === "complete"){
            onLoad()
          } else {
            window.addEventListener("load", onLoad)
          }
        })();
    </script>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/smoothscroll-polyfill@0.4.4/dist/smoothscroll.min.js"></script>
    <script src="scripts.js" defer></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100
      });
    </script>
</body>
</html>
