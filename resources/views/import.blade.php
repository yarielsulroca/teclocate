<form action="{{ route('clientes.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Importar Clientes</button>
</form>

<form action="{{ route('clientes.export') }}" method="GET">
    <button type="submit">Exportar Clientes</button>
</form>