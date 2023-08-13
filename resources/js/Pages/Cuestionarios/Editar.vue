<script setup>
import {onMounted, ref} from "vue";
import {router, Link, usePage, useForm} from "@inertiajs/vue3";
import {toggleNavbar} from '@/Helpers';
import Navbar from "@/Layouts/Navbar.vue";
import Sidenav from "@/Layouts/Sidenav.vue";
import { ElNotification } from 'element-plus'

const page = usePage();

defineProps({
    cuestionario: Object,
    empresas: Object
})

let form = useForm(page.props.cuestionario.data);

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

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
    $('#cuestionarioTable').DataTable(dtConfig);
})


const save = async() => {
    axios.patch(`/cuestionarios/${page.props.cuestionario.id}`, form)
        .then(function (response) {
            ElNotification({
                dangerouslyUseHTMLString: true,
                title: 'Autoguardado',
                message: `<span class="text-success">${response.data.message}</span>`,
                offset: 0,
                position: 'top-right',
                duration: 1000,
                icon: 'Edit',
                customClass: 'text-success'
            })
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error
            })
        });
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
                    <h1 class="mt-4"><i class="fa fa-user-doctor"></i>Revisión de  Cuestionario</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</Link></li>
                                <li class="breadcrumb-item fw-bold"><Link class="text-decoration-none" href="/cuestionarios"><i class="fa fa-clipboard-check"></i> Cuestionarios</Link></li>
                                <li class="breadcrumb-item active fw-bold"><i class="fa fa-user-doctor"></i>Revisión de  Cuestionario - Paciente: {{ cuestionario.data.datos_generales.nombre }}</li>
                            </ol>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table w-100" id="cuestionarioTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>No</th>
                                        <th class="w-25">Propiedades</th>
                                        <td class="fw-bold">Datos</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-primary">
                                        <th>1</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Datos Generales</td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <th>1</th>
                                        <th class="w-25">Nombre</th>
                                        <td><el-input prefix-icon="avatar" size="large" @change="save" v-model="form.datos_generales.nombre" /></td>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <th>2</th>
                                        <th>Fecha Nacimiento</th>
                                        <td><el-date-picker @change="save" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" type="date" class="w-100" v-model="form.datos_generales.nacimiento" /></td>
                                    </tr>
                                    <tr>
                                        <th>4</th>
                                        <th>3</th>
                                        <th>Edad</th>
                                        <td><el-input prefix-icon="TrendCharts" @change="save" size="large" v-model="form.datos_generales.edad" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>5</th>
                                        <th>4</th>
                                        <th>Sexo</th>
                                        <td>
                                            <el-select :suffix-icon="form.datos_generales.sexo === 'Masculino' ? 'Male' : 'Female'" @change="save" v-model="form.datos_generales.sexo" class="w-100" size="large">
                                                <el-option value="Masculino">Masculino</el-option>
                                                <el-option value="Femenino">Femenino</el-option>
                                            </el-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>6</th>
                                        <th>5</th>
                                        <th>Ciudad de Origen</th>
                                        <td><el-input prefix-icon="School" @change="save" size="large" v-model="form.datos_generales.ciudad_origen" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>7</th>
                                        <th>6</th>
                                        <th>Empresa</th>
                                        <td>
                                            <el-select suffix-icon="OfficeBuilding" @change="save" v-model="form.datos_generales.empresa" class="w-100" size="large">
                                                <el-option v-for="empresa in empresas" :value="empresa.nombre">{{empresa.nombre}}</el-option>
                                            </el-select>
                                        </td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>8</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Información de Contacto</td>
                                    </tr>
                                    <tr>
                                        <th>9</th>
                                        <th>7</th>
                                        <th>Teléfono</th>
                                        <td><el-input prefix-icon="phone" @change="save" size="large" v-model="form.info_contacto.telefono" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>10</th>
                                        <th>8</th>
                                        <th>Correo</th>
                                        <td><el-input prefix-icon="message" @change="save" size="large" v-model="form.info_contacto.correo" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>11</th>
                                        <th>9</th>
                                        <th>Dirección</th>
                                        <td><el-input prefix-icon="Location"  @change="save" size="large" v-model="form.info_contacto.direccion" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>12</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Signos Vitales</td>
                                    </tr>
                                    <tr>
                                        <th>13</th>
                                        <th>10</th>
                                        <th>Peso</th>
                                        <td><el-input prefix-icon="Dish" @change="save" size="large" v-model="form.signos_vitales.peso" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>14</th>
                                        <th>11</th>
                                        <th>Estatura</th>
                                        <td><el-input @change="save" size="large" v-model="form.signos_vitales.estatura" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>15</th>
                                        <th>12</th>
                                        <th>Presión Sistólica</th>
                                        <td><el-input @change="save" size="large" v-model="form.signos_vitales.p_sistolica" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>16</th>
                                        <th>13</th>
                                        <th>Presión Diastólica</th>
                                        <td><el-input @change="save" size="large" v-model="form.signos_vitales.p_diastolica" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>17</th>
                                        <th>14</th>
                                        <th>Pulso</th>
                                        <td><el-input @change="save" size="large" v-model="form.signos_vitales.pulso" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>18</th>
                                        <th>15</th>
                                        <th>Temperatura</th>
                                        <td><el-input @change="save" size="large" v-model="form.signos_vitales.temperatura" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>19</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Medidas</td>
                                    </tr>
                                    <tr>
                                        <th>20</th>
                                        <th>16</th>
                                        <th>Cuello</th>
                                        <td><el-input @change="save" size="large" v-model="form.medidas.cuello" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>21</th>
                                        <th>17</th>
                                        <th>Pecho</th>
                                        <td><el-input @change="save" size="large" v-model="form.medidas.pecho" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>22</th>
                                        <th>18</th>
                                        <th>Cintura</th>
                                        <td><el-input @change="save" size="large" v-model="form.medidas.cintura" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>23</th>
                                        <th>19</th>
                                        <th>Caderas</th>
                                        <td><el-input @change="save" size="large" v-model="form.medidas.caderas" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>24</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Estado Civil</td>
                                    </tr>
                                    <tr>
                                        <th>25</th>
                                        <th>20</th>
                                        <th>Estado Civil</th>
                                        <td><el-input @change="save" size="large" v-model="form.estado_civil.estado" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>26</th>
                                        <th>21</th>
                                        <th>Desde Cuando</th>
                                        <td><el-date-picker @change="save" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" type="date" class="w-100" v-model="form.estado_civil.desde_cuando" /></td>
                                    </tr>
                                    <tr>
                                        <th>27</th>
                                        <th>22</th>
                                        <th>Hijos</th>
                                        <td><el-input @change="save" size="large" v-model="form.estado_civil.hijos" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>28</th>
                                        <th>23</th>
                                        <th>Edades Hijos</th>
                                        <td><el-input @change="save" :disabled="form.estado_civil.hijos === 'Sin hijos'" size="large" v-model="form.estado_civil.edades_hijos" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>29</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Escolaridad</td>
                                    </tr>
                                    <tr>
                                        <th>30</th>
                                        <th>24</th>
                                        <th>Grado de Estudios</th>
                                        <td><el-input @change="save" size="large" v-model="form.escolaridad.grado_estudios" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>31</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Oficio y Profesión</td>
                                    </tr>
                                    <tr>
                                        <th>32</th>
                                        <th>25</th>
                                        <th>Oficio</th>
                                        <td><el-input @change="save" size="large" v-model="form.oficio_profesion.oficio" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>32</th>
                                        <th>25</th>
                                        <th>Profesión</th>
                                        <td><el-input @change="save" size="large" v-model="form.oficio_profesion.profesion" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>33</th>
                                        <th>26</th>
                                        <th>Último Trabajo</th>
                                        <td><el-input @change="save" size="large" v-model="form.oficio_profesion.ultimo_trabajo" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>34</th>
                                        <th>27</th>
                                        <th>Hasta Cuando</th>
                                        <td><el-date-picker @change="save" format="DD/MM/YYYY" value-format="DD/MM/YYYY" size="large" type="date" class="w-100" v-model="form.oficio_profesion.hasta_cuando" /></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>35</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Toxicomanías</td>
                                    </tr>
                                    <tr>
                                        <th>36</th>
                                        <th>28</th>
                                        <th>Fuma</th>
                                        <td><el-input @change="save" size="large" v-model="form.toxicomanias.fuma" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>37</th>
                                        <th>29</th>
                                        <th>Cuantos Cigarrillos</th>
                                        <td><el-input @change="save" size="large" v-model="form.toxicomanias.cuantos_cigarillos" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>38</th>
                                        <th>30</th>
                                        <th>Bebe</th>
                                        <td><el-input @change="save" size="large" v-model="form.toxicomanias.bebe" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>39</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Vivienda</td>
                                    </tr>
                                    <tr>
                                        <th>40</th>
                                        <th>31</th>
                                        <th>Personas con las q vive</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.personas_vivienda" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>41</th>
                                        <th>32</th>
                                        <th>Cantidad de personas</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.cantidad_personas" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>42</th>
                                        <th>33</th>
                                        <th>Estado de la vivienda</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.estado_vivienda" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>43</th>
                                        <th>34</th>
                                        <th>Propietario de la vivienda</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.propietario_vivienda" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>44</th>
                                        <th>35</th>
                                        <th>Recámaras</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.recamaras" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>45</th>
                                        <th>36</th>
                                        <th>Baños</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.banos" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>46</th>
                                        <th>37</th>
                                        <th>Cuartos</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.cuartos" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>47</th>
                                        <th>38</th>
                                        <th>Material de construcción vivienda</th>
                                        <td><el-input @change="save" size="large" v-model="form.vivienda.material_vivienda" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>48</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Estado Salud</td>
                                    </tr>
                                    <tr>
                                        <th>49</th>
                                        <th>39</th>
                                        <th>Vacuna influenza</th>
                                        <td><el-input @change="save" size="large" v-model="form.estado_salud.vacuna_influenza" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>50</th>
                                        <th>40</th>
                                        <th>Vacuna covid</th>
                                        <td><el-input @change="save" size="large" v-model="form.estado_salud.vacuna_covid" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>51</th>
                                        <th>41</th>
                                        <th>Dias de ejercicio en la semana</th>
                                        <td><el-input @change="save" size="large" v-model="form.estado_salud.ejercicio_semana" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>52</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Hábitos de Sueño</td>
                                    </tr>
                                    <tr>
                                        <th>53</th>
                                        <th>42</th>
                                        <th>Ronca</th>
                                        <td><el-input @change="save" size="large" v-model="form.habitos_sueno.ronca" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>54</th>
                                        <th>43</th>
                                        <th>Deja de respirar mientras duerme</th>
                                        <td><el-input @change="save" size="large" v-model="form.habitos_sueno.deja_respirar" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>55</th>
                                        <th>44</th>
                                        <th>Se siente adormilado</th>
                                        <td><el-input @change="save" size="large" v-model="form.habitos_sueno.adormilado" type="text"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>56</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Señas Particulares</td>
                                    </tr>
                                    <tr>
                                        <th>57</th>
                                        <th>45</th>
                                        <th>Tono de piel</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.tono_piel" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>58</th>
                                        <th>46</th>
                                        <th>Color del cabello</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.color_cabello" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>59</th>
                                        <th>47</th>
                                        <th>Pelo teñido</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.pelo_tenido" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>60</th>
                                        <th>48</th>
                                        <th>Tipo de cabello</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.tipo_cabello" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>61</th>
                                        <th>49</th>
                                        <th>Longitud cabello</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.longitud_cabello" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>62</th>
                                        <th>50</th>
                                        <th>Complexión física</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.complexion_fisica" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>63</th>
                                        <th>51</th>
                                        <th>Forma de la nariz</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.forma_nariz" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>64</th>
                                        <th>52</th>
                                        <th>Color de los ojos</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.color_ojos" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>65</th>
                                        <th>53</th>
                                        <th>Lunares</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.lunar" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>66</th>
                                        <th>54</th>
                                        <th>Descripción de los Lunares</th>
                                        <td><el-input @change="save" :disabled="form.senas_particulares.lunar === 'Sin lunares visibles'" size="large" v-model="form.senas_particulares.lunar_descripcion" type="textarea" :rows="3"/></td>
                                    </tr>
                                    <tr>
                                        <th>67</th>
                                        <th>55</th>
                                        <th>Tatuajes</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.tatuaje" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>68</th>
                                        <th>56</th>
                                        <th>Descripción de los Tatuajes</th>
                                        <td><el-input @change="save" :disabled="form.senas_particulares.tatuaje === 'Sin tatuajes'" size="large" v-model="form.senas_particulares.tatuaje_descripcion" type="textarea" :rows="3"/></td>
                                    </tr>
                                    <tr>
                                        <th>69</th>
                                        <th>57</th>
                                        <th>Cicatrices</th>
                                        <td><el-input @change="save" size="large" v-model="form.senas_particulares.cicatriz" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>70</th>
                                        <th>58</th>
                                        <th>Descripción de las Cicatrices</th>
                                        <td><el-input @change="save" :disabled="form.senas_particulares.cicatriz === 'Sin cicatrices'" size="large" v-model="form.senas_particulares.cicatriz_descripcion" type="textarea" :rows="3"/></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th>71</th>
                                        <th></th>
                                        <th></th>
                                        <td class="fw-bold text-white w-100">Discapacidades</td>
                                    </tr>
                                    <tr>
                                        <th>72</th>
                                        <th>59</th>
                                        <th>Discapcidad</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.discapacidad" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>73</th>
                                        <th>60</th>
                                        <th>Prótesis</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.protesis" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>74</th>
                                        <th>61</th>
                                        <th>Función de la Prótesis</th>
                                        <td><el-input @change="save" :disabled="form.discapacidades.protesis === 'No'" size="large" v-model="form.discapacidades.funcion_protesis" type="textarea" :rows="3"/></td>
                                    </tr>
                                    <tr>
                                        <th>75</th>
                                        <th>62</th>
                                        <th>Claudica</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.claudica" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>76</th>
                                        <th>63</th>
                                        <th>Discapacidades Visuales</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.discapacidad_visual" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>77</th>
                                        <th>64</th>
                                        <th>Lentes</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.lentes_pupilentes" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>78</th>
                                        <th>65</th>
                                        <th>Piezas dentales faltantes</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.falta_pieza_dental" type="text"/></td>
                                    </tr>
                                    <tr>
                                        <th>79</th>
                                        <th>66</th>
                                        <th>Empastes</th>
                                        <td><el-input @change="save" size="large" v-model="form.discapacidades.empastes" type="text"/></td>
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
