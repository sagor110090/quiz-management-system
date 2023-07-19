<!-- Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdropShow" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Show Role No.')}} {{ $selected_id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mt-2 mb-2 border border-secondary rounded-1 p-2">
                        <label for="name">{{__('Name')}}:-</label>
                        <div>{{ $name }}</div>
                    </div>

                    <div class="form-group mt-2 mb-2 border border-secondary rounded-1 p-2">
                        <label>{{__('Permissions')}}:-</label>
                        <div class="col-md-12">
                            @if (!empty($rolePermissions))
                                @foreach ($rolePermissions as $permission)
                                    <div class="badge bg-info">{{ $permission->name }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
