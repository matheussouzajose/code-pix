<script>

import Header from "../partials/Header.vue";
import {ChevronRightIcon} from '@heroicons/vue/24/outline'
import {defineComponent} from "vue";

export default defineComponent({
    name: 'Dashboard',
    components: {ChevronRightIcon, Header},
    setup() {

    }
})

</script>

<template>
    <div class="h-screen bg-gray-100">
        <Header/>
        <div class="flex justify-center">
            <div class="grid grid-cols-3 gap-3 mt-10">
                <div class="text-xl text-gray-500 font-semibold col-span-3">Contas bancarias</div>
                <div class="flex flex-row h-20 w-72 bg-white">
                    <div class="w-1 h-full bg-blue-500"></div>
                    <div class="flex flex-col grow justify-center px-5">
                        <div class="text-xl whitespace-nowrap text-gray-500">Nome completo</div>
                        <div class="text-sm whitespace-nowrap text-blue-500">Conta</div>
                    </div>
                    <ChevronRightIcon class="h-10 w-10 self-center pr-5 text-blue-700" aria-hidden="true"/>
                </div>
            </div>
        </div>
    </div>
</template>
