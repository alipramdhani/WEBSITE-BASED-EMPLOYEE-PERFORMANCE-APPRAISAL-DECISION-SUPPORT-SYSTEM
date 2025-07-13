<div class="container">
    <div class=" d-md-flex justify-content-between text-start mt-5 gap-3">
        {{-- Sosial Media --}}
        <div class="mb-md-4 mb-5 text-center text-md-start">
            <div class="mb-5">
                <h2>Sosial Media</h2>
            </div>
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-5">
                <div class="">
                    <a href="#">
                        <img src="{{ asset('images/ig.png')}}" alt="Instagram" width="38px">
                    </a>
                </div>
                <div class="">
                    <a href="#">
                        <img src="{{ asset('images/fb.png')}}" alt="Facebook" width="38px">
                    </a>
                </div>
                <div class="">
                    <a href="#">
                        <img src="{{ asset('images/x.png')}}" alt="X/Twitter" width="38px">
                    </a>
                </div>
            </div>
        </div>

        {{-- Tentang Achipelago --}}
        <div class=" d-none d-md-block mb-4" >
            <div class="mb-4">
                <h2>Tentang Arcchipelago</h2>
            </div>
            <div class="row">
                <div class="col-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            E-commerce & Global Distribution
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Architectur & Interior Design
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Good Govermance
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Hotel management
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Technology
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Career
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Franchise Plus
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Our Story
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center rounded-2" href="#">
                            Legal
                            <span class="material-symbols-rounded">
                                chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Sertifikasi --}}
        <div class="mb-4 w-auto w-md-25 text-center text-md-start">
            <div class="mb-4">
                <h2>Kami Bersertifikat</h2>
            </div>
            <div class="px-3 px-md-1">
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-start rounded-2 justify-content-between gap-3 text-start"
                        href="https://sm-indonesia.com/certificate/sertifikat/view_sertifikat/165-EC-240715">
                            <img src="{{ asset('images/certificate.png') }}" alt="Sertifikat 1" width="38" class="flex-shrink-0">
                            <div class="flex-grow-1">Sistem Manajemen Lingkungan</div>
                            <span class="material-symbols-rounded">chevron_right</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-start rounded-2 justify-content-between gap-3 text-start"
                        href="https://sm-indonesia.com/certificate/sertifikat/view_sertifikat/165-OS-240715">
                            <img src="{{ asset('images/certificate.png') }}" alt="Sertifikat 2" width="38" class="flex-shrink-0">
                            <div class="flex-grow-1">Sistem Manajemen Kesehatan <br> dan Keselamatan Kerja</div>
                            <span class="material-symbols-rounded">chevron_right</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-start rounded-2 justify-content-between gap-3 text-start"
                        href="https://drive.google.com/file/d/1yzMQOB_6NCZWgoAZBmP2tel6vmAh8dmF/view">
                            <img src="{{ asset('images/certificate.png') }}" alt="Sertifikat 3" width="38" class="flex-shrink-0">
                            <div class="flex-grow-1">Perusahaan Manajemen Hotel</div>
                            <span class="material-symbols-rounded">chevron_right</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- Tentang Archipelago | Mobile --}}
        <hr class="d-md-none">
        <div class="d-md-none">
            <div class="accordion accordion-flush" id="accordionTentangArchipelago">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingArchipelago">
                        <button class="accordion-button collapsed px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArchipelago" aria-expanded="false" aria-controls="collapseArchipelago">
                            <h2 class="mb-0 w-100 text-center">Tentang Archipelago</h2>
                        </button>
                    </h2>
                    <div id="collapseArchipelago" class="accordion-collapse collapse show" aria-labelledby="headingArchipelago" data-bs-parent="#accordionTentangArchipelago">
                        <div class="accordion-body px-0">
                            {{-- Link-list --}}
                            <ul class="nav flex-column">
                                @foreach ([
                                    'E-commerce & Global Distribution',
                                    'Architectur & Interior Design',
                                    'Good Governance',
                                    'Hotel Management',
                                    'Technology',
                                    'Career',
                                    'Franchise Plus',
                                    'Our Story',
                                    'Legal'
                                ] as $item)
                                    <li class="nav-item">
                                        <a class="nav-link d-flex justify-content-between align-items-center px-3 py-2" href="#">
                                            {{ $item }}
                                            <span class="material-symbols-rounded">chevron_right</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="my-3">
        {{-- Copyright cuy --}}
        <hr>
        <div class="fw-semibold  fs-6 text-center text-md-start">
            <p>Copyright 2025 © Mohamad Alif Ramdani</p>
        </div>
    </div>
</div>


</div>
