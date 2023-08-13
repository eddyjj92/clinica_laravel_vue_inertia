<script setup>
import {onMounted, ref} from "vue";
import {router, Link, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { genFileId } from 'element-plus'

defineProps({
    empresas: Object
})

let form = useForm({
    correo: null,
    nombre: null,
    empresa:null,
    cargo: null,
    password: null,
    confirmar_password: null,
    avatar: null
});
const upload = ref();
const dialogImageUrl = ref('')
const dialogVisible = ref(false)

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
    },
    onSuccess: async page2 =>{
        await Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: page2.props.flash.message
        });
    }
}

const submit = () =>{
    form.post(`/usuario/registrar`, options)
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
        form.avatar = new Blob([response.data])
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
                                    <div class="row align-items-center justify-content-center">
                                        <div class="form-floating col-md-12 mb-4">
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
                                                <img class="w-100" :src="dialogImageUrl" alt="Preview Image" />
                                            </el-dialog>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.correo" type="email" size="large" class="extra-large" id="floatingInput1" placeholder="Correo Electrónico"/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.nombre" type="text" size="large" class="extra-large" id="floatingInput2" placeholder="Nombre y Apellidos"/>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-select v-model="form.empresa" size="large" class="extra-large" id="floatingInput3" placeholder="Seleccionar Empresa">
                                                <el-option v-for="empresa in empresas" :value="empresa.nombre">{{empresa.nombre}}</el-option>
                                            </el-select>
                                        </div>
                                        <div class="form-floating col-md-6 mb-4">
                                            <el-input v-model="form.cargo" type="text" size="large" class="extra-large" id="floatingInput4" placeholder="Cargo Empresa"/>
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
