<div class="row">
    <div class="col-12 mb-2">
        <div>
            <strong>Cabecera</strong>
            <hr class="my-1">
            <small><i class="fa-solid fa-info-circle text-info"></i> Solo se permiten imágenes en formato .png, .jpg, .jpeg o .svg en dimensiones 728px de ancho por 90px de alto o imágenes relación de aspecto similares. </small>
        </div>
        <div class="form-group mb-2">
            <div class="input-group my-2">
                <label class="input-group-text" for="headerAddonFile"><i class="fa-solid fa-upload"></i></label>
                <input type="file" accept=".png,.jpeg,.jpg o .svg" id="headerAddonFile" class="form-control imageAddon" :class="addon.payload.header.base64 != null ? 'border border-2 border-success' : ''" @change="previewAddon(event,'header')" data-specific-width="728" data-specific-height="90" />
                <label class="input-group-text" for="headerAddonFile">Cargar anuncio</label>
            </div>
        </div>
    </div>
    <div class="col-12 mb-2">
        <input type="hidden" x-model="addon.payload.header.base64" class="form-control" required />
        <div class="form-group mb-2">
            <div class="input-group">
                <label for="headerAddonUrl" class="input-group-text"><i class="fa-solid fa-link"></i></label>
                <input type="text" id="headerAddonUrl" x-model="addon.payload.header.url" class="form-control" :class="isValidUrl(addon.payload.header.url) ? 'border border-2 border-success' : ''" :pattern="urlRegex" placeholder="URL para el anuncio" required />
            </div>
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="d-flex justify-content-center mb-2">
            <div class="w-100">
                <img :src="headerImagePreviewer" alt="Header previewer" class="w-100" x-show="headerImagePreviewer!==null">
                <h1 class="px-4 py-3 rounded-2 shadow bg-light text-dark text-center" x-show="headerImagePreviewer===null">
                    <i class="fa-regular fa-image m-auto"></i>
                </h1>
            </div>
        </div>
    </div>
</div>