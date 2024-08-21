<?php
// URL del archivo
$file_url = plugins_url('../../../docs/userguide.pdf', __FILE__);
?>

<div class="container my-4" x-data="aplineInit()">
    <div class="row">
        <div class="col-12 mb-2">
            <h1 class="">Conexión al día - Addons</h1>
            <hr class="my-1">
        </div>
        <div class="col-12 mb-2">
            <p class="text-justify">
                <i class="fas fa-info-circle text-info"></i> Este plugin administra los anuncios colocados en la cabecera y los laterales del portal. <a href="<?php echo esc_url($file_url); ?>" class="cursor-pointer fw-bold" download> Descargar guía de uso</a>.
            </p>
        </div>
    </div>

    <div class="row justify-content-between">
        <div class="col-12 col-md-6 mb-2 text-start">
            <div class="row g2 align-items-middle">
                <label class="col-auto" for="perPageElement">Mostrar</label>
                <select id="perPageElement" class="col-auto form-select w-auto" x-model="perPage" @change="onChangePerPage()">
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-2 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddonsForm" @click="createAddonModel()">
                <span data-bs-toggle="tooltip" data-bs-title="Agregar nuevo lote de anuncios.">
                    Agregar&nbsp;<i class="fa-solid fa-plus-circle"></i>
                </span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2 table-responsive">
            <table id="conexionaldia_addons_table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Estatus</th>
                        <th class="text-nowrap">Fecha de carga</th>
                        <th class="text-nowrap">Fecha de inicio</th>
                        <th class="text-nowrap">Fecha de finalización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="item in addonsPagination.items" :key="item.id">
                        <tr>
                            <td class="text-center" x-text="item.id"></td>
                            <td class="text-center">
                                <span :class="(item.status == '1' ? 'bg-success' : 'bg-dark')" class="rounded-pill badge" x-text="(item.status == '1' ? 'Activo' : 'Inactivo')"></span>
                            </td>
                            <td class="text-end text-nowrap" x-text="new Date(item.created_at).toLocaleDateString()"></td>
                            <td class="text-end text-nowrap" x-text="new Date(item.start_date).toLocaleDateString()"></td>
                            <td class="text-end text-nowrap" x-text="new Date(item.end_date).toLocaleDateString()"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-secondary btnShow" data-bs-toggle="modal" data-bs-target="#modalAddonPreview" :data-id="item.id" @click="findById(item.id)">
                                    <span data-bs-toggle="tooltip" data-bs-title="Mostrar anuncios">
                                        <i class="fa-solid fa-eye"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-sm btn-dark btnEdit" data-bs-toggle="modal" data-bs-target="#modalAddonsForm" :data-id="item.id" @click="findById(item.id)">
                                    <span data-bs-toggle="tooltip" data-bs-title="Editar anuncios">
                                        <i class="fa-solid fa-pencil"></i>
                                    </span>
                                </button>
                                <button x-show="(item.status) != '1'" type="button" class="btn btn-sm btn-danger btnDelete" :data-id="item.id" @click="deleteAddon(item)">
                                    <span data-bs-toggle="tooltip" data-bs-title="Eliminar anuncio">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-12 col-lg-5 mb-2 text-start">
            <strong x-text="addonsPagination.total"></strong> elementos totales
        </div>
        <div class="col-12 col-lg-7 mb-2 text-end">
            Página <strong x-text="addonsPagination.current_page"></strong>
            <button @click="previewPage()" class="btn btn-sm btn-secondary" :class="((addonsPagination.current_page <= 1) ? 'disabled' : null)">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button @click="nextPage()" class="btn btn-sm btn-secondary" :class="((addonsPagination.current_page >= addonsPagination.pages) ? 'disabled' : null)">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div id="modalAddonPreview" class="modal fade" tabindex="-1" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conexión al día - anuncios cargados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <strong>Anuncios en la cabecera</strong>
                        </div>
                        <div class="col-12 mb-2 text-center">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
                                    <img :src="addon.payload.header.path" alt="Header preview" class="w-100 w-sm-50 w-lg-50" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <strong>Anuncios en el lado izquierdo</strong>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row justify-content-center">
                                <template x-for="addon in addon.payload.left">
                                    <div class="col-8 col-md-4 col-lg-2 mb-2">
                                        <img :src="addon.path" alt="Left preview" class="w-100 w-sm-50" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <strong>Anuncios en el lado derecho</strong>
                        </div>
                        <div class="col-12 mb-2 text-center">
                            <div class="row justify-content-center">
                                <template x-for="addon in addon.payload.right">
                                    <div class="col-12 col-md-4 col-lg-3 mb-2">
                                        <img :src="addon.path" alt="Right preview" class="w-100 w-sm-50" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalAddonsForm" class="modal fade" tabindex="-1" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conexión al día - <span x-text="(addon.id != null ? 'editar' : 'registrar')"></span> anuncio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="hidden" x-model="addon.id" name="id">
                        <?php include('Components/addonForm/tabs.php') ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" :disabled="!enableSubmitButton()" @click="submitForm()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>
    let nonce = wpApiSettings.nonce;

    function aplineInit() {
        return {
            addon: {
                id: null,
                start_date: null,
                end_date: null,
                status: true,
                payload: {
                    header: {
                        url: null,
                        path: null,
                        base64: null
                    },
                    left: [{
                        url: null,
                        path: null,
                        base64: null
                    }],
                    right: [{
                        url: null,
                        path: null,
                        base64: null
                    }]
                },
                created_at: null,
                updated_at: null
            },
            addonsPagination: {
                items: 0,
                current_page: 1,
                per_page: 10,
                total: 0,
                pages: 1,
            },
            baseUrl: "/wp-json/conexionaldia_addons/",
            headerImagePreviewer: null,
            imageAddon: null,
            leftImagePreviewer: [],
            payloadTemplate: {
                header: {
                    url: null,
                    path: null
                },
                left: [{
                    url: null,
                    path: null
                }],
                right: [{
                    url: null,
                    path: null
                }]
            },
            perPage: 10,
            rightImagePreviewer: [],
            urlRegex: /^(https?:\/\/)?([\w\-]+(\.[\w\-]+)+)(\/[\w\-\/]*)?(\?[\w\-=&]*)?$/,
            init() {
                this.getAddons();
            },
            addLeftAddon() {
                (this.addon.payload.left).push({
                    url: null,
                    path: null,
                    base64: null
                });
            },
            addRightAddon() {
                (this.addon.payload.right).push({
                    url: null,
                    path: null,
                    base64: null
                });
            },
            addTooltips() {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            },
            createAddonModel() {
                this.addon = this.prepareAddon(null);
            },
            deleteAddon(addon) {
                Swal.fire({
                    icon: 'question',
                    title: 'Eliminar anuncios',
                    html: '¿Realmente deseas eliminar el anuncio con ID <strong>' + addon.id + '</strong>?<br/>Esta acción es irreversible.',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',

                }).then((result) => {
                    if (result.isConfirmed) {
                        let uri = this.baseUrl + "delete/" + addon.id;
                        fetch(uri, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-WP-Nonce": nonce
                                }
                            })
                            .then(response => response.json())
                            .then((data) => {
                                if (!isNaN(data)) {
                                    Swal.fire("Anuncio eliminado", "", "success");
                                    this.getAddons();
                                }
                            })
                            .catch((error) => {
                                this.showAlert("error", "Error", error);
                            });
                    }
                });
            },
            enableSubmitButton() {
                return (this.formValidationPeriod() && this.formValidationHeader() && this.formValidationLeft() && this.formValidationRight());
            },
            findById(id) {
                let uri = this.baseUrl + "find/" + id;
                fetch(uri, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "X-WP-Nonce": nonce
                        }
                    })
                    .then(response => response.json())
                    .then((addon) => {
                        this.addon = this.prepareAddon(addon);
                        this.addTooltips();
                    })
                    .catch((error) => {
                        this.showAlert("error", "Error", error);
                    });
            },
            formValidationHeader() {
                if (this.addon.payload.header.url == null || this.addon.payload.header.url == '') {
                    return false;
                }
                if (this.addon.payload.header.path == null && this.addon.payload.header.base64 == null) {
                    return false;
                }
                if (!this.isValidUrl(this.addon.payload.header.url)) {
                    return false;
                }
                return true;
            },
            formValidationLeft() {
                let valid = true;
                (this.addon.payload.left).forEach((leftAddon, index) => {
                    if (this.addon.payload.left[index].url == null || (this.addon.payload.left[index].url != null && !this.isValidUrl(this.addon.payload.left[index].url)) || (this.addon.payload.left[index].path == null && this.addon.payload.left[index].base64 == null)) {
                        valid = valid && false;
                    }
                });
                return valid;
            },
            formValidationPeriod() {
                if (this.addon.start_date == '' || this.addon.start_date == null) {
                    return false;
                }
                if (this.addon.end_date == '' || this.addon.end_date == null) {
                    return false;
                }
                if (this.addon.start_date > this.addon.end_date) {
                    return false;
                }
                return true;
            },
            formValidationRight() {
                let valid = true;
                (this.addon.payload.right).forEach((rightAddon, index) => {
                    if (this.addon.payload.right[index].url == null || (this.addon.payload.right[index].url != null && !this.isValidUrl(this.addon.payload.right[index].url)) || (this.addon.payload.right[index].path == null && this.addon.payload.right[index].base64 == null)) {
                        valid = valid && false;
                    }
                });
                return valid;
            },
            getAddons() {
                let uri = this.baseUrl + "index?perPage=" + this.addonsPagination.per_page + "&page=" + this.addonsPagination.current_page;
                fetch(uri, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "X-WP-Nonce": nonce
                        }
                    })
                    .then(response => response.json())
                    .then((data) => {
                        this.addonsPagination = data;
                        this.addTooltips();
                    })
                    .catch((error) => {
                        this.showAlert("error", "Error", error);
                    });
            },
            isJSON(json) {
                try {
                    JSON.parse(json);
                    return true;
                } catch (e) {
                    return false;
                }
            },
            isValidUrl(url) {
                return this.urlRegex.test(url);
            },
            nextPage() {
                if (this.addonsPagination.current_page <= this.addonsPagination.pages) {
                    this.addonsPagination.current_page = this.addonsPagination.current_page + 1;
                    this.getAddons();
                }
            },
            onChangePerPage() {
                this.addonsPagination.per_page = this.perPage;
                this.getAddons();
            },
            prepareAddon(addon) {
                if (addon != null) {
                    addon.payload = JSON.parse(addon.payload);
                    this.headerImagePreviewer = addon.payload.header.path;
                    this.leftImagePreviewer = [];
                    (addon.payload.left).forEach((left, index) => {
                        this.leftImagePreviewer[index] = left.path;
                    });
                    this.rightImagePreviewer = [];
                    (addon.payload.right).forEach((right, index) => {
                        this.rightImagePreviewer[index] = right.path;
                    });
                }
                return {
                    id: (addon == null ? null : (addon.id != null) ? parseInt(addon.id) : null),
                    start_date: (addon == null ? null : (addon.start_date != null ? addon.start_date.split(' ')[0] : null)),
                    end_date: (addon == null ? null : (addon.end_date != null ? addon.end_date.split(' ')[0] : null)),
                    status: (addon == null ? null : (addon.status == '1' ? true : false)),
                    payload: (addon == null ? this.payloadTemplate : (addon.payload != '' ? addon.payload : this.payloadTemplate)),
                    created_at: (addon == null ? null : (addon.created_at != null ? new Date(addon.created_at) : null)),
                    updated_at: (addon == null ? null : (addon.updated_at != null ? new Date(addon.updated_at) : null))
                };
            },
            previewAddon(event, section, index = null) {
                let
                    file = event.target.files[0],
                    specificWidth = parseInt(event.target.dataset['specificWidth']),
                    specificHeight = parseInt(event.target.dataset['specificHeight']);
                if (!file) {
                    switch (section) {
                        case "header":
                            this.headerImagePreviewer = null;
                            this.addon.payload.header.base64 = null;
                            break;
                        case "left":
                            this.leftImagePreviewer[index] = null;
                            break;
                        case "right":
                            this.rightImagePreviewer[index] = null;
                            break;
                        default:
                            break;
                    }
                    event.target.value = "";
                } else {
                    let acceptedMimes = ["image/png","image/jpg","image/jpeg","image/gif","image/svg+xml"];
                    if(acceptedMimes.indexOf(file.type) !== -1){
                        let fileReader = new FileReader();
                        fileReader.onload = (evt) => {
                            let img = new Image();
                            img.src = URL.createObjectURL(file);
                            img.onload = () => {
                                let ratioLoaded = parseFloat((img.width / img.height).toPrecision(2));
                                let ratioTarget = parseFloat((specificWidth / specificHeight).toPrecision(2));
                                if ((ratioLoaded == ratioTarget)) {
                                    if (section == "header") {
                                        this.addon.payload.header.base64 = evt.target.result;
                                        this.headerImagePreviewer = img.src;
                                    }
                                    if (section == "left") {
                                        this.addon.payload.left[index].base64 = evt.target.result;
                                        this.leftImagePreviewer[index] = img.src;
                                    }
                                    if (section == "right") {
                                        this.addon.payload.right[index].base64 = evt.target.result;
                                        this.rightImagePreviewer[index] = img.src;
                                    }
                                } else {
                                    if (section == "header") {
                                        this.headerImagePreviewer = null;
                                        this.addon.payload.header.base64 = null;
                                    }
                                    if (section == "left") {
                                        this.leftImagePreviewer[index] = null;
                                    }
                                    if (section == "right") {
                                        this.rightImagePreviewer[index] = null;
                                    }
                                    this.showAlert("warning", "¡Atención!", `La imagen cargada tiene dimensiones de <strong>${img.width}x${img.height} pixeles</strong> y las requeridas son de <strong>${specificWidth}x${specificHeight} pixeles</strong>. Intenta con otra imagen con las dimensiones o proporciones requeridas.`);
                                    event.target.value = "";
                                }
                            };
                        };
                        fileReader.readAsDataURL(file);
                    }
                    else{
                        this.showAlert("warning", "¡Atención!", `El archivo cargado no corresponde a los permitidos para formato de imagen <i>(.png, .jpg, .jpeg, .gif o .svg)</i>.`);
                        event.target.value = "";
                    }
                }
            },
            previewPage() {
                if (this.addonsPagination.current_page > 1) {
                    this.addonsPagination.current_page = this.addonsPagination.current_page - 1;
                    this.getAddons();
                }
            },
            removeLeftAddon(index) {
                if ((this.addon.payload.left).length > 1) {
                    this.addon.payload.left = (this.addon.payload.left).filter((_, _index) => _index !== index);
                }
            },
            removeRightAddon(index) {
                if ((this.addon.payload.right).length > 1) {
                    this.addon.payload.right = (this.addon.payload.right).filter((_, _index) => _index !== index);
                }
            },
            showAlert(icon, title, html) {
                Swal.fire({
                    "icon": icon,
                    "title": title,
                    "html": html
                });
            },
            submitForm() {
                let uri = this.baseUrl + "create";
                let method = "POST";
                if (this.addon.id == null || this.addon.id == "") {
                    this.addon.id = null;
                    this.addon.status = true;
                    this.addon.start_date = this.addon.start_date;
                    this.addon.end_date = this.addon.end_date;
                    this.addon.created_at = new Date();
                    this.addon.updated_at = null;
                }
                if (this.addon.id != null && this.addon.id != '') {
                    uri = this.baseUrl + "update/" + this.addon.id;
                    this.addon.updated_at = new Date();
                    method = 'PATCH';
                }
                this.addon.payload = JSON.stringify(this.addon.payload);
                fetch(uri, {
                        method: method,
                        headers: {
                            "Content-Type": "application/json",
                            "X-WP-Nonce": nonce
                        },
                        body: JSON.stringify(this.addon)
                    })
                    .then(response => response.json())
                    .then((data) => {
                        let modal = document.querySelector('[data-bs-dismiss="modal"]').click();
                        this.showAlert("success", "¡Excelente!", "El anuncio ha sido guardado exitosamente");
                        this.getAddons();
                        this.addon = this.prepareAddon(null);
                    })
                    .catch((error) => {
                        this.showAlert("error", "Error", error);
                    });
            }
        }
    }
</script>