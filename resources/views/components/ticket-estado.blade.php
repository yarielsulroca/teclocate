@props(['estado'])

<span class="{{ $estado === 'cerrado' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} px-2 py-1 rounded">
    {{ $estado === 'cerrado' ? 'Cerrado' : 'Abierto' }}
</span>