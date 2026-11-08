<footer class="site-footer">
    <div class="site-footer__main">
        <div class="shell site-footer__grid">
            <div>
                <div class="site-footer__brand">
                    <img src="{{ asset('assets/images/pict.png') }}" alt="" width="64" height="40" loading="lazy" decoding="async">
                    <p class="site-footer__name">
                        Patimban International<br>Car Terminal
                    </p>
                </div>
                <p>
                    Vehicle terminal operator at Patimban Port, Pusakanagara, Subang Regency, West Java. Operating since December 2021.
                </p>
            </div>

            <div>
                <h2>Explore</h2>
                <ul>
                    <li><a href="{{ url('/about') }}">About PICT</a></li>
                    <li><a href="{{ url('/operations') }}">Operations</a></li>
                    <li><a href="{{ url('/services') }}">Services</a></li>
                </ul>
            </div>

            <div>
                <h2>Company</h2>
                <ul>
                    <li><a href="{{ url('/our-tariffs') }}">Tariffs</a></li>
                    <li><a href="{{ url('/sustainability') }}">Sustainability</a></li>
                    <li><a href="{{ url('/news') }}">News</a></li>
                    <li><a href="https://www.linkedin.com/company/patimban-international-car-terminal/posts/?feedView=all" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                </ul>
            </div>

            <div>
                <h2>Contact</h2>
                <address>
                    Patimban Port, Pusakanagara,<br>
                    Subang Regency, West Java,<br>
                    Indonesia
                </address>
                <ul>
                    <li><a href="mailto:info@pict.co.id">info@pict.co.id</a></li>
                    <li><a href="https://patimbancarterminal.com/login" target="_blank" rel="noopener noreferrer">PICTOS login</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="shell">
            <p>&copy; {{ date('Y') }} PT Patimban International Car Terminal.</p>
            <p>Public information for terminal users and partners.</p>
        </div>
    </div>
</footer>
