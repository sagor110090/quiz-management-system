<!-- Modal -->
<div wire:ignore.self class="modal fade" id="questionShowModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="questionShowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Show Question')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">


            <div class="input-group mb-3">
                <span class="input-group-text  border-0">{{__('Question')}}:</span>
                <div class="form-control  border-0">{{$question}}</div>
            </div>

            @if (isset($questionOptions))
            @foreach ($questionOptions as $item)
            <div class="input-group mb-3">
                <span class="input-group-text  border-0">{{__('Option ')}}{{$loop->iteration}}:</span>
                <div class="form-control  border-0">{{$item->option_name}}</div>
            </div>
            @endforeach
            @endif






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
