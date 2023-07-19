<!-- Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Create New Role')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name"></label>
                        <input wire:model="name" type="text" class="form-control" id="name"
                            placeholder="{{__('Name')}}">@error('name') <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <strong>{{__('Permission')}}:</strong>
                        <br />
                        @foreach ($permission as $value)
                        <label>
                            <input wire:model.defer='selected_permission' type="checkbox" value="{{$value->id}}">
                            {{ $value->name }}</label>
                        <br />
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" wire:click.prevent="store()"
                    class="btn bg-primary close-modal text-white">{{__('Save')}}</button>
            </div>
        </div>
    </div>
</div>
