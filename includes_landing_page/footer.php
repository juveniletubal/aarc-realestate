<footer id="footer" class="footer accent-background">
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-about">
                <a href="" class="logo d-flex align-items-center">
                    <span class="sitename">Ammazeng Angels Realty Corporation</span>
                </a>
                <p>
                    Helping you find the perfect lot or property for your dream home or investment.
                    Connect with our expert agents for guidance and support.
                </p>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Properties</a></li>
                    <li><a href="#">Agents</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Product Management</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Graphic Design</a></li>
                </ul>
            </div>

            <div
                class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>A108 Adam Street</p>
                <p>New York, NY 535022</p>
                <p>United States</p>
                <p class="mt-4">
                    <strong>Phone:</strong> <span>+1 5589 55488 55</span>
                </p>
                <p><strong>Email:</strong> <span>info@example.com</span></p>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span><strong class="px-1 sitename">Ammazeng Angels</strong><span>All Rights Reserved</span></p>

        <div class="credits">
            Develop by <a href="https://www.facebook.com/juvenile.tubal13" target="_blank"><strong>Juvenile Tubal</strong></a>
        </div>
    </div>

</footer>

<!-- Scroll Top -->
<a
    href="#"
    id="scroll-top"
    class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- JS Files -->
<?php $assets->renderJS(); ?>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slides = document.querySelectorAll("#hero .bg-slide");
        let current = 0;

        setInterval(() => {
            slides[current].classList.remove("active");
            current = (current + 1) % slides.length;
            slides[current].classList.add("active");
        }, 5000);
    });
</script>

</body>

</html>