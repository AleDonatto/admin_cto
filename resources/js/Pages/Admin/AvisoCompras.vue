<template>
    <div class="" v-if="solicitudesPedido.lenght == 0"></div>
    <div v-else>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <h1 class="mt-8 text-2xl">Hay algunas solicitudes de pedidos de algunos clientes</h1>

                    <table class="table-auto mt-2 text-gray-500 w-full">
                        <thead>
                            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Telefono</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr v-for="(item, index) in solicitudesPedido" :key="index">
                                <td class="px-4 py-3 border">{{ item.NombreCliente }}</td>
                                <td class="px-4 py-3 border">{{ item.Telefono }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-5">
                        <p class="flex">
                            Revisa la seccion de Pedidos para mas informacion 
                            <a :href="route('pedidos')" class="text-blue-600 flex ml-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Ir a Pedidos 
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "@vue/runtime-core";
import axios from 'axios'

export default defineComponent({
    data(){
        return {
            solicitudesPedido: []
        }
    },
    mounted() {
        this.consultaSolicitudesCompra()
    },
    methods: {
        async consultaSolicitudesCompra(){
            
            await axios.get('/consulSolicitudesCompra')
            .then( res => {
                const {solicitudesPedido} = res.data

                this.solicitudesPedido = solicitudesPedido
            })
        }
    }
})
</script>

<style scoped>

</style>