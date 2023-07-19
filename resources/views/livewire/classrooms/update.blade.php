<!-- Modal -->
<div wire:ignore.self class="modal fade" id="classroomUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="classroomUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Update Classroom')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">
				<form>

            <div class="form-group mt-3">
                <label for="classroom_name">{{__('Classroom Name')}}</label>
                <input wire:model="classroom_name" type="text" class="form-control" id="classroom_name" placeholder="{{__('Classroom Name')}}">@error('classroom_name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="classroom_unique_id">{{__('Classroom Unique Id')}}</label>
                <input wire:model="classroom_unique_id" type="text" class="form-control" id="classroom_unique_id" placeholder="{{__('Classroom Unique Id')}}">@error('classroom_unique_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" wire:click.prevent="update()" data-bs-dismiss="modal" class="btn btn-primary close-modal">{{__('Update')}}</button>
            </div>
        </div>
    </div>
</div>
