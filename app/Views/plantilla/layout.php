<?php
if(!session('idusuario')){
    header('location: '.base_url().'');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Sistema">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="">
    <meta name="keywords" content="">


    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css" integrity="sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css" integrity="sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=" crossorigin="anonymous">

    <link rel="stylesheet" href="<?=base_url('public/adminlte')?>/dist/css/adminlte.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">

    <!-- <link rel="stylesheet" href="<?=base_url('public/css/styles.css')?>"> -->
     

    <?php echo $this->renderSection("css");?>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bolder" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="fa-solid fa-bars"></i> <?=session('iglesia')?>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="<?=base_url('public/images/nav/user.jpg')?>" class="user-image rounded-circle shadow" alt="User Image">
                            <span class="d-none d-md-inline"><?=session('usuario')?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="text-bg-white text-center pt-2">
                                <p>
                                    <?=session('nombres')?><br>
                                    <small class="fw-semibold"><?=session('tipo_usuario')?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <!-- <a href="<?=base_url('mis-datos')?>" class="btn btn-sm btn-outline-secondary">Mis datos</a> -->
                                <a href="<?=base_url('salir')?>" class="btn btn-sm btn-outline-secondary float-end">Salir</a>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="./" class="brand-link">                    
                    <span class="brand-text fw-light">Sistema Iglesia</span>
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                        <?php
                        if( session('idtipo_usuario') == 1 || session('idtipo_usuario') == 2 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('sistema')?>" class="nav-link <?php echo isset($dashLinkActive) ? 'active': ''?>">
                                <i class="nav-icon fa-solid fa-gauge-high"></i>
                                <p>DASHBOARD</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if( session('idtipo_usuario') == 1 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('iglesias')?>" class="nav-link <?php echo isset($iglesiasLinkActive) ? 'active': ''?>">
                                <i class="fa-solid fa-synagogue"></i>
                                <p>Iglesias</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if( session('idtipo_usuario') == 1 || session('idtipo_usuario') == 2 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('usuarios')?>" class="nav-link <?php echo isset($usuariosLinkActive) ? 'active': ''?>">
                                <i class="fa-solid fa-users"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if( session('idtipo_usuario') == 1 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('cajas-sis')?>" class="nav-link <?php echo isset($cajasLinkActiveSis) ? 'active': ''?>">
                                <i class="fa-solid fa-briefcase"></i>
                                <p>Cajas del Sistema</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if( session('idtipo_usuario') == 1 || session('idtipo_usuario') == 2 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('cajas-res')?>" class="nav-link <?php echo isset($cajasLinkActiveRes) ? 'active': ''?>">
                                <i class="fa-solid fa-briefcase"></i>
                                <p>Cajas Responsables</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if( session('idtipo_usuario') == 1 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('cuentas')?>" class="nav-link <?php echo isset($cuentasLinkActive) ? 'active': ''?>">
                                <i class="fa-solid fa-file-invoice"></i>
                                <p>Cuentas</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <?php
                        if( session('idtipo_usuario') == 1 || session('idtipo_usuario') == 2 || session('idtipo_usuario') == 3 ){
                        ?>
                        <li class="nav-item">
                            <a href="<?=base_url('registros')?>" class="nav-link <?php echo isset($registrosLinkActive) ? 'active': ''?>">
                                <i class="fa-solid fa-list-ol"></i>
                                <p>Procesos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=base_url('reportes-registros')?>" class="nav-link <?php echo isset($registrosRepLinkActive) ? 'active': ''?>">
                                <i class="fa-solid fa-chart-bar"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                        <?php
                        }
                        ?>

                        <li class="nav-item">
                            <a href="<?=base_url('salir')?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-arrow-right-from-bracket"></i>
                                <p>SALIR</p>
                            </a>
                        </li>
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <?php echo $this->renderSection("contenido");?>
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Desarrollado por: Luis A. Calderón Sánchez</div>
            <!--end::To the end-->
            <!--begin::Copyright-->
            <strong>
                Copyright &copy; <?php echo date('Y')?>
                <a href="./"><?php echo help_nombreWeb()?></a>.
            </strong>
            Todos los derechos reservados.
            <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
    </div>

    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="<?=base_url('public/adminlte')?>/dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>



    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };

        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>

    <?php echo $this->renderSection("scripts");?>
    
</body>

</html>