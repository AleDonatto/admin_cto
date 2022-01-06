<template>
    <app-layout title="Categorias">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorias
            </h2>
        </template>

        <div v-if="!showModal" class="pt-12 mt-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div class="w-full bg-white rounded-lg lg:rounded-l-none">
                        <form @submit.prevent="addProductos" method="post" enctype="multipart/form-data" class="px-8 pt-6 pb-8 mb-4 bg-white rounded" >
                            <div class="mb-4 md:flex p-5">
								<div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="categoria">Categoria</label>
									<input v-model="form.categoria" id="categoria" type="text" placeholder="Categoria" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':form.categoria.length === 150 }">{{ form.categoria.length }} /150</span>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="imagen">Seleccione Imagen</label>
									<input id="imagen" type="file" placeholder="imagen" ref="fileInput" @change="getImage" accept="image/jpeg" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
                                    <div v-if="imageMuestra === ''"></div>
                                    <div v-else-if="imageMuestra != ''">
                                        <figure class="figure">
                                            <img :src="imageMuestra" alt="imagen de muestra" class="figure-img img-fluid rounded">
                                            <figcaption class="figure-caption">Dimenciones de imagen recomendada (300X300)</figcaption>
                                        </figure>
                                    </div>
                                </div>
                                <div class="md:ml-2 mt-6">
									<button class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                    type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Crear Categoria
                                    </button>
								</div>
							</div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div v-else class="pt-12 mt-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div class="w-full bg-white rounded-lg lg:rounded-l-none">
                        <form @submit.prevent="updateCategorias" method="post" enctype="multipart/form-data" class="px-8 pt-6 pb-8 mb-4 bg-white rounded" >
                            <div class="mb-4 md:flex p-5">
								<div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="categoria">Categoria</label>
									<input v-model="formEdit.categoria" id="categoria" type="text" placeholder="Categoria" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':formEdit.categoria.length === 150 }">{{ formEdit.categoria.length }} /150</span>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">    
                                    <label for="" class="block mb-2 text-sm font-bold text-gray-700">Mostrar en WEB</label>
                                    <div class="outline-none relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" v-model="formEdit.mostrar" name="toggle" id="toggle" class="outline-none toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                    <label for="toggle" class="text-xs text-gray-700">{{formEdit.mostrar ? 'Visible' : 'Oculto' }}</label>
                                </div>
                                <div class="mb-4 md:flex">
                                    <div class="mb-4 ml-4 md:mr-2 md:mb-0">
                                        <label class="block mb-2 text-sm font-bold text-gray-700" for="imagen">Seleccione Imagen</label>
                                        <input id="imagen" type="file" placeholder="imagen" ref="fileInputEdit" @change="getImageEdit" accept="image/jpeg" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    </div>
                                    <div class="mb-4 ml-4 md:mr-2 md:mb-0">
                                        <div v-if="imageMuestraEdit === ''"></div>
                                        <div v-else-if="imageMuestraEdit != ''">
                                            <figure class="figure">
                                                <img :src="imageMuestraEdit" alt="imagen de muestra" class="figure-img img-fluid rounded">
                                                <figcaption class="figure-caption">Dimenciones de imagen recomendada (300X300)</figcaption>
                                                <figcaption class="figure-caption">Al seleccionar una nueva imagen se eliminara la anterior</figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:ml-2 mt-6">
                                    <div class="flex flex-nowrap space-x-4">
                                        <div>
                                            <button class="w-full px-4 py-2 font-bold text-white bg-red-500 rounded-full hover:bg-red-700 focus:outline-none focus:shadow-outline"
                                            type="reset" @click="closeModal" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Cancel
                                            </button>
                                        </div>
                                        <div>
                                            <button class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                            type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
								</div>
							</div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="">
            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4 bg-white shadow-xl sm:rounded-lg">
                    
                    <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                        
                        <div class="overflow-x-auto">
                            
                            <table id="categorias" style="width:100%" class="overflow-x-auto table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">ID</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Categoria</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Mostrar en Web</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Image</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Opciones</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100">
                                    <tr v-for="(item, index) in listCategoria" :key="index">
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.idCategoria }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.nameCategoria }}
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">
                                                <p class="inline-block rounded-full text-white bg-indigo-500 px-2 py-1 text-xs font-bold mr-3" :class="{'inline-block rounded-full text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3' : !item.mostrar }">
                                                    {{ item.mostrar ? 'Visible' : 'Oculto' }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3">
                                                        <!--<img class="rounded-full" src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg" width="40" height="40" alt="Alex Shatov">-->
                                                        <img v-if="item.image !== ''" class="rounded-full" width="40" height="40" :src="/storage/ + item.image" alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <button @click="openModal(item, index)" class="rounded-lg px-4 mr-2 bg-blue-500 hover:bg-blue-700 text-white focus:outline-none focus:shadow-outline" type="button">
                                                    Edit
                                                </button>

                                                <button @click="deleteCategoria(item.idCategoria)" class="rounded-lg px-4 mr-2 bg-red-500 hover:bg-red-700 text-white focus:outline-none focus:shadow-outline" type="button">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import axios from 'axios'
    import Swal from 'sweetalert2'

    export default defineComponent({
        props:{
            list_Cat: {}
        },
        data(){
            return {
                form: this.$inertia.form({
                    categoria: "",
                    image: null
                }),
                formEdit: this.$inertia.form({
                    idcategoria: 0,
                    categoria: "",
                    mostrar: true,
                    image: null,
                    oldImage: ''
                }),
                listCategoria: [],
                imageMuestra: '',
                imageMuestraEdit: '',
                showModal: false,
            }
        },
        mounted() {
            this.listCategoria = this.list_Cat 

            this.dataTable()
        },
        components: {
            AppLayout,
        },
        methods: {
            addProductos(){
                const input = this.$refs.fileInput
                const formData = new FormData();
                formData.append('categoria', this.form.categoria)
                formData.append('image', this.form.image)

                axios.post('/storeCategorias', formData)
                .then( res => {
                    const msj = res.data

                    this.form.reset('categoria')
                    this.form.reset('image')
                    this.imageMuestra = ''
                    this.listCategoria = msj.listcategoria
                    
                    input.type = 'text'
                    input.type = 'file'

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: msj.message,
                        showConfirmButton: false,
                        timer: 1000
                    })
                })
                .catch( err => {
                    const msj = err.response.data

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: msj.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                })
            },
            getImage(e){
                const img = e.target.files[0]
                this.form.image = img
                let reader  = new FileReader();

                reader.addEventListener("load", function () {
                    this.imageMuestra = reader.result;
                }.bind(this), false);

                if( this.form.image ){
                    if ( /\.(jpe?g|png)$/i.test( this.form.image.name ) ) {
                        reader.readAsDataURL( this.form.image );
                    }
                }
            },
            openModal(item){
                this.showModal = true

                this.formEdit.categoria = item.nameCategoria
                this.formEdit.idcategoria = item.idCategoria
                this.formEdit.oldImage = item.image
                item.mostrar ?  this.formEdit.mostrar = true : this.formEdit.mostrar = false 
            },
            closeModal(){
                
                this.formEdit.categoria = ''
                this.formEdit.mostrar = true 
                this.imageMuestraEdit = ''
                this.formEdit.image = null
                this.formEdit.oldImage = ''
                this.formEdit.idcategoria = 0
                const input = this.$refs.fileInputEdit
                
                input.type = 'text'
                input.type = 'file'
                
                this.showModal = false
            },
            getImageEdit(e){
                const img = e.target.files[0]
                this.formEdit.image = img

                const reader = new FileReader()

                reader.addEventListener('load', function(){
                    this.imageMuestraEdit = reader.result
                }.bind(this), false)

                if(this.formEdit.image){
                    if(/\.(jpe?g|png)$/i.test( this.formEdit.image.name )){
                        reader.readAsDataURL( this.formEdit.image )
                    }
                }
            },
            updateCategorias(){
                const formDataEdit = new FormData();
                formDataEdit.append('idcategoria', this.formEdit.idcategoria)
                formDataEdit.append('categoriaEdit', this.formEdit.categoria)
                formDataEdit.append('imageEdit', this.formEdit.image)
                formDataEdit.append('oldImage', this.formEdit.oldImage)
                formDataEdit.append('mostrar', this.formEdit.mostrar ? this.formEdit.mostrar = 1 : this.formEdit.mostrar = 0)

                axios.post('/updateCategorias', formDataEdit)
                .then( res => {
                    const msj = res.data
                    
                    this.closeModal()
                    this.listCategoria = msj.listcategoria

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: msj.message,
                        showConfirmButton: false,
                        timer: 1000
                    })
                })
                .catch(err => {
                    const msj = err.response.data
                    
                    //this.closeModal()

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: msj.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                })
            },
            deleteCategoria(categoria){
                Swal.fire({
                    title: 'Seguro que desea eliminar permanentemente?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        axios.delete('/deleteCategorias/'+categoria)
                        .then(res => {
                            const msj = res.data

                            if(msj.status === 'error'){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: msj.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }else{
                                this.listCategoria = msj.listcategorias

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: msj.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }

                        })
                        .catch(err => {
                            const msj = err.response.data
                            
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: msj.message,
                                showConfirmButton: false,
                                timer: 10000
                            })
                        })

                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            },
            dataTable(){
                $(document).ready(function() {
                    $('#categorias').DataTable( {
                        "scrollX": true
                    } );
                } );
            }
        },
    })
</script>

<style scoped>
.figure > img{
    width: 320px;
    height: 320px;
}
.modal {
    transition: opacity 0.25s ease;
}
body.modal-active {
    overflow-x: hidden;
    overflow-y: visible !important;
}
.toggle-checkbox:checked {
  @apply: right-0 border-green-400;
  right: 0;
  border-color: #68D391;
}
.toggle-checkbox:checked + .toggle-label {
  @apply: bg-green-400;
  background-color: #68D391;
}
</style>