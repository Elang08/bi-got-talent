<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#130c27">
    <title>BI Got Talent — Panggung untuk Bakatmu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="talent-site">
    <div class="talent-landing">
        <nav class="talent-nav">
            <a href="{{ url('/') }}" class="talent-brand" aria-label="BI Got Talent beranda">
                <span class="talent-brand-mark">BI</span>
                <span>GOT <strong>TALENT</strong></span>
            </a>
            <div class="talent-nav-links">
                <a href="#tentang">Tentang</a>
                <a href="#kategori">Kategori</a>
            </div>
            <div class="talent-nav-actions">
                @auth
                    <a class="talent-button talent-button-quiet" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="talent-login" href="{{ route('login') }}">Masuk</a>
                    <a class="talent-button talent-button-small" href="{{ route('register') }}">Daftar sekarang <span aria-hidden="true">↗</span></a>
                @endauth
            </div>
        </nav>

        <main>
            <section class="talent-hero" id="tentang">
                <div class="talent-hero-copy">
                    <div class="talent-eyebrow"><span></span> AJANG KREATIVITAS & PRESTASI</div>
                    <h1>Setiap bakat<br>punya <span>panggung.</span></h1>
                    <p class="talent-hero-description">Saatnya tunjukkan kemampuan terbaikmu. Temukan bidang yang kamu cintai, daftarkan diri, dan jadilah inspirasi berikutnya di BI Got Talent.</p>
                    <div class="talent-hero-actions">
                        @auth
                            <a class="talent-button" href="{{ route('dashboard') }}">Lihat dashboard <span aria-hidden="true">→</span></a>
                        @else
                            <a class="talent-button" href="{{ route('register') }}">Ikut berkompetisi <span aria-hidden="true">→</span></a>
                            <a class="talent-text-link" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
                        @endauth
                    </div>
                    <div class="talent-proof">
                        <div class="talent-avatar-stack" aria-hidden="true"><span>✦</span><span>♫</span><span>⌘</span></div>
                        <p><strong>Waktunya kamu bersinar</strong><br><span>Talenta hebat dimulai dari berani mencoba.</span></p>
                    </div>
                </div>

                <div class="talent-stage" aria-label="Ilustrasi panggung kompetisi">
                    <div class="talent-stage-glow"></div>
                    <span class="talent-spark talent-spark-one">✦</span>
                    <span class="talent-spark talent-spark-two">✧</span>
                    <span class="talent-stage-tag">PANGGUNG<br><strong>MILIKMU</strong></span>
                    <div class="talent-stage-disc"><span>✦</span></div>
                    <div class="talent-stage-person">
                        <span class="talent-person-head"></span>
                        <span class="talent-person-body"></span>
                        <span class="talent-person-arm"></span>
                    </div>
                    <div class="talent-stage-platform"><span>BI GOT TALENT</span></div>
                    <div class="talent-stage-base"></div>
                    <div class="talent-stage-caption"><span class="talent-live-dot"></span> TUNJUKKAN VERSI TERBAIKMU</div>
                </div>
            </section>

            <section class="talent-categories" id="kategori">
                <div class="talent-section-heading">
                    <div><span class="talent-section-kicker">PILIH PANGGUNGMU</span><h2>Bakatmu, ceritamu.</h2></div>
                    <p>Setiap keahlian layak mendapat kesempatan untuk bersinar.</p>
                </div>
                <div class="talent-category-grid">
                    <article class="talent-category-card talent-card-purple">
                        <span class="talent-category-icon">♫</span>
                        <span class="talent-category-number">01</span>
                        <h3>Seni & Pertunjukan</h3>
                        <p>Ekspresikan diri melalui musik, tari, dan penampilan panggung.</p>
                        <span class="talent-card-arrow">↗</span>
                    </article>
                    <article class="talent-category-card talent-card-pink">
                        <span class="talent-category-icon">✳</span>
                        <span class="talent-category-number">02</span>
                        <h3>Kreativitas Digital</h3>
                        <p>Wujudkan ide segar lewat desain, teknologi, dan karya digital.</p>
                        <span class="talent-card-arrow">↗</span>
                    </article>
                    <article class="talent-category-card talent-card-gold">
                        <span class="talent-category-icon">✦</span>
                        <span class="talent-category-number">03</span>
                        <h3>Inovasi & Lainnya</h3>
                        <p>Tunjukkan kemampuan unik yang membuatmu berbeda.</p>
                        <span class="talent-card-arrow">↗</span>
                    </article>
                </div>
            </section>
        </main>

        <footer class="talent-footer">
            <a href="{{ url('/') }}" class="talent-brand"><span class="talent-brand-mark">BI</span><span>GOT <strong>TALENT</strong></span></a>
            <span>Temukan bakatmu. Tunjukkan duniamu.</span>
            <span>© {{ date('Y') }} BI Got Talent</span>
        </footer>
    </div>
</body>
</html>
