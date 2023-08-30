<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import Buscador from "@/Components/Buscador.vue";

const page = usePage();

defineProps({
    usuarios: Object
})

let search = ref(null);
let result = ref({
    data: {
        usuarios: [],
        empresas: [],
        cuestionarios: [],
    }
})
let buscando = ref(false);

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
            text: '<i class="bi-person-add"> Registrar Usuario</i>',
            action: function ( e, dt, node, config ) {
                router.get('/usuario/registrar');
            },
            className: page.props.auth.user.roles[0].permissions.filter(value => value.id === 6).length > 0 ? `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white` : `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white disabled`,
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
        router.get('/usuarios');
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

const buscar = async(key) => {
    search.value = key;
    buscando.value = true;
    if(key !== null && key !== ''){
        await axios.get(`/buscador/${key}`).then(response => {
            result.value.data.usuarios = response.data.usuarios;
            result.value.data.empresas = response.data.empresas;
            result.value.data.cuestionarios = response.data.cuestionarios;
            buscando.value = false;
        })
    }
}
</script>

<template>
    <body class="sb-nav-fixed">
    <Navbar :search="search" @search="result => buscar(result)"/>
    <div id="layoutSidenav" class="vh-100">
        <Sidenav />
        <div id="layoutSidenav_content">
            <main>
                <Buscador :buscando="buscando" :result="result" :hidden="search === null || search === ''" />
                <div class="container-fluid px-4" :hidden="search !== null && search !== ''">
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
                                    <th>Empresa</th>
                                    <th>Estado Conexión</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="usr in usuarios" :key="usr.id">
                                    <td hidden>{{ usr.id }}</td>
                                    <td style="width: 35%">
                                        <div class="row justify-content-center align-items-center w-100">
                                            <div class="col-lg-4 col-md-5">
                                                <img class="rounded rounded-3 border border-2 border-primary w-100 h-100" :src="`/img/profile/${usr.avatar}`">
                                            </div>
                                            <div class="col-lg-8 col-md-7">
                                                <div class="text-base fw-bold">{{ usr.nombre }}</div>
                                                <div class="font-normal">{{ usr.email }}</div>
                                                <div class="font-normal">{{ usr.roles[0].name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ usr.empresa }}</div>
                                            <div class="font-normal">{{ usr.cargo }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row align-items-center justify-content-center">
                                            <span :class="`text-base fw-bold col-10 badge ${usr.conectado === 'conectado' ? 'bg-success' : ''} ${usr.conectado === 'desconectado' ? 'bg-danger' : ''} ${usr.conectado === 'sin autenticar' ? 'bg-secondary' : ''}`"><i :class="`fa ${usr.conectado === 'conectado' ? 'fa-network-wired' : ''} ${usr.conectado === 'desconectado' ? 'fa-close' : ''} ${usr.conectado === 'sin autenticar' ? 'fa-user-slash' : ''}`"></i> {{ usr.conectado }}</span>
                                            <span class="text-base fw-bold col-10">IP: {{ usr.conexion.ip ?? '-----------' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ usr.created_at }}</div>
                                        </div>
                                    </td>
                                    <td width="180px">
                                        <Link :href="`/usuario/perfil/${usr.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Perfil Usuario ${usr.nombre}`"><i class="bi bi-eye-fill fs-6"></i></Link>
                                        <Link :class="$page.props.auth.user.roles[0].permissions.filter(value => value.id === 7).length > 0 ? 'btn-info' : 'disabled btn-secondary'" :href="`/usuario/editar/${usr.id}`" class="btn m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Usuario ${usr.nombre}`"><i class="bi bi-pencil-square fs-6"></i></Link>
                                        <button :disabled="!$page.props.auth.user.roles[0].permissions.filter(value => value.id === 8).length > 0" @click="deleteUser(usr.id)" class="btn btn-danger m-1 rounded-3" :id="usr.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Usuario ${usr.nombre}`"> <i :hidden="idProcessing !== null && idProcessing === usr.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === usr.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
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
