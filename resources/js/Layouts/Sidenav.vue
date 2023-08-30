<script setup>
import {ref,onMounted} from 'vue';
import {router, Link } from "@inertiajs/vue3";
import { ripple } from '../Helpers';

onMounted(()=>{
    ripple()
})
</script>

<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <Link v-if="$page.props.auth.user !== null" class="nav-link ripple" href="/dashboard" style="margin-top: 20px">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </Link>
                    <a v-if="$page.props.auth.user !== null" class="nav-link collapsed ripple" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRoles" aria-expanded="false" aria-controls="collapseRoles">
                        <div class="sb-nav-link-icon"><i class="fas fa-shield"></i></div>
                        Roles y Permisos
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseRoles" aria-labelledby="headingOne" data-bs-parent="#collapseRoles">
                        <nav class="sb-sidenav-menu-nested nav">
                            <Link class="nav-link ripple" href="/roles"><i class="fas fa-eye"></i>&nbsp Ver Roles</Link>
                            <Link v-if="$page.props.auth.user !== null" class="nav-link ripple" href="/roles/create"><i class="fas fa-plus"></i>&nbsp Registrar Rol</Link>
                        </nav>
                    </div>
                    <a v-if="$page.props.auth.user !== null" class="nav-link collapsed ripple" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                        Usuarios
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUsuarios" aria-labelledby="headingOne" data-bs-parent="#collapseUsuarios">
                        <nav class="sb-sidenav-menu-nested nav">
                            <Link class="nav-link ripple" href="/usuarios"><i class="fas fa-users"></i>&nbsp Ver Usuarios</Link>
                            <Link v-if="$page.props.auth.user !== null" class="nav-link ripple" href="/usuario/registrar"><i class="fas fa-user-plus"></i>&nbsp Registrar Usuario</Link>
                        </nav>
                    </div>
                    <a v-if="$page.props.auth.user !== null"  class="nav-link collapsed ripple" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServidores" aria-expanded="false" aria-controls="collapseServidores">
                        <div class="sb-nav-link-icon"><i class="fas fa-building-columns"></i></div>
                        Empresas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseServidores" aria-labelledby="headingTwo" data-bs-parent="#collapseServidores">
                        <nav class="sb-sidenav-menu-nested nav">
                            <Link class="nav-link ripple" href="/empresas"><i class="fas fa-building-columns"></i>&nbsp Ver Empresas</Link>
                            <Link v-if="$page.props.auth.user !== null"  class="nav-link ripple" href="/empresas/create"><i class="fas fa-building-circle-check"></i>&nbsp Registrar Empresa</Link>
                        </nav>
                    </div>
                    <a v-if="$page.props.auth.user !== null"  class="nav-link collapsed ripple" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSolicitudes" aria-expanded="false" aria-controls="collapseSolicitudes">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-medical"></i></div>
                        Solicitudes
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseSolicitudes" aria-labelledby="headingTwo" data-bs-parent="#collapseSolicitudes">
                        <nav class="sb-sidenav-menu-nested nav">
                            <Link class="nav-link ripple" href="/solicitudes"><i class="fas fa-file-medical-alt"></i>&nbsp Ver Solicitudes</Link>
                            <Link v-if="$page.props.auth.user !== null"  class="nav-link ripple" href="/solicitudes/create"><i class="fas fa-circle-plus"></i>&nbsp Registrar Solicitud</Link>
                        </nav>
                    </div>
                    <Link v-if="$page.props.auth.user !== null"  class="nav-link ripple" href="/cuestionarios">
                        <div class="sb-nav-link-icon"><i class="fas fa-clipboard-check"></i></div>
                        Cuestionarios
                    </Link>
                    <Link class="nav-link ripple" href="/logout">
                        <div class="sb-nav-link-icon"><i class="fas fa-close"></i></div>
                        Cerrar Sesión
                    </Link>
                </div>
            </div>
            <div class="sb-sidenav-footer" style="height: 70px">
                <div class="small text-center"><i class="fa fa-user-circle"></i> Conectado:</div>
                <p class="small text-center fw-bold">{{$page.props.auth.user !== null ? $page.props.auth.user.email : 'Anónimo'}}</p>
            </div>
        </nav>
    </div>
</template>

<style scoped>

</style>
