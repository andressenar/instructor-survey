<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" class="import-form">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Importar Excel</button>
</form>
