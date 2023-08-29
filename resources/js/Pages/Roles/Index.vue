<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import Buscador from "@/Components/Buscador.vue";

const page = usePage();

defineProps({
    roles: Object
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
            text: '<i class="bi-shield-plus"> Registrar Rol de Usuario</i>',
            action: function ( e, dt, node, config ) {
                router.get('/roles/create');
            },
            className: page.props.auth.user.roles[0].permissions.filter(value => value.id === 2).length > 0 ? `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white` : `text-white bg-primary fw-bold border-black border-2 border ripple ripple-surface-white disabled`,
        },
    ],
}

onMounted(()=>{
    toggleNavbar()
    $('#rolesTable').DataTable(dtConfig);
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
    onSuccess: (page) =>{
        Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: page.props.flash.message
        })
        idProcessing.value = null;
        router.get('/roles');
    },
}

const deleteRole= (id) =>{
    Swal.fire({
        title: 'Eliminar Rol de Usuario',
        text: "¿Está seguro q desea eliminar este Rol de Usuario?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            idProcessing.value = id;
            router.delete(`/roles/${id}`, options)
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
                    <h1 class="mt-4"><i class="fa fa-shield"></i> Roles y Permisos</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-users"></i> Roles y Permisos</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-striped table-responsive w-100" id="rolesTable">
                                <thead>
                                <tr>
                                    <th hidden>Id</th>
                                    <th>Rol de Usuario</th>
                                    <th>Permisos</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="rol in roles" :key="rol.id">
                                    <td hidden>{{ rol.id }}</td>
                                    <td>
                                        <div class="text-base fw-bold">{{ rol.name }}</div>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center align-items-center w-100">
                                            <span  v-for="perm in rol.permissions" :class="`col-md-3 badge ${perm.name.includes('ver') ? 'text-bg-primary' : ''} ${perm.name.includes('registrar') ? 'text-bg-success' : ''} ${perm.name.includes('editar') ? 'text-bg-warning' : ''} ${perm.name.includes('eliminar') ? 'text-bg-danger' : ''} ${perm.name.includes('buscar') ? 'text-bg-info' : ''} mx-3 my-2`">
                                                <i :class="`fa ${perm.name.includes('ver') ? 'fa-eye' : ''} ${perm.name.includes('registrar') ? 'fa-plus-circle' : ''} ${perm.name.includes('editar') ? 'fa-edit' : ''} ${perm.name.includes('eliminar') ? 'fa-trash' : ''} ${perm.name.includes('buscar') ? 'fa-search' : ''} small`"></i> {{ perm.name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="text-base fw-bold">{{ rol.created_at }}</div>
                                        </div>
                                    </td>
                                    <td width="120px">
                                        <Link :class="$page.props.auth.user.roles[0].permissions.filter(value => value.id === 7).length > 0 ? 'btn-info' : 'disabled btn-secondary'" :href="`/roles/${rol.id}/edit`" class="btn m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Rol de Usuario ${rol.name}`"><i class="bi bi-pencil-square fs-6"></i></Link>
                                        <button :disabled="!$page.props.auth.user.roles[0].permissions.filter(value => value.id === 8).length > 0" @click="deleteRole(rol.id)" class="btn btn-danger m-1 rounded-3" :id="rol.id" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Rol de Usuario ${rol.name}`"> <i :hidden="idProcessing !== null && idProcessing === rol.id"  class="bi bi-trash fs-6"></i> <span :hidden="!(idProcessing === rol.id)" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
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
