<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm, usePage} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'

const page = usePage();

defineProps({
    empresas: Object,
    permisos: Object,
    roles: Object
})

let form = useForm({
    correo: null,
    nombre: null,
    empresa:null,
    cargo: null,
    password: null,
    confirmar_password: null,
    avatar: null,
    permisos: [],
    rol: null
});

let selectedRole = ref(null);
let selectedEmpresa= ref(null);
const upload = ref();
const dialogImageUrl = ref('')
const dialogVisible = ref(false)
let prevImageHeight = ref(0);
let permAll = ref(false);

onMounted(()=>{
    toggleNavbar()
})

const options = {
    preserveScroll: true,
    onError: async errors => {
        await Swal.fire({
            icon: 'error',
            title: 'Validación',
            text: errors.validacion
        })
        await router.get('/usuario/registrar')
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
    if(form.avatar !== null){
        const base64 = await fetch(form.avatar);
        form.avatar = await base64.blob();
    }
    await form.post(`/usuario/registrar`, options)
}

const handleChange = async (uploadFile) => {
    await axios({
        url: uploadFile.url,
        method: "GET",
        responseType: "blob", // importante
        onDownloadProgress: (progressEvent) => {
            var percentCompleted = Math.round((progressEvent.loaded * 100) /  progressEvent.total);
            console.log(percentCompleted)
        },
    }).then((response) => {
        const blob = new Blob([response.data])
        const reader = new FileReader();
        reader.onload = (event) => {
            form.avatar = event.target.result;
        }
        reader.readAsDataURL(blob);
        prevImageHeight.value = 310;
        toggleFullScreen();
    });
}

const handlePictureCardPreview = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url;
    dialogVisible.value = true;
}

const handleExceed = (files) => {
    upload.value.clearFiles()
    const file = files[0];
    file.uid = genFileId()
    upload.value.handleStart(file)
}

const handleRemove = () => {
    prevImageHeight.value = 210;
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

const setRole = (role) => {
    form.rol = page.props.roles.filter(rol => rol.id === role)[0];
}

const setEmpresa = (id) => {
    form.empresa = id;
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
                                    <li class="breadcrumb-item fw-bold"><Link href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                    <li class="breadcrumb-item active fw-bold"><Link href="/usuarios"> <i class="fa fa-users"></i> Usuarios </Link></li>
                                    <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-plus"></i>Registrar Usuario</li>
                                </ol>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="row align-items-center justify-content-center mb-4">
                                        <div class="form-floating" :class="form.avatar === null ? 'col-md-12' : 'col-md-8'">
                                            <el-upload
                                                ref="upload"
                                                class="upload-demo"
                                                drag
                                                :limit="1"
                                                :auto-upload="false"
                                                list-type="picture"
                                                :on-change="handleChange"
                                                :on-preview="handlePictureCardPreview"
                                                :on-exceed="handleExceed"
                                                :on-remove="handleRemove"
                                            >
                                                <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                                                <div class="el-upload__text">
                                                    Arrastre una imágen de perfil aquí <em>o haga click para subir</em>
                                                </div>
                                                <template #tip>
                                                    <div class="el-upload__tip">
                                                        jpg/png ficheros con un tamaño máximo de 5 Mb
                                                    </div>
                                                </template>
                                            </el-upload>
                                            <el-dialog v-model="dialogVisible">
                                                <p class="text-center fw-bold"><i class="fa fa-eye"></i> Vista Previa</p><img class="w-100" :src="dialogImageUrl" alt="Preview Image" />
                                            </el-dialog>
                                        </div>
                                        <div v-if="form.avatar !== null" class="form-floating col-md-4 mb-4">
                                            <img class="w-100 rounded border mt-3 border-2 border-primary" :style="`height: ${prevImageHeight}px`" :src="form.avatar" alt="">
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.correo" type="email" size="large" class="extra-large" id="floatingInput1" placeholder="Correo Electrónico"/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.nombre" type="text" size="large" class="extra-large" id="floatingInput2" placeholder="Nombre y Apellidos"/>
                                        </div>
                                        <div class="form-floating col-md-4 mb-4">
                                            <el-select
                                                v-model="selectedEmpresa"
                                                size="large" class="extra-large"
                                                id="floatingInput3"
                                                placeholder="Seleccionar Empresa"
                                                @change="setEmpresa(selectedEmpresa)"
                                            >
                                                <el-option v-for="empresa in empresas" :key="empresa.id" :label="empresa.nombre" :value="empresa.id"/>
                                            </el-select>
                                        </div>
                                        <div class="form-floating col-md-4 mb-4">
                                            <el-input v-model="form.cargo" type="text" size="large" class="extra-large" id="floatingInput4" placeholder="Cargo Empresa"/>
                                        </div>
                                        <div class="form-floating col-md-4 mb-4">
                                            <el-select
                                                v-model="selectedRole"
                                                size="large"
                                                class="extra-large"
                                                id="floatingInput4"
                                                placeholder="Seleccionar Rol de Usuario"
                                                @change="setRole(selectedRole)"
                                            >
                                                <el-option v-for="rol in roles" :key="rol.id" :label="rol.name" :value="rol.id"/>
                                            </el-select>
                                        </div>
                                        <div class="col-md-12 mb-4 row justify-content-start align-items-start">
                                            <h4 class="text-center"><i class="fa fa-user-secret"></i> Rol {{form.rol !== null ? form.rol.name : 'de Usuario'}} <br><Link v-if="form.rol !== null" class="btn btn-success" :href="`/roles/${form.rol.id}/edit`"><i class="fa fa-edit"></i> Editar Permisos</Link></h4>
                                            <div v-for="permiso in permisos" class="col-md-3 form-check">
                                                <input disabled :checked="form.rol !== null ? form.rol.permissions.filter(perm => perm.id === permiso.id).length > 0: false" type="checkbox" class="form-check-input" :id="`permiso${permiso.id}`">
                                                <label class="form-check-label" :for="`permiso${permiso.id}`">{{permiso.name}}</label>
                                            </div>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.password" type="password" size="large" class="extra-large" id="floatingInput5" placeholder="Contraseña" show-password/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.confirmar_password" type="password" size="large" class="extra-large" id="floatingInput6" placeholder="Confirmar Contraseña" show-password/>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button :disabled="form.processing" type="submit" class="btn btn-primary btn-lg shadow-3-strong text-capitalize"><i class="fa fa-save"></i> Guardar</button>
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
