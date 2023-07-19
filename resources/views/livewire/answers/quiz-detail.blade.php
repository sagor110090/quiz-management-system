<div>

    <div class="card card-body">
        <p>Total marks obtained: {{$answers->sum('mark')}}</p>
        <h5>Multiple choice and Missing word questions:</h5>
        <table class="table table-striped shadow p-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Correct ans</th>
                    <th>Mark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers->where('long_question_answer',null) as $answer)
                <tr>
                    <td>{{$loop->iteration}}.</td>
                    <td>{{Str::limit($answer->question, 100, '...')}}</td>
                    <td>{{$answer->short_question_answer}}</td>
                    <td>{{$answer->short_question_correct}}</td>
                    <td>{{$answer->mark}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h5>Long written answers:</h5>
        <table class="table table-striped shadow p-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Mark</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers->where('long_question_answer','!=',null) as $answer)
                <tr>
                    <td>{{$loop->iteration}}.</td>
                    <td>{{Str::limit($answer->question, 100, '...')}}</td>
                    <td>{{$answer->long_question_answer}}</td>
                    <td>{{$answer->mark}}</td>
                    <td>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#studentResultModal"
                            class="btn btn-success btn-sm" wire:click='show({{$answer->id}})'><i
                                class="fa fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    @include('livewire.answers.create')
</div>
