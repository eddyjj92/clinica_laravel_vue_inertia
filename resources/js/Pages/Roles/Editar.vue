<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'

const props = defineProps({
    rol: Object,
    permisos: Object,
})

let form = useForm({
    nombre: props.rol.name,
    rol: props.rol.id,
    permisos: []
});

let permAll = ref(false);

onMounted(()=>{
    filterPerm();
    toggleNavbar();
})

const options = {
    preserveScroll: true,
    onError: async errors => {
        await Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
        await router.get('/roles/create')
    },
    onSuccess: async page2 =>{
        await Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: page2.props.flash.message
        });
    }
}

const submit = async () =>{
    if(form.permisos.length === 0){
        await Swal.fire({
            icon: 'warning',
            title: 'Validación',
            text: 'Tiene que selecciona un permiso como mínimo'
        })
    }else{
        await form.put(`/roles/${props.rol.id}`, options);
    }
}

function toggleFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
}

const validaPermiso = (permiso) => {
    if(permiso === 0 && form.permisos.length === 0){
        props.permisos.forEach(permiso => {
            form.permisos.push(permiso.id)
        })
    }else if(permiso === 0 && form.permisos.length !== 0){
        form.permisos = [];
        permAll.value = false;
    }else{
        form.permisos.includes(permiso) ? form.permisos = form.permisos.filter(perm => perm !== permiso) : form.permisos.push(permiso);
    }
}

const filterPerm = () => {
    props.rol.permissions.forEach(perm => {
        form.permisos.push(perm.id)
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
                        <h1 class="mt-4"><i class="bi bi-pencil-square"></i> Editar Rol de Usuario</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/roles"> <i class="fa fa-shield"></i> Roles y Permisos </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="bi bi-pencil-square"></i> Editar Rol de Usuario</li>
                                </ol>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row align-items-center justify-content-center mb-4">
                                        <div class="form-floating col-12 mb-4">
                                            <el-input v-model="form.nombre" type="text" size="large" class="extra-large" id="floatingInput2" placeholder="Nombre y Apellidos"><template #prepend>Rol de Usuario</template></el-input>
                                        </div>
                                        <div class="col-md-12 mb-4 row justify-content-start align-items-start" id="permisos">
                                            <h3 class="text-center"><i class="fa fa-user-secret"></i> Permisos</h3>
                                            <div class="col-md-3 form-check">
                                                <input v-model="permAll" :checked="form.permisos.length === props.permisos.length && form.permisos.length !== 0" @change="validaPermiso(0)" type="checkbox" class="form-check-input" :id="`permiso0`">
                                                <label class="form-check-label" :for="`permiso0`">Todos</label>
                                            </div>
                                            <div v-for="permiso in permisos" class="col-md-3 form-check">
                                                <input @change="validaPermiso(permiso.id)" :checked="form.permisos.includes(permiso.id)" type="checkbox" class="form-check-input" :id="`permiso${permiso.id}`">
                                                <label class="form-check-label" :for="`permiso${permiso.id}`">{{permiso.name}}</label>
                                            </div>
                                        </div>
                                        <label for="permisos" class="small"><i class="fa fa-hands-helping"></i> Seleccione los permisos que desea asignar a este rol de usuario</label>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg shadow-3-strong text-capitalize"><i class="fa fa-save"></i> Actualizar</button>
                                    </div>
                                </form>
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
