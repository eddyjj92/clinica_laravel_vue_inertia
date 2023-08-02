<script setup>
import {onMounted, ref} from "vue";
import {router, Link} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";

defineProps({
    usuarios: Object
})

let dtConfig = {
    "order": [[ 0, 'asc' ]],
    language: {
        url: `api/datatables/es`
    },
    dom: 'lBfrtip',
    select: true,
    lengthMenu: [
        [10, 25, 50, 100, -1],
        ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
    ],
    buttons: [
        {
            text:      '<i class="bi-person-add"> Registrar Usuario</i>',
            action: function ( e, dt, node, config ) {
                router.get('/usuario/registrar');
            },
            className: `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white`,
        },
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#usersTable').DataTable(dtConfig);
})

let idProcessing = ref(null);
const options = {
    preserveScroll: true,
    onError: errors => {
        Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
        idProcessing.value = null;
    },
    onSuccess: () =>{
        idProcessing.value = null;
    },
}

const deleteUser = (id) =>{
    Swal.fire({
        title: 'Eliminar Usuario',
        text: "¿Está seguro q desea eliminar este usuario?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            idProcessing.value = id;
            router.delete(`/usuario/eliminar/${id}`, options)
        }
    })
}
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
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-users"></i> Usuarios</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-striped table-responsive w-100" id="usersTable">
                                <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Usuario</th>
                                    <th>Entidad</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="usr in usuarios" :key="usr.id">
                                    <td hidden>{{ usr.id }}</td>
                                    <td style="width: 35%">
                                        <div class="row justify-content-center align-items-center w-100">
                                            <!--                                                <div class="col-lg-4 col-md-5">
                                                                                                <img class="rounded rounded-3 w-100 h-100" :src="`img/profile/${usr.imagen}`">
                                                                                            </div>-->
                                            <div class="col-lg-8 col-md-7">
                                                <div class="text-base fw-bold">{{ usr.nombre }}</div>
                                                <div class="font-normal">{{ usr.email }}</div>
                                                <div class="font-normal">{{ usr.cargo }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ usr.empresa }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ usr.created_at }}</div>
                                        </div>
                                    </td>
                                    <td width="180px">
                                        <RouterLink :to="`/usuario/perfil/${usr.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Perfil Usuario ${usr.name}`"><i class="bi bi-eye-fill fs-6"></i></RouterLink>
                                        <RouterLink :to="`/usuario/editar/${usr.id}`" class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Usuario ${usr.name}`"><i class="bi bi-pencil-square fs-6"></i></RouterLink>
                                        <button @click="deleteUser(usr.id)" class="btn btn-danger m-1 rounded-3" :id="usr.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Usuario ${usr.name}`"> <i :hidden="idProcessing !== null && idProcessing === usr.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === usr.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
                                    </td>
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
                            <a href="#">Política de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
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
