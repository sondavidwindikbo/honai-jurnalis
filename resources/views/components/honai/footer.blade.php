<footer class="honai-footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="site-title">Honai Jurnalis <span>Kampung</span></div>
            <div class="footer-about">
                Media berita independen yang lahir dari semangat warga Papua untuk mencatat, merekam, dan menyuarakan kehidupan nyata di tanah cenderawasih. Kami hadir dari Rumah Belajar Honai Jurnalis Kampung, Buper Waena, dan berkomitmen pada jurnalisme yang jujur, berimbang, dan berpihak pada kebenaran.
            </div>
        </div>
        <div>
            <div class="footer-col-title">Rubrik</div>
            @foreach(\App\Models\Category::orderBy('name')->limit(6)->get() as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="footer-link">{{ $category->name }}</a>
            @endforeach
        </div>
        <div>
            <div class="footer-col-title">Informasi</div>
            <a href="#" class="footer-link">Tentang Kami</a>
            <a href="#" class="footer-link">Redaksi</a>
            <a href="#" class="footer-link">Pedoman Media Siber</a>
            <a href="#" class="footer-link">Kode Etik Jurnalistik</a>
            <a href="#" class="footer-link">Hubungi Kami</a>
        </div>
        <div>
            <div class="footer-col-title">Berkontribusi</div>
            <a href="#" class="footer-link">Kirim Tulisan</a>
            <a href="#" class="footer-link">Laporkan Berita</a>
            <a href="#" class="footer-link">Liputan Foto</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ now()->year }} Honai Jurnalis Kampung &bull; Buper Waena, Jayapura, Papua &bull; Media Warga yang Bebas dan Bertanggung Jawab
    </div>
</footer>
