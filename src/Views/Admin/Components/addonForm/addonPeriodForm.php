<div class="row">
    <div class="col-12 mb-2">
        <strong class="fs-3">Periodo de visualización</strong>
        <hr class="my-1">
    </div>
    <div class="col-12 col-md-6 col-lg-4 mb-2">
        <div class="form-group">
            <label for="startDate" class="control-label">Fecha de inicio</label>
            <div class="input-group">
                <label for="startDate" class="input-group-text"><i class="fa-solid fa-calendar-days"></i></label>
                <input type="date" x-model="addon.start_date" name="start_date" id="startDate" class="form-control" required />
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mb-2">
        <div class="form-group">
            <label for="endDate" class="control-label">Fecha de cierre:</label>
            <div class="input-group">
                <label for="endDate" class="input-group-text"><i class="fa-solid fa-calendar-days"></i></label>
                <input type="date" x-model="addon.end_date" :min="addon.start_date" name="end_date" id="endDate" class="form-control" required />
            </div>
        </div>
    </div>
</div>