<div class="row">
    <div class="col-12 mb-2">
        <div>
            <strong>Izquierda</strong>
            <hr class="my-1">
            <small><i class="fa-solid fa-info-circle text-info"></i> Solo se permiten imágenes en formato .png, .jpg, .jpeg o .svg en dimensiones 234px de ancho por 60px de alto o imágenes relación de aspecto similares. </small>
        </div>
    </div>
    <div class="col-12 mb-2">
        <template x-for="rightAddon, index in addon.payload.right" :key="index">
            <div class="row mb-2">
                <div class="col-12 col-md-8">
                    <div class="form-group mb-2">
                        <div class="input-group my-2">
                            <label class="input-group-text" for="rightAddonFile_{{ index }}"><i class="fa-solid fa-upload"></i></label>
                            <input type="file" accept=".png,.jpeg,.jpg o .svg" id="rightAddonFile_{{ index }}" class="form-control imageAddon" :class="addon.payload.right[index].base64 != null ? 'border border-2 border-success': ''" @change="previewAddon(event,'right',index)" data-specific-width="234" data-specific-height="60" />
                            <label class="input-group-text" for="rightAddonFile_{{ index }}">Cargar anuncio</label>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <input type="hidden" x-model="addon.payload.right[index].base64" class="form-control" required />
                        <div class="input-group">
                            <label for="rightAddonUrl_{{ index }}" class="input-group-text"><i class="fa-solid fa-link"></i></label>
                            <input type="text" id="rightAddonUrl_{{ index }}" x-model="addon.payload.right[index].url" class="form-control" :class="isValidUrl(addon.payload.right[index].url) ? 'borde border-2 border-success' : ''" placeholder="URL para el anuncio" required />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <div class="d-flex justify-content-center mb-2">
                        <div class="w-100">
                            <img :src="rightImagePreviewer[index]" alt="Left addon previewer" class="w-75 w-sm-50 w-md-25" x-show="index in rightImagePreviewer && rightImagePreviewer[index]!==null">
                            <h1 class="px-4 py-3 rounded-2 shadow bg-light text-dark text-center" x-show="!(index in rightImagePreviewer)">
                                <i class="fa-regular fa-image m-auto"></i>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button @click="addRightAddon()" type="button" class="btn btn-sm btn-success"><span data-bs-toggle="tooltip" data-bs-title="Agregar anuncio"><i class="fa-solid fa-plus-circle"></i></span></button>
                    <button x-show="index>0" @click="removeRightAddon(index)" type="button" class="btn btn-sm btn-danger"><span data-bs-toggle="tooltip" data-bs-title="Quitar anuncio"><i class="fa-solid fa-minus-circle"></i></span></button>
                </div>
            </div>
        </template>
    </div>
</div>