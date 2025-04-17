<ul class="m-0 p-0">
    <li class="d-flex align-items-center justify-content-center p-2">
        <img src="{{ asset('images/profile.png') }}" alt="Profile" class="profile-img ">
    </li>
    <li class="d-flex align-items-center justify-content-center p-2">
        <a href="#" class="align-items-center text-decoration-none text-dark" id="userMenuToggle">
            K3bycz
            <span>
                <i class="fa fa-caret-down" id="toggleIcon"></i>
            </span>
        </a>
    </li>
    <li class="d-flex align-items-center justify-content-center">
        <ul id="userDropdown" class="dropdown-list">
            <li class="pink-hover">
                <a href="#" class="text-decoration-none p-2 menu-option">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> Dane użytkownika
                </a>
            </li>
            <li class="pink-hover">
                <a href="#" class="text-decoration-none p-2 menu-option">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> Wyloguj
                </a>
            </li>
        </ul>
    </li>

    <h6> Pulpity </h6>
    <li class="p-2 pink-hover">
        <a href="/" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa fa-home" aria-hidden="true"></i></span> Pulpit
        </a>
    </li>
    <h6> Serwis </h6>
    <li class="p-2 pink-hover">
        <a href="/list/clients" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa fa-id-card" aria-hidden="true"></i></span> Klienci
        </a>
    </li>
    <li class="p-2 pink-hover">
        <a href="/list/devices" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa fa-laptop" aria-hidden="true"></i></span> Urządzenia
        </a>
    </li>
    <li class="p-2 pink-hover">
        <a href="/list/repairs" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa fa-gavel" aria-hidden="true"></i></span> Naprawy
        </a>
    </li>
    <li class="p-2 pink-hover">
        <a href="/list/orders" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa-solid fa-cart-shopping" aria-hidden="true"></i></span> Zamówienia
        </a>
    </li>
    <h6> Kalendarz </h6>
    <li class="p-2 pink-hover">
        <a href="/list/trips" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa-solid fa-suitcase" aria-hidden="true"></i></span> Wyjazdy
        </a>
    </li>
    <li class="p-2 pink-hover">
        <a href="/list/events" class="align-items-center text-decoration-none menu-option">
            <span class="ms-2"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span> Wydarzenia
        </a>
    </li>
</ul>