<div class="sidebar-menu">
    <div class="sidebar-menu__inner">
        <div class="cross-sidebar"><i class="fas fa-times"></i></div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item">
                <a href="{{ route('dashboard') }}" class="sidebar-menu-list__link active">
                    <span class="icon"><i class="fas fa-th-large"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="{{ route('my.investment') }}" class="sidebar-menu-list__link ">
                    <span class="icon"><i class="fas fa-dolly-flatbed"></i></span>
                    <span class="text">My Investments</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="{{ route('profit.history') }}" class="sidebar-menu-list__link ">
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <span class="text">Profit History</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item has-dropdown">
                <a href="javascript:void(0)" class="sidebar-menu-list__link ">
                    <span class="icon"><i class="fas fa-wallet"></i></span>
                    <span class="text">Deposit</span>
                </a>
                <div class="sidebar-submenu ">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('deposit.money') }}" class="sidebar-submenu-list__link ">
                                <span class="text">Deposit Money</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown">
                <a href="javascript:void(0)" class="sidebar-menu-list__link ">
                    <span class="icon"><i class="far fa-credit-card"></i></span>
                    <span class="text">Withdraw</span>
                </a>
                <div class="sidebar-submenu ">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('withdraw.money') }}" class="sidebar-submenu-list__link ">
                                <span class="text">Withdraw Money</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="{{ route('transactions') }}" class="sidebar-menu-list__link ">
                    <span class="icon"><i class="fas fa-exchange-alt"></i></span>
                    <span class="text">Transactions</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link " href="{{ route('profile.setting') }}">
                    <span class="icon"><i class="fas fa-user-circle"></i></span>
                    <span class="text">Profile Setting</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link " href="{{ route('user.change.password') }}">
                    <span class="icon"><i class="fas fa-cog"></i></span>
                    <span class="text">Change Password</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link" href="{{ route('user.logout') }}">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="text">Logout</span>
                </a>
            </li>

        </ul>
    </div>
</div>