<script>
import {defineComponent} from "vue";
import {BanknotesIcon} from '@heroicons/vue/24/outline'

export default defineComponent({
    name: 'Dashboard',
    components: {BanknotesIcon},
    setup() {

    }
})

</script>

<template>
    <header>
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-blue-400 ">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a class="flex items-center space-x-4">
                    <BanknotesIcon class="h-10 w-10 text-white rounded" aria-hidden="true"/>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold whitespace-nowrap dark:text-white">Cod - 001</span>
                        <span class="text-xl font-semibold whitespace-nowrap dark:text-white">Banco BBX</span>
                    </div>
                </a>
                <div class="flex items-center lg:order-2">
                    <a href="#"
                       class="text-gray-800 dark:text-white hover:bg-blue-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-gray-800">Sair</a>
                </div>
            </div>
        </nav>
    </header>
</template>
