@section('title', __('Site Settings'))
<div>
    <div class="col-lg-12 col-md-12 col-12">
        <div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 fw-bold text-white">{{_('Update Site Setting')}}</h3>
                </div>
                <div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
        <div class="card rounded-3">
            <div class="card-body">
                <div class="justify-content-between align-items-center mb-3">
                    <form>
                        <div class="form-group">
                            <label for="website_name"></label>
                            <input wire:model="website_name" type="text" class="form-control" id="website_name"
                                placeholder="{{__('Website Name')}}">
                            @error('website_name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="website_logo">{{__('Website logo')}}</label>
                            <input wire:model="website_logo" type="file" class="form-control" id="website_logo"
                                placeholder="Website Logo">
                            @error('website_logo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="website_favicon">{{__('Website favicon')}}</label>
                            <input wire:model="website_favicon" type="file" class="form-control" id="website_favicon">
                            @error('website_favicon') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="update()" data-bs-dismiss="modal"
                        class="btn bg-primary close-modal text-white">{{__('Update')}}</button>
                </div>
            </div>


        </div>
    </div>
