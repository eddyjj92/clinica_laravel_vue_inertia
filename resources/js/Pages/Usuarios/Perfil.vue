<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'

const props = defineProps({
    usuario: Object
});

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    columnDefs: [
        {
            target: 0,
            visible: false,
        },
    ],
    language: {
        url: `/api/datatables/es`
    },
    dom: 'lfrtip',
    select: true,
    lengthMenu: [
        [-1, 10, 25, 50, 100],
        ['Todo', '10 Filas', '25 Filas', '50 Filas', '100 Filas',]
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#userTable').DataTable(dtConfig);
});

</script>

<template>
    <body class="sb-nav-fixed">
        <Navbar />
        <div id="layoutSidenav" class="vh-100">
            <Sidenav />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><i class="fa fa-user"></i> Usuarios</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/usuarios"> <i class="fa fa-users"></i> Usuarios </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-cog"></i>Perfil Usuario (<Link :href="`/usuario/editar/${props.usuario.id}`">Editar</Link>)</li>
                                </ol>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped w-100" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="w-25">Propiedades</th>
                                            <td class="fw-bold">Datos</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <th>Avatar</th>
                                            <td><img style="width: 100px" :src="`/img/profile/${props.usuario.avatar}`" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <th>Nombre</th>
                                            <td>{{props.usuario.nombre}}</td>
                                        </tr>
                                        <tr>
                                            <th>3</th>
                                            <th>Correo</th>
                                            <td>{{props.usuario.email}}</td>
                                        </tr>
                                        <tr>
                                            <th>4</th>
                                            <th>Empresa</th>
                                            <td>{{props.usuario.empresa}}</td>
                                        </tr>
                                        <tr>
                                            <th>5</th>
                                            <th>Cargo</th>
                                            <td>{{props.usuario.cargo}}</td>
                                        </tr>
                                        <tr>
                                            <th>6</th>
                                            <th>Fecha Registro</th>
                                            <td>{{props.usuario.created_at}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Laboratorio Clínico y Patológico 2023</div>
                            <div>
                                <a id="show_politica_privacidad" href="#"><i class="bi bi-shield-fill-exclamation"></i> Política de Privacidad</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</template>

<style scoped>

</style>
