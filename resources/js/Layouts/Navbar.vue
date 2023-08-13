<script setup>
import {onMounted} from 'vue';
import {Link, usePage} from '@inertiajs/vue3'
import { ripple } from '../Helpers';

const emit = defineEmits(['search'])

const page = usePage()

onMounted(()=>{
    ripple()
})

</script>

<template>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="height: 60px;">
        <!-- Navbar Brand-->
        <Link class="navbar-brand ps-3 ripple" href="/dashboard" style="width: 80px">
            <img class="w-100" src="/img/logo.png" alt="">
        </Link>
        <span class="text-white fs-6 fw-bold text-center">Laboratorio Clínico <br> Patológico</span>
        <!-- Sidebar Toggle-->
        <button class="btn btn-lg ripple mx-1" id="sidebarToggle"><i class="fas fa-bars fs-3"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input @keyup="$emit('search', $event.target.value)" :disabled="$page.props.auth.user === null" :class="$page.props.auth.user === null ? 'text-decoration-line-through' : ''" class="form-control form-control" type="text" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="btnNavbarSearch" />
                <button :disabled="$page.props.auth.user === null" :class="$page.props.auth.user === null ? 'btn-secondary' : 'btn-primary ripple'" class="btn" id="btnNavbarSearch" type="button"><i :class="$page.props.auth.user !== null ? 'fa-search' : 'fa-cancel'" class="fas"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><Link v-if="$page.props.auth.user" class="dropdown-item ripple" :href="`/usuario/perfil/${$page.props.auth.user.id}`"><i class="fas fa-user-cog"></i> Perfil</Link></li>
                    <li><hr v-if="$page.props.auth.user" class="dropdown-divider"/></li>
                    <li><Link class="dropdown-item ripple" href="/logout"><i class="fa fa-close"></i> Cerrar Sesión</Link></li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
