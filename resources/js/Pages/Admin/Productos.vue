<template>
    <app-layout title="Productos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="pt-12 mt-2">
            <div class="conatiner mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div v-if="!editProducto" class="w-full bg-white rounded-lg lg:rounded-l-none">
                        <form @submit.prevent="addProductos" method="post" class="px-8 pt-6 pb-8 mb-4 bg-white rounded" >
                            <div class="mb-4 md:flex p-5">
								<div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="producto">Producto</label>
									<input v-model="form.producto" id="producto" type="text" placeholder="Producto" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':form.producto.length === 150 }">{{ form.producto.length }} /150</span>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="descripcion">Descripcion</label>
									<input v-model="form.descripcion" id="descripcion" type="text" placeholder="Descripcion" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':form.descripcion.length === 150 }">{{ form.descripcion.length }} /150</span>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="precio">Precio</label>
									<input v-model="form.precio" id="precio" type="text" placeholder="Precio" maxlength="100" minlength="1" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                </div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="codigo">Codigo</label>
									<input v-model="form.codigo" id="codigo" type="text" placeholder="Codigo" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':form.codigo.length === 150 }">{{ form.codigo.length }} /150</span>
								</div>
                                <div class="ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="categoria">Categoria</label>
                                    <select class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="categoria" id="categoria" v-model="form.categoria">
                                        <option value="" selected>Seleccione</option>
                                        <option :value="item.idCategoria" v-for="(item, index) in list_Cat" :key="index">{{ item.nameCategoria }}</option>
                                    </select>
								</div>
                                <div class="mb-4 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="imagen">Seleccione Imagen</label>
									<input id="imagen" type="file" placeholder="imagen" ref="fileInputProducto" @change="getImage" accept="image/jpeg" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
								</div>
							</div>
                            <div class="md:flex px-5">
                                <div class="ml-4 md:mr-2 md:mb-0">
									<div v-if="imageMuestra === ''"></div>
                                    <div v-else-if="imageMuestra != ''">
                                        <figure class="figure">
                                            <img :src="imageMuestra" alt="imagen de muestra" class="figure-img img-fluid rounded">
                                            <figcaption class="figure-caption">Dimenciones de imagen recomendada (300X300)</figcaption>
                                        </figure>
                                    </div>
								</div>
                                <div class="ml-8">
									<button class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                    type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Guardar Producto
                                    </button>
								</div>
                            </div>
                        </form>
                    </div>

                    <div v-else class="w-full bg-white rounded-lg lg:rounded-l-none">
                        <form @submit.prevent="updateProductos" method="post" class="px-8 pt-6 pb-8 mb-4 bg-white rounded" >
                            <div class="md:flex p-5">
								<div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="productoEdit">Producto</label>
									<input v-model="formEdit.producto" id="productoEdit" type="text" placeholder="Producto" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':formEdit.producto.length === 150 }">{{ formEdit.producto.length }} /150</span>
								</div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="descripcionEdit">Descripcion</label>
									<input v-model="formEdit.descripcion" id="descripcionEdit" type="text" placeholder="Descripcion" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':formEdit.descripcion.length === 150 }">{{ formEdit.descripcion.length }} /150</span>
								</div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="precioEdit">Precio</label>
									<input v-model="formEdit.precio" id="precioEdit" type="text" placeholder="Precio" maxlength="100" minlength="1" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                </div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="codigoEdit">Codigo</label>
									<input v-model="formEdit.codigo" id="codigoEdit" type="text" placeholder="Codigo" maxlength="150" minlength="2" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
                                    <span class="text-sm font-serif text-gray-600" :class="{ 'text-red-600':formEdit.codigo.length === 150 }">{{ formEdit.codigo.length }} /150</span>
								</div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="categoriaEdit">Categoria</label>
                                    <select  v-model="formEdit.categoria" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="categoriaEdit" id="categoriaEdit">
                                        <option value="" selected>Seleccione</option>
                                        <option :value="item.idCategoria" v-for="(item, index) in list_Cat" :key="index">{{ item.nameCategoria }}</option>
                                    </select>
								</div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
                                    <label for="" class="block mb-2 text-sm font-bold text-gray-700">Mostrar en WEB</label>
                                    <div class="outline-none relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" v-model="formEdit.mostrar" name="toggle" id="toggle" class="outline-none toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                    <label for="toggle" class="text-xs text-gray-700">{{formEdit.mostrar ? 'Visible' : 'Oculto' }}</label>
                                </div>
							</div>
                            <div class="md:flex px-5 py-2">
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="imagenEdit">Seleccione Imagen</label>
									<input id="imagenEdit" type="file" placeholder="imagen" ref="fileInputProductoEdit" @change="getImageEdit" accept="image/jpeg" class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"/>
								</div>
                                <div class="mb-2 ml-4 md:mr-2 md:mb-0">
									<div v-if="imageMuestraEdit === ''"></div>
                                    <div v-else-if="imageMuestraEdit != ''">
                                        <figure class="figure">
                                            <img :src="imageMuestraEdit" alt="imagen de muestra" class="figure-img img-fluid rounded">
                                            <figcaption class="figure-caption">Dimenciones de imagen recomendada (300X300)</figcaption>
                                            <figcaption class="figure-caption">Agregar una nueva imagen eliminara la enterior</figcaption>
                                        </figure>
                                    </div>
								</div>
                            </div>
                            <div class="px-5 mt-2">
                                <div class="flex flex-nowrap space-x-4">
                                    <div>
                                        <button class="px-4 py-2 font-bold text-white bg-red-500 rounded-full hover:bg-red-700 focus:outline-none focus:shadow-outline"
                                        type="button" @click="cancelarFormEdition" :class="{ 'opacity-25': formEdit.processing }" :disabled="formEdit.processing">
                                            Cancel
                                        </button>
                                    </div>
                                    <div>
                                        <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                        type="submit" :class="{ 'opacity-25': formEdit.processing }" :disabled="formEdit.processing">
                                            Save Changes
                                        </button>
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
                <div class="mb-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                        <div class="overflow-x-auto">
                            <table id="productos" style="width:100%" class="overflow-x-auto table-auto w-full">
                                <thead class="mt-2 text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">ID</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Nombre</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Codigo</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Descripcion</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Costo</div>
                                        </th>
                                        <th class="p'2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Visible en WEB</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Categoria</div>
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
                                    <tr v-for="(item, index) in listProductos" :key="index">
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.idProducto }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.nameProducto }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.codigo }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.descripcion }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.precio }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <p class="inline-block rounded-full text-white bg-indigo-500 px-2 py-1 text-xs font-bold mr-3" :class="{'inline-block rounded-full text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3' : !item.mostrar }">
                                                    {{ item.mostrar ? 'Visible' : 'Oculto' }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ item.nameCategoria }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3">
                                                        <img v-if="item.image !== ''" class="rounded-full" :src="/storage/ + item.image" width="40" height="40" alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <button @click="openFormEdit(item, index)" class="rounded-lg px-4 mr-2 bg-blue-500 hover:bg-blue-700 text-white focus:outline-none focus:shadow-outline" type="button">
                                                    Edit
                                                </button>
                                                <button @click="deleteProductos(item.idProducto)" class="rounded-lg px-4 mr-2 bg-red-500 hover:bg-red-700 text-white focus:outline-none focus:shadow-outline" type="button">
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
    import Swal from 'sweetalert2'
    import axios from 'axios'

    export default defineComponent({
        props:{
            list_Cat: {},
            list_Prod: {},
        },
        data(){
            return {
                form: this.$inertia.form({
                    producto: "",
                    codigo: "",
                    descripcion: "",
                    precio: 0.0,
                    categoria: "",
                    image: '',
                }),
                formEdit: this.$inertia.form({
                    idproducto: 0,
                    producto: "",
                    codigo: "",
                    descripcion: "",
                    precio: 0.0,
                    categoria: "",
                    image: '',
                    oldImage: '',
                    mostrar: true
                }),
                listProductos: [],
                listCat: [],
                imageMuestra: '',
                imageMuestraEdit: '',
                editProducto: false, 
            }
        },
        mounted() {
            this.listProductos = this.list_Prod,
            this.listCat = this.list_Cat

            this.dataTable()
        },
        updated(){
            this.dataTable()
        },
        components: {
            AppLayout,
        },
        methods: {
            addProductos(){
                const fileInput = this.$refs.fileInputProducto
                const formData = new FormData()
                formData.append('producto', this.form.producto)
                formData.append('codigo', this.form.codigo)
                formData.append('descripcion', this.form.descripcion)
                formData.append('precio', this.form.precio)
                formData.append('categoria', this.form.categoria)
                formData.append('image', this.form.image)

                axios.post('/storeProductos', formData)
                .then( res => {
                    const msj = res.data

                    this.form.reset('producto'),
                    this.form.reset('codigo'),
                    this.form.reset('descripcion'),
                    this.form.reset('precio'),
                    this.form.reset('categoria'),
                    this.form.reset('image')
                    this.imageMuestra = ''
                    this.listProductos = msj.listproductos

                    fileInput.type = 'text'
                    fileInput.type = 'file'

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
            getImageEdit(e){
                const img = e.target.files[0]
                this.formEdit.image = img
                const reader = new FileReader();

                reader.addEventListener('load', function (){
                    this.imageMuestraEdit = reader.result
                }.bind(this), false);

                if( this.formEdit.image ){
                    if ( /\.(jpe?g|png)$/i.test( this.formEdit.image.name ) ) {
                        reader.readAsDataURL( this.formEdit.image );
                    }
                }
            },
            openFormEdit(item){
                this.editProducto = true
                this.formEdit.idproducto = item.idProducto
                this.formEdit.producto = item.nameProducto
                this.formEdit.descripcion = item.descripcion 
                this.formEdit.codigo = item.codigo
                this.formEdit.precio = item.precio  
                this.formEdit.categoria = item.categoria_id
                this.formEdit.oldImage = item.image
                item.mostrar ?  this.formEdit.mostrar = true : this.formEdit.mostrar = false 
                
            },
            cancelarFormEdition(){
                this.editProducto = false
                this.formEdit.idproducto = 0
                this.formEdit.producto = ''
                this.formEdit.descripcion = '' 
                this.formEdit.codigo = ''
                this.formEdit.precio = 0  
                this.formEdit.categoria = 0
                this.formEdit.oldImage = ''
                this.formEdit.mostrar = true
                this.formEdit.image = ''

                const fileInput = this.$refs.fileInputProductoEdit
                fileInput.type = 'text'
                fileInput.type = 'file'
                this.imageMuestraEdit = ''
            },
            updateProductos(){
                const formData = new FormData()
                const show = this.formEdit.mostrar ? this.formEdit.mostrar = 1 : this.formEdit.mostrar = 0
                formData.append('idproducto', this.formEdit.idproducto)
                formData.append('productoEdit', this.formEdit.producto)
                formData.append('descripcionEdit', this.formEdit.descripcion)
                formData.append('codigoEdit', this.formEdit.codigo)
                formData.append('precioEdit', this.formEdit.precio)
                formData.append('categoriaEdit', this.formEdit.categoria)
                formData.append('oldImage', this.formEdit.oldImage)
                formData.append('mostrarEdit', show)
                formData.append('imageEdit', this.formEdit.image)

                axios.post('/updateProductos', formData)
                .then( res => {
                    const msj = res.data
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: msj.message,
                        showConfirmButton: false,
                        timer: 1000
                    })

                    this.listProductos = msj.listproductos
                    this.cancelarFormEdition()
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
            deleteProductos(producto){
                Swal.fire({
                    title: 'Seguro que desea eliminar permanentemente?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        axios.delete('/deleteProductos/'+producto)
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
                                this.listProductos = msj.listproductos

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
                    $('#productos').DataTable( {
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