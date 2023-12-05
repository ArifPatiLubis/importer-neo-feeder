<nav class="sidebar sidebar-offcanvas " id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#beranda" aria-expanded="false"
                aria-controls="referensi" style="{{ Request::is('Administrator/Beranda*') ? 'color: green' : '' }}">
                <i class="fa-solid fa-house fa-fw mr-2"></i>
                <span class="menu-title">Beranda</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="beranda">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Beranda/Profil-Kampus') }}" 
                            style="{{ Request::is('Administrator/Beranda/Profil-Kampus') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-university fa-fw mr-2"></i>
                            <span class="menu-title">Profil Universitas</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Beranda/Program-Studi') }}" 
                            style="{{ Request::is('Administrator/Beranda/Program-Studi') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-graduation-cap fa-fw mr-2"></i>
                            <span class="menu-title">Program Studi</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Beranda/Penugasan-Dosen') }}" 
                            style="{{ Request::is('Administrator/Beranda/Penugasan-Dosen') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-person-chalkboard fa-fw mr-2"></i>
                            <span class="menu-title">Penugasan Dosen</span></a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pddikti" aria-expanded="false"
                aria-controls="referensi" style="{{ Request::is('Administrator/Data-Pddikti*') ? 'color: green' : '' }}">
                <i class="fa-solid fas fas fa-laptop-code fa-fw mr-2"></i>
                <span class="menu-title">Data PDDIKTI</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pddikti">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Data-Pddikti/Mahasiswa') }}" 
                            style="{{ Request::is('Administrator/Data-Pddikti/Mahasiswa') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-book-open-reader fa-fw mr-2"></i>
                            <span class="menu-title">Mahasiswa</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Data-Pddikti/Kelas-Perkuliahan') }}" 
                            style="{{ Request::is('Administrator/Data-Pddikti/Kelas-Perkuliahan') ? 'color: green' : '' }}">
                            <i class="fa-solid 	fas fa-chalkboard fa-fw mr-2"></i>
                            <span class="menu-title">Kelas Perkuliahan</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Data-Pddikti/KRS') }}" 
                            style="{{ Request::is('Administrator/Data-Pddikti/KRS') ? 'color: green' : '' }}">
                            <i class="fa-solid 	fas fa-book-open fa-fw mr-2"></i>
                            <span class="menu-title">KRS</span></a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#referensi" aria-expanded="false"
                aria-controls="referensi" style="{{ Request::is('Administrator/Referensi*') ? 'color: green' : '' }}">
                <i class="fa-solid fa-info-circle fa-fw mr-2"></i>
                <span class="menu-title">Referensi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="referensi">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Agama') }}" 
                            style="{{ Request::is('Administrator/Referensi/Agama') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-hands-praying fa-fw mr-2"></i>
                            <span class="menu-title">Agama</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Jalur-Masuk') }}" 
                            style="{{ Request::is('Administrator/Referensi/Jalur-Masuk') ? 'color: green' : '' }}">
                            <i class="fa-solid fas fa-layer-group fa-fw mr-2"></i>
                            <span class="menu-title">Jalur Masuk</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Jenis-Evaluasi') }}" 
                            style="{{ Request::is('Administrator/Referensi/Jenis-Evaluasi') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-list-check fa-fw mr-2"></i>
                            <span class="menu-title">Jenis Evaluasi</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Jenjang-Pendidikan') }}" 
                            style="{{ Request::is('Administrator/Referensi/Jenjang-Pendidikan') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-school-flag fa-fw mr-2"></i>
                            <span class="menu-title">Jenjang Pendidikan</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Pembiayaan') }}" 
                            style="{{ Request::is('Administrator/Referensi/Pembiayaan') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-money-bill fa-fw mr-2"></i>
                            <span class="menu-title">Pembiayaan</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Referensi/Wilayah') }}" 
                            style="{{ Request::is('Administrator/Referensi/Wilayah') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-map fa-fw mr-2"></i>
                            <span class="menu-title">Wilayah</span></a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#import" aria-expanded="false"
                aria-controls="referensi" style="{{ Request::is('Administrator/Import*') ? 'color: green' : '' }}">
                <i class="fa-solid fa-file-excel fa-fw mr-2"></i>
                <span class="menu-title">Import Excel</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="import">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Import/Biodata') }}" 
                            style="{{ Request::is('Administrator/Import/Biodata') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-users fa-fw mr-2"></i>
                            <span class="menu-title">Biodata Mahasiswa</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Import/Histori') }}" 
                            style="{{ Request::is('Administrator/Import/Histori') ? 'color: green' : '' }}">
                            <i class="fa-solid fa-book fa-fw mr-2"></i>
                            <span class="menu-title">Histori Pendidikan</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Import/Dosen-Pengajar') }}" 
                            style="{{ Request::is('Administrator/Import/Dosen-Pengajar') ? 'color: green' : '' }}">
                            <i class="fa-solid fas fa-chalkboard-teacher fa-fw mr-2"></i>
                            <span class="menu-title">Dosen Pengajar</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Import/Peserta-Kelas') }}" 
                            style="{{ Request::is('Administrator/Import/Peserta-kelas') ? 'color: green' : '' }}">
                            <i class="fa-solid fas fa-columns fa-fw mr-2"></i>
                            <span class="menu-title">Peserta Kelas/KRS</span></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Import/Aktivitas-Perkuliahan') }}" 
                            style="{{ Request::is('Administrator/Import/Aktivitas-Perkuliahan') ? 'color: green' : '' }}">
                            <i class="fa-solid fas fa-clipboard-list fa-fw mr-2"></i>
                            <span class="menu-title">Aktivitas Perkuliahan</span></a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false"
                aria-controls="referensi" style="{{ Request::is('Administrator/Pengaturan*') ? 'color: green' : '' }}">
                <i class="fa-solid fa-cog fa-fw mr-2"></i>
                <span class="menu-title">Pengaturan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="setting">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Administrator/Pengaturan/Daftar-Pengguna') }}" 
                            style="{{ Request::is('Administrator/Pengaturan/Daftar-Pengguna') ? 'color: green' : '' }}">
                            <i class="fa-solid fas fa-user-friends fa-fw mr-2"></i>
                            <span class="menu-title">Daftar Pengguna</span></a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
