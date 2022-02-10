<template>
    <app-layout title="Pedidos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedidos
            </h2>
        </template>

        <div class="pt-12 mt-2" v-if="showLista">
            <div class="conatiner mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="px-8 pt-2">
                        <h1 class="text-gray-600 text-lg font-medium">Nombre: {{ listaCliente.nombre }} - Telefono: {{ listaCliente.telefono }}</h1>
                    </div>
                    
                    <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">

                        <div>
                            <div class="">
                                <div class="flex flex-col w-full px-8 text-gray-800 bg-white pin-r pin-y">
                                    <div class="flex-1">
                                        <table class="w-full text-sm lg:text-base" cel-spacing="0">
                                            <thead>
                                                <tr class="h-12 uppercase">
                                                    <th class="md:table-cell"></th>
                                                    <th class="text-left">Producto</th>
                                                    <th class="lg:text-right text-left pl-5 lg:pl-0">
                                                        <span class="lg:hidden" title="Quantity">Cant</span>
                                                        <span class="hidden lg:inline">Cantidad</span>
                                                    </th>
                                                    <th class="text-right md:table-cell">
                                                        <span class="lg:hidden" title="Quantity">P. U.</span>
                                                        <span class="hidden lg:inline">Precio</span>
                                                    </th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(list, id) in listaCliente.lista" :key="id">
                                                    <td class="pb-4 md:table-cell">
                                                        <img :src="/storage/ + list.image" :alt="list.nombre">
                                                    </td>
                                                    <td class="mb-2 md:ml-2 text-ellipsis overflow-hidden">
                                                        <p class='mb-2 md:ml-2 text-ellipsis overflow-hidden'>{{ list.nombre }}</p>
                                                    </td>
                                                    <td class="justify-center md:justify-end md:flex mt-6">
                                                        <div class="w-20 h-10">
                                                            <div class="relative flex flex-row w-full h-8">
                                                                <p class='w-full font-semibold text-center text-gray-700 bg-gray-200 outline-none focus:outline-none hover:text-black focus:text-black'>{{list.cantidad}}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right md:table-cell">
                                                        <span class="text-sm lg:text-base font-medium m-2">
                                                            S/D
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-4">
                        <div class="flex gap-4 mt-auto">
                            <select name="esatatusCompra" id="" v-model="listaCliente.estatus" class="flex items-center gap-1 sm:text-lg border border-gray-300 px-3 py-1 rounded-full hover:bg-gray-50 transition-colors focus:bg-gray-100 focus:outline-none focus-visible:border-gray-500">
                                <option :value="0">Seleccione</option>
                                <option :value="1">Solicitado por el Cliente</option>
                                <option :value="2">Confirmar de Recibido</option>
                                <option :value="3">Entregado</option>
                                <option :value="4">Cancelar Compra</option>
                            </select>
                            <button class='ml-auto flex items-center gap-1 sm:text-lg border border-gray-300 px-3 py-1 rounded-full hover:bg-gray-50 transition-colors focus:bg-gray-100 focus:outline-none focus-visible:border-gray-500'
                            @click="changeStatusCompra(listaCliente.idCompra)">
                                <span>Guardar Cambios</span>
                            </button>
                            <button class="flex items-center gap-1 sm:text-lg border border-gray-300 px-3 py-1 rounded-full hover:bg-gray-50 transition-colors focus:bg-gray-100 focus:outline-none focus-visible:border-gray-500"
                            @click="cerrarListaCompra">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>

        <div class="pt-12 mt-2">
            <div class="conatiner mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                        <div class="overflow-x-auto">
                            <table class="overflow-x-auto table-auto w-full" id="pedidos" style="width:100%">
                                <thead class="mt-2 text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">ID</div>    
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Nombre Cliente</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Telefono Cliente</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Estatus</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Fecha del Pedido</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Lista Compras</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100">
                                    <tr v-for="(item, index) in listaCompra" :key="index">
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">{{ item.idCompra }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">{{ item.NombreCliente }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">{{ item.Telefono }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <p v-if="item.estatus == 1" class="inline-block rounded-full text-white bg-indigo-500 px-2 py-1 text-xs font-bold mr-3">
                                                    Ordenado por el Cliente
                                                </p>
                                                <p v-else-if="item.estatus == 2" class="inline-block rounded-full text-white bg-blue-400 px-2 py-1 text-xs font-bold mr-3">
                                                    Confirmado de recibido
                                                </p>
                                                <p v-else-if="item.estatus == 3" class="inline-block rounded-full text-white bg-green-400 px-2 py-1 text-xs font-bold mr-3">
                                                    Entregado al Cliente
                                                </p>
                                                <p v-else-if="item.estatus == 4" class="inline-block rounded-full text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3">
                                                    Compra Cancelada
                                                </p>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">{{ item.created_at }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <button type="button" class="rounded-lg px-4 mr-2 bg-blue-500 hover:bg-blue-700 text-white focus:outline-none focus:shadow-outline"
                                                @click="verListaCompra(item)">Ver Lista de compra</button>
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
import { defineComponent } from "@vue/runtime-core";
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'
import Swal from 'sweetalert2'

export default defineComponent({
    props: {
        listapedidos: {}
    },
    components: {
        AppLayout,
    },
    mounted() {
        this.listaCompra = this.listapedidos

        this.dataTable()
    },
    data() {
        return {
            listaCompra: [],
            listaCliente: {
                idCompra: 0,
                nombre: '',
                telefono: '',
                lista: [],    
                estatus: 0
            },
            showLista: false,
        }
    },
    methods: {
        verListaCompra(datosCliente){
            this.showLista = true
            const {NombreCliente, Telefono, idCompra, estatus} = datosCliente

            this.listaCliente.nombre = NombreCliente
            this.listaCliente.telefono = Telefono
            this.listaCliente.estatus = estatus
            this.listaCliente.idCompra = idCompra

            axios.get(`/getCompraCliente/${idCompra}`)
            .then(res => {
                const {lista_productos} = res.data

                this.listaCliente.lista = lista_productos
            })
        },
        cerrarListaCompra(){
            this.showLista = false

            this.listaCliente.nombre = ''
            this.listaCliente.telefono = ''
            this.listaCliente.lista = []
            this.listaCliente.estatus = 0
            this.listaCliente.idCompra = 0
        },
        changeStatusCompra(idCompra){

            const datos = {
                'estatus': this.listaCliente.estatus
            }

            axios.put(`/updateEstatusCompra/${idCompra}`, datos)
            .then( res => {
                const {message, updateListaPedidos} = res.data

                this.listaCompra = updateListaPedidos

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 1000
                })

                this.cerrarListaCompra()

            })
            .catch( err => {
                const msj = err.response.data

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: msj.message,
                    showConfirmButton: false,
                    timer: 1000
                })
            })
        },
        dataTable(){
            $(document).ready(function() {
                $('#pedidos').DataTable( {
                    "scrollX": true
                } );
            } );
        }
    }
})
</script>

<style scoped>
img {
    height: 3rem;
    width: 4rem;
}
</style>