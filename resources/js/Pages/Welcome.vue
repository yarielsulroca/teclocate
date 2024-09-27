<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="text-white bg-black dark:bg-red dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="flex flex-col items-center justify-center py-10">
                    <div class="flex items-center justify-center">
                        <ApplicationLogo class="h-auto max-w-full"/>
                    </div>
                    <nav v-if="canLogin" class="flex justify-center mt-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('filament.admin.pages.dashboard')"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-red/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Panel Administrativo
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('filament.admin.auth.login')"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <!-- Contenido principal -->
                </main>

                <footer class="py-16 text-sm text-center text-white dark:text-white/70">
                    @Ascensores Company... make by Kube Agency
                </footer>
            </div>
        </div>
    </div>
</template>
