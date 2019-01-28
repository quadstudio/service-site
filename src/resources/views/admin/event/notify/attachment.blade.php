<div class="card mt-3 attachment-item">
    <div class="card-body">
        <div class="form-row required">
            <div class="col mb-3">
                <div class="form-group">
                    <label for="attachment_{{$random}}">Выбрать файл</label>
                    <input type="file"
                           name="attachment[{{$random}}]"
                           class="form-control-file{{ $errors->has('attachment.'.$random) ? ' is-invalid' : '' }}"
                           id="attachment_{{$random}}">
                    <span class="invalid-feedback">{{ $errors->first('attachment.'.$random) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();" class="btn btn-sm btn-danger">Удалить</a>
    </div>
</div>