<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        {{-- <img src="{{compta_asset('dist/img/AdminLTELogo.png')}}" alt="AkasiCompta" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        {{-- <i class="fab fa-cuttlefish brand-icon text-success"></i> --}}
        <span class="brand-text font-weight-bolder">AkasiMorgue<span class="text-success">Manager</span></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- <img src="{{compta_asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image"> --}}
                <i class="fas fa-user text-white" style="font-size: xx-large; opacity: .8"></i>
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth_user()->firstname }} {{ auth_user()->lastname }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{ ($page == 'dashboard')?'active':'' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('exercice.index')}}" class="nav-link {{ ($page == 'exercice')?'active':'' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        {{-- <p>Exercices</p> --}}
                        <p>Réception des corps</p>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('journal.index')}}" class="nav-link {{ ($page == 'journal')?'active':'' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Examen médical</p>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a href="{{route('devise.index')}}" class="nav-link {{ ($page == 'devise')?'active':'' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>Mouvements des corps</p>
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="{{route('ecriture.index')}}" class="nav-link {{ ($page == 'ecriture')?'active':'' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>Autorisations</p>
                    </a>
                </li>
              
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Budgets
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('budget')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Elaboration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('budget')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Exécution</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Rapports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('balance')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Balance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('bilan')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Bilan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('resultat')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Résultat</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-header">CONFIGURATIONS</li>
                <li class="nav-item">
                    <a href="{{route('compte.index')}}" class="nav-link {{ ($page == 'compte')?'active':'' }}">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>Morgue</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('devise.index')}}" class="nav-link {{ ($page == 'devise')?'active':'' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>Devises</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('parametre')}}" class="nav-link {{ ($page == 'parametre')?'active':'' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Paramètres</p>
                    </a>
                </li> --}}
                <li class="nav-item" style="border-top: 1px solid #4f5962;">
                    <a href="{{route('logout')}}" class="nav-link logout">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Déconnexion</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 