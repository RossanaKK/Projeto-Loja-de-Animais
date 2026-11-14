@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // O Laravel injeta o valor do .env diretamente aqui
    const cloudName = "{{ env('CLOUDINARY_CLOUD_NAME') }}";
    const uploadPreset = 'lojainfo_preset';

    // Verificação de segurança
    if (!cloudName || cloudName === '') {
        console.error("ERRO CRÍTICO: O CLOUDINARY_CLOUD_NAME está vazio no .env!");
        alert("Erro de configuração: Verifica se CLOUDINARY_CLOUD_NAME está definido no ficheiro .env");
        return;
    }

    console.log("Widget a inicializar com Cloud Name:", cloudName);

    const myWidget = cloudinary.createUploadWidget({
        cloudName: cloudName,
        uploadPreset: uploadPreset,
        sources: ['local', 'url'],
        multiple: false,
        maxFiles: 1,
        cropping: false,
        showAdvancedOptions: false
    }, function (error, result) {
        if (!error && result && result.event === "success") {
            console.log("Upload bem-sucedido! URL:", result.info.secure_url);

            document.getElementById('img').value = result.info.secure_url;
            let divPreview =  document.getElementById('editProductImage');
            divPreview.querySelector('img').src = result.info.secure_url;
            // document.getElementById('imagePreview').style.display = 'block';
        }

        if (error) {
            console.error("Erro no upload:", error);
            alert("Erro ao fazer upload: " + error.message);
        }
    });

    const btn = document.getElementById('uploadWidgetBtn');
    if (btn) {
        btn.addEventListener('click', function() {
            console.log("Botão clicado. A abrir widget...");
            myWidget.open();
        });
    }
});
</script>
@endpush
