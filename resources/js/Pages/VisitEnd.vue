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
const url_get_tickets=`/api/tickets-update/${props.phone}`;
const url=`/api/visitas/`;

const ticketValue=ref('');
async function makeApiRequest() {
    loading.value = true;
    try {
        const response = await axios.get(url_get_tickets);
        console.log(response.data); // Verifica la estructura de los datos

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
                },
                visita: {
                    id: ticket.visita.id,
                    comenzada: ticket.visita.comenzada,
                    terminada: ticket.visita.terminada
                }
            }));
            allTickets.value = tickets.value;
            // Filtrar los tickets para excluir aquellos cuya visita está finalizada
            tickets.value = tickets.value.filter(ticket => !ticket.visita.terminada);
        } else {
            error.value = 'Los datos recibidos no son un array';
        }
    } catch (err) {
        if (err.response && err.response.status === 404) {
            Swal.fire({
                icon: 'info',
                title: 'No se encontraron tickets',
                text: err.response.data.message || 'No hay ningun ticket para usted.'
            });
            error.value = err.response.data.message || 'No hay ningun ticket para usted.';
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

onMounted(() => {
    makeApiRequest();
});

async function finishVisit(visitaId, lat1, long1) {
    navigator.geolocation.getCurrentPosition(async (position) => {
        const { latitude, longitude } = position.coords;
        console.log('Latitude:', latitude, 'Longitude:', longitude);
        console.log('Id:', visitaId);
        console.log(lat1, long1);
        console.log(calculateDistance(lat1, long1, latitude, longitude));
        const response = await axios.put(`/api/visitas/${visitaId}`, {
                    latitude: latitude,
                    longitude: longitude
                });
                showModal.value = true;
    });
}
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radio de la Tierra en kilómetros
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c; // Distancia en kilómetros
    return distance;
}
function redirectToWhatsApp() {
    const phoneNumber = '+5491135289388';
    const message = `Visita Finalizada`;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.location.href = whatsappUrl;
}
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
                <p class="mb-2">{{ new Date(ticket.fecha_asignacion).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }) }} : <span :class="{
                    'text-red-500': ticket.prioridad === 'alta',
                    'text-yellow-500': ticket.prioridad === 'media',
                    'text-green-500': ticket.prioridad === 'baja'
                }">{{ ticket.prioridad }}</span></p>
                <div class="mb-4 text-gray-400">
                    <p><strong>Cliente:</strong></p>
                    <p>{{ ticket.cliente.calle }} {{ ticket.cliente.numero }}</p>
                    <p>{{ ticket.cliente.localidad }}, {{ ticket.cliente.provincia }}</p>
                </div>
                <div>
                    <button @click="finishVisit(ticket.visita.id, ticket.cliente.latitude, ticket.cliente.longitude)" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700">
                        Finalizar Visita
                    </button>
                </div>
            </div>
        </div>
        <footer class="mt-8 text-gray-500">
            &copy; 2024 Ascensores Company ... By Kube Agency.
        </footer>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-4 text-black bg-white rounded-lg">
                <h2 class="mb-4 text-xl font-bold">Aceptar</h2>
                <p>Se finalizó su visita correctamente</p>
                <button @click="redirectToWhatsApp()" class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</template>
<style scoped>
.text-red-500 {
    color: #f56565;
}
.text-yellow-500 {
    color: #ecc94b;
}
.text-green-500 {
    color: #48bb78;
}
</style>
