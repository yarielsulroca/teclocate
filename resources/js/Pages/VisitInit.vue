<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ApplicationLogo from '@/Components/ApplicationLogo.vue'; // Asegúrate de que la ruta sea correcta
import Swal from 'sweetalert2';
const props = defineProps({
    phone: String
});
const loading = ref(false);
const error = ref(null);
const tickets = ref([]);
const showModal = ref(false);
let allTickets = ref([]);
const metaTag = document.querySelector('meta[name="csrf-token"]');
const csrfToken = metaTag ? metaTag.getAttribute('content') : '';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
const url_get_tickets=`/api/tickets/${props.phone}`;
const url_post_visitas=`/api/visitas/`;
const ticketId=ref('');

async function makeApiRequest() {
    loading.value = true;
    try {
        const response = await axios.get(url_get_tickets);
        if (Array.isArray(response.data)) {
            tickets.value = response.data.map(ticket => ({
                id: ticket.id,
                nro_ticket: ticket.nro_ticket,
                descripcion: ticket.descripcion,
                fecha_asignacion: ticket.fecha_asignacion,
                prioridad: ticket.prioridad,
                tecnico_id: ticket.tecnico_id,
                cliente: {
                    calle: ticket.cliente.calle,
                    numero: ticket.cliente.numero,
                    localidad: ticket.cliente.localidad,
                    provincia: ticket.cliente.provincia,
                    latitude: ticket.cliente.latitud,
                    longitude: ticket.cliente.longitud
                },
                tecnico: {
                    phone: ticket.tecnico.phone
                }
            }));
            allTickets.value = tickets.value;
        } else {
            error.value = 'Los datos recibidos no son un array';
        }
    } catch (err) {
        if (err.response && err.response.status === 404) {
            Swal.fire({
                icon: 'info',
                title: 'No se encontraron tickets',
                text: err.response.data.message || 'No hay ningun tieket para usted.'
            });
            error.value = err.response.data.message || 'No hay ningun tieket para usted.';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error en la solicitud',
                text: 'Error en la solicitud: ' + err.message
            });
            error.value = 'Error en la solicitud: ' + err.message;
        }
    } finally {
        loading.value = false;
    }
}

async function createVisit(ticketId) {
    navigator.geolocation.getCurrentPosition(async (position) => {
        const { latitude, longitude } = position.coords;
        const response = await axios.post(`https://teclocate.ascensorescompany.com/api/visitas`,
                {
                    ticket_id:ticketId,
                    latitude:latitude,
                    longitude: longitude,
                    comenzada: 1,
                    terminada: 0
                });
                showModal.value = true;
    });
}

function redirectToWhatsApp() {
    const phoneNumber = '+5491135289388';
    const message = "Registró su Inicio Vista correctamente";
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.location.href = whatsappUrl;
}

onMounted(() => {
    makeApiRequest();
});
</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen p-4 text-white bg-black">
        <ApplicationLogo class="mb-4"></ApplicationLogo>
        <h1 class="mb-10 text-2xl font-bold">Tickets para Iniciar la Visita:</h1>
        <div v-if="loading" class="text-gray-500">Cargando...</div>
        <div v-if="error" class="text-red-500">{{ error }}</div>
        <div v-if="tickets.length > 0" class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="ticket in tickets" :key="ticket.id" class="w-full h-auto p-4 bg-gray-800 border border-gray-700 rounded-lg md:w-80">
                <h2 class="mb-2 text-xl font-semibold">Ticket #{{ ticket.nro_ticket }}</h2>
                <p>Descripción:</p>
                <p class="mb-2">{{ ticket.descripcion }}</p>
                <p class="mb-2">{{ ticket.fecha_asignacion }} : {{ ticket.prioridad }}</p>
                <div class="mb-4 text-gray-400">
                    <p><strong>Cliente:</strong></p>
                    <p>{{ ticket.cliente.calle }} {{ ticket.cliente.numero }}</p>
                    <p>{{ ticket.cliente.localidad }}, {{ ticket.cliente.provincia }}</p>
                </div>
                <button @click="createVisit(ticket.id)" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700">
                    Crear Visita
                </button>
            </div>
        </div>
        <footer class="mt-8 text-gray-500">
            &copy; 2024 Ascensores Company ... By Kube Agency.
        </footer>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-4 text-black bg-white rounded-lg">
                <h2 class="mb-4 text-xl font-bold">Visita Creada</h2>
                <p>Registró su Inicio Vista correctamente</p>
                <button @click="redirectToWhatsApp" class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</template>
